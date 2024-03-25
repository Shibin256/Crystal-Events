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
                <span>Complaints </span>
            </h2>
        </div>
        <div class="blank" style="min-height: auto;">
            <div class="blank-page">
                <div class="forms">
                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Add Complaint</h4>
                        </div>
                        <div class="form-body">
                            <form action="php/complaint.php" method="post">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Topic</label>
                                    <input type="text" class="form-control" placeholder="Topic" name="topic"
                                        id="recipient-rname" required="">
                                </div>

                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Description</label>
                                    <textarea rows=5 class="form-control" placeholder="Description" name="description"
                                        id="recipient-rname" required=""></textarea>
                                </div>


                                <button type="submit" class="btn btn-default w3ls-button" name="edit">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="blank" style="min-height: auto;">
            <div class="blank-page">
                <table id="table" class="">
                    <thead>

                        <tr>
                            <th>Topic</th>
                            <th>Complaint</th>
                            <th>Date Of Submission</th>
                            <th>Reply</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from complaint where email='$email'";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr>
                            <td><?php echo $row['topic']; ?></td>
                            <td><?php echo $row['complaint']; ?></td>
                            <td><?php echo date_format(date_create($row['submitted_date']), 'd-m-Y h:i A'); ?></td>
                            <td><?php echo $row['reply']; ?></td>
                            <td>
                                <?php
                                    if ($row['status'] == 1)
                                        echo "<p style='color: orange;'>Pending</p>";
                                    else if ($row['status'] == 2)
                                        echo "<p style='color: red;'>Closed</p>";
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
    </div>

    <!-- //blank-page -->

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
</script>