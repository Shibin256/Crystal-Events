<?php
require('header.php');
?>

<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>

<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/datetime/1.5.1/css/dataTables.dateTime.min.css" rel="stylesheet">

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Pending Bookings</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <table id="table" class="table-responsive">
                    <thead>
                        <tr>
                            <th>BookID</th>
                            <th>event</th>
                            <th>Company</th>
                            <th>Company Email</th>
                            <th>Event DateTime</th>
                            <th>Event Place</th>
                            <th>Event District</th>
                            <th>Event Pincode</th>
                            <th>Requirements</th>
                            <th>Company Reply</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select bookings.*,events.*,company.*,category.*,events.name as event_name,company.name as company_name  from bookings,events,company,category where company.email=events.company_email and category.cat_id=events.category and events.event_id=bookings.event_id and user_email='$email' and (book_status=0 or book_status=1) order by book_status,event_date_time";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><?php echo $row['book_id']; ?></td>
                                <td><a href="javascript:;" data-toggle="modal" data-target="#exampleModal" onclick="{document.getElementById('name').innerHTML='<?php echo $row['event_name']; ?>';document.getElementById('category').innerHTML='<?php echo $row['cat_title']; ?>';document.getElementById('description').innerHTML='<?php echo $row['description']; ?>'}"><?php echo $row['event_name']; ?></a>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo date_format(date_create($row['event_date_time']), 'd-m-Y h:i A'); ?></td>
                                <td><?php echo $row['event_place']; ?></td>
                                <td><?php echo $row['event_district']; ?></td>
                                <td><?php echo $row['event_pincode']; ?></td>
                                <td><?php echo $row['requirements']; ?></td>
                                <td><?php echo $row['reply']; ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal1" onclick="{document.getElementById('book_id').value='<?php echo $row['book_id']; ?>';document.getElementById('date_time').value='<?php echo $row['event_date_time']; ?>';document.getElementById('place').value='<?php echo $row['event_place']; ?>';document.getElementById('district').value='<?php echo $row['event_district']; ?>';document.getElementById('pincode').value='<?php echo $row['event_pincode']; ?>';document.getElementById('requirements').value='<?php echo $row['requirements'] ?>';}">Edit</button>
                                        <button class="btn btn-sm btn-danger" onclick="cancel('<?php echo $row['book_id']; ?>')">Cancel</button>
                                    </div>
                                </td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- //blank-page -->
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Event Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <h5 class="card-title" id="name"></h5>
                    <h6 class="card-title" id="category"></h6>
                    <p class="card-text" id="description"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Booking Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/book_pending.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="book_id" name="book_id">
                    <div class="form-group">
                        <label for="City" class="col-form-label">DateTime</label>
                        <input type="datetime-local" class="form-control" placeholder="" name="date_time" id="date_time" required="">
                    </div>
                    <div class="form-group">
                        <label for="City" class="col-form-label">Place</label>
                        <input type="text" class="form-control" placeholder="" name="place" id="place" required="">
                    </div>
                    <div class="form-group">
                        <label for="District" class="col-form-label">District</label>
                        <select class="form-control" placeholder="District" name="district" id="district" required="">
                            <option value="" disabled selected></option>
                            <option value="Kasargod">Kasargod</option>
                            <option value="Kannur">Kannur</option>
                            <option value="Wayanad">Wayanad</option>
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
                        <label for="Pincode" class="col-form-label">Pincode</label>
                        <input type="text" class="form-control" placeholder="" name="pincode" id="pincode" required="">
                    </div>

                    <div class="form-group">
                        <label for="Pincode" class="col-form-label">Description</label>
                        <textarea class="form-control" placeholder="" name="requirements" id="requirements" required=""></textarea>
                    </div>
                </div>
                </ </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="edit">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>




<?php
require('footer.php');
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        let table = new DataTable('#table', {
            order: [],
            dom: 'lBfrtip',
            buttons: [{
                extend: 'copyHtml5',
                text: '<i class="fa fa-copy"> Copy</i>',
            }, {
                extend: 'excelHtml5',
                title: "Orders(<?php echo $email; ?>) - CrystalEvents",
                text: '<i class="fa fa-file-excel-o"> Excel</i>',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }, {
                extend: 'pdfHtml5',
                title: "Orders(<?php echo $email; ?>) - CrystalEvents",
                orientation: 'landscape',
                pageSize: 'A3',
                text: '<i class="fa fa-file-pdf-o"> PDF</i>',
                titleAttr: 'PDF',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }, {
                extend: 'print',
                title: "Orders(<?php echo $email; ?>) - CrystalEvents",
                orientation: 'landscape',
                pageSize: 'A4',
                text: '<i class="fa fa-print"> Print</i>',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }],
        });
    });

    function cancel(book_id) {
        Swal.fire({
            title: 'Cancel',
            text: "Are you sure want to cancel?",
            icon: 'question',
            showClass: {
                popup: 'animated fadeInDown faster'
            },
            hideClass: {
                popup: 'animated zoomOut faster'
            },
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "php/book_pending.php",
                    type: "post",
                    data: {
                        cancel: true,
                        book_id: book_id,
                    },
                    beforeSend: function() {
                        Swal.fire({
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                        });
                        Swal.showLoading();
                    },
                    success: function(res) {
                        console.log(res);
                        Swal.fire({
                            icon: 'success',
                            title: ' Success!',
                        }).then((result) => {
                            window.location.reload(true);
                        })
                    }
                });
            }

        });
    }
</script>