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
                <span>Bikes </span>
            </h2>
        </div>
        <div class="blank">
            <div class="blank-page">


                <div class="forms">
                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Add New Bikes</h4>
                        </div>
                        <div class="form-body">
                            <form action="php/addbikes.php" method="post" enctype="multipart/form-data" onsubmit="return check()">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Name</label>
                                    <input type="text" class="form-control" placeholder="Name" name="name" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Brand</label>
                                    <select class="form-control" placeholder="Color" name="brand" required="">
                                        <option value="" selected disabled>Brand</option>
                                        <option value="DUCATI">DUCATI</option>
                                        <option value="YAMAHA">YAMAHA</option>
                                        <option value="BMW">BMW</option>
                                        <option value="KAWASAKI">KAWASAKI</option>
                                        <option value="KTM">KTM</option>
                                        <option value="HONDA">HONDA</option>
                                        <option value="TRIUMPH">TRIUMPH</option>
                                        <option value="HARLEY DAVIDSON">HARLEY DAVIDSON</option>
                                        <option value="AGUSTA ">AGUSTA</option>

                                    </select>
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
                                            <option value="<?php echo $row['category_id']; ?>">
                                                <?php echo $row['category_name']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Color</label>
                                    <select class="form-control" placeholder="Color" name="color" required="">
                                        <option value="" selected disabled>Color</option>
                                        <option value="Red">Red</option>
                                        <option value="Black">Black</option>
                                        <option value="Yellow">Yellow</option>
                                        <option value="White">White</option>
                                        <option value="Green">Green</option>
                                        <option value="Blue">Blue</option>
                                        <option value="Grey">Grey</option>
                                        <option value="Orange">Orange</option>
                                        <option value="Brown">Brown</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">CC</label>
                                    <input type="number" class="form-control" placeholder="Cubic Capacity" name="cubic_capacity" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Stock</label>
                                    <input type="number" class="form-control" placeholder="stock" name="stock" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Photo</label>
                                    <input type="file" class="form-control" placeholder="Photo" name="photo1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Photo</label>
                                    <input type="file" class="form-control" placeholder="Photo" name="photo2" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Photo</label>
                                    <input type="file" class="form-control" placeholder="Photo" name="photo3" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Price</label>
                                    <input type="number" class="form-control" placeholder="Price" name="price" required="">
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