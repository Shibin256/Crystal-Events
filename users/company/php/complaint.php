<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

// Ensure company is logged in
if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 2) {
    header("Location: ../../../login.html");
    exit;
}

$updated = false;
if (isset($_POST['update'])) {
    $complaint_id = (int)($_POST['complaint_id'] ?? 0);
    $reply = trim($_POST['reply'] ?? '');

    if ($complaint_id > 0 && $reply !== '') {
        $sql = "UPDATE complaint SET reply=?, status=2 WHERE complaint_id=?";
        $res = update($sql, [$reply, $complaint_id]);
        $updated = (bool)$res;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Complaint - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php if ($updated): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Reply Submitted Successfully!',
        }).then(() => {
            window.location.replace('../complaints.php');
        });
    </script>
<?php else: ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Failed to update complaint',
            text: 'Please provide a valid reply.'
        }).then(() => {
            window.location.replace('../complaints.php');
        });
    </script>
<?php endif; ?>
</body>
</html>
