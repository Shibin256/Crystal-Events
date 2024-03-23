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
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_SESSION['email'];
        $phone = $_POST['phone'];
        $housename = $_POST['housename'];
        $place = $_POST['place'];
        $district = $_POST['district'];
        $pincode = $_POST['pincode'];
        $date_of_birth = $_POST['date_of_birth'];
        $acc_no = $_POST['acc_no'];
        $ifsc_code = $_POST['ifsc_code'];



        $sql = "UPDATE `users` SET `firstname`='$firstname',`lastname`='$lastname',`phone`='$phone',`housename`='$housename',`place`='$place',`district`='$district',`pincode`='$pincode',`date_of_birth`='$date_of_birth',`ifsc_code`='$ifsc_code',`acc_no`='$acc_no' where email='$email'";

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