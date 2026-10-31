<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 2) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid request.";

if (isset($_POST['add'])) {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $category_id = (int)($_POST['category_id'] ?? 0);
    $email = $_SESSION['email'];

    if ($name === '' || $category_id <= 0 || $description === '') {
        $msg = "Please fill in all required fields.";
    } else {
        // Check for duplicate event under the same company
        $check = sel("SELECT event_id FROM events WHERE name=? AND company_email=?", [$name, $email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $msg = "An event with this name already exists in your catalogue!";
        } else {
            $sql = "INSERT INTO events (name, category, description, company_email) VALUES (?, ?, ?, ?)";
            $inserted = insert($sql, [$name, $category_id, $description, $email]);
            if ($inserted) {
                $status = "success";
                $msg = "Event Added Successfully!";
            } else {
                $msg = "Database error while adding event.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Add Event - Crystal Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php if ($status === "success"): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: <?php echo json_encode($msg); ?>,
        }).then(() => {
            window.location.replace('../viewevents.php');
        });
    </script>
<?php else: ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: <?php echo json_encode($msg); ?>,
        }).then(() => {
            window.location.replace('../addevents.php');
        });
    </script>
<?php endif; ?>
</body>
</html>
