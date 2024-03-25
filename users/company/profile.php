<?php
require('header.php');

$sql = "select * from company where email='$email'";
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
                                <img src="<?php echo 'uploads/profile/' . $row['profile_pic']; ?>" alt="Profile Image">
                                <div class="edit-icon">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <input type="file" id="file-input" style="display: none;" accept=".jpg, .jpeg, .png">
                            </div>
                        </div>
                        <div class="progressbar-heading grids-heading" style="margin-bottom: 80px;">
                            <h2><?php echo $row['name']; ?></h2>
                        </div>
                        <h4 style="margin-top: 15px;" id="h4.-bootstrap-heading"><?php echo $row['email']; ?></h4>
                        <h4 style="margin-top: 15px;" id="h4.-bootstrap-heading"><?php echo $row['phone']; ?></h4>
                        <h4 style="margin-top: 15px;" id="h4.-bootstrap-heading"><?php echo $row['ownername']; ?></h4>
                        <br><br>
                        <p style="text-align: justify;"><?php echo $row['about']; ?></p>
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
                                            <input type="email" name="email" disabled class="form-control" placeholder="Email" value="<?php echo $row['email']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Name" pattern="[A-Za-z ]+" title="Only letters and spaces are allowed" required value="<?php echo $row['name']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Owner name</label>
                                            <input type="text" name="ownername" class="form-control" placeholder="Owner Name" pattern="[A-Za-z ]+" title="Only letters and spaces are allowed" required value="<?php echo $row['ownername']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Mobile</label>
                                            <input type="text" name="phone" class="form-control" placeholder="mobile number" required pattern="\d{10}" title="Please enter a 10-digit phone number" value="<?php echo $row['phone']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Street Name</label>
                                            <input type="text" name="place" class="form-control" pattern="[A-Za-z ]+" title="Only letters and spaces are allowed" placeholder="street name" required value="<?php echo $row['place']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">District</label>
                                            <select class="form-control" placeholder="District" name="district" id="dist" required="">
                                                <option value="Kasargod">Kasargod</option>
                                                <option value="Kannur">Kannur</option>
                                                <option value="Waynad">Wayanad</option>
                                                <option value="Kozhikode">Kozhikode</option>
                                                <option value="Malappuram">Malappuram</option>
                                                <option value="Palakkad">Palakkad</option>
                                                <option value="Thrissur">Thrissur</option>
                                                <option value="Ernakulam">Ernakulam</option>
                                                <option value="Idukki">Idukki</option>
                                                <option value="Kottayam">Kottayam</option>
                                                <option value="Alappuzha">Alappuzha</option>
                                                <option value="Pathanamthitta">Pathanamthitta</option>
                                                <option value="Kollam">Kollam</option>
                                                <option value="Thiruvananthapuram">Thiruvananthapuram</option>

                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="">Pincode</label>
                                            <input type="text" name="pincode" class="form-control" placeholder="pincode" pattern="\d{6}" title="Please enter a 6-digit pin number" required value="<?php echo $row['pincode']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Established date</label>
                                            <input type="date" name="est_date" class="form-control" placeholder="date of birth" required value="<?php echo $row['est_date']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Account number</label>
                                            <input type="text" name="acc_no" class="form-control" pattern="\d{11,16}" title="Please enter a valid account number " placeholder="account number" required value="<?php echo $row['acc_no']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">IFSC Code</label>
                                            <input type="text" name="ifsc_code" class="form-control" placeholder="ifsc codes" pattern="[A-Z]{4}\d{7}" title="Please enter a valid IFSC code " required value="<?php echo $row['ifsc_code']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="">About</label>
                                            <textarea name="about" rows="10" class="form-control" placeholder="About" pattern="[A-Za-z ]+" title="Please enter a valid data" required><?php echo $row['about']; ?></textarea>
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


    </div>
</div>


<?php
require('footer.php');
?>
<script>
    function validateForm() {
        var nameInput = document.getElementById('name');
        var emailInput = document.getElementById('email');
        var phoneInput = document.getElementById('number');
        var ownernameInput = document.getElementById('ownername');
        var placeInput = document.getElementById('place');
        var pcodeInput = document.getElementById('pincode');
        var accountNumberInput = document.getElementById('accnum');
        var ifscCodeInput = document.getElementById('ifsccode');

        var namePattern = /[A-Za-z ]+/;
        var placePattern = /^[A-Za-z0-9 ]+$/;
        var phonePattern = /\d{10}/;
        var emailPattern = /[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/;
        var pinPattern = /\d{6}/;
        var accountNumberPattern = /\d{11,16}/;
        var ifscCodePattern = /[A-Za-z]{4}\d{7}/;

        if (!namePattern.test(nameInput.value)) {
            alert('Please enter a valid name (only letters and spaces are allowed).');
            return false;
        }
        if (!namePattern.test(lnameInput.value)) {
            alert('Please enter a valid name (only letters and spaces are allowed).');
            return false;
        }
        if (!placePattern.test(ownernameInput.value)) {
            alert('Please enter a valid name ');
            return false;
        }
        if (!placePattern.test(placeInput.value)) {
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