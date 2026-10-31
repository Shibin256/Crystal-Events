<?php
session_start();
require_once __DIR__ . '/connect.php';

$status = "error";
$title = "Failed to send message";
$text = "Please fill in all required fields.";

if (isset($_POST['add'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $message === '') {
        $text = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $text = "Please provide a valid email address.";
    } else {
        $ins = insert("INSERT INTO contact (name, email, message) VALUES (?, ?, ?)",
            [$name, $email, $message]);
        if ($ins) {
            $status = "success";
            $title = "Message Sent!";
            $text = "Thank you for contacting us. We will get back to you soon.";
        } else {
            $text = "Database error while sending message.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Contact Us - Crystal Events</title>
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
