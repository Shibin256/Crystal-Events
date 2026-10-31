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
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Events</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page " style="display: flex;justify-content: space-between;">
                <div>
                    Filter by :
                    <select id="cat">
                        <option value="all">Category</option>
                        <?php
                        $sql = "select * from category";
                        $res = sel($sql);
                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_title']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>


                <div>
                    <input type="text" id="search" placeholder="Search events.." />
                    <button type="button" onclick="window.location.reload()"><i class="fa fa-repeat"></i> Clear
                        all</button>
                </div>

            </div>
            <div class="blank-page row" id="content" style="margin: 0px;">



                <?php
                $cartEvents = [];
                $cartRes = sel("SELECT event_id FROM cart WHERE user=?", [$email]);
                if ($cartRes) {
                    while ($c = mysqli_fetch_assoc($cartRes)) {
                        $cartEvents[(int)$c['event_id']] = true;
                    }
                }

                $sql = "select events.*,category.*,company.*,company.name as company_name,events.name as event_name from events,category,company where events.category=category.cat_id and company.email=events.company_email order by events.event_id desc";
                $res = sel($sql);
                if ($res) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $eventId = (int)$row['event_id'];
                        $inCart = isset($cartEvents[$eventId]);
                ?>
                    <div class="col-md-4 col-sm-6" style="margin: 0px;display: inline-block;padding: 15px;vertical-align: top;">
                        <div class="card" style="height: 100%; display: flex; flex-direction: column;">

                            <div class="card-header font-weight-bold" style="background: #f8f9fa;">
                                <?php echo safe_html($row['cat_title']); ?>
                            </div>
                            <div class="card-body" style="flex: 1 1 auto;">
                                <h5 class="card-title" style="color: #337ab7; font-weight: 600;"><?php echo safe_html($row['event_name']); ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-building"></i> <?php echo safe_html($row['company_name']); ?></h6>
                                <p class="card-text" style="font-size: 13px; color: #555; text-align: justify;"><?php echo nl2br(safe_html($row['description'])); ?></p>
                            </div>
                            <div class="card-footer" style="background: #fafafa; border-top: 1px solid #eee;">
                                <div style="display: flex;justify-content: space-evenly">
                                    <?php if ($inCart): ?>
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removecart(<?php echo $eventId; ?>)"><i class="fa fa-trash"></i> Remove from Cart</button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-primary btn-sm" onclick="addcart(<?php echo $eventId; ?>)"><i class="fa fa-cart-plus"></i> Add to Cart</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                    }
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
    function addcart(id) {
        $.ajax({
            url: "php/cart.php",
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

    function removecart(id) {
        $.ajax({
            url: "php/cart.php",
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
        $('#cat').change(function() {
            $.ajax({
                url: "php/allevents.php",
                type: "post",
                data: {
                    filterp: "check",
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
                url: "php/allevents.php",
                type: "post",
                data: {
                    searchp: "check",
                    search: document.getElementById('search').value,
                    cat: document.getElementById('cat').value,

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