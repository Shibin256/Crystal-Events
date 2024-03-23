<?php
require('../../../php/connect.php');

if (isset($_POST['book_id'])) {
    $book_id = $_POST['book_id'];
    $status = $_POST['status'];
    $email = $_POST['email'];




    if ($status == 2) {


        $sql = "update test_book set status=$status where book_id=$book_id";
        update($sql);

        $title = "Test Drive";
        $template = file_get_contents('../../mail-templates/test_drive_complete.html');
        $template = str_replace('{{id}}', $book_id, $template);
        send_mail($email, $title, $template);
    }


    echo 1;
    exit();
} else {
    echo "<script>window.location.replace('../');</script>";
    exit();
}
