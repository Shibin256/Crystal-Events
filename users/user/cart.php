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
                            <form>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Event Date</th>
                                            <th>Requirements</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
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
                                                    <input type="date" class="form-control" name="<?php echo $row['event_id'] . '_date'; ?>">
                                                </td>
                                                <td class="" style="vertical-align: middle;">
                                                    <textarea class="form-control" placeholder="Enter your requirements..." name="<?php echo $row['event_id'] . '_req'; ?>">

                                        </textarea>
                                                </td>
                                                <td class="">
                                                    <div style="display: flex;align-items: center;justify-content: center;">
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="remove(<?php echo $row['cart_id']; ?>)">
                                                            <span class="glyphicon glyphicon-remove"></span> Remove
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php
                                        }

                                        ?>


                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button type="button" class="btn btn-info" onclick="window.location.href='allbikes.php'">
                                                    <span class="fa fa-shopping-cart"></span> Continue Shopping
                                                </button>
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
    function minus(id) {
        var now = $("#quantity" + id).val();
        if (now > 1) {
            $.ajax({
                url: "php/addcart.php",
                type: "post",
                data: {
                    minus: "check",
                    id: id

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
                    window.location.reload(true);

                }
            });
        }
    }

    function plus(id, max) {
        var now = $("#quantity" + id).val();
        if (now != max) {
            $.ajax({
                url: "php/addcart.php",
                type: "post",
                data: {
                    plus: "check",
                    id: id

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
                    window.location.reload(true);

                }
            });
        }
    }

    function remove(id) {
        $.ajax({
            url: "php/removewish.php",
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

    function setDate(input) {
        const today = new Date();
        const minDate = new Date(today);
        minDate.setDate(minDate.getDate() + 3);

        if (minDate.getMonth() !== today.getMonth()) {
            minDate.setDate(1);
            minDate.setMonth(minDate.getMonth() + 1);
        }

        const minDateString = minDate.toISOString().split('T')[0];
        input.min = minDateString;
    }
</script>