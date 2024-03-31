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
                <a href=".php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Blank</span>
            </h2>
        </div>

        <div class="blank">
            <div class="blank-page">
                <table id="table" class="table-responsive">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Owner Name</th>
                            <th>Street Name</th>
                            <th>District</th>
                            <th>Pincode</th>
                            <th>Established Date</th>
                            <th>IFSC Code</th>
                            <th>Account Number</th>
                            <th>Aadhar</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from company,login where login.email=company.email order by status";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><span class="bt-content"><?php echo $row['name']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['phone']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['email']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['ownername']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['place']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['district']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['pincode']; ?></span></td>
                                <td><span class="bt-content" style="text-wrap: nowrap;"><?php echo date_format(date_create($row['est_date']), "d-m-Y"); ?></span>
                                </td>
                                <td><span class="bt-content"><?php echo $row['ifsc_code']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['acc_no']; ?></span></td>
                                <td><span class="bt-content"><?php echo $row['aadhar']; ?></span></td>
                                <td>
                                    <?php
                                    if ($row['status'] == 0) {
                                    ?>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-success" onclick="accept_or_reject('<?php echo $row['email']; ?>',1)">Accept</button>
                                            <button class="btn btn-sm btn-danger" onclick="accept_or_reject('<?php echo $row['email']; ?>',0)">Reject</button>
                                        </div>
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
                title: "Companies(<?php echo $email; ?>) - Crystal Events",
                text: '<i class="fa fa-file-excel-o"> Excel</i>',

            }, {
                extend: 'pdfHtml5',
                title: "Companies(<?php echo $email; ?>) - Crystal Events",
                orientation: 'landscape',
                pageSize: 'A3',
                text: '<i class="fa fa-file-pdf-o"> PDF</i>',
                titleAttr: 'PDF',

            }, {
                extend: 'print',
                title: "Companies(<?php echo $email; ?>) - Crystal Events",
                orientation: 'landscape',
                pageSize: 'A4',
                text: '<i class="fa fa-print"> Print</i>',

            }],
        });
    });

    function accept_or_reject(email, status) {
        Swal.fire({
            title: 'User Status',
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
                    url: "php/accept_or_reject.php",
                    type: "post",
                    data: {
                        email: email,
                        status: status,
                        user: "company"
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