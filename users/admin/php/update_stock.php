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
        $bike_id = $_POST['bike_id'];
        $stock = $_POST['stock'];


        $sql = "UPDATE `bike` SET `stock`='$stock' where bike_id='$bike_id'";

        update($sql);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Updated successfully!',
            }).then((result) => {
                window.location.replace('../viewbikes.php');
            })
        </script>

    <?php

    }

    ?>
</body>

</html>