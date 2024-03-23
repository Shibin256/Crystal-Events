<?php
require('../../../php/connect.php');

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];
    $email = $_POST['email'];




    if ($status == 2) {
        $ddate = date('Y-m-d H:i:s');;

        $sql = "select * from pro_order,bike where bike.bike_id=pro_order.bike_id and order_id='$order_id'";
        $res = sel($sql);
        $row = mysqli_fetch_assoc($res);
        $price = $row['price'];
        $amt = $price - 50000;

        $sql = "insert into payment (amount,paid_date) values ('$amt','$ddate')";
        insert($sql);

        $pay_id = mysqli_insert_id($conn);

        $sql = "update pro_order set status=$status,delivered_date='$ddate',payment_id2='$pay_id' where order_id=$order_id";
        update($sql);

        $title = "Order Delivered";
        $template = file_get_contents('../../mail-templates/order_delivered.html');
        $template = str_replace('{{id}}', $order_id, $template);
        send_mail($email, $title, $template);
    }


    echo 1;
    exit();
} else {
    echo "<script>window.location.replace('../');</script>";
    exit();
}
