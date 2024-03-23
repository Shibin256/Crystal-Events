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
                <table id="table" class="">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>House Name</th>
                            <th>Street Name</th>
                            <th>District</th>
                            <th>Pincode</th>
                            <th>D.O.B</th>
                            <th>IFSC Code</th>
                            <th>Account Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from customer";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td data-th="Name"><span class="bt-content"><?php echo $row['first_name']; ?></span></td>
                            <td data-th="lname"><span class="bt-content"><?php echo $row['last_name']; ?></span></td>
                            <td data-th="Phone"><span class="bt-content"><?php echo $row['phone_no']; ?></span></td>
                            <td data-th="Email"><span class="bt-content"><?php echo $row['email_id']; ?></span></td>
                            <td data-th="Hname"><span class="bt-content"><?php echo $row['housename']; ?></span></td>
                            <td data-th="sname"><span class="bt-content"><?php echo $row['streetname']; ?></span></td>
                            <td data-th="district"><span class="bt-content"><?php echo $row['district']; ?></span></td>
                            <td data-th="pincode"><span class="bt-content"><?php echo $row['pincode']; ?></span></td>
                            <td data-th="DOB"><span class="bt-content"
                                    style="text-wrap: nowrap;"><?php echo date_format(date_create($row['date_of_birth']), "d-m-Y"); ?></span>
                            </td>
                            <td data-th="ifsc"><span class="bt-content"><?php echo $row['ifsc_code']; ?></span></td>
                            <td data-th="Anum"><span class="bt-content"><?php echo $row['account_number']; ?></span>
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

        }, {
            extend: 'pdfHtml5',
            title: "Orders(<?php echo $email; ?>) - AutoDoc",
            orientation: 'landscape',
            pageSize: 'A3',
            text: '<i class="fa fa-file-pdf-o"> PDF</i>',
            titleAttr: 'PDF',

        }, {
            extend: 'print',
            title: "Orders(<?php echo $email; ?>) - AutoDoc",
            orientation: 'landscape',
            pageSize: 'A4',
            text: '<i class="fa fa-print"> Print</i>',

        }],
    });
});
</script>