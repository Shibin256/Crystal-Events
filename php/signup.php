<html>

<head>

    <script src="../js/jquery.3.6.1.min.js"></script>
    <script src="../js/sweetalert2@11.js"></script>
</head>

<body>
    <?php
    require('connect.php');
    if (isset($_POST['user'])) {
    ?>
        <script>
            Swal.showLoading();
        </script>
        <?php
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        $sql = "select * from login where email='$email'";
        if (num($sql) == 0) {
            $sql = "insert into users(firstname,lastname,email) values('$firstname','$lastname','$email')";
            insert($sql);
            $sql2 = "insert into login values('$email','$password',2,0)";
            insert($sql2);


        ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Success!',
                }).then((result) => {
                    window.location.replace('../login.html');
                })
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Account already existing!',
                }).then((result) => {
                    window.location.replace('../login.html');
                })
            </script>
        <?php

        }
    } else if (isset($_POST['company'])) {
        ?>
        <script>
            Swal.showLoading();
        </script>
        <?php
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];


        $sql = "select * from login where email='$email'";
        if (num($sql) == 0) {
            $sql = "insert into company(name,email) values('$name','$email')";
            insert($sql);
            $sql2 = "insert into login values('$email','$password',3,0)";
            insert($sql2);

        ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Registration Success!',
                }).then((result) => {
                    window.location.replace('../login.html');
                })
            </script>
        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Account already existing!',
                }).then((result) => {
                    window.location.replace('../login.html');
                })
            </script>
    <?php

        }
    }
    ?>
</body>

</html>