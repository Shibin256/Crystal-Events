<?php
session_start();
require('../../../php/connect.php');

if (isset($_POST['remove'])) {
    $id = $_POST['id'];

    $sql = "delete from wishlist where wishlist_id='$id'";
    delete($sql);
    echo 1;
    exit();
}
