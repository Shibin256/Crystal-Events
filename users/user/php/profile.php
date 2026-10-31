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

$validDistricts = [
    "Kasargod", "Kannur", "Wayanad", "Kozhikode", "Malappuram", "Palakkad",
    "Thrissur", "Ernakulam", "Idukki", "Kottayam", "Alappuzha", "Pathanamthitta",
    "Kollam", "Thiruvananthapuram"
];

if (isset($_POST['edit'])) {
    $firstname     = trim($_POST['firstname'] ?? '');
    $lastname      = trim($_POST['lastname'] ?? '');
    $phone         = trim($_POST['phone'] ?? '');
    $housename     = trim($_POST['housename'] ?? '');
    $place         = trim($_POST['place'] ?? '');
    $district      = trim($_POST['district'] ?? '');
    $pincode       = trim($_POST['pincode'] ?? '');
    $date_of_birth = trim($_POST['date_of_birth'] ?? '');
    $acc_no        = trim($_POST['acc_no'] ?? '');
    $ifsc_code     = strtoupper(trim($_POST['ifsc_code'] ?? ''));

    if ($firstname === '' || $lastname === '' || $phone === '' || $place === '' || $district === '' || $pincode === '') {
        $msg = "Please fill in all required profile fields.";
    } elseif (!preg_match("/^[a-zA-Z\s'-]+$/", $firstname) || !preg_match("/^[a-zA-Z\s'-]+$/", $lastname)) {
        $msg = "First and last names must contain only letters.";
    } elseif (!preg_match('/^\d{10}$/', $phone)) {
        $msg = "Phone number must be exactly 10 digits.";
    } elseif (!in_array($district, $validDistricts)) {
        $msg = "Please select a valid district from the list.";
    } elseif (!preg_match('/^\d{6}$/', $pincode)) {
        $msg = "Pincode must be exactly 6 digits.";
    } elseif ($date_of_birth !== '' && (!strtotime($date_of_birth) || strtotime($date_of_birth) > strtotime('-10 years') || strtotime($date_of_birth) < strtotime('-120 years'))) {
        $msg = "Please provide a valid date of birth (must represent an age between 10 and 120 years).";
    } elseif ($acc_no !== '' && !preg_match('/^\d{9,18}$/', $acc_no)) {
        $msg = "Bank account number must be between 9 and 18 digits.";
    } elseif ($ifsc_code !== '' && !preg_match('/^[A-Z]{4}0[A-Z0-9]{6}$/', $ifsc_code)) {
        $msg = "IFSC code format is invalid (4 letters, 0, followed by 6 alphanumeric characters).";
    } elseif (strip_tags($housename) !== $housename || strip_tags($place) !== $place) {
        $msg = "Address fields cannot contain HTML tags.";
    } else {
        $dobVal = ($date_of_birth === '') ? null : $date_of_birth;
        $accVal = ($acc_no === '') ? null : $acc_no;
        $ifscVal = ($ifsc_code === '') ? null : $ifsc_code;

        $sql = "UPDATE users SET firstname=?, lastname=?, phone=?, housename=?, place=?, district=?, pincode=?, date_of_birth=?, ifsc_code=?, acc_no=? WHERE email=?";
        $res = update($sql, [$firstname, $lastname, $phone, $housename, $place, $district, $pincode, $dobVal, $ifscVal, $accVal, $email]);

        if ($res) {
            $status = "success";
            $msg = "Profile updated successfully!";
        } else {
            $msg = "Failed to update profile in database.";
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