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
        $name = $_POST['name'];
        $ownername = $_POST['ownername'];
        $email = $_SESSION['email'];
        $phone = $_POST['phone'];
        $place = $_POST['place'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $est_date = $_POST['est_date'];
        $acc_no = $_POST['acc_no'];
        $ifsc_code = $_POST['ifsc_code'];
        $about = $_POST['about'];



        $sql = "UPDATE `company` SET `name`='$name',`ownername`='$ownername',`phone`='$phone',`place`='$place',`district`='$district',`pincode`='$pincode',`est_date`='$est_date',`ifsc_code`='$ifsc_code',`acc_no`='$acc_no',`about`='$about' where email='$email'";

        update($sql);
    ?>
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Updated successfully!',
    }).then((result) => {
        window.location.replace('../profile.php');
    })
    </script>

    <?php

    }

    ?>
</body>

</html>