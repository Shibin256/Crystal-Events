<?php
if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('allbikes.php');</script>";
}
require('header.php');
require('../php/keys.php');
$id = $_GET['id'];
$sql = "select * from bike,category where bike.category_id=category.category_id and bike_id=$id";

if (num($sql) == 0) {
    echo "<script>window.location.replace('allbikes.php');</script>";
}
$res = sel($sql);
$row = mysqli_fetch_assoc($res);
?>
<style>
    .display-flex {
        display: flex;
    }

    .product-count {
        margin-top: 15px;
    }

    .product-count .qtyminus,
    .product-count .qtyplus {
        width: 34px;
        height: 34px;
        background: #212529;
        text-align: center;
        font-size: 19px;
        line-height: 36px;
        color: #fff;
        cursor: pointer;
    }

    .product-count .qtyminus {
        border-radius: 3px 0 0 3px;
    }

    .product-count .qtyplus {
        border-radius: 0 3px 3px 0;
    }

    .product-count .qty {
        width: 60px;
        text-align: center;
    }

    .product-dtl label {
        line-height: 16px;
        font-size: 15px;
    }

    /* product images */
    .store-body {
        display: flex;
        flex-direction: row;
        padding: 0;
    }


    .store-body .product-payment-details {
        width: 40%;
        padding: 15px 15px 0 15px;
    }

    .product-info .product-gallery {
        display: flex;
        flex-direction: row;
    }

    .product-gallery-featured {
        display: flex;
        width: 100%;
        flex-direction: row;
        justify-content: center;
        align-items: flex-start;
        padding: 15px;
        cursor: zoom-in;
    }

    .product-gallery-featured>img {
        width: inherit;
    }

    .product-gallery-thumbnails {
        padding: 15px 0px;
    }

    .product-gallery-thumbnails .thumbnails-list li {
        margin-bottom: 5px;
        cursor: pointer;
        position: relative;
        width: 75px;
        height: 75px;
    }

    .thumbnails-list li img {
        display: block;
        width: inherit;
        height: inherit;
    }

    .product-gallery-thumbnails .thumbnails-list li:hover::before {
        content: "";
        width: 3px;
        height: 100%;
        background: #007bff;
        position: absolute;
        top: 0;
        left: 0;
    }
