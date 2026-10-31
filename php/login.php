<?php
session_start();
require_once __DIR__ . '/connect.php';

$status = "error";
$title = "Incorrect Credentials";
$text = "";
$redirect = "../login.html";

if (isset($_POST['login'])) {
    $email = trim($_POST["email"] ?? '');
    $password = $_POST["password"] ?? '';

    if ($email === '' || $password === '') {
        $title = "Missing Fields";
        $text = "Please enter both email and password.";
    } else {
        $res = sel("SELECT email, password, usertype, status FROM login WHERE email=?", [$email]);
        if ($res && mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_assoc($res);
            $hash = $row['password'];
            $valid = false;

            if (password_verify($password, $hash)) {
                $valid = true;
            } elseif ($password === $hash) {
                // One-time migration from plaintext to bcrypt
                $valid = true;
                $newHash = password_hash($password, PASSWORD_BCRYPT);
                update("UPDATE login SET password=? WHERE email=?", [$newHash, $email]);
            }

            if ($valid) {
                session_regenerate_id(true);
                $_SESSION['email'] = $email;
                $_SESSION['usertype'] = (int)$row['usertype'];
                $_SESSION['status'] = (int)$row['status'];
                $_SESSION['menu'] = 'dash';

                $status = "success";

                // Admin
                if ((int)$row['usertype'] === 1) {
                    $title = "Welcome Back Admin!";
                    $redirect = "../users/admin/";
                }
                // User
                elseif ((int)$row['usertype'] === 2) {
                    if ((int)$row['status'] === 0) {
                        $status = "info";
                        $title = "Account under verification!";
                        $redirect = "../users/user/profile.php";
                    } else {
                        $title = "Welcome Back User!";
                        $redirect = "../users/user/";
                    }
                }
                // Company
                elseif ((int)$row['usertype'] === 3) {
                    if ((int)$row['status'] === 0) {
                        $status = "info";
                        $title = "Account under verification!";
                        $redirect = "../users/company/profile.php";
                    } else {
                        $title = "Welcome Back Company!";
                        $redirect = "../users/company/";
                    }
                }
            } else {
                $title = "Incorrect Credentials";
            }
        } else {
            $title = "Account doesn't exist!";
            $redirect = "../login.html";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - Crystal Events</title>
    <script src="../js/jquery.3.6.1.min.js"></script>
    <script src="../js/sweetalert2@11.js"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($title); ?>,
            text: <?php echo json_encode($text); ?>
        }).then(() => {
            window.location.replace(<?php echo json_encode($redirect); ?>);
        });
    </script>
</body>
</html>
