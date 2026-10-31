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
                            <th>Company</th>
                            <th>Company Email</th>
                            <th>Event DateTime</th>
                            <th>Event Place</th>
                            <th>Event District</th>
                            <th>Event Pincode</th>
                            <th>Requirements</th>
                            <th>Company Reply</th>
                            <th>Price</th>
                            <th>Action</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select bookings.*,events.*,company.*,category.*,events.name as event_name,company.name as company_name from bookings,events,company,category where company.email=events.company_email and category.cat_id=events.category and events.event_id=bookings.event_id and user_email=? and book_status=2 order by book_status,event_date_time";
                        $res = sel($sql, [$email]);

                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo safe_html($row['book_id']); ?></td>
                            <td><a href="javascript:;" data-toggle="modal" data-target="#exampleModal"
                                    onclick="{document.getElementById('name').innerHTML=<?php echo htmlspecialchars(json_encode($row['event_name']), ENT_QUOTES, 'UTF-8'); ?>;document.getElementById('category').innerHTML=<?php echo htmlspecialchars(json_encode($row['cat_title']), ENT_QUOTES, 'UTF-8'); ?>;document.getElementById('requirements').innerHTML=<?php echo htmlspecialchars(json_encode($row['requirements']), ENT_QUOTES, 'UTF-8'); ?>}"><?php echo safe_html($row['event_name']); ?></a></td>
                            <td><?php echo safe_html($row['company_name'] ?? $row['name']); ?></td>
                            <td><?php echo safe_html($row['company_email'] ?? $row['email']); ?></td>
                            <td><?php echo date_format(date_create($row['event_date_time']), 'd-m-Y h:i A'); ?></td>
                            <td><?php echo safe_html($row['event_place']); ?></td>
                            <td><?php echo safe_html($row['event_district']); ?></td>
                            <td><?php echo safe_html($row['event_pincode']); ?></td>
                            <td><?php echo safe_html($row['requirements']); ?></td>
                            <td><?php echo safe_html($row['reply']); ?></td>
                            <td>₹<?php echo number_format((float)$row['price'], 2); ?></td>
                            <td>
                                <div class="btn-group">
                                    <?php
                                        if ($row['pay_id1'] == 0) {
                                        ?>
                                    <button class="btn btn-sm btn-primary"
                                        onclick="pay(<?php echo (int)$row['book_id']; ?>, <?php echo (int)round($row['price'] * 0.40); ?>)">Pay Advance Now</button>
                                    <button class="btn btn-sm btn-danger"
                                        onclick="cancel(<?php echo (int)$row['book_id']; ?>)">Cancel</button>
                                    <?php
                                        }
                                        if ($row['pay_id1'] != 0 && $row['pay_id2'] == 0) {
                                        ?>
                                    <button class="btn btn-sm btn-info"
                                        onclick="pay2(<?php echo (int)$row['book_id']; ?>, <?php echo (int)($row['price'] - round($row['price'] * 0.40)); ?>)">Pay Balance Now</button>
                                    <?php
                                        }
                                        ?>
                                </div>
                            </td>
                        </tr>

                        <?php
                            }
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
require('../../php/keys.php');

?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/datetime/1.5.1/js/dataTables.dateTime.min.js"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

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

var IS_MOCK_PAYMENTS = <?php echo defined('MOCK_PAYMENTS') && MOCK_PAYMENTS ? 'true' : 'false'; ?>;

function processPaymentAjax(url, book_id, amt, responseRef) {
    Swal.fire({
        title: "Processing payment...",
        allowOutsideClick: false,
        allowEscapeKey: false,
        didOpen: () => { Swal.showLoading(); }
    });
    $.ajax({
        url: url,
        type: "post",
        data: {
            success: "check",
            book_id: book_id,
            amt: amt,
            response: responseRef
        },
        dataType: "json",
        success: function(res) {
            Swal.close();
            Swal.fire({
                icon: 'success',
                title: 'Payment Success!',
                text: 'Amount: ₹' + (res.amount || amt)
            }).then(() => {
                window.location.reload(true);
            });
        },
        error: function(xhr) {
            Swal.close();
            var errMsg = 'Payment failed.';
            try {
                var json = JSON.parse(xhr.responseText);
                if (json.message) errMsg = json.message;
            } catch (e) {}
            Swal.fire({
                icon: 'error',
                title: 'Payment Error',
                text: errMsg
            });
        }
    });
}

function pay(book_id, amt) {
    if (IS_MOCK_PAYMENTS) {
        Swal.fire({
            title: 'Confirm Advance Payment',
            text: 'Pay 40% Advance (₹' + amt + ') via Mock Payment Gateway?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Pay ₹' + amt
        }).then((result) => {
            if (result.isConfirmed) {
                processPaymentAjax("php/success.php", book_id, amt, 'mock_adv_' + Date.now());
            }
        });
        return;
    }

    <?php
    $uRes = sel("select * from users where email=?", [$email]);
    $uRow = $uRes ? mysqli_fetch_assoc($uRes) : [];
    ?>
    var options = {
        "key": "<?php echo safe_html($apikey); ?>",
        "amount": amt * 100,
        "currency": "INR",
        "name": "Crystal Events",
        "description": "Advance Payment (40%)",
        "image": "images/logo.png",
        "handler": function(response) {
            processPaymentAjax("php/success.php", book_id, amt, response.razorpay_payment_id || response);
        },
        "prefill": {
            "name": <?php echo json_encode(($uRow['firstname'] ?? '') . ' ' . ($uRow['lastname'] ?? '')); ?>,
            "email": <?php echo json_encode($uRow['email'] ?? ''); ?>,
            "contact": <?php echo json_encode($uRow['phone'] ?? ''); ?>
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}

function pay2(book_id, amt) {
    if (IS_MOCK_PAYMENTS) {
        Swal.fire({
            title: 'Confirm Balance Payment',
            text: 'Pay 60% Balance (₹' + amt + ') via Mock Payment Gateway?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Pay ₹' + amt
        }).then((result) => {
            if (result.isConfirmed) {
                processPaymentAjax("php/success2.php", book_id, amt, 'mock_bal_' + Date.now());
            }
        });
        return;
    }

    <?php
    $uRes = sel("select * from users where email=?", [$email]);
    $uRow = $uRes ? mysqli_fetch_assoc($uRes) : [];
    ?>
    var options = {
        "key": "<?php echo safe_html($apikey); ?>",
        "amount": amt * 100,
        "currency": "INR",
        "name": "Crystal Events",
        "description": "Balance Payment (60%)",
        "image": "images/logo.png",
        "handler": function(response) {
            processPaymentAjax("php/success2.php", book_id, amt, response.razorpay_payment_id || response);
        },
        "prefill": {
            "name": <?php echo json_encode(($uRow['firstname'] ?? '') . ' ' . ($uRow['lastname'] ?? '')); ?>,
            "email": <?php echo json_encode($uRow['email'] ?? ''); ?>,
            "contact": <?php echo json_encode($uRow['phone'] ?? ''); ?>
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}


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