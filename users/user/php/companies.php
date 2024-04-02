<?php
session_start();
$email = $_SESSION['email'];

require("../../../php/connect.php");

if (isset($_POST['searchp'])) {

    $search = $_POST['search'];

    $sql = "select * from company where name like '%" . $search . "%'";


    $num = num($sql);
    if ($num == 0) {
        echo "<p style='text-align: center;'>No results found!!!</p>";
    } else {
        $result = sel($sql);
        $n = 0;
        while ($row = mysqli_fetch_assoc($result)) {
            $n++;
?>
            <div class="col-md-3" style="margin: 0px;display: inline-block;padding: 15px;">
                <div class="card" style="height: 100%;">
                    <img class="card-img" src="<?php echo '../company/uploads/profile/' . $row['profile_pic']; ?>" style="height: 200px;">
                    <!-- <div class="card-header"></div> -->
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['name']; ?></h5>
                        <p class="card-text" style="text-align: justify;">
                            <?php echo  substr($row['about'], 0, 300); ?>...</p>
                    </div>
                    <div class="card-footer">
                        <div style="display: flex;justify-content: space-evenly">
                            <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='view.php?id=<?php echo urlencode($row['email']); ?>'">View</button>
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