<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    require('../../../php/connect.php');
    if (isset($_POST['add'])) {
        $id = $_POST['id'];
        $email = $_SESSION['email'];

        $sql = "insert into cart (event_id,user) values ('$id','$email')";
        insert($sql);
        echo 1;
        exit();
    }
    if (isset($_POST['remove'])) {
        $id = $_POST['id'];

        $sql = "delete from cart where cart_id='$id'";
        delete($sql);
        echo 1;
        exit();
    }
    if (isset($_POST['cart'])) {
        $email = $_SESSION['email'];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'event_id') !== false) {
                echo $key . "    " . $value . "<br>";
                $event_id = $_POST[$key];
                $date = $_POST[$event_id . '_date'];
                $place = $_POST[$event_id . '_place'];
                $district = $_POST[$event_id . '_district'];
                $pincode = $_POST[$event_id . '_pincode'];
                $req = $_POST[$event_id . '_req'];
                $sql = "insert into bookings (event_id,user_email,requirements,event_date_time,event_place,event_district,event_pincode) values ('$event_id','$email','$req','$date','$place','$district','$pincode')";
                insert($sql);
            }
        }

        $sql = "delete from cart where user='$email'";
        delete($sql);




    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Booking Added Successfully!',
            }).then((result) => {
                window.location.replace('../book_pending.php');
            })
        </script>

    <?php

    }

    ?>
</body>

</html>