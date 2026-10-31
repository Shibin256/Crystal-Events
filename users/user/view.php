<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: companies.php");
    exit;
}
require('header.php');

$id = trim($_GET['id']);
$res = sel("SELECT * FROM company WHERE email=?", [$id]);
if (!$res || mysqli_num_rows($res) === 0) {
    echo "<script>window.location.replace('companies.php');</script>";
    exit;
}
$row = mysqli_fetch_assoc($res);
?>
<style>
.display-flex { display: flex; }
.store-body { display: flex; flex-direction: row; padding: 0; }
.carousel-item img { height: 450px; object-fit: cover; }
.review-block { background-color: #FAFAFA; border: 1px solid #EFEFEF; padding: 15px; border-radius: 3px; margin-bottom: 15px; }
.review-block-name { font-size: 14px; font-weight: 700; margin: 10px 0px 5px 0px; }
.review-block-date { font-size: 12px; color: #777; }
.review-block-rate { font-size: 13px; margin-bottom: 10px; }
.review-block-description { font-size: 13px; line-height: 1.6; }
.rating-block { background-color: #FAFAFA; border: 1px solid #EFEFEF; padding: 15px; border-radius: 3px; }
.bold { font-weight: 700; }
.padding-bottom-7 { padding-bottom: 7px; }
</style>

<section id="main-content">
    <div class="typo-agile">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-5">
                    <img src="../company/uploads/profile/<?php echo rawurlencode(!empty($row['profile_pic']) ? $row['profile_pic'] : 'default.jpg'); ?>"
                         alt="<?php echo safe_html($row['name']); ?>"
                         class="img-fluid rounded" style="width: 100%; max-height: 400px; object-fit: cover; border: 1px solid #ddd;">
                </div>
                <div class="col-md-7" style="border-left: 1px solid #eee; padding-left: 30px;">
                    <h2 style="color: #337ab7; font-weight: 700; margin-top: 0;"><?php echo safe_html($row['name']); ?></h2>
                    <?php if (!empty($row['est_date'])): ?>
                        <p class="text-muted"><i class="fa fa-calendar"></i> Established in <?php echo date_format(date_create($row['est_date']), "d-m-Y"); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($row['ownername'])): ?>
                        <h4 style="font-size: 16px; color: #555;"><strong>Owner:</strong> <?php echo safe_html($row['ownername']); ?></h4>
                    <?php endif; ?>
                    <p style="text-align: justify; line-height: 1.6; color: #555;"><?php echo nl2br(safe_html($row['about'])); ?></p>
                    <hr>
                    <dl class="row">
                        <dt class="col-sm-3">Email</dt>
                        <dd class="col-sm-9"><?php echo safe_html($row['email']); ?></dd>
                        <dt class="col-sm-3">Phone</dt>
                        <dd class="col-sm-9"><?php echo safe_html($row['phone']); ?></dd>
                        <dt class="col-sm-3">Place</dt>
                        <dd class="col-sm-9"><?php echo safe_html($row['place']); ?></dd>
                        <dt class="col-sm-3">District</dt>
                        <dd class="col-sm-9"><?php echo safe_html($row['district']); ?></dd>
                        <dt class="col-sm-3">Pin Code</dt>
                        <dd class="col-sm-9"><?php echo safe_html($row['pincode']); ?></dd>
                    </dl>
                </div>
            </div>
            <hr>
        </div>

        <!-- Gallery Section -->
        <div class="container mt-5">
            <h4 style="font-weight: 600;"><i class="fa fa-picture-o"></i> Gallery</h4><br>
            <?php
            $gRes = sel("SELECT * FROM gallery WHERE company_email=?", [$id]);
            $galleryItems = [];
            if ($gRes) {
                while ($g = mysqli_fetch_assoc($gRes)) {
                    $galleryItems[] = $g;
                }
            }
            if (empty($galleryItems)):
            ?>
                <p class="text-muted">No gallery photos uploaded yet.</p>
            <?php else: ?>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php foreach ($galleryItems as $idx => $gItem): ?>
                            <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $idx; ?>" class="<?php echo $idx === 0 ? 'active' : ''; ?>"></li>
                        <?php endforeach; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php foreach ($galleryItems as $idx => $gItem): ?>
                            <div class="carousel-item <?php echo $idx === 0 ? 'active' : ''; ?>">
                                <img class="d-block w-100" src="../company/uploads/gallery/<?php echo rawurlencode($gItem['photo']); ?>" alt="<?php echo safe_html($gItem['caption']); ?>">
                                <?php if (!empty($gItem['caption'])): ?>
                                    <div class="carousel-caption d-none d-md-block" style="background: rgba(0,0,0,0.5); border-radius: 4px;">
                                        <h5><?php echo safe_html($gItem['caption']); ?></h5>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Reviews Section -->
        <?php
        $revSql = "SELECT review.*, users.firstname, users.lastname, users.profile_pic 
                   FROM review 
                   JOIN bookings ON review.book_id = bookings.book_id 
                   JOIN events ON bookings.event_id = events.event_id 
                   JOIN users ON users.email = bookings.user_email 
                   WHERE events.company_email = ? 
                   ORDER BY review.review_date DESC";
        $revRes = sel($revSql, [$id]);
        $reviews = [];
        $totalStars = 0;
        $starCounts = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

        if ($revRes) {
            while ($r = mysqli_fetch_assoc($revRes)) {
                $reviews[] = $r;
                $s = (int)$r['star'];
                if ($s >= 1 && $s <= 5) {
                    $starCounts[$s]++;
                    $totalStars += $s;
                }
            }
        }
        $countm = count($reviews);
        $avgRate = $countm > 0 ? round($totalStars / $countm, 1) : 0;
        ?>

        <div class="container mt-5">
            <h4 style="font-weight: 600;"><i class="fa fa-star"></i> Customer Reviews</h4><br>
            <?php if ($countm === 0): ?>
                <div class="alert alert-light text-center">
                    <p class="text-muted" style="margin: 0;">No reviews yet for this organizer.</p>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="rating-block">
                            <h4>Average user rating</h4>
                            <h2 class="bold padding-bottom-7"><?php echo $avgRate; ?> <small>/ 5</small></h2>
                            <div style="margin-bottom: 5px;">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <button type="button" class="btn btn-sm <?php echo $i <= round($avgRate) ? 'btn-warning' : 'btn-secondary'; ?>" style="padding: 2px 6px;">
                                        <span class="fa fa-star"></span>
                                    </button>
                                <?php endfor; ?>
                            </div>
                            <div class="text-muted"><i class="fa fa-user"></i> <?php echo $countm; ?> total review<?php echo $countm > 1 ? 's' : ''; ?></div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php for ($s = 5; $s >= 1; $s--):
                            $cnt = $starCounts[$s];
                            $pct = $countm > 0 ? round(($cnt / $countm) * 100) : 0;
                            $barClass = $s >= 4 ? 'bg-success' : ($s === 3 ? 'bg-info' : ($s === 2 ? 'bg-warning' : 'bg-danger'));
                        ?>
                            <div class="d-flex align-items-center" style="margin-bottom: 5px;">
                                <div style="width: 40px;"><?php echo $s; ?> <span class="fa fa-star"></span></div>
                                <div class="progress flex-grow-1" style="height: 10px; margin: 0 10px;">
                                    <div class="progress-bar <?php echo $barClass; ?>" role="progressbar" style="width: <?php echo $pct; ?>%" aria-valuenow="<?php echo $pct; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div style="width: 30px; text-align: right;"><?php echo $cnt; ?></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-sm-12">
                        <div class="review-block">
                            <?php foreach ($reviews as $rev):
                                $revPic = !empty($rev['profile_pic']) ? $rev['profile_pic'] : 'default.jpg';
                            ?>
                                <div class="row" style="padding: 10px 0; border-bottom: 1px solid #eee;">
                                    <div class="col-sm-3">
                                        <img src="uploads/profile/<?php echo rawurlencode($revPic); ?>" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div class="review-block-name"><?php echo safe_html($rev['firstname'] . ' ' . $rev['lastname']); ?></div>
                                        <div class="review-block-date"><?php echo date_format(date_create($rev['review_date']), 'M d, Y'); ?></div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="review-block-rate">
                                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                                <span class="fa fa-star <?php echo $i <= (int)$rev['star'] ? 'text-warning' : 'text-muted'; ?>"></span>
                                            <?php endfor; ?>
                                        </div>
                                        <div class="review-block-description"><?php echo nl2br(safe_html($rev['review'])); ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
require('footer.php');
?>
