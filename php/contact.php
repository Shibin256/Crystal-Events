<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    require('connect.php');
    if (isset($_POST['add'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $message = $_POST['message'];

        $sql = "insert into contact (name,email,message) values ('$name','$email','$message')";
        insert($sql);


    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Message Sent',
            }).then((result) => {
                window.location.replace('../index.php');
            })
        </script>


    <?php

    }
    ?>
</body>

</html>