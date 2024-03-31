<?php
require('header.php');
?>

<!-- tables -->
<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
<style>
    .btn:focus,
    .btn:active,
    button:focus,
    button:active {
        outline: none !important;
        box-shadow: none !important;
    }

    #image-gallery .modal-footer {
        display: block;
    }

    .thumb {
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>

<div class="main-grid">
    <div class="agile-grids">
        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Gallery </span>
            </h2>
        </div>
        <div class="blank">
            <div class="blank-page">


                <div class="forms">
                    <div class="form-grids widget-shadow" data-example-id="basic-forms">
                        <div class="form-title">
                            <h4>Add Photos</h4>
                        </div>
                        <div class="form-body">
                            <form action="php/gallery.php" method="post" enctype="multipart/form-data" onsubmit="return check()">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Photo</label>
                                    <input type="file" class="form-control" placeholder="Name" name="photo" required="">
                                </div>
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Caption</label>
                                    <input type="text" class="form-control" placeholder="Caption" name="caption" required="">
                                </div>
                                <button type="submit" class="btn btn-default w3ls-button" name="add">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

            <div class="container" style="margin-top: 50px;">
                <div class="row">

                    <?php
                    $sql = "select * from gallery where company_email='$email'";
                    $res = sel($sql);

                    while ($row = mysqli_fetch_assoc($res)) {
                    ?>
                        <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                            <div style="background-color: #fff;border: 1px solid #dee2e6;">
                                <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="" data-image="<?php echo 'uploads/gallery/' . $row['photo'] ?>" data-target="#image-gallery">
                                    <img class="img-thumbnail" src="<?php echo 'uploads/gallery/' . $row['photo'] ?>" alt="Another alt text" style="border: none;">
                                </a>
                                <p><?php echo  $row['caption'] ?></p>
                            </div>
                        </div>
                    <?php
                    }
                    ?>



                    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="image-gallery-title"></h4>
                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img id="image-gallery-image" class="img-responsive col-md-12" src="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary float-left" id="show-previous-image"><i class="fa fa-arrow-left"></i>
                                    </button>

                                    <button type="button" id="show-next-image" class="btn btn-secondary float-right"><i class="fa fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>

</div>

<?php
require('footer.php');
?>

<script type="text/javascript">
    function check() {
        var photo = document.getElementById('photo');
        var fileExtension = photo.value.split('.').pop().toLowerCase();
        if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png') {
            return true;
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Invalid File Format!',
                text: 'Please select jpg, jpeg or png file',
            }).then((result) => {
                photo.focus();
            })
            return false;
        }

    }

    let modalId = $('#image-gallery');

    $(document)
        .ready(function() {

            loadGallery(true, 'a.thumbnail');

            //This function disables buttons when needed
            function disableButtons(counter_max, counter_current) {
                $('#show-previous-image, #show-next-image')
                    .show();
                if (counter_max === counter_current) {
                    $('#show-next-image')
                        .hide();
                } else if (counter_current === 1) {
                    $('#show-previous-image')
                        .hide();
                }
            }

            /**
             *
             * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
             * @param setClickAttr  Sets the attribute for the click handler.
             */

            function loadGallery(setIDs, setClickAttr) {
                let current_image,
                    selector,
                    counter = 0;

                $('#show-next-image, #show-previous-image')
                    .click(function() {
                        if ($(this)
                            .attr('id') === 'show-previous-image') {
                            current_image--;
                        } else {
                            current_image++;
                        }

                        selector = $('[data-image-id="' + current_image + '"]');
                        updateGallery(selector);
                    });

                function updateGallery(selector) {
                    let $sel = selector;
                    current_image = $sel.data('image-id');
                    $('#image-gallery-title')
                        .text($sel.data('title'));
                    $('#image-gallery-image')
                        .attr('src', $sel.data('image'));
                    disableButtons(counter, $sel.data('image-id'));
                }

                if (setIDs == true) {
                    $('[data-image-id]')
                        .each(function() {
                            counter++;
                            $(this)
                                .attr('data-image-id', counter);
                        });
                }
                $(setClickAttr)
                    .on('click', function() {
                        updateGallery($(this));
                    });
            }
        });

    // build key actions
    $(document)
        .keydown(function(e) {
            switch (e.which) {
                case 37: // left
                    if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
                        $('#show-previous-image')
                            .click();
                    }
                    break;

                case 39: // right
                    if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
                        $('#show-next-image')
                            .click();
                    }
                    break;

                default:
                    return; // exit this handler for other keys
            }
            e.preventDefault(); // prevent the default action (scroll / move caret)
        });
</script>