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
        $name = $_POST['name'];
        $brand = $_POST['brand'];
        $category_id = $_POST['category_id'];
        $color = $_POST['color'];
        $cubic_capacity = $_POST['cubic_capacity'];
        $stock = $_POST['stock'];
        $photo1 = $_FILES["photo1"]["name"];
        $photo2 = $_FILES["photo2"]["name"];
        $photo3 = $_FILES["photo3"]["name"];
        $price = $_POST['price'];

        $sql = "select * from bike where name='$name' and brand='$brand' and category_id='$category_id'";
        if (num($sql) == 0) {

            $sql = "INSERT INTO bike(name,brand,category_id,color,cubic_capacity,stock,price) VALUES ('$name','$brand','$category_id','$color','$cubic_capacity','$stock','$price')";
            $conn = insert($sql);
            $id = mysqli_insert_id($conn);

            $targetDirectory = "../uploads/bikes/";
            $target_file = $targetDirectory . basename($_FILES["photo1"]["name"]);
            move_uploaded_file($_FILES["photo1"]["tmp_name"], $target_file);

            $target_file = $targetDirectory . basename($_FILES["photo2"]["name"]);
            move_uploaded_file($_FILES["photo2"]["tmp_name"], $target_file);

            $target_file = $targetDirectory . basename($_FILES["photo3"]["name"]);
            move_uploaded_file($_FILES["photo3"]["tmp_name"], $target_file);


            $sql = "insert into bike_photos (bike_id,image) values ('$id','$photo1')";
            insert($sql);
            $sql = "insert into bike_photos (bike_id,image) values ('$id','$photo2')";
            insert($sql);
            $sql = "insert into bike_photos (bike_id,image) values ('$id','$photo3')";
            insert($sql);


    ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Bike Added',
                }).then((result) => {
                    window.location.replace('../viewbikes.php');
                })
            </script>

        <?php
        } else {
        ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Same Bike already exsists!!!',
                }).then((result) => {
                    window.location.replace('../viewbikes.php');
                })
            </script>

    <?php
        }
    }
    ?>
</body>

</html>