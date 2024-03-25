<?php
require('header.php');

$sql = "select status from login where email='$email'";
$res = sel($sql);
$row = mysqli_fetch_assoc($res);
$status = $row['status'];

if ($status == 0) {
    echo "<script>window.location.replace('profile.php')</script>";
}
?>

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.html">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Home</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <div class="row">



                    <?php
                    $sql = "select * from bike,category where bike.category_id=category.category_id and stock>0 order by rand() limit 3";
                    $res = sel($sql);
                    while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                        <div class="col-md-4" style="margin: 0px;display: inline-block;padding: 15px;">
                            <div class="card" style="height: 100%;">

                                <div id="carouselExampleIndicators<?php echo $row['bike_id']; ?>" class="carousel slide" data-ride="carousel" style="">
                                    <ol class="carousel-indicators">
                                        <li data-target="#carouselExampleIndicators<?php echo $row['bike_id']; ?>" data-slide-to="0" class="active"></li>
                                        <li data-target="#carouselExampleIndicators<?php echo $row['bike_id']; ?>" data-slide-to="1"></li>
                                        <li data-target="#carouselExampleIndicators<?php echo $row['bike_id']; ?>" data-slide-to="2"></li>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php
                                        $id = $row['bike_id'];
                                        $sql2 = "select * from bike_photos where bike_id='$id'";
                                        $res2 = sel($sql2);
                                        $n = 0;
                                        while ($row2 = mysqli_fetch_assoc($res2)) {
                                            if ($n == 0) {
                                                $n += 1;
                                        ?>
                                                <div class="carousel-item active">
                                                    <img class="d-block w-100" src="<?php echo '../admin/uploads/bikes/' . $row2['image']; ?>" style="height: 250px;" alt="First slide">
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="carousel-item ">
                                                    <img class="d-block w-100" src="<?php echo '../admin/uploads/bikes/' . $row2['image']; ?>" style="height: 250px;" alt="First slide">
                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators<?php echo $row['bike_id']; ?>" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators<?php echo $row['bike_id']; ?>" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <div class="card-header">
                                    <?php echo $row['name']; ?>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['brand']; ?></h5>
                                    <p class="card-text">Category: <?php echo $row['category_name']; ?></p>
                                    <p class="card-text">Color: <?php echo $row['color']; ?></p>
                                    <p class="card-text">CC: <?php echo $row['cubic_capacity']; ?> CC</p>
                                    <p class="card-text">Price: ₹<?php echo $row['price']; ?></p>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div style="display: flex;justify-content: end;">
                    <button class="btn btn-primary" onclick="window.location.href='allbikes.php'">
                        More Bikes
                    </button>
                </div>

            </div>
        </div>
        <!-- //blank-page -->
    </div>
</div>

<?php
require('footer.php');
?>