<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid review submission.";
$email = $_SESSION['email'];

if (isset($_POST['add'])) {
    $book_id = (int)($_POST['book_id'] ?? 0);
    $rate = (int)($_POST['rate'] ?? 5);
    $review = trim($_POST['review'] ?? '');
    $rdate = date('Y-m-d H:i:s');

    if ($rate < 1) $rate = 1;
    if ($rate > 5) $rate = 5;

    // Verify booking belongs to this user and is completed
    $check = sel("SELECT book_id FROM bookings WHERE book_id=? AND user_email=?", [$book_id, $email]);
    if ($check && mysqli_num_rows($check) > 0) {
        // Prevent duplicate review on same booking
        $existing = sel("SELECT review_id FROM review WHERE book_id=?", [$book_id]);
        if ($existing && mysqli_num_rows($existing) > 0) {
            $msg = "You have already submitted a review for this event booking.";
        } else {
            $sql = "INSERT INTO review (review, star, review_date, book_id) VALUES (?, ?, ?, ?)";
            $ins = insert($sql, [$review, $rate, $rdate, $book_id]);
            if ($ins) {
                $status = "success";
                $msg = "Review Added Successfully!";
            } else {
                $msg = "Database error while adding review.";
            }
        }
    } else {
        $msg = "Booking not found or does not belong to your account.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Submit Review - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($msg); ?>
        }).then(() => {
            window.location.replace('../book_completed.php');
        });
    </script>
</body>
</html>
