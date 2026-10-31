<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid request.";

if (isset($_POST['edit'])) {
    $email = $_SESSION['email'];
    $cdate = date('Y-m-d H:i:s');
    $topic = trim($_POST['topic'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($topic === '' || $description === '') {
        $msg = "Please provide both a topic and details for your complaint.";
    } else {
        $ins = insert("INSERT INTO complaint (email, topic, complaint, submitted_date, status) VALUES (?, ?, ?, ?, 1)",
            [$email, $topic, $description, $cdate]);
        if ($ins) {
            $status = "success";
            $msg = "Complaint Registered Successfully!";
        } else {
            $msg = "Database error while registering complaint.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Submit Complaint - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($msg); ?>
        }).then(() => {
            window.location.replace('../complaint.php');
        });
    </script>
</body>
</html>
