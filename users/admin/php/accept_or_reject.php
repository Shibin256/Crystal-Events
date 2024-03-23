<?php
require('../../../php/connect.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $status = $_POST['status'];
    $user = $_POST['user'];
    if ($user == "user") {
        if ($status == 1) {
            $sql = "update login set status=1 where email='$email'";
            update($sql);
            echo 1;
            exit();
        } else {
            $sql = "delete from login where email='$email'";
            delete($sql);
            $sql = "delete from users where email='$email'";
            delete($sql);
            echo 1;
            exit();
        }
    } else {
        if ($status == 1) {
            $sql = "update login set status=1 where email='$email'";
            update($sql);
            echo 1;
            exit();
        } else {
            $sql = "delete from login where email='$email'";
            delete($sql);
            $sql = "delete from company where email='$email'";
            delete($sql);
            echo 1;
            exit();
        }
    }
}
