<?php
session_start();
$email = $_SESSION['email'];

require("../../../php/connect.php");

if (isset($_POST['searchp']) || isset($_POST['filterp']) || isset($_POST['cat'])) {

    $search = $_POST['search'];
    $filter = $_POST['filter'];
    $cat = $_POST['cat'];

    $sql = "select * from bike,category where bike.category_id=category.category_id and stock>0 and name like '%" . $search . "%'";

    if ($filter != 'all')
        $sql .= " and brand='$filter'";
    if ($cat != 'all')
        $sql .= " and category.category_id='$cat'";

    $num = num($sql);
    if ($num == 0) {
        echo "<p style='text-align: center;'>No results found!!!</p>";
    } else {
        $result = sel($sql);
        $n = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $n++;
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
                    <div class="card-footer">
                        <div style="display: flex;justify-content: space-evenly">
                            <?php
                            $sql2 = "select * from wishlist where email_id='$email' and bike_id=" . $row['bike_id'];
                            $num = num($sql2);
                            if ($num != 0) {
                            ?>
                                <div class="heart" style="border: none;background: transparent;" onclick="removewish(<?php echo $row['bike_id']; ?>)"><i class="fa fa-heart" style="color: red;"></i>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="heart" style="border: none;background: transparent;" onclick="addwish(<?php echo $row['bike_id']; ?>)"><i class="fa fa-heart-o"></i></div>

                            <?php
                            }
                            ?>
                            <button class="btn btn-sm btn-primary" onclick="window.location.href='view.php?id=<?php echo $row['bike_id']; ?>'"><i class="fa fa-eye"></i> View</button>
                        </div>
                    </div>
                </div>
            </div>

<?php

        }
    }


    exit();
}

?>