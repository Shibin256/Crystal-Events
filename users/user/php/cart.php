<?php
session_start();
require('../../../php/connect.php');

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $email = $_SESSION['email'];

    $sql = "insert into wishlist (bike_id,email_id) values ('$id','$email')";
    insert($sql);
    echo 1;
    exit();
}

if (isset($_POST['remove'])) {
    $id = $_POST['id'];

    $sql = "delete from wishlist where wishlist_id='$id'";
    delete($sql);
    echo 1;
    exit();
}
