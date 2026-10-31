<?php
session_start();
require_once __DIR__ . '/connect.php';

$status = "error";
$title = "Invalid Credentials";
$text = "";
$redirect = "../login.html";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $title = "Invalid Request Method";
    $text = "Only POST requests are permitted.";
} elseif (isset($_POST['login'])) {
    $email = strtolower(trim($_POST["email"] ?? ''));
    $password = $_POST["password"] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    if ($email === '' || $password === '') {
        $title = "Missing Fields";
        $text = "Please enter both email and password.";
    } else {
        // Brute force check: 5 failed attempts per email/IP in the last 10 minutes
        $attemptCheck = sel("SELECT COUNT(*) as failed FROM login_attempts WHERE email=? AND ip_address=? AND attempt_time > (NOW() - INTERVAL 10 MINUTE)", [$email, $ip]);
        $failCount = 0;
        if ($attemptCheck) {
            $row = mysqli_fetch_assoc($attemptCheck);
            $failCount = (int)($row['failed'] ?? 0);
        }

        if ($failCount >= 5) {
            $title = "Account Locked";
            $text = "Too many failed login attempts. Please try again after 10 minutes.";
        } else {
            $res = sel("SELECT email, password, usertype, status FROM login WHERE LOWER(email)=?", [$email]);
            $loginSuccess = false;
            $userRow = null;

            if ($res && mysqli_num_rows($res) > 0) {
                $userRow = mysqli_fetch_assoc($res);
                $hash = $userRow['password'];

                if (password_verify($password, $hash)) {
                    $loginSuccess = true;
                } elseif ($password === $hash) {
                    // One-time migration from legacy plaintext password to bcrypt
                    $loginSuccess = true;
                    $newHash = password_hash($password, PASSWORD_BCRYPT);
                    update("UPDATE login SET password=? WHERE email=?", [$newHash, $userRow['email']]);
                }
            }

            if ($loginSuccess && $userRow) {
                // Clear failed attempts on successful login
                delete("DELETE FROM login_attempts WHERE email=? OR ip_address=?", [$email, $ip]);

                session_regenerate_id(true);
                $_SESSION['email'] = $userRow['email'];
                $_SESSION['usertype'] = (int)$userRow['usertype'];
                $_SESSION['status'] = (int)$userRow['status'];
                $_SESSION['menu'] = 'dash';
                $_SESSION['last_activity'] = time();

                $status = "success";

                // Admin
                if ((int)$userRow['usertype'] === 1) {
                    $title = "Welcome Back Admin!";
                    $redirect = "../users/admin/";
                }
                // User
                elseif ((int)$userRow['usertype'] === 2) {
                    if ((int)$userRow['status'] === 0) {
                        $status = "info";
                        $title = "Account under verification!";
                        $redirect = "../users/user/profile.php";
                    } else {
                        $title = "Welcome Back User!";
                        $redirect = "../users/user/";
                    }
                }
                // Company
                elseif ((int)$userRow['usertype'] === 3) {
                    if ((int)$userRow['status'] === 0) {
                        $status = "info";
                        $title = "Account under verification!";
                        $redirect = "../users/company/profile.php";
                    } else {
                        $title = "Welcome Back Company!";
                        $redirect = "../users/company/";
                    }
                }
            } else {
                // Record failed login attempt
                insert("INSERT INTO login_attempts (ip_address, email, attempt_time) VALUES (?, ?, NOW())", [$ip, $email]);

                $title = "Invalid Credentials";
                $text = "Invalid email or password.";
            }
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
