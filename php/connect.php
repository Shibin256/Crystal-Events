<?php
$conn = mysqli_connect('localhost', "root", "", "crystal-events");
if (!$conn)
    die("connection fail");

date_default_timezone_set("Asia/Kolkata");

function insert($sql)
{
    global $conn;
    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
        return false;
    } else
        return $conn;
}

function num($sql)
{
    global $conn;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $numrow = mysqli_num_rows($result);
        return $numrow;
    } else {
        return false;
    }
}

function sel($sql)
{
    global $conn;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        return $result;
    } else {
        return false;
    }
}

function update($sql)
{
    global $conn;
    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
        return false;
    } else
        return true;
}

function delete($sql)
{
    global $conn;
    if (!mysqli_query($conn, $sql)) {
        echo mysqli_error($conn);
        return false;
    } else
        return true;
}

function send_mail($email, $title, $body)
{
    if (mail($email, $title, $body, "From: Crystal Events<crystalevents@gmail.com>\r\nMIME-Version: 1.0\r\nContent-Type: text/html; charset=UISO-8859-1\r\n"))
        return 1;
    else
        return 0;
}
