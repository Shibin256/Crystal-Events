<html>

<head>

    <script src="../js/jquery.3.6.1.min.js"></script>
    <script src="../js/sweetalert2@11.js"></script>
</head>

<body>
    <?php
    session_start();
    require("connect.php");
    if (isset($_POST['login'])) {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $sql = "select * from login where email='$email'";
        if (num($sql) != 0) {
            $res = sel($sql);
            $row = mysqli_fetch_assoc($res);
            if ($password == $row['password']) {
                $_SESSION['email'] = $email;
                $_SESSION['menu'] = 'dash';
                // company
                if ($row['usertype'] == 3) {
                    $sql = "select status from login where email='$email'";
                    $res = sel($sql);
                    $row = mysqli_fetch_assoc($res);
                    if ($row['status'] == 0) {
    ?>
                        <script>
                            Swal.fire({
                                icon: 'info',
                                title: 'Account under verification!',
                            }).then((result) => {
                                window.location.replace('../users/company/profile.php');
                            });
                        </script>
                    <?php
                    } else {
                    ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome Back Company!',
                            }).then((result) => {
                                window.location.replace('../users/company/');
                            });
                        </script>
                    <?php
                    }
                }
                // user
                else if ($row['usertype'] == 2) {
                    $sql = "select status from login where email='$email'";
                    $res = sel($sql);
                    $row = mysqli_fetch_assoc($res);
                    if ($row['status'] == 0) {
                    ?>
                        <script>
                            Swal.fire({
                                icon: 'info',
                                title: 'Account under verification!',
                            }).then((result) => {
                                window.location.replace('../users/user/profile.php');
                            });
                        </script>
                    <?php
                    } else {
                    ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Welcome Back User!',
                            }).then((result) => {
                                window.location.replace('../users/user/');
                            });
                        </script>
                    <?php
                    }
                }
                //admin
                else if ($row['usertype'] == 1) {
                    ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Welcome Back Admin!',
                        }).then((result) => {
                            window.location.replace('../users/admin/');
                        });
                    </script>
                <?php
                }
            } else {
                ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Incorrect Credentials',
                    }).then((result) => {
                        window.location.replace('../login.html');
                    });
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Account doesn\'t exsist!',
                }).then((result) => {
                    window.location.replace('../');
                });
            </script>
    <?php
        }
    }
    ?>
</body>

</html>