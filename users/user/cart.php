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
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-center">Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = mysqli_fetch_assoc($res)) {

                                    ?>
                                        <tr>
                                            <td class="col-sm-8 col-md-6">
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
                                                        <h5 class="media-heading"> by <?php echo $row['cat_title']; ?></h5>


                                                    </div>
                                                </div>
                                            </td>
                                            <td class="col-sm-1 col-md-1 text-center" style="vertical-align: middle;">
                                                <strong><?php //echo $row['price']; 
                                                        ?></strong>
                                            </td>
                                            <td class="col-sm-1 col-md-1">
                                                <div style="display: flex;align-items: center;justify-content: center;">
                                                    <button type="button" class="btn btn-danger" onclick="remove(<?php echo $row['cart_id']; ?>)">
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
</script>