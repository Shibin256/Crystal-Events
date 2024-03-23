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
        $t_date = $_POST['t_date'];


        $sql = "insert into payment (amount,paid_date) values ('500','$date')";
        insert($sql);

        $pay_id = mysqli_insert_id($conn);


        $bike_id = $id;
        $sql2 = "insert into test_book (email_id,bike_id,book_date,test_date,payment_id) values ('$email','$bike_id','$date','$t_date','$pay_id')";
        insert($sql2);

        $t_id = mysqli_insert_id($conn);

        $title = "Payment Success";
        $template = file_get_contents('../../mail-templates/payment.html');
        $template = str_replace('{{amt}}', '500', $template);
        $template = str_replace('{{id}}', $t_id, $template);
        send_mail($email, $title, $template);

        $_SESSION['menu'] = "book";

        echo 1;
        exit();
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