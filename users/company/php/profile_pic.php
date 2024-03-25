<?php
session_start();
require('../../../php/connect.php');

if (isset($_FILES["file"])) {
    $email = $_SESSION['email'];
    $targetDirectory = "../uploads/profile/";
    $originalFileName = basename($_FILES["file"]["name"]);
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $newFileName = str_replace(['@', '.'], '', $email) . "." . $fileExtension;
    $targetFile = $targetDirectory . $newFileName;
    $sql = "select profile_pic from company where email='$email'";
    $res = sel($sql);
    $row = mysqli_fetch_assoc($res);
    $oldFile = $row['profile_pic'];
    $oldFilePath = '../uploads/profile/' . $oldFile;
    if ($oldFile != 'default.jpg') {
        unlink($oldFilePath);
    }
    $sql = "UPDATE `company` SET profile_pic='$newFileName' where email='$email'";
    update($sql);
    move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile);
    echo 1;
    exit();
}