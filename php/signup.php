<?php
session_start();
require_once __DIR__ . '/connect.php';

$status = "error";
$title = "Registration Failed";
$text = "Please check your inputs.";
$redirect = "../login.html";

if (isset($_POST['user'])) {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($firstname === '' || $lastname === '' || $email === '' || $password === '') {
        $text = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $text = "Please enter a valid email address.";
    } else {
        $check = sel("SELECT email FROM login WHERE email=?", [$email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $title = "Account already exists!";
            $text = "An account with this email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $uRes = insert("INSERT INTO users (firstname, lastname, email, profile_pic) VALUES (?, ?, ?, 'default.jpg')",
                [$firstname, $lastname, $email]);
            $lRes = insert("INSERT INTO login (email, password, usertype, status) VALUES (?, ?, 2, 0)",
                [$email, $hashedPassword]);

            if ($uRes && $lRes) {
                $status = "success";
                $title = "Registration Success!";
                $text = "Your user account has been registered and is pending admin verification.";
            } else {
                $text = "Database error during registration.";
            }
        }
    }
} elseif (isset($_POST['company'])) {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        $text = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $text = "Please enter a valid email address.";
    } else {
        $check = sel("SELECT email FROM login WHERE email=?", [$email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $title = "Account already exists!";
            $text = "An account with this email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $cRes = insert("INSERT INTO company (name, email, profile_pic) VALUES (?, ?, 'default.jpg')",
                [$name, $email]);
            $lRes = insert("INSERT INTO login (email, password, usertype, status) VALUES (?, ?, 3, 0)",
                [$email, $hashedPassword]);

            if ($cRes && $lRes) {
                $status = "success";
                $title = "Registration Success!";
                $text = "Your company account has been registered and is pending admin verification.";
            } else {
                $text = "Database error during registration.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registration - Crystal Events</title>
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
