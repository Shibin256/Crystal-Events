<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 1) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid category.";

if (isset($_POST['add'])) {
    $cat_title = trim($_POST['cat_title'] ?? '');
    if ($cat_title !== '') {
        $check = sel("SELECT cat_id FROM category WHERE cat_title=?", [$cat_title]);
        if ($check && mysqli_num_rows($check) > 0) {
            $msg = "This category already exists.";
        } else {
            $ins = insert("INSERT INTO category (cat_title) VALUES (?)", [$cat_title]);
            if ($ins) {
                $status = "success";
                $msg = "Category Added Successfully!";
            } else {
                $msg = "Database error while adding category.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Category - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($msg); ?>,
        }).then(() => {
            window.location.replace('../category.php');
        });
    </script>
</body>
</html>
