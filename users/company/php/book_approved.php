<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 3) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if (isset($_POST['book_id'])) {
    $book_id = (int)$_POST['book_id'];
    $company_email = $_SESSION['email'];

    // Verify booking belongs to this company and is fully paid
    $check = sel("SELECT bookings.book_id FROM bookings JOIN events ON bookings.event_id = events.event_id WHERE bookings.book_id=? AND events.company_email=?", [$book_id, $company_email]);
    if ($check && mysqli_num_rows($check) > 0) {
        update("UPDATE bookings SET book_status=3 WHERE book_id=?", [$book_id]);
        echo 1;
        exit;
    } else {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Booking not found or unauthorized']);
        exit;
    }
}

http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Bad request']);
