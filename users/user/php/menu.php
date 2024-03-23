<?php
    session_start();

    if(isset($_POST['id'])) {
        $_SESSION['menu']=$_POST['id'];
        echo 1;
    }
?>