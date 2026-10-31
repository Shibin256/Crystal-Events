<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 2) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid upload request.";

if (isset($_POST["add"])) {
    $email = $_SESSION['email'];
    $caption = trim($_POST['caption'] ?? '');

    if ($caption === '') {
        $msg = "Please provide a caption.";
    } elseif (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
        $msg = "File upload failed. Error code: " . ($_FILES['photo']['error'] ?? 'missing');
    } else {
        $file = $_FILES['photo'];
        $maxBytes = 5 * 1024 * 1024; // 5 MB

        if ($file['size'] > $maxBytes) {
            $msg = "File exceeds the 5MB size limit.";
        } else {
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
                $msg = "Invalid file type. Only JPG, PNG, and WebP images are allowed.";
            } elseif (@getimagesize($file['tmp_name']) === false) {
                $msg = "Uploaded file is not a valid image.";
            } else {
                $ext = $allowedMimes[$mime];
                $newFilename = bin2hex(random_bytes(16)) . '.' . $ext;
                $targetDir = __DIR__ . '/../uploads/gallery/';
                if (!is_dir($targetDir)) {
                    @mkdir($targetDir, 0755, true);
                }
                $targetPath = $targetDir . $newFilename;

                if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                    $sql = "INSERT INTO gallery (photo, caption, company_email) VALUES (?, ?, ?)";
                    $res = insert($sql, [$newFilename, $caption, $email]);
                    if ($res) {
                        $status = "success";
                        $msg = "Photo uploaded successfully!";
                    } else {
                        @unlink($targetPath);
                        $msg = "Database error while saving photo.";
                    }
                } else {
                    $msg = "Could not save uploaded file to gallery destination.";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Gallery Upload - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php if ($status === "success"): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: <?php echo json_encode($msg); ?>,
        }).then(() => {
            window.location.replace('../gallery.php');
        });
    </script>
<?php else: ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: <?php echo json_encode($msg); ?>,
        }).then(() => {
            window.location.replace('../gallery.php');
        });
    </script>
<?php endif; ?>
</body>
</html>
