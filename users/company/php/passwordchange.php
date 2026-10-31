<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 3) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$title = "Error!";
$text = "Invalid request.";

if (isset($_POST['edit'])) {
    $cpass = $_POST['cpass'] ?? '';
    $npass = $_POST['npass'] ?? '';
    $email = $_SESSION['email'];

    if ($cpass === '' || $npass === '') {
        $text = "Both current and new passwords are required.";
    } elseif (strlen($npass) < 6) {
        $text = "New password must be at least 6 characters.";
    } else {
        $res = sel("SELECT password FROM login WHERE email=?", [$email]);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $stored = $row['password'];

            if (password_verify($cpass, $stored) || $cpass === $stored) {
                $newHash = password_hash($npass, PASSWORD_BCRYPT);
                $up = update("UPDATE login SET password=? WHERE email=?", [$newHash, $email]);
                if ($up) {
                    $status = "success";
                    $title = "Success!";
                    $text = "Password updated successfully.";
                } else {
                    $text = "Failed to update password in database.";
                }
            } else {
                $text = "Current password is incorrect.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Change Password - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($title); ?>,
            text: <?php echo json_encode($text); ?>
        }).then(() => {
            window.location.replace('../index.php');
        });
    </script>
</body>
</html>
