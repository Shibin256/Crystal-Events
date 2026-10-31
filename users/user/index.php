<?php
require('header.php');
?>

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
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
                    if ($res) {
                        while ($row = mysqli_fetch_assoc($res)) {
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
                                    <a href="view.php?id=<?php echo urlencode($row['company_email']); ?>" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye"></i> View Organizer</a>
                                </div>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div style="display: flex;justify-content: flex-end; margin-top: 15px;">
                    <button class="btn btn-primary" onclick="window.location.href='allevents.php'">
                        <i class="fa fa-search"></i> Browse All Events
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