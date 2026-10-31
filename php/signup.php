<?php
session_start();
require_once __DIR__ . '/connect.php';

$status = "error";
$title = "Registration Failed";
$text = "Please check your inputs.";
$redirect = "../login.html";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $title = "Invalid Request Method";
    $text = "Only POST requests are permitted.";
} elseif (isset($_POST['usertype']) && (int)$_POST['usertype'] === 1) {
    $title = "Registration Failed";
    $text = "Unauthorized registration role. Self-registration as administrator is not permitted.";
} elseif (isset($_POST['user'])) {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';
    $phone = trim($_POST['phone'] ?? '');

    if ($firstname === '' || $lastname === '' || $email === '' || $password === '' || $cpassword === '') {
        $text = "All fields are required and cannot be empty or whitespace only.";
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $firstname) || !preg_match("/^[a-zA-Z\s'-]+$/", $lastname)) {
        $text = "Names must contain only letters and cannot include digits or HTML.";
    } elseif (strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, ' ') !== false || substr_count($email, '@') !== 1 || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $text = "Please enter a valid email address (maximum 255 characters).";
    } elseif (strlen($password) < 8) {
        $text = "Password must be at least 8 characters long.";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)/', $password)) {
        $text = "Password must contain both letters and numbers.";
    } elseif ($password !== $cpassword) {
        $text = "Passwords do not match.";
    } elseif ($phone !== '' && !preg_match('/^\d{10}$/', $phone)) {
        $text = "Phone number must be a valid 10-digit number.";
    } else {
        $check = sel("SELECT email FROM login WHERE LOWER(email)=?", [$email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $title = "Account already exists!";
            $text = "An account with this email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $lRes = insert("INSERT INTO login (email, password, usertype, status) VALUES (?, ?, 2, 0)",
                [$email, $hashedPassword]);
            $uRes = insert("INSERT INTO users (firstname, lastname, email, phone, profile_pic) VALUES (?, ?, ?, ?, 'default.jpg')",
                [$firstname, $lastname, $email, ($phone !== '' ? $phone : null)]);

            if ($lRes && $uRes) {
                $status = "success";
                $title = "Registration Success!";
                $text = "Your user account has been registered and is pending admin verification.";
            } else {
                delete("DELETE FROM login WHERE email=?", [$email]);
                delete("DELETE FROM users WHERE email=?", [$email]);
                $text = "Database error during registration.";
            }
        }
    }
} elseif (isset($_POST['company'])) {
    $name = trim($_POST['name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $cpassword = $_POST['cpassword'] ?? '';
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $email === '' || $password === '' || $cpassword === '') {
        $text = "All fields are required and cannot be empty or whitespace only.";
    } elseif (strip_tags($name) !== $name || preg_match('/[<>]/', $name)) {
        $text = "Company name cannot contain HTML tags or special characters.";
    } elseif (strlen($email) > 255 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strpos($email, ' ') !== false || substr_count($email, '@') !== 1 || !preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
        $text = "Please enter a valid email address (maximum 255 characters).";
    } elseif (strlen($password) < 8) {
        $text = "Password must be at least 8 characters long.";
    } elseif (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)/', $password)) {
        $text = "Password must contain both letters and numbers.";
    } elseif ($password !== $cpassword) {
        $text = "Passwords do not match.";
    } elseif ($phone !== '' && !preg_match('/^\d{10}$/', $phone)) {
        $text = "Phone number must be a valid 10-digit number.";
    } else {
        $check = sel("SELECT email FROM login WHERE LOWER(email)=?", [$email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $title = "Account already exists!";
            $text = "An account with this email is already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $lRes = insert("INSERT INTO login (email, password, usertype, status) VALUES (?, ?, 3, 0)",
                [$email, $hashedPassword]);
            $cRes = insert("INSERT INTO company (name, email, phone, profile_pic) VALUES (?, ?, ?, 'default.jpg')",
                [$name, $email, ($phone !== '' ? $phone : null)]);

            if ($lRes && $cRes) {
                $status = "success";
                $title = "Registration Success!";
                $text = "Your company account has been registered and is pending admin verification.";
            } else {
                delete("DELETE FROM login WHERE email=?", [$email]);
                delete("DELETE FROM company WHERE email=?", [$email]);
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
