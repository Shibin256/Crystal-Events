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
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];
        $email = $_SESSION['email'];
        $sql = "INSERT INTO events(name,category,description,company_email) VALUES ('$name','$category_id','$description','$email')";
        $conn = insert($sql);


    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Event Added',
            }).then((result) => {
                window.location.replace('../viewevents.php');
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
                window.location.replace('../viewevents.php');
            })
        </script>

    <?php
    }

    ?>
</body>

</html>