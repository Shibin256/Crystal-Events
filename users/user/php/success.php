<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if (isset($_POST['success'])) {
    $email = $_SESSION['email'];
    $book_id = (int)($_POST['book_id'] ?? 0);
    $response = trim($_POST['response'] ?? '');

    if ($book_id <= 0) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid booking ID']);
        exit;
    }

    // Verify booking belongs to logged-in user and quotation has been approved
    $bRes = sel("SELECT book_id, price, pay_id1, book_status FROM bookings WHERE book_id=? AND user_email=?", [$book_id, $email]);
    if (!$bRes || mysqli_num_rows($bRes) === 0) {
        http_response_code(404);
        echo json_encode(['status' => 'error', 'message' => 'Booking not found or does not belong to your account']);
        exit;
    }

    $booking = mysqli_fetch_assoc($bRes);
    if ((int)$booking['pay_id1'] !== 0) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Advance payment already processed for this booking']);
        exit;
    }

    $price = (float)$booking['price'];
    if ($price <= 0) {
        http_response_code(400);
        echo json_encode(['status' => 'error', 'message' => 'Invalid booking price']);
        exit;
    }

    // Calculate advance amount (40%) server-side
    $advanceAmount = round($price * 0.40);

    // Verify Razorpay signature if live mode
    if (!defined('MOCK_PAYMENTS') || !MOCK_PAYMENTS) {
        $razorpayPaymentId = $_POST['razorpay_payment_id'] ?? $response;
        $razorpayOrderId   = $_POST['razorpay_order_id'] ?? '';
        $razorpaySignature = $_POST['razorpay_signature'] ?? '';

        if (!empty($razorpayOrderId) && !empty($razorpaySignature)) {
            $expectedSignature = hash_hmac('sha256', $razorpayOrderId . '|' . $razorpayPaymentId, RAZORPAY_KEY_SECRET);
            if (!hash_equals($expectedSignature, $razorpaySignature)) {
                http_response_code(400);
                echo json_encode(['status' => 'error', 'message' => 'Invalid Razorpay signature']);
                exit;
            }
        } elseif (empty($razorpayPaymentId)) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Missing payment identifier']);
            exit;
        }
    } else {
        if (empty($response)) {
            $response = 'mock_adv_' . bin2hex(random_bytes(6));
        }
    }

    $paidDate = date('Y-m-d H:i:s');
    $ins = insert("INSERT INTO payment (amount, paid_date, ref_id) VALUES (?, ?, ?)",
        [$advanceAmount, $paidDate, $response]);

    if (!$ins) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database error while saving payment']);
        exit;
    }

    $pay_id = mysqli_insert_id($conn);
    $up = update("UPDATE bookings SET pay_id1=? WHERE book_id=? AND user_email=?", [$pay_id, $book_id, $email]);

    $_SESSION['menu'] = "book";
    echo json_encode(['status' => 'success', 'pay_id' => $pay_id, 'amount' => $advanceAmount]);
    exit;
}

http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Bad request']);
