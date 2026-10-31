<?php
session_start();

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    http_response_code(403);
    echo 0;
    exit;
}

if (isset($_POST['id'])) {
    $_SESSION['menu'] = preg_replace('/[^a-zA-Z0-9_-]/', '', (string)$_POST['id']);
    echo 1;
    exit;
}
echo 0;
