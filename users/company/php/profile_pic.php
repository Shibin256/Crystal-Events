<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 3) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if (isset($_FILES["file"])) {
    $email = $_SESSION['email'];
    $file = $_FILES["file"];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Upload error code: ' . $file['error']]);
        exit;
    }

    $maxBytes = 5 * 1024 * 1024; // 5 MB
    if ($file['size'] > $maxBytes) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'File exceeds 5MB size limit']);
        exit;
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    $allowedMimes = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp'
    ];

    $origExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!array_key_exists($mime, $allowedMimes) || !in_array($origExt, ['jpg', 'jpeg', 'png', 'webp'])) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid image format. Allowed: JPG, PNG, WebP']);
        exit;
    }

    if (@getimagesize($file['tmp_name']) === false) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid image file']);
        exit;
    }

    $ext = $allowedMimes[$mime];
    $newFileName = bin2hex(random_bytes(16)) . '.' . $ext;
    $targetDir = __DIR__ . '/../uploads/profile/';
    if (!is_dir($targetDir)) {
        @mkdir($targetDir, 0755, true);
    }
    $targetFile = $targetDir . $newFileName;

    // Fetch existing profile pic to clean up if not default
    $res = sel("SELECT profile_pic FROM company WHERE email=?", [$email]);
    $oldFile = '';
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $oldFile = $row['profile_pic'];
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
        update("UPDATE company SET profile_pic=? WHERE email=?", [$newFileName, $email]);

        if ($oldFile && $oldFile !== 'default.jpg' && file_exists($targetDir . $oldFile)) {
            @unlink($targetDir . $oldFile);
        }

        echo 1;
        exit;
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
        exit;
    }
}

http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'No file provided']);
