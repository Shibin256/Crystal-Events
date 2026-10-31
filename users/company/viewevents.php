<?php
require('header.php');

// Fetch categories for edit modal
$catList = [];
$catRes = sel("SELECT cat_id, cat_title FROM category ORDER BY cat_title ASC");
if ($catRes) {
    while ($c = mysqli_fetch_assoc($catRes)) {
        $catList[] = $c;
    }
}
?>
<style>
.event-card {
    background: #fff;
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12);
    margin-bottom: 20px;
    display: flex;
    flex-direction: column;
    height: 100%;
}
.event-card .card-header {
    background-color: #f7f7f7;
    border-bottom: 1px solid #eee;
    font-weight: 600;
    padding: 10px 15px;
    color: #337ab7;
}
.event-card .card-body {
    padding: 15px;
    flex: 1 1 auto;
}
.event-card .card-footer {
    background: #fafafa;
    border-top: 1px solid #eee;
    padding: 10px 15px;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
</style>

<div class="main-grid">
    <div class="agile-grids">
        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Events</span>
            </h2>
        </div>

        <div class="blank">
            <div class="row">
                <?php
                $sql = "SELECT events.*, category.cat_title FROM events JOIN category ON events.category = category.cat_id WHERE events.company_email = ? ORDER BY events.event_id DESC";
                $res = sel($sql, [$email]);
                $hasEvents = false;

                if ($res) {
                    while ($row = mysqli_fetch_assoc($res)) {
                        $hasEvents = true;
                ?>
                <div class="col-md-4 col-sm-6" style="margin-bottom: 20px;">
                    <div class="event-card">
                        <div class="card-header">
                            <i class="fa fa-tag"></i> <?php echo safe_html($row['cat_title']); ?>
                        </div>
                        <div class="card-body">
                            <h4 style="margin-top: 0; color: #333; font-weight: 600;"><?php echo safe_html($row['name']); ?></h4>
                            <p style="text-align: justify; color: #666; font-size: 13px; line-height: 1.6; min-height: 60px;">
                                <?php echo nl2br(safe_html($row['description'])); ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-sm btn-info"
                                data-toggle="modal"
                                data-target="#editModal"
                                onclick="openEditModal(<?php echo (int)$row['event_id']; ?>, <?php echo htmlspecialchars(json_encode($row['name']), ENT_QUOTES, 'UTF-8'); ?>, <?php echo (int)$row['category']; ?>, <?php echo htmlspecialchars(json_encode($row['description']), ENT_QUOTES, 'UTF-8'); ?>)">
                                <i class="fa fa-pencil"></i> Edit
                            </button>
                            <form action="php/delete_event.php" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this event?');">
                                <input type="hidden" name="event_id" value="<?php echo (int)$row['event_id']; ?>">
                                <button type="submit" name="delete" class="btn btn-sm btn-danger">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                    }
                }

                if (!$hasEvents) {
                    echo '<div class="col-md-12"><div class="alert alert-info"><i class="fa fa-info-circle"></i> No events added yet. <a href="addevents.php" class="alert-link">Add your first event</a>.</div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Edit Event Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Event</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/edit_event.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="edit_event_id" name="event_id">
                    <div class="form-group">
                        <label for="edit_name">Event Name</label>
                        <input type="text" class="form-control" name="name" id="edit_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_category">Category</label>
                        <select class="form-control" name="category_id" id="edit_category" required>
                            <?php foreach ($catList as $cat): ?>
                            <option value="<?php echo (int)$cat['cat_id']; ?>">
                                <?php echo safe_html($cat['cat_title']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea rows="5" class="form-control" name="description" id="edit_description" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="edit">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(id, name, category, description) {
    document.getElementById('edit_event_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_category').value = category;
    document.getElementById('edit_description').value = description;
}
</script>

<?php
require('footer.php');
?>
