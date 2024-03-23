<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <html>

    <head>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <?php
        session_start();
        require('../../../php/connect.php');
        if (isset($_POST['update'])) {
            $complaint_id = $_POST['complaint_id'];
            $reply = $_POST['reply'];




            $sql = "update complaint set reply='$reply',status=2 where complaint_id='$complaint_id'";
            $res = update($sql);
        ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: ' Success!',
                }).then((result) => {
                    window.location.replace('../complaints.php');
                })
            </script>

        <?php

        }

        ?>
    </body>

    </html>