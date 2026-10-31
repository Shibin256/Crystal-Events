<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    if (isset($_POST['cancel'])) {
        http_response_code(403);
        echo 0;
        exit;
    }
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid request.";
$email = $_SESSION['email'];

if (isset($_POST['edit'])) {
    $book_id = (int)($_POST['book_id'] ?? 0);
    $date_time = trim($_POST['date_time'] ?? '');
    $place = trim($_POST['place'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $requirements = trim($_POST['requirements'] ?? '');

    // Verify booking belongs to this user and is pending or rejected
    $check = sel("SELECT book_id FROM bookings WHERE book_id=? AND user_email=?", [$book_id, $email]);
    if ($check && mysqli_num_rows($check) > 0) {
        $sql = "UPDATE bookings SET event_date_time=?, event_place=?, event_district=?, event_pincode=?, requirements=?, book_status=0 WHERE book_id=? AND user_email=?";
        $res = update($sql, [$date_time, $place, $district, $pincode, $requirements, $book_id, $email]);
        if ($res) {
            $status = "success";
            $msg = "Updated successfully!";
        } else {
            $msg = "Database error while updating booking.";
        }
    } else {
        $msg = "Booking not found or unauthorized.";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Booking - Crystal Events</title>
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
<?php
    exit;
}

if (isset($_POST['cancel'])) {
    $book_id = (int)($_POST['book_id'] ?? 0);
    // Allow cancellation only if advance payment has NOT been made
    $check = sel("SELECT book_id, pay_id1 FROM bookings WHERE book_id=? AND user_email=?", [$book_id, $email]);
    if ($check && mysqli_num_rows($check) > 0) {
        $row = mysqli_fetch_assoc($check);
        if ((int)$row['pay_id1'] === 0) {
            delete("DELETE FROM bookings WHERE book_id=? AND user_email=?", [$book_id, $email]);
            echo 1;
            exit;
        } else {
            http_response_code(400);
            echo "Cannot cancel booking with advance payment processed.";
            exit;
        }
    }
    http_response_code(404);
    echo 0;
    exit;
}
?>
