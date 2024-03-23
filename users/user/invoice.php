<?php
if (!isset($_GET['id'])) {
    echo "<script>window.location.replace('index.php');</script>";
}
session_start();
require("../php/connect.php");
$id = $_GET['id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js">
    </script>
    <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <style>
    body {
        margin-top: 10px;
        background: #eee;
    }

    @media print {
        #print {
            display: none;
        }
    }
    </style>
</head>

<body>
    <div class="container bootdey">
        <div class="row invoice row-printable">
            <div class="col-md-10 col-md-offset-1">
                <!-- col-lg-12 start here -->
                <div class="panel panel-default plain" id="dash_0">
                    <!-- Start .panel -->
                    <div class="panel-body p30">
                        <div class="row">
                            <!-- Start .row -->
                            <div class="col-lg-6">
                                <!-- col-lg-6 start here -->
                                <div class="invoice-logo"><img width="100"
                                        src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Invoice logo">
                                </div>
                            </div>
                            <!-- col-lg-6 end here -->
                            <div class="col-lg-6">
                                <!-- col-lg-6 start here -->
                                <div class="invoice-from">
                                    <ul class="list-unstyled text-right">
                                        <li>AutoDoc</li>
                                        <li>2500 Ridgepoint Dr, Suite 105-C</li>
                                        <li>Austin TX 78754</li>
                                        <li>VAT Number EU826113958</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- col-lg-6 end here -->
                            <div class="col-lg-12">
                                <!-- col-lg-12 start here -->
                                <div class="invoice-details mt25">
                                    <div class="well">
                                        <ul class="list-unstyled mb0">
                                            <?php
                                            $sql = "select * from pro_order,payment where order_id=$id";
                                            $res = sel($sql);
                                            $row = mysqli_fetch_assoc($res);
                                            ?>
                                            <li><strong>Invoice</strong> #<?php echo $row['payment_id']  ?></li>
                                            <li><strong>Invoice Date:</strong>
                                                <?php echo date_format(date_create($row['paid_date']), 'd/m/Y h:i A'); ?>
                                            </li>
                                            <li><strong>Paid Date:</strong>
                                                <?php echo date_format(date_create($row['paid_date']), 'd/m/Y h:i A'); ?>
                                            </li>
                                            <li><strong>Status:</strong> <span class="label label-success">PAID</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="invoice-to mt25">
                                    <ul class="list-unstyled">
                                        <?php
                                        $sql = "select * from customer,pro_order where customer.email_id=pro_order.email_id and pro_order.order_id=$id";
                                        $res = sel($sql);
                                        $row = mysqli_fetch_assoc($res);

                                        ?>
                                        <li><strong>Invoiced To</strong></li>
                                        <li><?php echo $row['first_name'] . " " . $row['last_name'] ?></li>
                                        <li><?php echo $row['housename'] . ", " . $row['streetname'] . ", " ?></li>
                                        <li><?php echo $row['district'] . " - " . $row['pincode'] ?></li>
                                        <li><?php echo $row['phone_no']  ?></li>
                                    </ul>
                                </div>
                                <div class="invoice-items">
                                    <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="per70 text-center">Bike</th>
                                                    <th class="per5 text-center">Description</th>
                                                    <th class="per25 text-center">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "select * from pro_order,bike where pro_order.bike_id=bike.bike_id and order_id=$id";
                                                $res = sel($sql);
                                                $row = mysqli_fetch_assoc($res);
                                                ?>
                                                <tr>
                                                    <td>1</td>
                                                    <td> <a
                                                            href="view.php?id=<?php echo $row['bike_id']; ?>"><?php echo $row['name']; ?></a>
                                                    </td>
                                                    <td>Booking</td>
                                                    <td class="text-right">₹50000</td>
                                                </tr>
                                                <?php
                                                if ($row['status'] == 2) {
                                                ?>
                                                <tr>
                                                    <td>1</td>
                                                    <td> <a
                                                            href="view.php?id=<?php echo $row['bike_id']; ?>"><?php echo $row['name']; ?></a>
                                                    </td>
                                                    <td>Purchase</td>
                                                    <td class="text-right">₹<?php echo $row['price'] - 50000; ?></td>
                                                </tr>
                                                <?php
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th></th>
                                                    <th colspan="2" class="text-right">Total:</th>
                                                    <th class="text-right">₹
                                                        <?php
                                                        if ($row['status'] == 2) {
                                                        ?>
                                                        <?php echo $row['price']; ?>
                                                        <?php
                                                        } else {
                                                        ?>
                                                        50000<?php
                                                                }
                                                                    ?>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                                <div class="invoice-footer mt25">
                                    <p class="text-center">Generated on <?php echo date("l, F jS, Y ") ?><a id="print"
                                            href="javascript:;" onclick="window.print();"
                                            class="btn btn-default ml15"><i class="fa fa-print mr5"></i> Print</a></p>
                                </div>
                            </div>
                            <!-- col-lg-12 end here -->
                        </div>
                        <!-- End .row -->
                    </div>
                </div>
                <!-- End .panel -->
            </div>
            <!-- col-lg-12 end here -->
        </div>
    </div>
</body>

</html>