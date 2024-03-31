<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    require('../../../php/connect.php');
    if (isset($_POST['edit'])) {
        $book_id = $_POST['book_id'];
        $date_time = $_POST['date_time'];
        $place = $_POST['place'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $requirements = $_POST['requirements'];



        $sql = "update bookings set event_date_time='$date_time',event_place='$place',event_district='$district',event_pincode='$pincode',requirements='$requirements',book_status=0 where book_id='$book_id'";

        update($sql);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Updated successfully!',
            }).then((result) => {
                window.location.replace('../book_pending.php');
            })
        </script>

    <?php

    }
    if (isset($_POST['cancel'])) {
        $book_id = $_POST['book_id'];
        $sql = "delete from bookings where book_id='$book_id'";
        delete($sql);
        echo 1;
        exit();
    }

    ?>
</body>

</html>