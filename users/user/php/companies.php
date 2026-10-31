<?php
session_start();
require_once __DIR__ . '/../../../php/connect.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['usertype']) || (int)$_SESSION['usertype'] !== 2) {
    http_response_code(403);
    echo "<p style='text-align: center;'>Unauthorized</p>";
    exit;
}

if (isset($_POST['searchp'])) {
    $search = trim($_POST['search'] ?? '');

    $sql = "SELECT * FROM company WHERE name LIKE ? ORDER BY name ASC";
    $result = sel($sql, ['%' . $search . '%']);

    if (!$result || mysqli_num_rows($result) === 0) {
        echo "<p style='text-align: center; width: 100%; padding: 20px;'>No results found!</p>";
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
            $profilePic = !empty($row['profile_pic']) ? $row['profile_pic'] : 'default.jpg';
            $aboutSnippet = substr(safe_str($row['about']), 0, 300);
?>
            <div class="col-md-3 col-sm-6" style="margin: 0px; display: inline-block; padding: 15px; vertical-align: top;">
                <div class="card" style="height: 100%; display: flex; flex-direction: column;">
                    <img class="card-img-top" src="../company/uploads/profile/<?php echo rawurlencode($profilePic); ?>" alt="<?php echo safe_html($row['name']); ?>" style="height: 200px; object-fit: cover;">
                    <div class="card-body" style="flex: 1 1 auto;">
                        <h5 class="card-title" style="font-weight: 600;"><?php echo safe_html($row['name']); ?></h5>
                        <p class="card-text" style="text-align: justify; font-size: 13px; color: #666;">
                            <?php echo nl2br(safe_html($aboutSnippet)); ?><?php if (strlen(safe_str($row['about'])) > 300) echo '...'; ?>
                        </p>
                    </div>
                    <div class="card-footer" style="background: #fafafa; border-top: 1px solid #eee;">
                        <div style="display: flex; justify-content: space-evenly">
                            <button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='view.php?id=<?php echo urlencode($row['email']); ?>'">
                                <i class="fa fa-eye"></i> View Company
                            </button>
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
