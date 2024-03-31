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
                <span>Approved Bookings</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <table id="table" class="table-responsive">
                    <thead>
                        <tr>
                            <th>BookID</th>
                            <th>event</th>
                            <th>User</th>
                            <th>User Email</th>
                            <th>Event DateTime</th>
                            <th>Event Place</th>
                            <th>Event District</th>
                            <th>Event Pincode</th>
                            <th>Requirements</th>
                            <th>Company Reply</th>
                            <th>Pay Status</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select bookings.*,events.*,users.*,category.*,events.name as event_name  from bookings,events,users,category where users.email=bookings.user_email and category.cat_id=events.category and events.event_id=bookings.event_id and company_email='$email' and book_status=2 order by book_status,event_date_time";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><?php echo $row['book_id']; ?></td>
                                <td><a href="javascript:;" data-toggle="modal" data-target="#exampleModal" onclick="{document.getElementById('name').innerHTML='<?php echo $row['event_name']; ?>';document.getElementById('category').innerHTML='<?php echo $row['cat_title']; ?>';document.getElementById('description').innerHTML='<?php echo $row['description']; ?>'}"><?php echo $row['event_name']; ?></a>
                                <td><?php echo $row['firstname'] . " " . $row['lastname']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo date_format(date_create($row['event_date_time']), 'd-m-Y h:i A'); ?></td>
                                <td><?php echo $row['event_place']; ?></td>
                                <td><?php echo $row['event_district']; ?></td>
                                <td><?php echo $row['event_pincode']; ?></td>
                                <td><?php echo $row['requirements']; ?></td>
                                <td><?php echo $row['reply']; ?></td>
                                <td>
                                    <?php
                                    if ($row['pay_id1'] == 0) {
                                    ?>
                                        <p class="text-warning">Pending</p>
                                    <?php
                                    } else if ($row['pay_id2'] == 0) {
                                    ?>
                                        <p class="text-info">Balance Pending</p>
                                    <?php
                                    } else {
                                    ?>
                                        <p class="text-success">Completed</p>
                                    <?php
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['book_status'] == 2 && $row['pay_id2'] != 0) {
                                    ?>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-success" onclick="complete('<?php echo $row['book_id']; ?>')">Mark as Completed</button>
                                        </div>
                                    <?php
                                    }
                                    ?>
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

    function complete(book_id) {
        Swal.fire({
            title: 'Booking Status',
            text: "Are you sure want to update?",
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
                    url: "php/book_approved.php",
                    type: "post",
                    data: {
                        complete: "complete",
                        book_id: book_id
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