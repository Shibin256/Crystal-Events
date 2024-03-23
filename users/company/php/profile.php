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
        $fname = $_POST['fname'];
        $lname = $_POST['lname'];
        $email = $_SESSION['email'];
        $contact_number = $_POST['mobile'];
        $housename = $_POST['hname'];
        $streetname = $_POST['sname'];
        $district = $_POST['district'];
        $pincode = $_POST['pcode'];
        $date_of_birth = $_POST['dob'];
        $account_number = $_POST['accnum'];
        $ifsc_code = $_POST['ifsccode'];



        $sql = "UPDATE `customer` SET `first_name`='$fname',`last_name`='$lname',`phone_no`='$contact_number',`housename`='$housename',`streetname`='$streetname',`district`='$district',`pincode`='$pincode',`date_of_birth`='$date_of_birth',`ifsc_code`='$ifsc_code',`account_number`='$account_number' where email_id='$email'";

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