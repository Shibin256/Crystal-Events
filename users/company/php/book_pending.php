<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 3) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid request.";
$company_email = $_SESSION['email'];

if (isset($_POST['edit'])) {
    $book_id = (int)($_POST['book_id'] ?? 0);
    $reply = trim($_POST['reply'] ?? '');

    // Verify ownership
    $check = sel("SELECT bookings.book_id FROM bookings JOIN events ON bookings.event_id = events.event_id WHERE bookings.book_id=? AND events.company_email=?", [$book_id, $company_email]);
    if ($check && mysqli_num_rows($check) > 0) {
        $up = update("UPDATE bookings SET reply=?, book_status=1 WHERE book_id=?", [$reply, $book_id]);
        if ($up) {
            $status = "success";
            $msg = "Booking rejected with reason successfully.";
        } else {
            $msg = "Database error while updating booking.";
        }
    } else {
        $msg = "Booking not found or unauthorized.";
    }
} elseif (isset($_POST['approve'])) {
    $book_id = (int)($_POST['book_id'] ?? 0);
    $price = (float)($_POST['price'] ?? 0);

    if ($price <= 0) {
        $msg = "Please enter a valid price quotation greater than 0.";
    } else {
        $check = sel("SELECT bookings.book_id FROM bookings JOIN events ON bookings.event_id = events.event_id WHERE bookings.book_id=? AND events.company_email=?", [$book_id, $company_email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $up = update("UPDATE bookings SET price=?, book_status=2 WHERE book_id=?", [$price, $book_id]);
            if ($up) {
                $status = "success";
                $msg = "Booking approved and quotation sent!";
            } else {
                $msg = "Database error while approving booking.";
            }
        } else {
            $msg = "Booking not found or unauthorized.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Action - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($msg); ?>
        }).then(() => {
            window.location.replace('../book_pending.php');
        });
    </script>
</body>
</html>
