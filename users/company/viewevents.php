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
                <span>Events</span>
            </h2>
        </div>

        <div class="blank">
            <div class="row">



                <?php
                $sql = "select * from events,category where events.category=category.cat_id and company_email='$email'";
                $res = sel($sql);
                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                <div class="col-md-4" style="margin: 0px;display: inline-block;padding: 15px;">
                    <div class="card">

                        <div class="card-header">
                            <?php echo $row['cat_title']; ?>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row['name']; ?></h5>
                            <p class="card-text" style="text-align: justify;"><?php echo $row['description']; ?></p>
                        </div>
                        <div class="card-footer text-muted" style="display: flex;justify-content: space-evenly;">
                            <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="document.getElementById('events_id').value='<?php //echo $row['events_id']; 
                                                                                                                                                                                                ?>';document.getElementById('stock').value='<?php //echo $row['stock']; 
                                                                                                                                                                                                                                            ?>'">
                                    Update Stock
                                </button>
                                <button type="button" class="btn btn-sm btn-info" onclick="window.location.href='view.php?id=<?php //echo $row['events_id']; 
                                                                                                                                ?>'">View</button> -->

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
                    <input type="hidden" id="events_id" name="events_id">
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