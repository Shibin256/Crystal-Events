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
                <a href="index.html">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Blank</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <table id="table">
                    <thead>
                        <tr>
                            <th>OrderID</th>
                            <th>event</th>
                            <th>User</th>
                            <th>User Email</th>
                            <th>Ordered Date</th>
                            <th>Delivered Date</th>
                            <th>Price</th>
                            <th>Booking Price</th>
                            <th>Status</th>
                            <th>Action</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from bookings,events,customer where customer.email_id=bookings.email_id and events.event_id=bookings.event_id order by status,event_date";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><a href="view.php?id=<?php echo $row['event_id']; ?>"><?php echo $row['name']; ?></a>
                                <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                <td><?php echo $row['email_id']; ?></td>
                                <td><?php echo date_format(date_create($row['order_date']), 'd-m-Y h:i A'); ?></td>
                                <td>
                                    <?php
                                    if ($row['delivered_date'] != NULL)
                                        echo date_format(date_create($row['delivered_date']), 'd-m-Y h:i A');
                                    else
                                        echo "-";
                                    ?>
                                </td>
                                <td>₹ <?php echo $row['price']; ?></td>
                                <td>₹ 50000</td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1)
                                        echo "<p style='color: orange;'>Pending</p>";
                                    else if ($row['status'] == 2)
                                        echo "<p style='color: green;'>Completed</p>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                    ?>
                                        <button class="btn btn-sm btn-primary" onclick="update(<?php echo $row['order_id']; ?>,<?php echo $row['status'] + 1; ?>,'<?php echo $row['email_id']; ?>')">Update
                                            to<br> Delivered</button>
                                    <?php
                                    } else {
                                        echo "-";
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
                title: "Orders(<?php echo $email; ?>) - AutoDoc",
                text: '<i class="fa fa-file-excel-o"> Excel</i>',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }, {
                extend: 'pdfHtml5',
                title: "Orders(<?php echo $email; ?>) - AutoDoc",
                orientation: 'landscape',
                pageSize: 'A3',
                text: '<i class="fa fa-file-pdf-o"> PDF</i>',
                titleAttr: 'PDF',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }, {
                extend: 'print',
                title: "Orders(<?php echo $email; ?>) - AutoDoc",
                orientation: 'landscape',
                pageSize: 'A4',
                text: '<i class="fa fa-print"> Print</i>',
                exportOptions: {
                    columns: 'th:not(:last-child)'
                }
            }],
        });
    });

    function update(order_id, status, email) {
        Swal.fire({
            title: 'Order Update',
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
                    url: "php/order_status.php",
                    type: "post",
                    data: {
                        order_id: order_id,
                        status: status,
                        email: email
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