</style>
<section id="main-content">
    <div class="typo-agile">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 ">
                    <div class="store-body">
                        <div class="product-info">
                            <div class="product-gallery">
                                <div class="product-gallery-thumbnails">
                                    <ol class="thumbnails-list list-unstyled">
                                        <?php
                                        $sql2 = "select * from bike_photos where bike_id='$id'";
                                        $res2 = sel($sql2);
                                        $n = 0;
                                        while ($row2 = mysqli_fetch_assoc($res2)) {
                                            if ($n == 0) {
                                                $default = $row2['image'];
                                                $n += 1;
                                            }
                                        ?>
                                            <li><img src="<?php echo '../admin/uploads/bikes/' . $row2['image']; ?>" alt="">
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ol>
                                </div>
                                <div class="product-gallery-featured">
                                    <img src="<?php echo '../admin/uploads/bikes/' . $default; ?>" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="border-left: solid 0.1px;">
                    <h2><?php echo $row['name']; ?></h2><br>
                    <p> </p>
                    <h3> ₹ <?php echo $row['price']; ?></h3><br>
                    <p>Booking price: ₹ 50000</p>
                    <p>Test Drive Booking price: ₹ 500</p><br><br>
                    <?php
                    if ($row['stock'] > 0) {
                    ?>
                        <p>Availability: <span class="text-success">In Stock</span></p>

                        <br>
                    <?php
                    } else {
                    ?>
                        <p>Availability: <span class="text-danger">Out of Stock</span></p>
                    <?php
                    }
                    ?>
                    <br><br>

                    <h2 class="mb-5">Specification</h2>
                    <dl class="row mb-5">
                        <dt class="col-sm-3">Brand</dt>
                        <dd class="col-sm-9"><?php echo $row['brand']; ?></dd>

                        <dt class="col-sm-3">Category </dt>
                        <dd class="col-sm-9"><?php echo $row['category_name']; ?></dd>
                        <dt class="col-sm-3">Color</dt>
                        <dd class="col-sm-9"><?php echo $row['color']; ?></dd>
                        <dt class="col-sm-3">Cubic capacity</dt>
                        <dd class="col-sm-9"><?php echo $row['cubic_capacity']; ?></dd>
                        <dt class="col-sm-3">Price</dt>
                        <dd class="col-sm-9">₹<?php echo $row['price']; ?></dd>
                    </dl>
                </div>
            </div>
            <hr>
        </div>
        <?php
        $sql2 = "select * from pro_order where bike_id=$id and rating!=0";
        if (num($sql2) != 0) {

        ?>
            <div class="container mt-5">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="rating-block">
                            <h4>Average user rating</h4>
                            <?php
                            $sql2 = "select avg(rating) as rate from pro_order where bike_id=$id and rating!=0";
                            $res2 = sel($sql2);
                            $row2 = mysqli_fetch_assoc($res2);
                            ?>
                            <h2 class="bold padding-bottom-7"><?php echo round($row2['rate'], 1); ?> <small>/ 5</small>
                            </h2>
                            <div style="margin-bottom: 5px;">
                                <?php

                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $row2['rate']) {
                                ?>
                                        <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                                            <span class="fa fa-star" aria-hidden="true"></span>
                                        </button>
                                    <?php
                                    } else {
                                    ?>
                                        <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align" style="background-color: grey;">
                                            <span class="fa fa-star" aria-hidden="true"></span>
                                        </button>
                                    <?php
                                    }
                                    ?>

                                <?php
                                }
                                ?>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <?php
                                $sql2 = "select * from pro_order where bike_id=$id and rating!=0";
                                $countm = num($sql2);
                                ?>
                                <span class="fa fa-user" style="margin-right: 10px;"></span><?php echo $countm; ?> total
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <?php
                        $sql2 = "select * from pro_order where bike_id=$id and rating=5";
                        $count = num($sql2);

                        ?>
                        <div class="pull-left">
                            <div class="pull-left" style="width:35px; line-height:1;">
                                <div style="height:9px; margin:5px 0;">5 <span class="fa fa-star"></span>
                                </div>
                            </div>
                            <div class="pull-left" style="width:180px;">
                                <div class="progress" style="height:9px; margin:8px 0;">
                                    <div class="progress-bar bg-success" role="progressbar" aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                        <span class="sr-only"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                        </div>

                        <?php
                        $sql2 = "select * from pro_order where bike_id=$id and rating=4";
                        $count = num($sql2);

                        ?>
                        <div class="pull-left">
                            <div class="pull-left" style="width:35px; line-height:1;">
                                <div style="height:9px; margin:5px 0;">4 <span class="fa fa-star"></span>
                                </div>
                            </div>
                            <div class="pull-left" style="width:180px;">
                                <div class="progress" style="height:9px; margin:8px 0;">
                                    <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                        </div>
                        <?php
                        $sql2 = "select * from pro_order where bike_id=$id and rating=3";
                        $count = num($sql2);

                        ?>
                        <div class="pull-left">
                            <div class="pull-left" style="width:35px; line-height:1;">
                                <div style="height:9px; margin:5px 0;">3 <span class="fa fa-star"></span>
                                </div>
                            </div>
                            <div class="pull-left" style="width:180px;">
                                <div class="progress" style="height:9px; margin:8px 0;">
                                    <div class="progress-bar bg-info" role="progressbar" aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                        </div>
                        <?php
                        $sql2 = "select * from pro_order where bike_id=$id and rating=2";
                        $count = num($sql2);

                        ?>
                        <div class="pull-left">
                            <div class="pull-left" style="width:35px; line-height:1;">
                                <div style="height:9px; margin:5px 0;">2 <span class="fa fa-star"></span>
                                </div>
                            </div>
                            <div class="pull-left" style="width:180px;">
                                <div class="progress" style="height:9px; margin:8px 0;">
                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                        </div>
                        <?php
                        $sql2 = "select * from pro_order where bike_id=$id and rating=1";
                        $count = num($sql2);

                        ?>

                        <div class="pull-left">
                            <div class="pull-left" style="width:35px; line-height:1;">
                                <div style="height:9px; margin:5px 0;">1 <span class="fa fa-star"></span>
                                </div>
                            </div>
                            <div class="pull-left" style="width:180px;">
                                <div class="progress" style="height:9px; margin:8px 0;">
                                    <div class="progress-bar bg-danger" role="progressbar" aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                        <span class="sr-only">80% Complete (danger)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <hr />
                        <div class="review-block">

                            <?php
                            $sql2 = "select * from pro_order,customer where pro_order.email_id=customer.email_id and bike_id=$id and rating!=0 order by review_date";
                            $res2 = sel($sql2);
                            while ($row2 = mysqli_fetch_assoc($res2)) {
                            ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="<?php echo 'uploads/profile/' . $row2['profile_pic'] . '?' . time(); ?>" class="img-rounded" style="width: 60px;height: 60px;">
                                        <div class="review-block-name">
                                            <?php echo $row2['first_name'] . " " . $row2['last_name']; ?></div>
                                        <div class="review-block-date" style="font-size: 12px;">
                                            <?php echo date_format(date_create($row2['review_date']), 'F d, Y - h:i:m A'); ?><br />
                                            <script>
                                                document.write(date_diff(
                                                    '<?php echo date_format(date_create($row2['review_date']), 'Y-m-d') ?>'
                                                ));
                                            </script>
                                            day ago
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="review-block-rate" style="margin-bottom: 15px;;">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $row2['rating']) {
                                            ?>
                                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                                        <span class="fa fa-star" aria-hidden="true"></span>
                                                    </button>
                                                <?php
                                                } else {
                                                ?>
                                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align" style="background-color: grey;;">
                                                        <span class="fa fa-star" aria-hidden="true"></span>
                                                    </button>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                        <!-- <div class="review-block-title"></div> -->
                                        <div class="review-block-description"><?php echo $row2['review']; ?></div>
                                    </div>
                                </div>
                                <hr />
                            <?php
                            }
                            ?>

                        </div>
                    </div>
                </div>

            </div>
        <?php
        } else {
        ?>
            <div class="container mt-5">
                <h3>No Reviews Yet!!!</h3>
            </div>
        <?php
        }
        ?>
    </div>
</section>

<?php
require('footer.php');
?>

<script>
    // select all thumbnails
    const galleryThumbnail = document.querySelectorAll(".thumbnails-list li");
    // select featured
    const galleryFeatured = document.querySelector(".product-gallery-featured img");

    // loop all items
    galleryThumbnail.forEach((item) => {
        item.addEventListener("mouseover", function() {
            let image = item.children[0].src;
            galleryFeatured.src = image;
        });
    });

    // show popover
    $(".main-questions").popover('show');
</script>