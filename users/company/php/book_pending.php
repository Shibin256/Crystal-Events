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
        $book_id = $_POST['book_id'];
        $reply = $_POST['reply'];

        $sql = "update bookings set reply='$reply',book_status=1 where book_id='$book_id'";
        update($sql);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Updated successfully!',
            }).then((result) => {
                window.location.replace('../book_pending.php');
            })
        </script>

    <?php

    }
    if (isset($_POST['approve'])) {
        $book_id = $_POST['book_id'];
        $price = $_POST['price'];

        $sql = "update bookings set price='$price',book_status=2 where book_id='$book_id'";
        update($sql);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Updated successfully!',
            }).then((result) => {
                window.location.replace('../book_pending.php');
            })
        </script>

    <?php

    }
    ?>
</body>

</html>