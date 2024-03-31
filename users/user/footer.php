    <!-- footer -->
    <div class="footer">
        <p>© 2023 CrystalEvents . All Rights Reserved . Design by <a href="">Shibin K P</a></p>
    </div>
    <!-- //footer -->
    </section>
    <!-- <script src="js/bootstrap.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>

    <script src="js/proton.js"></script>


    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function logout() {
            Swal.fire({
                title: 'Logout',
                text: "Are you sure want to logout?",
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
                    Swal.fire({
                        title: "Logging out...",
                        timer: 1500,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didClose: () => {
                            window.location.replace('../../php/logout.php');
                        }
                    });
                    Swal.showLoading();
                }

            });
        }

        $('main-menu ul li  .active').removeClass('active');
        $('#<?php echo $_SESSION['menu']; ?>').addClass(' active');

        // $("#sidebar ul li a").on("click", function() {
        //     changem(this.id);
        // });

        function changem(id) {
            $.ajax({
                url: "php/menu.php",
                type: "post",
                data: {
                    menu: "check",
                    id: id,
                },
                success: function(res) {
                    console.log(id);
                }
            });
        }
    </script>
    </body>

    </html>