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
                $sql = "select events.*,category.*,company.*,company.name as company_name,events.name as event_name from events,category,company where events.category=category.cat_id and company.email=events.company_email";
                $res = sel($sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <div class="col-md-4" style="margin: 0px;display: inline-block;padding: 15px;">
                        <div class="card" style="height: 100%;">

                            <div class="card-header">
                                <?php echo $row['cat_title']; ?>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['event_name']; ?></h5>
                                <h6 class="card-title"><?php echo $row['company_name']; ?></h6>
                                <p class="card-text"><?php echo $row['description']; ?></p>
                            </div>
                            <div class="card-footer">
                                <div style="display: flex;justify-content: space-evenly">
                                    <?php
                                    $sql2 = "select * from cart where user='$email' and event_id=" . $row['event_id'];
                                    $num = num($sql2);
                                    if ($num != 0) {
                                    ?>
                                        <div class="heart" style="border: none;background: transparent;" onclick="removecart(<?php echo $row['event_id']; ?>)"><button class="btn btn-danger btn-sm">Remove from Cart</button></div>
                                    <?php
                                    } else {
                                    ?>
                                        <div class="heart" style="border: none;background: transparent;" onclick="addcart(<?php echo $row['event_id']; ?>)"><button class="btn btn-primary btn-sm">Add to Cart</button></div>

                                    <?php
                                    }
                                    ?>
                                    <!-- <button class="btn btn-sm btn-primary"
                                    onclick="window.location.href='view.php?id=<?php //echo $row['event_id']; 
                                                                                ?>'"><i
                                        class="fa fa-eye"></i> View</button> -->
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
        $('#filter, #cat').change(function() {
            $.ajax({
                url: "php/allevents.php",
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
                url: "php/allevents.php",
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