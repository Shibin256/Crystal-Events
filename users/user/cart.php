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
                $sql = "select cart.cart_id, events.*, category.cat_title, company.name as company_name, company.profile_pic as company_pic from cart join events on events.event_id=cart.event_id join category on category.cat_id=events.category join company on company.email=events.company_email where cart.user=? order by cart.cart_id desc";
                $res = sel($sql, [$email]);
                $total = 0;
                if (!$res || mysqli_num_rows($res) == 0) {
                ?>
                    <div class="alert alert-info text-center" style="margin-top: 20px;">
                        <h4><i class="fa fa-shopping-cart"></i> Your cart is empty!</h4>
                        <p><a href="allevents.php" class="btn btn-primary btn-sm mt-3"><i class="fa fa-search"></i> Browse Events</a></p>
                    </div>

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
                                            $cPic = !empty($row['company_pic']) ? $row['company_pic'] : 'default.jpg';
                                        ?>
                                            <tr>
                                                <td class="">
                                                    <div class="media">
                                                        <a class="thumbnail pull-left" href="view.php?id=<?php echo urlencode($row['company_email']); ?>">
                                                            <img class="media-object" src="../company/uploads/profile/<?php echo rawurlencode($cPic); ?>" style="width: 72px; height: 72px; object-fit: cover;">
                                                        </a>

                                                        <div class="media-body" style="padding:5px;margin-left:5px;">
                                                            <h4 class="media-heading"><?php echo safe_html($row['name']); ?></h4>
                                                            <h5 class="media-heading text-muted">by <?php echo safe_html($row['company_name']); ?></h5>
                                                            <p><span class="badge badge-secondary"><?php echo safe_html($row['cat_title']); ?></span></p>

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
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="remove(<?php echo (int)$row['cart_id']; ?>)">
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