<?php
session_start();
$email = $_SESSION['email'];

require("../../../php/connect.php");

if (isset($_POST['searchp']) || isset($_POST['cat'])) {

    $search = $_POST['search'];
    $cat = $_POST['cat'];

    $sql = "select events.*,category.*,company.*,company.name as company_name,events.name as event_name from events,category,company where events.category=category.cat_id and company.email=events.company_email and events.name like '%" . $search . "%'";


    if ($cat != 'all')
        $sql .= " and category.cat_id='$cat'";

    $num = num($sql);
    if ($num == 0) {
        echo "<p style='text-align: center;'>No results found!!!</p>";
    } else {
        $result = sel($sql);
        $n = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $n++;
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
                                <div class="heart" style="border: none;background: transparent;" onclick="removecart(<?php echo $row['event_id']; ?>)"><button class="btn btn-danger btn-sm">Remove
                                        from Cart</button></div>
                            <?php
                            } else {
                            ?>
                                <div class="heart" style="border: none;background: transparent;" onclick="addcart(<?php echo $row['event_id']; ?>)"><button class="btn btn-primary btn-sm">Add to
                                        Cart</button></div>

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
    }


    exit();
}

?>