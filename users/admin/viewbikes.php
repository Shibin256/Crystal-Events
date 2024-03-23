<?php
require('header.php');
?>
<style>
/* .carousel-inner>.item>img,
    .carousel-inner>.item>a>img {
        width: 70%;
        margin: auto;
    } */

.carousel-inner>.carousel-item>img {
    height: 300px;
}
</style>
<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Bikes</span>
            </h2>
        </div>

        <div class="blank">
            <div class="row">



                <?php
                $sql = "select * from bike,category where bike.category_id=category.category_id";
                $res = sel($sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="col-md-4" style="margin: 0px;display: inline-block;padding: 15px;">
                    <div class="card">

                        <div id="carouselExampleIndicators<?php echo $row['bike_id']; ?>" class="carousel slide"
                            data-ride="carousel" style="">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators<?php echo $row['bike_id']; ?>"
                                    data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators<?php echo $row['bike_id']; ?>"
                                    data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators<?php echo $row['bike_id']; ?>"
                                    data-slide-to="2"></li>
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
                                    <img class="d-block w-100" src="<?php echo 'uploads/bikes/' . $row2['image']; ?>"
                                        alt="First slide">
                                </div>
                                <?php
                                        } else {
                                        ?>
                                <div class="carousel-item ">
                                    <img class="d-block w-100" src="<?php echo 'uploads/bikes/' . $row2['image']; ?>"
                                        alt="First slide">
                                </div>
                                <?php
                                        }
                                    }
                                    ?>
                            </div>
                            <a class="carousel-control-prev"
                                href="#carouselExampleIndicators<?php echo $row['bike_id']; ?>" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next"
                                href="#carouselExampleIndicators<?php echo $row['bike_id']; ?>" role="button"
                                data-slide="next">
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
                            <p class="card-text">Stock: <?php echo $row['stock']; ?></p>
                        </div>
                        <div class="card-footer text-muted" style="display: flex;justify-content: space-evenly;">
                            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                data-target="#exampleModal"
                                onclick="document.getElementById('bike_id').value='<?php echo $row['bike_id']; ?>';document.getElementById('stock').value='<?php echo $row['stock']; ?>'">
                                Update Stock
                            </button>
                            <button type="button" class="btn btn-sm btn-info"
                                onclick="window.location.href='view.php?id=<?php echo $row['bike_id']; ?>'">View</button>

                        </div>
                    </div>
                </div>
                <?php
                }
                ?>

            </div>
        </div>
        <!-- //blank-page -->
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Stock Update</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/update_stock.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="bike_id" name="bike_id">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Stock</label>
                        <input type="number" class="form-control" name="stock" id="stock" required="">
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="update">Save Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require('footer.php');
?>