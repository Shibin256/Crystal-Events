<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 3) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid profile update request.";
$email = $_SESSION['email'];

if (isset($_POST['edit'])) {
    $name = trim($_POST['name'] ?? '');
    $ownername = trim($_POST['ownername'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $place = trim($_POST['place'] ?? '');
    $district = trim($_POST['district'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');
    $est_date = trim($_POST['est_date'] ?? '');
    $acc_no = trim($_POST['acc_no'] ?? '');
    $ifsc_code = trim($_POST['ifsc_code'] ?? '');
    $about = trim($_POST['about'] ?? '');

    if ($est_date === '') {
        $est_date = null;
    }

    $sql = "UPDATE company SET name=?, ownername=?, phone=?, place=?, district=?, pincode=?, est_date=?, ifsc_code=?, acc_no=?, about=? WHERE email=?";
    $res = update($sql, [$name, $ownername, $phone, $place, $district, $pincode, $est_date, $ifsc_code, $acc_no, $about, $email]);

    if ($res) {
        $status = "success";
        $msg = "Profile updated successfully!";
    } else {
        $msg = "Failed to update company profile.";
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
