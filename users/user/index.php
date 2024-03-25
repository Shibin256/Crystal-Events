<?php
require('header.php');

$sql = "select status from login where email='$email'";
$res = sel($sql);
$row = mysqli_fetch_assoc($res);
$status = $row['status'];

if ($status == 0) {
    echo "<script>window.location.replace('profile.php')</script>";
}
?>

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.html">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Home</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <div class="row">



                    <?php
                    $sql = "select events.*,category.*,company.*,company.name as company_name,events.name as event_name from events,category,company where events.category=category.cat_id and company.email=events.company_email order by rand() limit 3";
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
                <div style="display: flex;justify-content: end;">
                    <button class="btn btn-primary" onclick="window.location.href='allevents.php'">
                        More Events
                    </button>
                </div>

            </div>
        </div>
        <!-- //blank-page -->
    </div>
</div>

<?php
require('footer.php');
?>