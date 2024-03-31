<?php
require('header.php');
?>
<style>
    .display-flex {
        display: flex;
    }

    .product-count {
        margin-top: 29px;
    }

    .product-count .qtyminus,
    .product-count .qtyplus {
        width: 30px;
        height: 30px;
        background: #212529;
        text-align: center;
        font-size: 19px;
        line-height: 30px;
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
        width: 40px;
        text-align: center;
    }

    .product-dtl label {
        line-height: 16px;
        font-size: 15px;
    }
</style>

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Cart</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <?php
                $sql = "select * from cart,events,category where events.event_id=cart.event_id and category.cat_id=events.category and user='$email'";
                $res = sel($sql);
                $total = 0;
                if (num($sql) == 0) {
                ?>
                    <p>Nothing here!</p>

                <?php
                } else {

                ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <form method="post" action="php/cart.php">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Event Date & Time</th>
                                            <th>Location</th>
                                            <th>Requirements</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $n = 1;
                                        while ($row = mysqli_fetch_assoc($res)) {

                                        ?>
                                            <tr>
                                                <td class="">
                                                    <div class="media">
                                                        <?php
                                                        $id = $row['company_email'];
                                                        $sql2 = "select * from company where email='$id'";
                                                        $res2 = sel($sql2);
                                                        $row2 = mysqli_fetch_assoc($res2);
                                                        ?>
                                                        <a class="thumbnail pull-left" href=""> <img class="media-object" src="../company/uploads/profile/<?php echo $row2['profile_pic']; ?>" style="width: 72px; height: 72px;"> </a>

                                                        <div class="media-body" style="padding:5px;margin-left:5px;">
                                                            <h4 class="media-heading"><a href=""><?php echo $row['name']; ?></a>
                                                            </h4>
                                                            <h5 class="media-heading"> by <?php echo $row2['name']; ?></h5>
                                                            <p><?php echo $row['cat_title']; ?></p>

                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="" style="vertical-align: middle;">
                                                    <input type="hidden" name="<?php echo 'event_id' . $n; ?>" value="<?php echo $row['event_id']; ?>" required>
                                                    <input type="datetime-local" class="form-control" name="<?php echo $row['event_id'] . '_date'; ?>" required onclick="setDateTime(this)" onkeypress="return false">
                                                </td>
                                                <td class="" style="vertical-align: middle;">
                                                    <input type="text" class="form-control" name="<?php echo $row['event_id'] . '_place'; ?>" placeholder="Event Place" required>
                                                    <select class="form-control" placeholder="District" name="<?php echo $row['event_id'] . '_district'; ?>" id="dist" required="">
                                                        <option disabled selected style="color: #495057;">Event District
                                                        </option>
                                                        <option value="Kasargod">Kasargod</option>
                                                        <option value="Kannur">Kannur</option>
                                                        <option value="Waynad">Wayanad</option>
                                                        <option value="Kozhikode">Kozhikode</option>
                                                        <option value="Malappuram">Malappuram</option>
                                                        <option value="Palakkad">Palakkad</option>
                                                        <option value="Thrissur">Thrissur</option>
                                                        <option value="Ernakulam">Ernakulam</option>
                                                        <option value="Idukki">Idukki</option>
                                                        <option value="Kottayam">Kottayam</option>
                                                        <option value="Alappuzha">Alappuzha</option>
                                                        <option value="Pathanamthitta">Pathanamthitta</option>
                                                        <option value="Kollam">Kollam</option>
                                                        <option value="Thiruvananthapuram">Thiruvananthapuram</option>

                                                    </select>
                                                    <input type="text" class="form-control" name="<?php echo $row['event_id'] . '_pincode'; ?>" placeholder="Event Pincode" required>
                                                </td>
                                                <td class="" style="vertical-align: middle;">
                                                    <textarea class="form-control" placeholder="Enter your requirements..." name="<?php echo $row['event_id'] . '_req'; ?>" required></textarea>
                                                </td>
                                                <td class="" style="vertical-align: middle;">
                                                    <div style="display: flex;align-items: center;justify-content: center;">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="remove(<?php echo $row['cart_id']; ?>)">
                                                            <span class="glyphicon glyphicon-remove"></span> Remove
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                            $n++;
                                        }

                                        ?>


                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td class="" style="vertical-align: middle;">
                                                <div style="display: flex;align-items: center;justify-content: center;">
                                                    <button type="submit" class="btn btn-info" name="cart">
                                                        <span class="fa fa-shopping-cart"></span> Book Now
                                                    </button>
                                                </div>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>
                            </form>
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






<section id="main-content">
    <div class="container typo-agile">

    </div>
</section>

<?php
require('footer.php');
?>

<script>
    function remove(id) {
        $.ajax({
            url: "php/cart.php",
            type: "post",
            data: {
                remove: "check",
                id: id

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
                window.location.reload(true);

            }
        });
    }

    function setDateTime(input) {
        const today = new Date();
        const minDateTime = new Date(today);
        minDateTime.setDate(minDateTime.getDate() + 3);

        if (minDateTime.getMonth() !== today.getMonth()) {
            minDateTime.setDate(1);
            minDateTime.setMonth(minDateTime.getMonth() + 1);
        }

        const minDateTimeString = minDateTime.toISOString().slice(0, 16);
        input.min = minDateTimeString;
    }
</script>