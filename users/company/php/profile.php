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

$validDistricts = [
    "Kasargod", "Kannur", "Wayanad", "Kozhikode", "Malappuram", "Palakkad",
    "Thrissur", "Ernakulam", "Idukki", "Kottayam", "Alappuzha", "Pathanamthitta",
    "Kollam", "Thiruvananthapuram"
];

if (isset($_POST['edit'])) {
    $name      = trim($_POST['name'] ?? '');
    $ownername = trim($_POST['ownername'] ?? '');
    $phone     = trim($_POST['phone'] ?? '');
    $place     = trim($_POST['place'] ?? '');
    $district  = trim($_POST['district'] ?? '');
    $pincode   = trim($_POST['pincode'] ?? '');
    $est_date  = trim($_POST['est_date'] ?? '');
    $acc_no    = trim($_POST['acc_no'] ?? '');
    $ifsc_code = strtoupper(trim($_POST['ifsc_code'] ?? ''));
    $aadhar    = trim($_POST['aadhar'] ?? '');
    $about     = trim($_POST['about'] ?? '');

    if ($name === '' || $ownername === '' || $phone === '' || $place === '' || $district === '' || $pincode === '') {
        $msg = "Please fill in all required company profile fields.";
    } elseif (strip_tags($name) !== $name || preg_match('/[<>]/', $name)) {
        $msg = "Company name cannot contain HTML tags or special characters.";
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $ownername)) {
        $msg = "Owner name must contain only letters.";
    } elseif (!preg_match('/^\d{10}$/', $phone)) {
        $msg = "Phone number must be exactly 10 digits.";
    } elseif (!in_array($district, $validDistricts)) {
        $msg = "Please select a valid district from the list.";
    } elseif (!preg_match('/^\d{6}$/', $pincode)) {
        $msg = "Pincode must be exactly 6 digits.";
    } elseif ($est_date !== '' && (!strtotime($est_date) || strtotime($est_date) > time())) {
        $msg = "Established date cannot be in the future.";
    } elseif ($acc_no !== '' && !preg_match('/^\d{9,18}$/', $acc_no)) {
        $msg = "Bank account number must be between 9 and 18 digits.";
    } elseif ($ifsc_code !== '' && !preg_match('/^[A-Z]{4}0[A-Z0-9]{6}$/', $ifsc_code)) {
        $msg = "IFSC code format is invalid (4 letters, 0, followed by 6 alphanumeric characters).";
    } elseif ($aadhar !== '' && !preg_match('/^\d{12}$/', $aadhar)) {
        $msg = "Aadhar number must be exactly 12 digits.";
    } elseif (strip_tags($place) !== $place || strip_tags($about) !== $about) {
        $msg = "Form fields cannot contain raw HTML tags.";
    } else {
        $estVal   = ($est_date === '') ? null : $est_date;
        $accVal   = ($acc_no === '') ? null : $acc_no;
        $ifscVal  = ($ifsc_code === '') ? null : $ifsc_code;
        $aadVal   = ($aadhar === '') ? null : $aadhar;

        $sql = "UPDATE company SET name=?, ownername=?, phone=?, place=?, district=?, pincode=?, est_date=?, ifsc_code=?, acc_no=?, aadhar=?, about=? WHERE email=?";
        $res = update($sql, [$name, $ownername, $phone, $place, $district, $pincode, $estVal, $ifscVal, $accVal, $aadVal, $about, $email]);

        if ($res) {
            $status = "success";
            $msg = "Profile updated successfully!";
        } else {
            $msg = "Failed to update company profile in database.";
        }
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