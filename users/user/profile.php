<?php
require('header.php');

$sql = "select * from users where email='$email'";
$res = sel($sql);
$row = mysqli_fetch_assoc($res);
?>
<style>
    .profile-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
    }

    .profile-image {
        position: relative;
        width: 150px;
        height: 150px;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        box-shadow: -1px 1px 5px rgb(0, 0, 0);
    }

    .edit-icon {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background-color: #007bff;
        color: #fff;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .edit-icon i {
        font-size: 18px;
    }
</style>
<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Profile </span>
            </h2>
        </div>
        <?php
        if ($status == 0) {
        ?>
            <br>
            <div class="alert alert-info bg-info">
                <strong>Info!</strong> Account under verification. Please complete profile.
            </div>
        <?php
        }
        ?>
        <div class="blank">
            <div class="row">
                <div class="col-md-4">
                    <div class="blank-page">
                        <div class="profile-container">
                            <div class="profile-image">
                                <img src="<?php echo 'uploads/profile/' . rawurlencode(!empty($row['profile_pic']) ? $row['profile_pic'] : 'default.jpg'); ?>" alt="Profile Image">
                                <div class="edit-icon">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <input type="file" id="file-input" style="display: none;" accept=".jpg, .jpeg, .png, .webp">
                            </div>
                        </div>
                        <div class="progressbar-heading grids-heading" style="margin-bottom: 30px;">
                            <h2><?php echo safe_html(($row['firstname'] ?? '') . " " . ($row['lastname'] ?? '')); ?></h2>
                        </div>
                        <h4 style="margin-top: 15px;"><i class="fa fa-envelope"></i> <?php echo safe_html($row['email']); ?></h4>
                        <h4 style="margin-top: 15px;"><i class="fa fa-phone"></i> <?php echo safe_html($row['phone']); ?></h4>
                        <h4 style="margin-top: 15px;"><i class="fa fa-home"></i> <?php echo safe_html($row['housename']); ?></h4>
                        <h4 style="margin-top: 15px;"><i class="fa fa-map-marker"></i> <?php echo safe_html($row['place']); ?></h4>
                        <h4 style="margin-top: 15px;"><i class="fa fa-location-arrow"></i> <?php echo safe_html($row['district']); ?></h4>
                        <h4 style="margin-top: 15px;"><i class="fa fa-tag"></i> <?php echo safe_html($row['pincode']); ?></h4>
                        <h4 style="margin-top: 15px;"><i class="fa fa-birthday-cake"></i> <?php echo safe_html($row['date_of_birth']); ?></h4>
                    </div>


                </div>
                <div class="col-md-8">
                    <div class="blank-page">
                        <div class="forms">
                            <div class="form-grids widget-shadow" data-example-id="basic-forms">
                                <div class="form-title">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="form-body">
                                    <form action="php/profile.php" method="post">
                                        <div class="form-group">
                                            <label for="">Email address</label>
                                            <input type="email" name="email" disabled class="form-control" placeholder="Email" value="<?php echo safe_html($row['email']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">First name</label>
                                            <input type="text" name="firstname" class="form-control" placeholder="First name" required value="<?php echo safe_html($row['firstname']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Last name</label>
                                            <input type="text" name="lastname" class="form-control" placeholder="Last name" required value="<?php echo safe_html($row['lastname']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Mobile</label>
                                            <input type="text" name="phone" class="form-control" placeholder="Mobile number" required pattern="\d{10}" title="Please enter a 10-digit phone number" value="<?php echo safe_html($row['phone']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">House Name</label>
                                            <input type="text" name="housename" class="form-control" placeholder="House name" required value="<?php echo safe_html($row['housename']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Place</label>
                                            <input type="text" name="place" class="form-control" placeholder="Place" required value="<?php echo safe_html($row['place']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">District</label>
                                            <select class="form-control" name="district" id="dist" required="">
                                                <?php
                                                $districts = ["Kasargod", "Kannur", "Wayanad", "Kozhikode", "Malappuram", "Palakkad", "Thrissur", "Ernakulam", "Idukki", "Kottayam", "Alappuzha", "Pathanamthitta", "Kollam", "Thiruvananthapuram"];
                                                foreach ($districts as $d):
                                                ?>
                                                    <option value="<?php echo $d; ?>" <?php echo ($row['district'] === $d) ? 'selected' : ''; ?>><?php echo $d; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Pincode</label>
                                            <input type="text" name="pincode" class="form-control" placeholder="Pincode" pattern="\d{6}" title="Please enter a 6-digit pin number" required value="<?php echo safe_html($row['pincode']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Date Of Birth</label>
                                            <input type="date" name="date_of_birth" class="form-control" placeholder="Date of birth" value="<?php echo safe_html($row['date_of_birth']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Account number</label>
                                            <input type="text" name="acc_no" class="form-control" placeholder="Account number" value="<?php echo safe_html($row['acc_no']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">IFSC Code</label>
                                            <input type="text" name="ifsc_code" class="form-control" placeholder="IFSC Code" value="<?php echo safe_html($row['ifsc_code']); ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary" name="edit">Save Profile</button>
                                    </form>
                                </div>
                            </div>
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
<script>
    function validateForm() {
        var fnameInput = document.getElementById('fname');
        var lnameInput = document.getElementById('lname');
        var emailInput = document.getElementById('email');
        var phoneInput = document.getElementById('number');
        var hnameInput = document.getElementById('hname');
        var snameInput = document.getElementById('sname');
        var pcodeInput = document.getElementById('pcode');
        var accountNumberInput = document.getElementById('accnum');
        var ifscCodeInput = document.getElementById('ifsccode');

        var namePattern = /[A-Za-z ]+/;
        var placePattern = /^[A-Za-z0-9 ]+$/;
        var phonePattern = /\d{10}/;
        var emailPattern = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/;
        var pinPattern = /\d{6}/;
        var accountNumberPattern = /\d{11,16}/;
        var ifscCodePattern = /[A-Za-z]{4}\d{7}/;

        if (!namePattern.test(fnameInput.value)) {
            alert('Please enter a valid name (only letters and spaces are allowed).');
            return false;
        }
        if (!namePattern.test(lnameInput.value)) {
            alert('Please enter a valid name (only letters and spaces are allowed).');
            return false;
        }
        if (!placePattern.test(hnameInput.value)) {
            alert('Please enter a valid name ');
            return false;
        }
        if (!placePattern.test(snameInput.value)) {
            alert('Please enter a valid name ');
            return false;
        }
        if (!phonePattern.test(phoneInput.value)) {
            alert('Please enter a valid 10-digit phone number.');
            return false;
        }
        if (!pinPattern.test(pcodeInput.value)) {
            alert('Please enter a valid 6-digit phone number.');
            return false;
        }
        if (!accountNumberPattern.test(accountNumberInput.value)) {
            alert('Please enter a valid account number ');
            return false;
        }

        if (!ifscCodePattern.test(ifscCodeInput.value)) {
            alert('Please enter a valid IFSC code ');
            return false;
        }

        return true;
    }
</script>
<script>
    var dropdown = document.getElementById("dist");

    for (var i = 0; i < dropdown.options.length; i++) {
        if (dropdown.options[i].value === "<?php echo $row['district']; ?>") {
            dropdown.selectedIndex = i;
            break;
        }
    }

    //profile pic update
    $('.edit-icon').on('click', function(e) {
        $('#file-input').click();
    });
    $('#file-input').on('change', function() {
        var selectedFile = this.files[0];
        if (selectedFile) {
            var fileExtension = selectedFile.name.split('.').pop().toLowerCase();
            if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png') {
                var formData = new FormData();
                formData.append('file', selectedFile);
                $.ajax({
                    url: 'php/profile_pic.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        console.log(res);
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Picture Updated!',
                        }).then((result) => {
                            window.location.reload();
                        })
                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Format!',
                    text: 'Please select jpg, jpeg or png file',
                }).then((result) => {
                    window.location.reload();
                })
            }
        }
    });
</script>