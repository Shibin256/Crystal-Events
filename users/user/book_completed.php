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
.dataTables_length {
    margin-right: 15px;

}

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
                <span>Completed Bookings</span>
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
                        $sql = "select bookings.*,events.*,company.*,category.*,events.name as event_name,company.name as company_name  from bookings,events,company,category where company.email=events.company_email and category.cat_id=events.category and events.event_id=bookings.event_id and user_email='$email' and book_status=3 order by book_status,event_date_time";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $row['book_id']; ?></td>
                            <td><a href="javascript:;" data-toggle="modal" data-target="#exampleModal"
                                    onclick="{document.getElementById('name').innerHTML='<?php echo $row['event_name']; ?>';document.getElementById('category').innerHTML='<?php echo $row['cat_title']; ?>';document.getElementById('requirements').innerHTML='<?php echo $row['requirements']; ?>'}"><?php echo $row['event_name']; ?></a>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo date_format(date_create($row['event_date_time']), 'd-m-Y h:i A'); ?></td>
                            <td><?php echo $row['event_place']; ?></td>
                            <td><?php echo $row['event_district']; ?></td>
                            <td><?php echo $row['event_pincode']; ?></td>
                            <td><?php echo $row['requirements']; ?></td>
                            <td><?php echo $row['reply']; ?></td>
                            <td><?php echo $row['price']; ?></td>
                            <td>
                                <?php
                                    $id = $row['book_id'];
                                    $sql = "select * from review where book_id='$id'";

                                    if (num($sql) == 0) {
                                    ?>
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal2"
                                    onclick="document.getElementById('book_id').value=<?php echo $row['book_id']; ?>">Add
                                    Review</button>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
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
                    <input type="hidden" id="book_id" name="book_id">
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

function pay(book_id, amt) {
    <?php
        $sql = "select * from users where email='$email'";
        $res = sel($sql);
        $row = mysqli_fetch_assoc($res);

        ?>
    var options = {
        "key": "<?php echo $apikey ?>", // Enter the Key ID generated from the Dashboard
        "amount": amt *
            100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "name": "Crystal Events",
        "description": "Payment",
        "image": "images/logo.png",
        //"order_id": "order_9A33XWu170gUtm", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        // "callback_url": "php/success.php?amt=" + amt,
        "handler": function(response) {
            console.log(response.razorpay_payment_id);
            $.ajax({
                url: "php/success.php",
                type: "post",
                data: {
                    success: "check",
                    book_id: book_id,
                    amt: amt,
                    response: response.razorpay_payment_id


                },
                beforeSend: function() {
                    Swal.fire({
                        title: "Please wait for a while...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    Swal.showLoading();
                },
                success: function(res) {
                    console.log(res);
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Success!',
                    }).then((result) => {
                        window.location.reload(true);
                    })

                }
            });
        },
        "prefill": {
            "name": "<?php echo $row['firstname'] . ' ' . $row['lastname'] ?>",
            "email": "<?php echo $row['email'] ?>",
            "contact": "<?php echo $row['phone'] ?>"
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}

function pay2(book_id, amt) {
    <?php
        $sql = "select * from users where email='$email'";
        $res = sel($sql);
        $row = mysqli_fetch_assoc($res);

        ?>
    var options = {
        "key": "<?php echo $apikey ?>", // Enter the Key ID generated from the Dashboard
        "amount": amt *
            100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
        "currency": "INR",
        "name": "Crystal Events",
        "description": "Payment",
        "image": "images/logo.png",
        //"order_id": "order_9A33XWu170gUtm", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
        // "callback_url": "php/success.php?amt=" + amt,
        "handler": function(response) {
            console.log(response);
            $.ajax({
                url: "php/success2.php",
                type: "post",
                data: {
                    success: "check",
                    book_id: book_id,
                    amt: amt,
                    response: response

                },
                beforeSend: function() {
                    Swal.fire({
                        title: "Please wait for a while...",
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                    });
                    Swal.showLoading();
                },
                success: function(res) {
                    Swal.close();
                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Success!',
                    }).then((result) => {
                        window.location.reload(true);
                    })

                }
            });
        },
        "prefill": {
            "name": "<?php echo $row['firstname'] . ' ' . $row['lastname'] ?>",
            "email": "<?php echo $row['email'] ?>",
            "contact": "<?php echo $row['phone'] ?>"
        },
        "notes": {
            "address": "Razorpay Corporate Office"
        },
        "theme": {
            "color": "#3399cc"
        }
    };
    var rzp1 = new Razorpay(options);
    rzp1.open();
}
</script>