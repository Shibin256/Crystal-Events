<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    require('../../../php/connect.php');
    if (isset($_POST['add'])) {
        $order_id = $_POST['order_id'];
        $rate = $_POST['rate'];
        $rdate = date('Y-m-d H:i:s');
        $review = $_POST['review'];

        $sql = "update pro_order set rating='$rate',review='$review',review_date='$rdate' where order_id='$order_id'";

        update($sql);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Review Added Successfully!',
            }).then((result) => {
                window.location.replace('../order.php');
            })
        </script>

    <?php
    }
    ?>
</body>

</html>