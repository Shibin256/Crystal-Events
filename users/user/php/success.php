<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    require('../../../php/connect.php');
    if (isset($_POST['success'])) {
        $email = $_SESSION['email'];
        $amt = $_POST['amt'];
        $response = $_POST['response'];
        $date = date('Y-m-d H:i:s');
        $id = $_POST['book_id'];


        $sql = "insert into payment (amount,paid_date,ref_id) values ('$amt','$date','$response')";
        insert($sql);
        echo $sql;

        $pay_id = mysqli_insert_id($conn);


        $sql2 = "update bookings set pay_id1='$pay_id' where book_id='$id'";
        insert($sql2);

        $_SESSION['menu'] = "book";
        exit();
    } else {
    ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
            }).then((result) => {
                window.location.replace('../book_approved.php');
            })
        </script>
    <?php

    }

    ?>
</body>

</html>