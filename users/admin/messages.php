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
        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Category </span>
            </h2>
        </div>
        <div class="blank">
            <div class="blank-page">


                <table id="table" class="table-responsive" style="min-width: 100%">
                    <thead>

                        <tr>
                            <th>Contact ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from contact order by contact_id desc";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><?php echo $row['contact_id']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td><?php echo $row['message']; ?></td>
                            </tr>

                        <?php
                        }
                        ?>
                    </tbody>
                </table>

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