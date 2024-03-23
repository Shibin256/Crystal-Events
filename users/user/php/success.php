<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    require('../../../php/connect.php');
    if (isset($_POST['id'])) {
        $email = $_SESSION['email'];
        $id = $_POST['id'];
        $date = date('Y-m-d H:i:s');


        $sql = "insert into payment (amount,paid_date) values ('50000','$date')";
        insert($sql);

        $pay_id = mysqli_insert_id($conn);


        $bike_id = $id;
        $sql2 = "insert into pro_order (email_id,bike_id,order_date,payment_id) values ('$email','$bike_id','$date','$pay_id')";
        insert($sql2);

        $o_id = mysqli_insert_id($conn);

        $sql3 = "update bike set stock = stock - 1 where bike_id='$bike_id'";
        update($sql3);


        $title = "Payment Success";
        $template = file_get_contents('../../mail-templates/payment.html');
        $template = str_replace('{{amt}}', '50000', $template);
        $template = str_replace('{{id}}', $o_id, $template);
        send_mail($email, $title, $template);

        $_SESSION['menu'] = "book";
    } else {
    ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
            }).then((result) => {
                window.location.replace('../index.php');
            })
        </script>
    <?php

    }

    ?>
</body>

</html>