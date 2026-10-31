<?php
require('header.php');

// Metrics calculations for the logged-in company
$totalEvents = num("SELECT event_id FROM events WHERE company_email=?", [$email]);

$pendingBookings = num(
    "SELECT bookings.book_id FROM bookings JOIN events ON bookings.event_id=events.event_id WHERE events.company_email=? AND bookings.book_status IN (0, 1)",
    [$email]
);

$approvedBookings = num(
    "SELECT bookings.book_id FROM bookings JOIN events ON bookings.event_id=events.event_id WHERE events.company_email=? AND bookings.book_status=2",
    [$email]
);

$completedBookings = num(
    "SELECT bookings.book_id FROM bookings JOIN events ON bookings.event_id=events.event_id WHERE events.company_email=? AND bookings.book_status=3",
    [$email]
);

$earnRes = sel(
    "SELECT SUM(bookings.price) as total_earnings FROM bookings JOIN events ON bookings.event_id=events.event_id WHERE events.company_email=? AND (bookings.pay_id1 > 0 OR bookings.pay_id2 > 0)",
    [$email]
);
$earnRow = $earnRes ? mysqli_fetch_assoc($earnRes) : null;
$totalEarnings = (float)($earnRow['total_earnings'] ?? 0);

$rateRes = sel(
    "SELECT AVG(review.star) as avg_rating, COUNT(review.review_id) as total_reviews FROM review JOIN bookings ON review.book_id=bookings.book_id JOIN events ON bookings.event_id=events.event_id WHERE events.company_email=?",
    [$email]
);
$rateRow = $rateRes ? mysqli_fetch_assoc($rateRes) : null;
$avgRating = $rateRow && $rateRow['avg_rating'] !== null ? round((float)$rateRow['avg_rating'], 1) : 0;
$totalReviews = (int)($rateRow['total_reviews'] ?? 0);
?>
<style>
.metric-box {
    background: #fff;
    border-radius: 6px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.06);
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    border-left: 4px solid #337ab7;
    transition: transform 0.2s ease;
}
.metric-box:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.metric-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    margin-right: 15px;
    color: #fff;
    flex-shrink: 0;
}
.metric-details h3 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    color: #333;
}
.metric-details p {
    margin: 4px 0 0 0;
    font-size: 13px;
    color: #777;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.bg-events { background: #337ab7; }
.bg-pending { background: #f0ad4e; }
.bg-approved { background: #5bc0de; }
.bg-completed { background: #5cb85c; }
.bg-earnings { background: #6f42c1; }
.bg-rating { background: #e83e8c; }
</style>

<div class="main-grid">
    <div class="agile-grids">
        <div class="banner">
            <h2>
                <a href="index.php">Dashboard</a>
                <i class="fa fa-angle-right"></i>
                <span>Overview</span>
            </h2>
        </div>

        <div class="blank" style="padding-top: 20px;">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="metric-box" style="border-left-color: #337ab7;">
                        <div class="metric-icon bg-events">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div class="metric-details">
                            <h3><?php echo $totalEvents; ?></h3>
                            <p>Total Events</p>
                            <small><a href="viewevents.php" class="text-primary">Manage Catalogue &rarr;</a></small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="metric-box" style="border-left-color: #f0ad4e;">
                        <div class="metric-icon bg-pending">
                            <i class="fa fa-clock-o"></i>
                        </div>
                        <div class="metric-details">
                            <h3><?php echo $pendingBookings; ?></h3>
                            <p>Pending Enquiries</p>
                            <small><a href="book_pending.php" class="text-warning">Review Requests &rarr;</a></small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="metric-box" style="border-left-color: #5bc0de;">
                        <div class="metric-icon bg-approved">
                            <i class="fa fa-thumbs-up"></i>
                        </div>
                        <div class="metric-details">
                            <h3><?php echo $approvedBookings; ?></h3>
                            <p>Approved Bookings</p>
                            <small><a href="book_approved.php" class="text-info">Track Bookings &rarr;</a></small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="metric-box" style="border-left-color: #5cb85c;">
                        <div class="metric-icon bg-completed">
                            <i class="fa fa-check-circle"></i>
                        </div>
                        <div class="metric-details">
                            <h3><?php echo $completedBookings; ?></h3>
                            <p>Completed Events</p>
                            <small><a href="book_completed.php" class="text-success">View History &rarr;</a></small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="metric-box" style="border-left-color: #6f42c1;">
                        <div class="metric-icon bg-earnings">
                            <i class="fa fa-inr"></i>
                        </div>
                        <div class="metric-details">
                            <h3>₹<?php echo number_format($totalEarnings, 2); ?></h3>
                            <p>Total Booked Revenue</p>
                            <small class="text-muted">From active & completed bookings</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="metric-box" style="border-left-color: #e83e8c;">
                        <div class="metric-icon bg-rating">
                            <i class="fa fa-star"></i>
                        </div>
                        <div class="metric-details">
                            <h3><?php echo $avgRating; ?> <small style="font-size: 14px; color: #888;">/ 5</small></h3>
                            <p>Average Rating</p>
                            <small class="text-muted"><?php echo $totalReviews; ?> customer review<?php echo $totalReviews !== 1 ? 's' : ''; ?></small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent bookings table -->
            <div class="row" style="margin-top: 15px;">
                <div class="col-md-12">
                    <div style="background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.06);">
                        <h4 style="margin-top: 0; font-weight: 600; color: #337ab7; margin-bottom: 15px;">
                            <i class="fa fa-history"></i> Recent Booking Requests
                        </h4>
                        <?php
                        $recentSql = "SELECT bookings.*, events.name as event_name, users.firstname, users.lastname 
                                      FROM bookings 
                                      JOIN events ON bookings.event_id=events.event_id 
                                      JOIN users ON bookings.user_email=users.email 
                                      WHERE events.company_email=? 
                                      ORDER BY bookings.book_id DESC LIMIT 5";
                        $recentRes = sel($recentSql, [$email]);
                        if ($recentRes && mysqli_num_rows($recentRes) > 0):
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event</th>
                                        <th>Client</th>
                                        <th>Event Date</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($r = mysqli_fetch_assoc($recentRes)): ?>
                                    <tr>
                                        <td>#<?php echo safe_html($r['book_id']); ?></td>
                                        <td><strong><?php echo safe_html($r['event_name']); ?></strong></td>
                                        <td><?php echo safe_html($r['firstname'] . ' ' . $r['lastname']); ?></td>
                                        <td><?php echo date_format(date_create($r['event_date_time']), 'd-m-Y h:i A'); ?></td>
                                        <td><?php echo safe_html($r['event_place'] . ', ' . $r['event_district']); ?></td>
                                        <td>
                                            <?php
                                            $st = (int)$r['book_status'];
                                            if ($st === 0) echo '<span class="badge badge-warning">Pending</span>';
                                            elseif ($st === 1) echo '<span class="badge badge-danger">Rejected</span>';
                                            elseif ($st === 2) echo '<span class="badge badge-info">Approved</span>';
                                            elseif ($st === 3) echo '<span class="badge badge-success">Completed</span>';
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                            <p class="text-muted" style="margin: 0;">No booking requests received yet.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require('footer.php');
?>
