<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    http_response_code(403);
    echo "<p style='text-align: center;'>Unauthorized</p>";
    exit;
}

$email = $_SESSION['email'];

if (isset($_POST['searchp']) || isset($_POST['cat'])) {
    $search = trim($_POST['search'] ?? '');
    $cat = trim($_POST['cat'] ?? 'all');

    $sql = "SELECT events.*, category.cat_title, company.name AS company_name, events.name AS event_name 
            FROM events 
            JOIN category ON events.category = category.cat_id 
            JOIN company ON company.email = events.company_email 
            WHERE events.name LIKE ?";
    $params = ['%' . $search . '%'];

    if ($cat !== 'all' && is_numeric($cat)) {
        $sql .= " AND category.cat_id = ?";
        $params[] = (int)$cat;
    }

    $sql .= " ORDER BY events.event_id DESC";
    $result = sel($sql, $params);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<p style='text-align: center; width: 100%; padding: 20px;'>No results found!</p>";
    } else {
        // Preload user's cart event IDs to avoid N+1 queries
        $cartEvents = [];
        $cartRes = sel("SELECT event_id FROM cart WHERE user=?", [$email]);
        if ($cartRes) {
            while ($cRow = mysqli_fetch_assoc($cartRes)) {
                $cartEvents[(int)$cRow['event_id']] = true;
            }
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $eventId = (int)$row['event_id'];
            $inCart = isset($cartEvents[$eventId]);
?>
            <div class="col-md-4 col-sm-6" style="margin: 0px; display: inline-block; padding: 15px; vertical-align: top;">
                <div class="card" style="height: 100%; display: flex; flex-direction: column;">
                    <div class="card-header font-weight-bold" style="background:#f8f9fa;">
                        <?php echo safe_html($row['cat_title']); ?>
                    </div>
                    <div class="card-body" style="flex: 1 1 auto;">
                        <h5 class="card-title" style="color: #337ab7; font-weight: 600;"><?php echo safe_html($row['event_name']); ?></h5>
                        <h6 class="card-subtitle mb-2 text-muted"><i class="fa fa-building"></i> <?php echo safe_html($row['company_name']); ?></h6>
                        <p class="card-text" style="font-size: 13px; color: #555; text-align: justify;"><?php echo nl2br(safe_html($row['description'])); ?></p>
                    </div>
                    <div class="card-footer" style="background: #fafafa; border-top: 1px solid #eee;">
                        <div style="display: flex; justify-content: space-evenly">
                            <?php if ($inCart): ?>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removecart(<?php echo $eventId; ?>)">
                                    <i class="fa fa-trash"></i> Remove from Cart
                                </button>
                            <?php else: ?>
                                <button type="button" class="btn btn-primary btn-sm" onclick="addcart(<?php echo $eventId; ?>)">
                                    <i class="fa fa-cart-plus"></i> Add to Cart
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
<?php
        }
    }
    exit;
}
?>
