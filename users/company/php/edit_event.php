<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 3) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid request.";

if (isset($_POST['edit'])) {
    $event_id = (int)($_POST['event_id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $category = (int)($_POST['category_id'] ?? 0);
    $description = trim($_POST['description'] ?? '');
    $email = $_SESSION['email'];

    if ($event_id > 0 && $name !== '' && $category > 0 && $description !== '') {
        $check = sel("SELECT event_id FROM events WHERE event_id=? AND company_email=?", [$event_id, $email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $up = update("UPDATE events SET name=?, category=?, description=? WHERE event_id=? AND company_email=?",
                [$name, $category, $description, $event_id, $email]);
            if ($up) {
                $status = "success";
                $msg = "Event updated successfully!";
            } else {
                $msg = "Database error while updating event.";
            }
        } else {
            $msg = "Event not found or unauthorized.";
        }
    } else {
        $msg = "Please provide valid event details.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Edit Event - Crystal Events</title>
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
            window.location.replace('../viewevents.php');
        });
    </script>
<?php endif; ?>
</body>
</html>
