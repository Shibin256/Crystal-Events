<?php
if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('companies.php');</script>";
}
require('header.php');
$id = $_GET['id'];
$sql = "select * from company where email='$id'";

if (num($sql) == 0) {
    echo "<script>window.location.replace('companies.php');</script>";
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

.carousel-item img {
    height: 500px;
    object-fit: cover;
}
</style>
<script>
function date_diff(rdate) {
    const start = new Date(rdate);
    const end = new Date();

    const timeDiff = end - start;
    const daysDiff = timeDiff / (1000 * 60 * 60 * 24);

    return Math.round(daysDiff);
}
</script>
<section id="main-content">
    <div class="typo-agile">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 ">
                    <img src="../company/uploads/profile/<?php echo $row['profile_pic']; ?>" alt="Product Image"
                        class="img-fluid" style="width: 540px;height: 540px">

                </div>
                <div class="col-md-6" style="border-left: solid 0.1px;">
                    <h2><?php echo $row['name']; ?></h2>
                    <p>Established in <?php echo date_format(date_create($row['est_date']), "d-m-Y"); ?></p><br>
                    <h3> Owner: <?php echo $row['ownername']; ?></h3><br>
                    <p style="text-align: justify;"><?php echo $row['about']; ?></p><br><br>

                    <dl class="row mb-5">
                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9"><?php echo $row['email']; ?></dd>
                        <dt class="col-sm-3">Phone </dt>
                        <dd class="col-sm-9"><?php echo $row['phone']; ?></dd>
                        <dt class="col-sm-3">Place</dt>
                        <dd class="col-sm-9"><?php echo $row['place']; ?></dd>
                        <dt class="col-sm-3">District</dt>
                        <dd class="col-sm-9"><?php echo $row['district']; ?></dd>
                        <dt class="col-sm-3">Pin Code</dt>
                        <dd class="col-sm-9"><?php echo $row['pincode']; ?></dd>
                    </dl>
                </div>
            </div>
            <hr>
        </div>
        <div class="container mt-5">
            <h4>Gallery</h4><br>
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $sql4 = "select * from gallery where company_email='$id'";
                    if (num($sql4) == 0) {
                    ?>

                    <?php
                    } else if (num($sql4) == 1) {
                        $res4 = sel($sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                    ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <?php
                    } else {
                        $res4 = sel($sql4);
                        $n = 0;
                        while ($row4 = mysqli_fetch_assoc($res4)) {
                            if ($n == 0) {

                        ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <?php
                            } else {
                            ?>
                    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $n; ?>"></li>
                    <?php
                            }

                            $n++;
                        }
                    }
                    ?>
                </ol>
                <div class="carousel-inner">
                    <?php
                    $sql4 = "select * from gallery where company_email='$id'";
                    if (num($sql4) == 0) {
                    ?>
                    <h6>Nothing here...</h6>
                    <?php
                    } else if (num($sql4) == 1) {
                        $res4 = sel($sql4);
                        $row4 = mysqli_fetch_assoc($res4);
                    ?>
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="<?php echo '../company/uploads/gallery/' . $row4['photo'] ?>"
                            alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo $row4['caption'] ?></h5>

                        </div>
                    </div>
                    <?php
                    } else {
                        $res4 = sel($sql4);
                        $n = 0;
                        while ($row4 = mysqli_fetch_assoc($res4)) {
                            if ($n == 0) {
                                $n++;

                        ?>
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="<?php echo '../company/uploads/gallery/' . $row4['photo'] ?>"
                            alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo $row4['caption'] ?></h5>

                        </div>
                    </div>
                    <?php
                            } else {
                            ?>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="<?php echo '../company/uploads/gallery/' . $row4['photo'] ?>"
                            alt="First slide">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo $row4['caption'] ?></h5>

                        </div>
                    </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>

        <?php
        $sql2 = "select * from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id';";
        if (num($sql2) != 0) {

        ?>
        <div class="container mt-5">


            <div class="row">
                <div class="col-sm-6">
                    <div class="rating-block">
                        <h4>Average user rating</h4>
                        <?php
                            $sql2 = "select avg(star) as rate from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id'";
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
                                <span class="fa fa-star" aria-hidden="true" style="width: 10px;"></span>
                            </button>
                            <?php
                                    } else if ($i - 0.5 == $row2['rate']) {
                                    ?>
                            <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align">
                                <span class="fa fa-star-half" aria-hidden="true" style="width: 10px;"></span>
                            </button>
                            <?php
                                    } else {
                                    ?>
                            <button type="button" class="btn btn-warning btn-sm" aria-label="Left Align"
                                style="background-color: grey;">
                                <span class="fa fa-star" aria-hidden="true" style="width: 10px;"></span>
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
                                $sql2 = "select * from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id'";
                                $countm = num($sql2);
                                ?>
                            <span class="fa fa-user" style="margin-right: 10px;"></span><?php echo $countm; ?> total
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <?php
                        $sql2 = "select * from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id' and star=5";
                        $count = num($sql2);

                        ?>
                    <div class="pull-left">
                        <div class="pull-left" style="width:35px; line-height:1;">
                            <div style="height:9px; margin:5px 0;">5 <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="pull-left" style="width:180px;">
                            <div class="progress" style="height:9px; margin:8px 0;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0"
                                    aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                    <span class="sr-only"></span>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                    </div>

                    <?php
                        $sql2 = "select * from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id' and star=4";
                        $count = num($sql2);

                        ?>
                    <div class="pull-left">
                        <div class="pull-left" style="width:35px; line-height:1;">
                            <div style="height:9px; margin:5px 0;">4 <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="pull-left" style="width:180px;">
                            <div class="progress" style="height:9px; margin:8px 0;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0"
                                    aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                    <span class="sr-only">80% Complete (danger)</span>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                    </div>
                    <?php
                        $sql2 = "select * from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id' and star=3";
                        $count = num($sql2);

                        ?>
                    <div class="pull-left">
                        <div class="pull-left" style="width:35px; line-height:1;">
                            <div style="height:9px; margin:5px 0;">3 <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="pull-left" style="width:180px;">
                            <div class="progress" style="height:9px; margin:8px 0;">
                                <div class="progress-bar bg-info" role="progressbar"
                                    aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0"
                                    aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                    <span class="sr-only">80% Complete (danger)</span>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                    </div>
                    <?php
                        $sql2 = "select * from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id' and star=2";
                        $count = num($sql2);

                        ?>
                    <div class="pull-left">
                        <div class="pull-left" style="width:35px; line-height:1;">
                            <div style="height:9px; margin:5px 0;">2 <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="pull-left" style="width:180px;">
                            <div class="progress" style="height:9px; margin:8px 0;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0"
                                    aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
                                    <span class="sr-only">80% Complete (danger)</span>
                                </div>
                            </div>
                        </div>
                        <div class="pull-right" style="margin-left:10px;"><?php echo $count; ?> </div>
                    </div>
                    <?php
                        $sql2 = "select * from review, bookings, events where review.book_id=bookings.book_id and bookings.event_id=events.event_id and company_email='$id' and star=1";
                        $count = num($sql2);

                        ?>

                    <div class="pull-left">
                        <div class="pull-left" style="width:35px; line-height:1;">
                            <div style="height:9px; margin:5px 0;">1 <span class="fa fa-star"></span>
                            </div>
                        </div>
                        <div class="pull-left" style="width:180px;">
                            <div class="progress" style="height:9px; margin:8px 0;">
                                <div class="progress-bar bg-danger" role="progressbar"
                                    aria-valuenow="<?php echo ($count / $countm) * 100; ?>" aria-valuemin="0"
                                    aria-valuemax="100" style="width: <?php echo ($count / $countm) * 100; ?>%">
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
                            $sql2 = "select * from review, bookings, events, users where review.book_id=bookings.book_id and bookings.event_id=events.event_id and users.email=bookings.user_email and company_email='$id'";
                            $res2 = sel($sql2);
                            while ($row2 = mysqli_fetch_assoc($res2)) {
                            ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?php echo 'uploads/profile/' . $row2['profile_pic'] . '?' . time(); ?>"
                                    class="img-rounded" style="width: 60px;height: 60px;">
                                <div class="review-block-name">
                                    <?php echo $row2['firstname'] . " " . $row2['lastname']; ?></div>
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
                                                if ($i <= $row2['star']) {
                                            ?>
                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align">
                                        <span class="fa fa-star" aria-hidden="true"></span>
                                    </button>
                                    <?php
                                                } else {
                                                ?>
                                    <button type="button" class="btn btn-warning btn-xs" aria-label="Left Align"
                                        style="background-color: grey;">
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
        <div class="container mt-5 mb-5">
            <h3 align="center">No Reviews Yet!!!</h3>
        </div>
        <?php
        }
        ?>
    </div>
</section>



<?php
require('footer.php');
?>