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
                <span>Bookings</span>
                <i class="fa fa-angle-right"></i>
                <span>Test Drive</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <table id="table" class="table-responsive">
                    <thead>
                        <tr>
                            <th>BookingID</th>
                            <th>Bike</th>
                            <th>Booked Date</th>
                            <th>Test Date</th>
                            <th>Booking Price</th>
                            <th>Status</th>
                            <th>Invoice</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from test_book,bike,payment where test_book.payment_id=payment.payment_id and bike.bike_id=test_book.bike_id and email_id='$email' order by status,test_date";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><?php echo $row['book_id']; ?></td>
                                <td><a href="view.php?id=<?php echo $row['bike_id']; ?>"><?php echo $row['name']; ?></a>
                                </td>
                                <td><?php echo date_format(date_create($row['book_date']), 'd-m-Y h:i A'); ?></td>
                                <td><?php echo date_format(date_create($row['test_date']), 'd-m-Y'); ?></td>
                                <td>₹ 500</td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1)
                                        echo "<p style='color: orange;'>Pending</p>";
                                    else if ($row['status'] == 2)
                                        echo "<p style='color: green;'>Completed</p>";
                                    ?>
                                </td>
                                <td><a class="btn btn-sm btn-primary" target="_blank" href="invoice2.php?id=<?php echo $row['book_id']; ?>">View</a></td>
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
</script>