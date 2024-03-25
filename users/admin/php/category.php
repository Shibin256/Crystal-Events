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
        $cat_title = $_POST['cat_title'];

        $sql = "INSERT INTO category(cat_title) VALUES ('$cat_title')";
        $conn = insert($sql);


    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Category Added',
            }).then((result) => {
                window.location.replace('../category.php');
            })
        </script>


    <?php

    }
    ?>
</body>

</html>