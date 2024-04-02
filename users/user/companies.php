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
                <span>Companies</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page " style="display: flex;justify-content: space-between;">


                <div>
                    <input type="text" id="search" placeholder="Search companies.." />
                    <button type="button" onclick="window.location.reload()"><i class="fa fa-repeat"></i> Clear
                        all</button>
                </div>

            </div>
            <div class="blank-page row" id="content" style="margin: 0px;">



                <?php
                $sql = "select * from company";
                $res = sel($sql);
                while ($row = mysqli_fetch_assoc($res)) {
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
    $(document).ready(function() {


        $('#search').keyup(function() {
            $.ajax({
                url: "php/companies.php",
                type: "post",
                data: {
                    searchp: "check",
                    search: document.getElementById('search').value,

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