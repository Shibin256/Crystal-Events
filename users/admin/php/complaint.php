<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 1) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid update.";

if (isset($_POST['update'])) {
    $complaint_id = (int)($_POST['complaint_id'] ?? 0);
    $reply = trim($_POST['reply'] ?? '');

    if ($complaint_id > 0 && $reply !== '') {
        $res = update("UPDATE complaint SET reply=?, status=2 WHERE complaint_id=?", [$reply, $complaint_id]);
        if ($res) {
            $status = "success";
            $msg = "Complaint reply saved!";
        } else {
            $msg = "Database error while updating complaint.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reply Complaint - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($msg); ?>,
        }).then(() => {
            window.location.replace('../complaints.php');
        });
    </script>
</body>
</html>
