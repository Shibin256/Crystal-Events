<?php
session_start();
require('../../../php/connect.php');

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $email = $_SESSION['email'];

    $sql = "insert into cart (event_id,user) values ('$id','$email')";
    insert($sql);
    echo 1;
    exit();
}

if (isset($_POST['remove'])) {
    $id = $_POST['id'];
    $email = $_SESSION['email'];

    $sql = "delete from cart where event_id='$id' and user='$email'";
    delete($sql);
    echo 1;
    exit();
}
