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
        $cpass = $_POST['cpass'];
        $npass = $_POST['npass'];
        $email = $_SESSION['email'];

        $sql = "select password from login where email='$email'";
        $res = sel($sql);
        $row = mysqli_fetch_assoc($res);
        $pass = $row['password'];

        if ($pass == $cpass) {
            $sql = "update login set password='$npass' where email='$email'";
            $res = sel($sql);
    ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: ' Success!',
                }).then((result) => {
                    window.location.replace('../index.php');
                })
            </script>

        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: ' Error!',
                    text: 'Wrong Password!'
                }).then((result) => {
                    window.location.replace('../index.php');
                })
            </script>

    <?php
        }
    }
    ?>
</body>

</html>