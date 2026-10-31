<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    if (isset($_POST['add']) || isset($_POST['remove'])) {
        http_response_code(403);
        echo 0;
        exit;
    }
    header("Location: ../../../login.html");
    exit;
}

$email = $_SESSION['email'];

if (isset($_POST['add'])) {
    $event_id = (int)($_POST['id'] ?? 0);
    if ($event_id > 0) {
        // Prevent duplicate cart items
        $check = sel("SELECT cart_id FROM cart WHERE event_id=? AND user=?", [$event_id, $email]);
        if ($check && mysqli_num_rows($check) === 0) {
            insert("INSERT INTO cart (event_id, user) VALUES (?, ?)", [$event_id, $email]);
        }
        echo 1;
        exit;
    }
    echo 0;
    exit;
}

if (isset($_POST['remove'])) {
    $id = (int)($_POST['id'] ?? 0);
    if ($id > 0) {
        // Safe delete matching either cart_id or event_id, scoped strictly to the logged-in user
        delete("DELETE FROM cart WHERE user=? AND (cart_id=? OR event_id=?)", [$email, $id, $id]);
        echo 1;
        exit;
    }
    echo 0;
    exit;
}

if (isset($_POST['cart'])) {
    $insertedCount = 0;
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'event_id') === 0 && is_numeric($value)) {
            $event_id = (int)$value;
            $date = trim($_POST[$event_id . '_date'] ?? '');
            $place = trim($_POST[$event_id . '_place'] ?? '');
            $district = trim($_POST[$event_id . '_district'] ?? '');
            $pincode = trim($_POST[$event_id . '_pincode'] ?? '');
            $req = trim($_POST[$event_id . '_req'] ?? '');

            if ($event_id > 0 && $date !== '' && $place !== '') {
                $sql = "INSERT INTO bookings (event_id, user_email, requirements, event_date_time, event_place, event_district, event_pincode, book_status) VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
                $ins = insert($sql, [$event_id, $email, $req, $date, $place, $district, $pincode]);
                if ($ins) {
                    $insertedCount++;
                }
            }
        }
    }

    // Clear cart for this user
    delete("DELETE FROM cart WHERE user=?", [$email]);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Submitted - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Bookings Submitted Successfully!',
            text: 'Your request has been sent to the event organizers for quotation.'
        }).then(() => {
            window.location.replace('../book_pending.php');
        });
    </script>
</body>
</html>
<?php
    exit;
}
?>
