<?php
session_start();
require('../../../php/connect.php');

if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];

    $sql = "update bookings set book_status=3 where book_id=$book_id";
    update($sql);

    echo 1;
    exit();
}
