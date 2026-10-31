<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 1) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if (isset($_POST['email'])) {
    $email = trim($_POST['email'] ?? '');
    $status = (int)($_POST['status'] ?? 0);
    $userType = trim($_POST['user'] ?? '');

    if ($email === '') {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
        exit;
    }

    if ($userType === "user") {
        if ($status === 1) {
            update("UPDATE login SET status=1 WHERE email=?", [$email]);
            echo 1;
            exit;
        } else {
            delete("DELETE FROM login WHERE email=?", [$email]);
            delete("DELETE FROM users WHERE email=?", [$email]);
            echo 1;
            exit;
        }
    } else {
        if ($status === 1) {
            update("UPDATE login SET status=1 WHERE email=?", [$email]);
            echo 1;
            exit;
        } else {
            delete("DELETE FROM login WHERE email=?", [$email]);
            delete("DELETE FROM company WHERE email=?", [$email]);
            echo 1;
            exit;
        }
    }
}

http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Bad request']);
