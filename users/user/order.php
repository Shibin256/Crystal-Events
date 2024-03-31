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

<style>
    .rate {
        float: left;
        height: 46px;
        padding: 0 10px;
    }

    .rate:not(:checked)>input {
        position: absolute;
        top: -9999px;
    }

    .rate:not(:checked)>label {
        float: right;
        width: 1em;
        overflow: hidden;
        white-space: nowrap;
        cursor: pointer;
        font-size: 30px;
        color: #ccc;
    }

    .rate:not(:checked)>label:before {
        content: '★ ';
    }

    .rate>input:checked~label {
        color: #ffc700;
    }

    .rate:not(:checked)>label:hover,
    .rate:not(:checked)>label:hover~label {
        color: #deb217;
    }

    .rate>input:checked+label:hover,
    .rate>input:checked+label:hover~label,
    .rate>input:checked~label:hover,
    .rate>input:checked~label:hover~label,
    .rate>label:hover~input:checked~label {
        color: #c59b08;
    }
</style>

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Blank</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <table id="table" class="table-responsive">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Bike</th>
                            <th>Ordered Date</th>
                            <th>Delivered Date</th>
                            <th>Price</th>
                            <th>Booking Price</th>
                            <th>Status</th>
                            <th>Invoice</th>
                            <th>Review</th>


                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from pro_order,bike,customer,payment where pro_order.payment_id=payment.payment_id and customer.email_id=pro_order.email_id and bike.bike_id=pro_order.bike_id and customer.email_id='$email' order by status,order_date,delivered_date";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><?php echo $row['order_id']; ?></td>
                                <td><a href="view.php?id=<?php echo $row['bike_id']; ?>"><?php echo $row['name']; ?></a>
                                <td><?php echo date_format(date_create($row['order_date']), 'd-m-Y h:i A'); ?></td>
                                <td><?php echo date_format(date_create($row['delivered_date']), 'd-m-Y h:i A'); ?></td>
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
                                <td><a class="btn btn-sm btn-primary" target="_blank" href="invoice.php?id=<?php echo $row['order_id']; ?>">View</a></td>
                                <td>
                                    <?php
                                    if ($row['review'] == "" && $row['delivered_date'] != NULL) {
                                    ?>
                                        <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#exampleModal" onclick="document.getElementById('order_id').value=<?php echo $row['order_id']; ?>">Add</button>
                                    <?php
                                    } else {
                                    ?>
                                        <button class="btn btn-sm btn-info" onclick="window.location.href='view.php?id=<?php echo $row['bike_id']; ?>'">View</button>

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
                <h5 class="modal-title" id="exampleModalLabel">Add Review</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="php/review.php" method="post">
                <div class="modal-body">
                    <input type="hidden" id="order_id" name="order_id">
                    <div class="form-group">
                        <div class="form-control" style="border: none;">
                            <div class="rate">
                                <input type="radio" id="star5" name="rate" value="5" />
                                <label for="star5" title="text">5 stars</label>
                                <input type="radio" id="star4" name="rate" value="4" />
                                <label for="star4" title="text">4 stars</label>
                                <input type="radio" id="star3" name="rate" value="3" />
                                <label for="star3" title="text">3 stars</label>
                                <input type="radio" id="star2" name="rate" value="2" />
                                <label for="star2" title="text">2 stars</label>
                                <input type="radio" id="star1" name="rate" value="1" />
                                <label for="star1" title="text">1 star</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Review</label>
                        <textarea rows=5 class="form-control" name="review" id="review" required=""></textarea>
                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" name="add">Add</button>
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
</script>