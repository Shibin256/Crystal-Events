<?php
require('header.php');
?>

<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>


<div class="main-grid">
    <div class="agile-grids">
        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Events </span>
            </h2>
        </div>
        <div class="blank">
            <div class="blank-page">


                <div class="forms">
                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Add New Events</h4>
                        </div>
                        <div class="form-body">
                            <form action="php/addevents.php" method="post" enctype="multipart/form-data"
                                onsubmit="return check()">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Category</label>
                                    <select class="form-control" placeholder="Category" name="category_id" required="">
                                        <option value="" selected disabled>Category</option>
                                        <?php

                                        $sql = "select * from category";
                                        $res = sel($sql);
                                        while ($row = mysqli_fetch_assoc($res)) {
                                        ?>
                                        <option value="<?php echo $row['cat_id']; ?>">
                                            <?php echo $row['cat_title']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Description</label>
                                    <textarea rows="6" class="form-control" placeholder="Give detailed description..."
                                        name="description" required=""></textarea>
                                </div>
                                <button type="submit" class="btn btn-default w3ls-button" name="add">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<?php
require('footer.php');
?>

<script type="text/javascript">
function check() {
    var photo = document.getElementById('photo');
    var fileExtension = photo.value.split('.').pop().toLowerCase();
    if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png') {
        return true;
    } else {
        Swal.fire({
            icon: 'error',
            title: 'Invalid File Format!',
            text: 'Please select jpg, jpeg or png file',
        }).then((result) => {
            photo.focus();
        })
        return false;
    }

}
</script>