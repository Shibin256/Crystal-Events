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
        <!-- //blank-page -->
        <div class="blank">
            <div class="blank-page">
                <table id="table" class="table-responsive">
                    <thead>

                        <tr>
                            <th>ComplaintId</th>
                            <th>Topic</th>
                            <th>Complaint</th>
                            <th>Date Of Submission</th>
                            <th>User</th>
                            <th>User Email</th>
                            <th>Reply</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "select * from complaint,customer where customer.email_id=complaint.email_id order by status,submitted_date ";
                        $res = sel($sql);

                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                            <tr>
                                <td><?php echo $row['complaint_id']; ?></td>
                                <td><?php echo $row['topic']; ?></td>
                                <td><?php echo $row['complaint']; ?></td>
                                <td><?php echo date_format(date_create($row['submitted_date']), 'd-m-Y h:i A'); ?></td>
                                <td><?php echo $row['first_name'] . " " . $row['last_name']; ?></td>
                                <td><?php echo $row['email_id']; ?></td>
                                <td><?php echo $row['reply']; ?></td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1)
                                        echo "<p style='color: orange;'>Pending</p>";
                                    else if ($row['status'] == 2)
                                        echo "<p style='color: red;'>Closed</p>";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['status'] == 1) {
                                    ?>
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#exampleModal" onclick="document.getElementById('complaint_id').value='<?php echo $row['complaint_id']; ?>';">
                                            Update
                                        </button>
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
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Complaint</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="php/complaint.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" id="complaint_id" name="complaint_id">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Reply</label>
                            <textarea rows=5 class="form-control" name="reply" id="reply" required=""></textarea>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="update">Save Update</button>
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