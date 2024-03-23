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
                <span>Password </span>
            </h2>
        </div>
        <div class="blank">
            <div class="blank-page">

                <div class="forms">
                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Change Password</h4>
                        </div>
                        <div class="form-body">
                            <form action="php/passwordchange.php" method="post">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Current Password</label>
                                    <input type="password" class="form-control" placeholder="Enter Current Password" name="cpass" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">New Password</label>
                                    <input type="password" class="form-control" placeholder="Enter New Password" name="npass" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Confirm Password</label>
                                    <input type="password" class="form-control" placeholder="Re-Enter Password" name="cnpass" required="">
                                </div>




                                <button type="submit" class="btn btn-default w3ls-button" name="edit">Submit</button>
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
    $(document).ready(function() {
        let table = new DataTable('#table');
    });
</script>