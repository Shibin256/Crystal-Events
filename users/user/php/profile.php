<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid profile update request.";
$email = $_SESSION['email'];

if (isset($_POST['edit'])) {
    $firstname = trim($_POST['firstname'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $housename = trim($_POST['housename'] ?? '');
    $place = trim($_POST['place'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $date_of_birth = trim($_POST['date_of_birth'] ?? '');
    $acc_no = trim($_POST['acc_no'] ?? '');
    $ifsc_code = trim($_POST['ifsc_code'] ?? '');

    if ($date_of_birth === '') {
        $date_of_birth = null;
    }

    $sql = "UPDATE users SET firstname=?, lastname=?, phone=?, housename=?, place=?, district=?, pincode=?, date_of_birth=?, ifsc_code=?, acc_no=? WHERE email=?";
    $res = update($sql, [$firstname, $lastname, $phone, $housename, $place, $district, $pincode, $date_of_birth, $ifsc_code, $acc_no, $email]);

    if ($res) {
        $status = "success";
        $msg = "Profile updated successfully!";
    } else {
        $msg = "Failed to update profile.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Update Profile - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            icon: <?php echo json_encode($status); ?>,
            title: <?php echo json_encode($msg); ?>
        }).then(() => {
            window.location.replace('../profile.php');
        });
    </script>
</body>
</html>
