<?php
require('header.php');

$userCount = num("SELECT email FROM users");
$companyCount = num("SELECT email FROM company");
$eventCount = num("SELECT event_id FROM events");
$bookingCount = num("SELECT book_id FROM bookings");

$revRes = sel("SELECT SUM(amount) as total_rev FROM payment");
$revRow = $revRes ? mysqli_fetch_assoc($revRes) : null;
$totalRevenue = (float)($revRow['total_rev'] ?? 0);

$messageCount = num("SELECT contact_id FROM contact");
?>
<style>
.stat-card {
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
.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.stat-icon {
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
.stat-info h3 {
    margin: 0;
    font-size: 26px;
    font-weight: 700;
    color: #333;
}
.stat-info p {
    margin: 4px 0 0 0;
    font-size: 13px;
    color: #777;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.stat-info a {
    font-size: 12px;
    font-weight: 500;
    text-decoration: none;
}
.c-blue { background: #337ab7; border-left-color: #337ab7; }
.c-green { background: #5cb85c; border-left-color: #5cb85c; }
.c-orange { background: #f0ad4e; border-left-color: #f0ad4e; }
.c-teal { background: #5bc0de; border-left-color: #5bc0de; }
.c-purple { background: #6f42c1; border-left-color: #6f42c1; }
.c-red { background: #d9534f; border-left-color: #d9534f; }
</style>

<div class="main-grid">
    <div class="agile-grids">
        <div class="banner">
            <h2>
                <a href="index.php">Admin Panel</a>
                <i class="fa fa-angle-right"></i>
                <span>Platform Metrics</span>
            </h2>
        </div>

        <div class="blank" style="padding-top: 20px;">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="stat-card" style="border-left-color: #337ab7;">
                        <div class="stat-icon c-blue">
                            <i class="fa fa-users"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $userCount; ?></h3>
                            <p>Registered Users</p>
                            <a href="users.php" class="text-primary">Manage Users &rarr;</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="stat-card" style="border-left-color: #5cb85c;">
                        <div class="stat-icon c-green">
                            <i class="fa fa-building"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $companyCount; ?></h3>
                            <p>Event Companies</p>
                            <a href="companies.php" class="text-success">Manage Companies &rarr;</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="stat-card" style="border-left-color: #f0ad4e;">
                        <div class="stat-icon c-orange">
                            <i class="fa fa-calendar-check-o"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $eventCount; ?></h3>
                            <p>Events Listed</p>
                            <a href="category.php" class="text-warning">Manage Categories &rarr;</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="stat-card" style="border-left-color: #5bc0de;">
                        <div class="stat-icon c-teal">
                            <i class="fa fa-bookmark"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $bookingCount; ?></h3>
                            <p>Total Bookings</p>
                            <small class="text-muted">Across all organizers</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="stat-card" style="border-left-color: #6f42c1;">
                        <div class="stat-icon c-purple">
                            <i class="fa fa-inr"></i>
                        </div>
                        <div class="stat-info">
                            <h3>₹<?php echo number_format($totalRevenue, 2); ?></h3>
                            <p>Platform Payments</p>
                            <small class="text-muted">Total processed receipts</small>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="stat-card" style="border-left-color: #d9534f;">
                        <div class="stat-icon c-red">
                            <i class="fa fa-envelope"></i>
                        </div>
                        <div class="stat-info">
                            <h3><?php echo $messageCount; ?></h3>
                            <p>Enquiries / Messages</p>
                            <a href="messages.php" class="text-danger">View Inquiries &rarr;</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent bookings overview -->
            <div class="row" style="margin-top: 15px;">
                <div class="col-md-12">
                    <div style="background: #fff; padding: 20px; border-radius: 6px; box-shadow: 0 2px 5px rgba(0,0,0,0.06);">
                        <h4 style="margin-top: 0; font-weight: 600; color: #337ab7; margin-bottom: 15px;">
                            <i class="fa fa-list"></i> Recent Platform Bookings
                        </h4>
                        <?php
                        $bRes = sel("SELECT bookings.*, events.name as event_name, company.name as company_name, users.firstname, users.lastname 
                                     FROM bookings 
                                     JOIN events ON bookings.event_id=events.event_id 
                                     JOIN company ON events.company_email=company.email 
                                     JOIN users ON bookings.user_email=users.email 
                                     ORDER BY bookings.book_id DESC LIMIT 6");
                        if ($bRes && mysqli_num_rows($bRes) > 0):
                        ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event</th>
                                        <th>Organizer</th>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($b = mysqli_fetch_assoc($bRes)): ?>
                                    <tr>
                                        <td>#<?php echo safe_html($b['book_id']); ?></td>
                                        <td><strong><?php echo safe_html($b['event_name']); ?></strong></td>
                                        <td><?php echo safe_html($b['company_name']); ?></td>
                                        <td><?php echo safe_html($b['firstname'] . ' ' . $b['lastname']); ?></td>
                                        <td><?php echo date_format(date_create($b['event_date_time']), 'd-m-Y'); ?></td>
                                        <td>₹<?php echo number_format((float)$b['price'], 2); ?></td>
                                        <td>
                                            <?php
                                            $st = (int)$b['book_status'];
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
                            <p class="text-muted" style="margin: 0;">No bookings on the platform yet.</p>
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
