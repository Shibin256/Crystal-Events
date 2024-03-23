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
        $email = $_SESSION['email'];
        $cdate = date('Y-m-d H:i:s');
        $topic = $_POST['topic'];
        $description = $_POST['description'];



        $sql = "insert into complaint(email_id,topic,complaint,submitted_date) values ('$email','$topic','$description','$cdate')";

        update($sql);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Complaint Registered Successfully!',
            }).then((result) => {
                window.location.replace('../complaint.php');
            })
        </script>

    <?php
    } else {
        echo "<script>window.location.replace('../');</script>";
    }
    ?>
</body>

</html>