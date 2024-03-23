<?php
require('header.php');
?>

<style>
.heart:hover {
    cursor: pointer;
}
</style>

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.html">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Bikes</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page " style="display: flex;justify-content: space-between;">
                <div>
                    Filter by :
                    <select id="filter">
                        <option value="all">Brand</option>
                        <?php
                        $sql = "select distinct brand from bike";
                        $res = sel($sql);
                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <option value="<?php echo $row['brand']; ?>"><?php echo $row['brand']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <select id="cat">
                        <option value="all">Category</option>
                        <?php
                        $sql = "select * from category";
                        $res = sel($sql);
                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['category_name']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>


                <div>
                    <input type="text" id="search" placeholder="Search bikes.." />
                    <button type="button" onclick="window.location.reload()"><i class="fa fa-repeat"></i> Clear
                        all</button>
                </div>

            </div>
            <div class="blank-page row" id="content" style="margin: 0px;">



                <?php
                $sql = "select * from bike,category where bike.category_id=category.category_id and stock>=0";
                $res = sel($sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="col-md-4" style="margin: 0px;display: inline-block;padding: 15px;">
                    <div class="card" style="height: 100%;">

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
                                    <img class="d-block w-100"
                                        src="<?php echo '../admin/uploads/bikes/' . $row2['image']; ?>"
                                        style="height: 250px;" alt="First slide">
                                </div>
                                <?php
                                        } else {
                                        ?>
                                <div class="carousel-item ">
                                    <img class="d-block w-100"
                                        src="<?php echo '../admin/uploads/bikes/' . $row2['image']; ?>"
                                        style="height: 250px;" alt="First slide">
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
                        </div>
                        <div class="card-footer">
                            <div style="display: flex;justify-content: space-evenly">
                                <?php
                                    $sql2 = "select * from wishlist where email_id='$email' and bike_id=" . $row['bike_id'];
                                    $num = num($sql2);
                                    if ($num != 0) {
                                    ?>
                                <div class="heart" style="border: none;background: transparent;"
                                    onclick="removewish(<?php echo $row['bike_id']; ?>)"><i class="fa fa-heart"
                                        style="color: red;"></i></div>
                                <?php
                                    } else {
                                    ?>
                                <div class="heart" style="border: none;background: transparent;"
                                    onclick="addwish(<?php echo $row['bike_id']; ?>)"><i class="fa fa-heart-o"></i>
                                </div>

                                <?php
                                    }
                                    ?>
                                <button class="btn btn-sm btn-primary"
                                    onclick="window.location.href='view.php?id=<?php echo $row['bike_id']; ?>'"><i
                                        class="fa fa-eye"></i> View</button>
                            </div>
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

<?php
require('footer.php');
?>

<script>
function addwish(id) {
    $.ajax({
        url: "php/wish.php",
        type: "post",
        data: {
            add: "check",
            id: id

        },
        success: function(res) {
            window.location.reload(true);

        }
    });
}

function removewish(id) {
    $.ajax({
        url: "php/wish.php",
        type: "post",
        data: {
            remove: "check",
            id: id

        },
        success: function(res) {
            window.location.reload(true);

        }
    });
}


$(document).ready(function() {
    $('#filter, #cat').change(function() {
        $.ajax({
            url: "php/allbikes.php",
            type: "post",
            data: {
                filterp: "check",
                filter: document.getElementById('filter').value,
                cat: document.getElementById('cat').value,
                search: document.getElementById('search').value
            },
            beforeSend: function() {
                Swal.fire({
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                });
                Swal.showLoading();
            },
            success: function(res) {
                Swal.close();
                // console.log(res);
                document.getElementById('content').innerHTML = res;

            }
        });
    });

    $('#search').keyup(function() {
        $.ajax({
            url: "php/allbikes.php",
            type: "post",
            data: {
                searchp: "check",
                search: document.getElementById('search').value,
                cat: document.getElementById('cat').value,
                filter: document.getElementById('filter').value

            },
            // beforeSend: function() {
            //     Swal.fire({
            //         allowOutsideClick: false,
            //         allowEscapeKey: false,
            //     });
            //     Swal.showLoading();
            // },
            success: function(res) {
                // Swal.close();
                // console.log(res);
                document.getElementById('content').innerHTML = res;

            }
        });
    });


});
</script>