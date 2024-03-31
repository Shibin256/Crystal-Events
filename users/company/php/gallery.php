<html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php
    session_start();
    require('../../../php/connect.php');
    if (isset($_POST["add"])) {
        $email = $_SESSION['email'];
        $caption = $_POST['caption'];
        $targetDirectory = "../uploads/gallery/";
        $originalFileName = basename($_FILES["photo"]["name"]);
        $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
        $targetFile = $targetDirectory . $originalFileName;


        $sql = "insert into gallery (photo, caption, company_email) values ('$originalFileName','$caption','$email')";
        insert($sql);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFile);
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Uploaded successfully!',
            }).then((result) => {
                window.location.replace('../gallery.php');
            })
        </script>

    <?php

    }

    ?>
</body>

</html>