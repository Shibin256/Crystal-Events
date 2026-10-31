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
                $sql = "select * from company order by name asc";
                $res = sel($sql);
                if ($res) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $profilePic = !empty($row['profile_pic']) ? $row['profile_pic'] : 'default.jpg';
                        $aboutSnippet = substr(safe_str($row['about']), 0, 300);
                ?>
                    <div class="col-md-3 col-sm-6" style="margin: 0px;display: inline-block;padding: 15px;vertical-align: top;">
                        <div class="card" style="height: 100%; display: flex; flex-direction: column;">
                            <img class="card-img-top" src="<?php echo '../company/uploads/profile/' . rawurlencode($profilePic); ?>" alt="<?php echo safe_html($row['name']); ?>" style="height: 200px; object-fit: cover;">
                            <div class="card-body" style="flex: 1 1 auto;">
                                <h5 class="card-title" style="font-weight: 600;"><?php echo safe_html($row['name']); ?></h5>
                                <p class="card-text" style="text-align: justify; font-size: 13px; color: #666;">
                                    <?php echo nl2br(safe_html($aboutSnippet)); ?><?php if (strlen(safe_str($row['about'])) > 300) echo '...'; ?></p>
                            </div>
                            <div class="card-footer" style="background: #fafafa; border-top: 1px solid #eee;">
                                <div style="display: flex;justify-content: space-evenly">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='view.php?id=<?php echo urlencode($row['email']); ?>'"><i class="fa fa-eye"></i> View Company</button>
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