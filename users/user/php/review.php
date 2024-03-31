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
        $book_id = $_POST['book_id'];
        $rate = $_POST['rate'];
        $rdate = date('Y-m-d H:i:s');
        $review = $_POST['review'];

        $sql = "insert into review (review,star,review_date,book_id) values ('$review','$rate','$rdate','$book_id')";

        insert($sql);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Review Added Successfully!',
            }).then((result) => {
                window.location.replace('../book_completed.php');
            })
        </script>

    <?php
    }
    ?>
</body>

</html>