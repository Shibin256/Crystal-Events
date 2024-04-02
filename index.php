<?php
require('php/connect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Crystal Events</title>
    <link rel="icon" href="img/logo.png" type="image/gif" sizes="16x16">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>

    <!-- Spinner Start -->
    <div id="spinner" class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
        <div class="spinner-grow text-primary" role="status"></div>
    </div>

    <!-- Spinner End -->


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Kochi, Kerala</a></small>

                </div>
                <div class="top-link pe-2">
                    <a href="login.html" class="position-relative me-4 my-auto">

                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fff" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">

                            <path d="M217.9 105.9L340.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L217.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1L32 320c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM352 416l64 0c17.7 0 32-14.3 32-32l0-256c0-17.7-14.3-32-32-32l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32l64 0c53 0 96 43 96 96l0 256c0 53-43 96-96 96l-64 0c-17.7 0-32-14.3-32-32s14.3-32 32-32z" />
                        </svg>
                    </a>
                    <a href="signup.html" class="position-relative me-4 my-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#fff" class="bi bi-bag-heart-fill" viewBox="0 0 640 512">

                            <path d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="index.php" class="navbar-brand">
                    <h1 class="text-primary display-6">
                        <img src="img/logo.png" style="width: 80px;">Crystal Events
                    </h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="index.php" class="nav-item nav-link active">Home</a>
                        <a href="about.html" class="nav-item nav-link">About</a>
                        <div class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-filter-left" viewBox="0 0 16 16">
                                    <path d="M2 10.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5" />
                                </svg>Filter</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="#eventcompanies-session" class="dropdown-item">Verified</a>
                                <a href="#Slider-session" class="dropdown-item">Companies</a>
                                <a href="#top-rated" class="dropdown-item">Top Rated</a>
                            </div>
                        </div>
                        <a href="contact.html" class="nav-item nav-link">Contact</a>
                    </div>
                    <!-- <div class="d-flex m-3 me-0">
                        <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4" data-bs-toggle="modal" data-bs-target="#searchModal"><i class="fas fa-search text-primary"></i></button>

                        <a href="#" class="position-relative me-4 my-auto">

                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-bag-heart-fill" viewBox="0 0 16 16">
                                <path d="M11.5 4v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4zM8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1m0 6.993c1.664-1.711 5.825 1.283 0 5.132-5.825-3.85-1.664-6.843 0-5.132" />
                            </svg>

                            <span class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1" style="top: -5px; left: 15px; height: 20px; min-width: 20px;">3</span>
                        </a>

                        <a href="contact.html" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    </div> -->
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->


    <!-- Modal Search Start -->
    <!-- <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex align-items-center">
                    <div class="input-group w-75 mx-auto d-flex">
                        <input type="search" class="form-control p-3" placeholder="keywords" aria-describedby="search-icon-1">
                        <span id="search-icon-1" class="input-group-text p-3"><i class="fa fa-search"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- Modal Search End -->

    <!-- Eventcompanies section Start-->
    <div class="container-fluid Eventcompanies py-5" id="eventcompanies-session">
        <div class="container py-5"><br><br><br>
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Our Trusted partners</h1>
                    </div>
                    <!-- <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">All catogories</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex py-2 m-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-2">
                                    <span class="text-dark" style="width: 130px;">MARRIEGE</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-3">
                                    <span class="text-dark" style="width: 130px;">BIRTHDAY</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-4">
                                    <span class="text-dark" style="width: 130px;">FUNCTIONS</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill" data-bs-toggle="pill" href="#tab-5">
                                    <span class="text-dark" style="width: 130px;">CATORING</span>
                                </a>
                            </li>
                        </ul>
                    </div> -->
                </div>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-5">
                                    <?php
                                    $sql = "select
                                    c.*,
                                    coalesce(sum(r.star), 0) as total_stars,
                                    coalesce(avg(r.star), 0) as avg_stars
                                    from
                                        company c
                                    left join
                                        events e on c.email = e.company_email
                                    left join
                                        bookings b on e.event_id = b.event_id
                                    left join
                                        review r on b.book_id = r.book_id
                                    group by
                                        c.email, c.name
                                    order by rand() 
                                    limit 8";
                                    $res = sel($sql);

                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <div class="col-md-6 col-lg-4 col-xl-3">
                                            <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 375.5px;">
                                                <div class="Eventcompanies-img">
                                                    <img src="<?php echo "users/company/uploads/profile/" . $row['profile_pic']; ?>" class="img-fluid  rounded-top" alt="" style="height: 173.33px;width: 100%;">
                                                </div>
                                                <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                                <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 200px;">
                                                    <h5><?php echo $row['name']; ?></h5>

                                                    <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor"><?php echo $row['place'] . ", " . $row['district']; ?></a></small>

                                                    <div class="d-flex my-3 px-2">
                                                        <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;"><?php echo round($row['avg_stars'], 2); ?></i>
                                                        <div class="py-1 px-1">
                                                            <?php
                                                            $avg_stars = $row['avg_stars'];
                                                            $filled_stars = intval($avg_stars);
                                                            $half_star = $avg_stars - $filled_stars >= 0.5;

                                                            for ($i = 0; $i < $filled_stars; $i++) {
                                                                echo '<i class="fas fa-star text-primary"></i>';
                                                            }
                                                            if ($half_star) {
                                                                echo '<i class="fas fa-star-half-alt text-primary"></i>';
                                                                $filled_stars++;
                                                            }
                                                            for ($i = $filled_stars; $i < 5; $i++) {
                                                                echo '<i class="fas fa-star"></i>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <!-- <p style="font-size: 14px;"> Wedding, birthday, Function</p> -->
                                                    <div class="d-flex justify-content-between flex-lg-wrap py-5">
                                                        <!-- <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#"
                                                        class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                            fill="currentcolor" class="bi bi-bag-heart-fill"
                                                            viewBox="0 0 512 512">

                                                            <path
                                                                d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="tab-2" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/hooray events/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Hooray Events</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor"> Panampilly Nagar,
                                                        Kochi</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">4.0</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;">Event Management & Wedding Planners</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-4">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/cevex events/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Cevex Corporate</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">Manorama Junction,
                                                        Kochi</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">4.3</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, Functions, promotions</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-4">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/dolphin events/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Dolphin Events</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">Kaloor Kochi</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">3.9</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, birthday, Function</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-5">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-3" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/eventos magic/logo.JPG" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Eventos Magic</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">******</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">4.7</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, Birthday, Functions</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-5">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/dolphin events/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Dolphin Events</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">Kaloor Kochi</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">3.9</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, birthday, Function</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-5">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-4" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/cevex events/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Cevex Corporate</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">Manorama Junction,
                                                        Kochi</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">4.3</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, Functions, promotions</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-4">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/dolphin events/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Dolphin Events</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">Kaloor Kochi</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">3.9</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, birthday, Function</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-5">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="tab-5" class="tab-pane fade show p-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/eventos magic/logo.JPG" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Eventos Magic</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">******</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">4.7</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, Birthday, Functions</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-5">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/executive evnts/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Executive Events</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">Panampilly Nagar,
                                                        Kochi</a></small>
                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">4.0</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, Bachelor Parties, Functions</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-4">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="rounded position-relative Eventcompanies-item" style="width: 260px; height: 450px;">
                                            <div class="Eventcompanies-img">
                                                <img src="event img/fonix/logo.jpg" class="img-fluid w-100  rounded-top" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom" style="width: 260px; height: 276px;">
                                                <h5>Fonix Events</h5>

                                                <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor">Kacheripady, Kochi</a></small>

                                                <div class="d-flex my-3 px-2">
                                                    <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;">3.7</i>
                                                    <div class="py-1 px-1"><i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star text-primary"></i>
                                                        <i class="fas fa-star"></i>
                                                    </div>
                                                </div>
                                                <p style="font-size: 14px;"> Wedding, Corporate events</p>
                                                <div class="d-flex justify-content-between flex-lg-wrap py-4">
                                                    <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book
                                                        Know</a>
                                                    <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">
                                                            
                                                            <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                                        </svg></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Eventcompanies section End-->


    <!-- Slidercompanies section Start-->
    <div class="container-fluid Slidercompanies py-5" id="Slider-session">
        <div class="container py-5">
            <h1 class="mb-0">ENJOY EVERY MOMENTS WITH CREATION</h1>
            <div class="owl-carousel Slidercompanies-carousel justify-content-center">
                <?php
                $sql = "select
                        c.*,
                        coalesce(sum(r.star), 0) as total_stars,
                        coalesce(avg(r.star), 0) as avg_stars
                        from
                            company c
                        left join
                            events e on c.email = e.company_email
                        left join
                            bookings b on e.event_id = b.event_id
                        left join
                            review r on b.book_id = r.book_id
                        group by
                            c.email, c.name
                        order by rand() 
                        limit 8";
                $res = sel($sql);

                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <div class="border border-primary rounded position-relative Slidercompanies-item" style="width: 260px; height: 375px;">
                        <div class="Slidercompanies-img">
                            <img src="<?php echo "users/company/uploads/profile/" . $row['profile_pic'] ?>" class="img-fluid w-100 rounded-top" alt="" style="height: 173.33px;width: 100%;">
                        </div>
                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;">Verified</div>
                        <div class="p-4 rounded-bottom">
                            <h4><?php echo $row['name'] ?></h4>
                            <small class="me-1"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor"><?php echo $row['place'] . ", " . $row['district'] ?></a></small>
                            <div class="d-flex my-3 px-2">
                                <i class="text-white bg-success px-2 py-1 rounded " style="top: 10px; left: 10px; font-style: normal; font-size: 14px;"><?php echo round($row['avg_stars'], 2); ?></i>
                                <div class="py-1 px-1">
                                    <?php
                                    $avg_stars = $row['avg_stars'];
                                    $filled_stars = intval($avg_stars);
                                    $half_star = $avg_stars - $filled_stars >= 0.5;

                                    for ($i = 0; $i < $filled_stars; $i++) {
                                        echo '<i class="fas fa-star text-primary"></i>';
                                    }
                                    if ($half_star) {
                                        echo '<i class="fas fa-star-half-alt text-primary"></i>';
                                        $filled_stars++;
                                    }
                                    for ($i = $filled_stars; $i < 5; $i++) {
                                        echo '<i class="fas fa-star"></i>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- <p> Wedding, birthday, Function</p> -->
                            <div class="d-flex justify-content-between flex-lg-wrap">
                                <!-- <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book Know</a>
                                <a href="#" class="btn border border-secondary rounded-pill px-3 text-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentcolor" class="bi bi-bag-heart-fill" viewBox="0 0 512 512">

                                        <path d="M225.8 468.2l-2.5-2.3L48.1 303.2C17.4 274.7 0 234.7 0 192.8v-3.3c0-70.4 50-130.8 119.2-144C158.6 37.9 198.9 47 231 69.6c9 6.4 17.4 13.8 25 22.3c4.2-4.8 8.7-9.2 13.5-13.3c3.7-3.2 7.5-6.2 11.5-9c0 0 0 0 0 0C313.1 47 353.4 37.9 392.8 45.4C462 58.6 512 119.1 512 189.5v3.3c0 41.9-17.4 81.9-48.1 110.4L288.7 465.9l-2.5 2.3c-8.2 7.6-19 11.9-30.2 11.9s-22-4.2-30.2-11.9zM239.1 145c-.4-.3-.7-.7-1-1.1l-17.8-20c0 0-.1-.1-.1-.1c0 0 0 0 0 0c-23.1-25.9-58-37.7-92-31.2C81.6 101.5 48 142.1 48 189.5v3.3c0 28.5 11.9 55.8 32.8 75.2L256 430.7 431.2 268c20.9-19.4 32.8-46.7 32.8-75.2v-3.3c0-47.3-33.6-88-80.1-96.9c-34-6.5-69 5.4-92 31.2c0 0 0 0-.1 .1s0 0-.1 .1l-17.8 20c-.3 .4-.7 .7-1 1.1c-4.5 4.5-10.6 7-16.9 7s-12.4-2.5-16.9-7z" />
                                    </svg>
                                </a> -->
                            </div>
                        </div>
                    </div>

                <?php
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Slidercompanies Section End -->


    <!-- Banner Section Start-->
    <div class="container-fluid banner bg-secondary my-5">
        <div class="container py-5">
            <div class="row g-4 align-items-center">
                <div class="col-lg-6">
                    <div class="py-4">
                        <h1 class="display-3 text-white">specific company ads</h1>
                        <p class="fw-normal display-3 text-dark mb-4">in Our page</p>
                        <p class="mb-4 text-dark">The generated Lorem Ipsum is therefore always free from repetition
                            injected humour, or non-characteristic words etc.</p>
                        <a href="#" class="banner-btn btn border-2 border-white rounded-pill text-dark py-3 px-5">BUY</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="position-relative">
                        <img src="img/" class="img-fluid w-100 rounded" alt="">
                        <div class="d-flex align-items-center justify-content-center bg-white rounded-circle position-absolute" style="width: 140px; height: 140px; top: 0; left: 0;">
                            <h1 style="font-size: 100px;">1</h1>
                            <div class="d-flex flex-column">
                                <span class="h2 mb-0">50$</span>
                                <span class="h4 text-muted mb-0"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Section End -->


    <!-- Top rated companies Start -->
    <div class="container-fluid py-5" id="top-rated">
        <div class="container py-5">
            <div class="text-center mx-auto mb-5" style="max-width: 700px;">
                <h1 class="display-4">Top Rated Companies</h1>
                <p>.</p>
            </div>
            <div class="row g-4">
                <?php
                $sql = "select
                        c.*,
                        coalesce(sum(r.star), 0) as total_stars,
                        coalesce(avg(r.star), 0) as avg_stars
                        from
                            company c
                        left join
                            events e on c.email = e.company_email
                        left join
                            bookings b on e.event_id = b.event_id
                        left join
                            review r on b.book_id = r.book_id
                        group by
                            c.email, c.name
                        order by avg_stars desc 
                        limit 6";
                $res = sel($sql);

                while ($row = mysqli_fetch_assoc($res)) {
                ?>
                    <div class="col-lg-6 col-xl-4">
                        <div class="p-4 rounded bg-light" style="width: 360px; height: 260px;">
                            <div class="row align-items-center">
                                <div class="col-6">
                                    <img src="<?php echo 'users/company/uploads/profile/' . $row['profile_pic']; ?>" class="img-fluid rounded-circle" style="width: 150px;height: 150px;" alt="">
                                </div>
                                <div class="col-6">
                                    <a href="#" class="h5"><?php echo $row['name']; ?></a>
                                    <div class="d-flex my-3">
                                        <?php
                                        $avg_stars = $row['avg_stars'];
                                        $filled_stars = intval($avg_stars);
                                        $half_star = $avg_stars - $filled_stars >= 0.5;

                                        for ($i = 0; $i < $filled_stars; $i++) {
                                            echo '<i class="fas fa-star text-primary"></i>';
                                        }
                                        if ($half_star) {
                                            echo '<i class="fas fa-star-half-alt text-primary"></i>';
                                            $filled_stars++;
                                        }
                                        for ($i = $filled_stars; $i < 5; $i++) {
                                            echo '<i class="fas fa-star"></i>';
                                        }
                                        ?>
                                    </div>
                                    <small class="me-5"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="currentColor"><?php echo $row['place'] . ', ' . $row['district']; ?></a></small>
                                    <!-- <p> Wedding, birthday, Function</p> -->
                                    <div class="d-flex justify-content-between flex-lg-wrap">
                                        <!-- <a href="TrisolEvents.html" class="btn border border-secondary rounded-pill px-3 text-primary">Book Know</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php

                }
                ?>

            </div>
        </div>
    </div>
    <!-- Top rated companies End -->


    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-white-50 footer pt-5 mt-5">
        <div class="container py-5">
            <div class="pb-4 mb-4" style="border-bottom: 1px solid rgba(226, 175, 24, 0.5) ;">
                <div class="row g-4">
                    <div class="col-lg-3">
                        <a href="#">
                            <h1 class="text-primary mb-0">CRYSTAL Events</h1>
                            <p class="text-secondary mb-0">ENJOY EVERY MOMENTS</p>
                        </a>
                    </div>
                    <div class="col-lg-6">
                        <div class="position-relative mx-auto">
                            <input class="form-control border-0 w-100 py-3 px-4 rounded-pill" type="email" placeholder="Your Email">
                            <button type="submit" class="btn btn-primary border-0 border-secondary py-3 px-4 position-absolute rounded-pill text-white" style="top: 0; right: 0;">Subscribe Now</button>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex justify-content-end pt-3">
                            <a class="btn  btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentcolor" viewBox="0 0 512 512">

                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                </svg></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-facebook-f"></i></a>
                            <a class="btn btn-outline-secondary me-2 btn-md-square rounded-circle" href=""><i class="fab fa-instagram"></i></a>
                            <a class="btn btn-outline-secondary btn-md-square rounded-circle" href=""><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Why People Like us!</h4>
                        <p class="mb-4">Crystal Events: Seamless experience, comprehensive features, trusted
                            reliability, innovative technology, exceptional service, vibrant community, affordability,
                            passion for events.</p>
                        <a href="About.html" class="btn border-secondary py-2 px-4 rounded-pill text-primary">Read
                            More</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Quik links</h4>
                        <a class="btn-link" href="About.html">About Us</a>
                        <a class="btn-link" href="contact.html">Contact Us</a>
                        <a class="btn-link" href="">Privacy Policy</a>
                        <a class="btn-link" href="">Terms & Condition</a>
                        <a class="btn-link" href="">Return Policy</a>
                        <a class="btn-link" href="">FAQs & Help</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex flex-column text-start footer-item">
                        <h4 class="text-light mb-3">Account</h4>
                        <a class="btn-link" href="">My Account</a>
                        <a class="btn-link" href="">Wishlist</a>
                        <a class="btn-link" href="">History</a>

                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4 class="text-light mb-3">Contact</h4>
                        <p>Address: Head office HMT junction, Kalamssery, Kochi</p>
                        <p>Email: CrystalEvents@gmail.in</p>
                        <p>Payment Accepted</p>
                        <img src="img/payment.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- Copyright Start -->
    <div class="container-fluid copyright bg-dark py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <span class="text-light"><a href="#"><i class="fas fa-copyright text-light me-2"></i>Crystal
                            Events</a>, All right reserved.</span>
                </div>
                <div class="col-md-6 my-auto text-center text-md-end text-white">
                    <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                    <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                    <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                    Designed By <a class="border-bottom" href="https://htmlcodex.com">shibin kp</a> <a class="border-bottom" href="https://themewagon.com"></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Copyright End -->



    <!-- Back to Top -->
    <a href="#" class="btn btn-primary border-3 border-primary rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>