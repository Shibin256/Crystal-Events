<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || $_SESSION['usertype'] !== 2) {
    header("Location: ../../../login.html");
    exit;
}

$status = "error";
$msg = "Invalid request.";

if (isset($_POST['delete'])) {
    $event_id = (int)($_POST['event_id'] ?? 0);
    $email = $_SESSION['email'];

    if ($event_id > 0) {
        // Verify ownership
        $check = sel("SELECT event_id FROM events WHERE event_id=? AND company_email=?", [$event_id, $email]);
        if ($check && mysqli_num_rows($check) > 0) {
            $del = delete("DELETE FROM events WHERE event_id=? AND company_email=?", [$event_id, $email]);
            if ($del) {
                $status = "success";
                $msg = "Event deleted successfully!";
            } else {
                $msg = "Could not delete event. It may be linked to existing bookings.";
            }
        } else {
            $msg = "Event not found or does not belong to your account.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Delete Event - Crystal Events</title>
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
