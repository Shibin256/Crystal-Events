<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<?php
session_start();
if (!isset($_SESSION['email'])) {
    echo "<script>window.location.replace('../../index.html')</script>";
}
$email = $_SESSION['email'];
require('../../php/connect.php');
?>
<!DOCTYPE html>

<head>
    <title>Crystal Events
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Colored Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
    addEventListener("load", function() {
        setTimeout(hideURLbar, 0);
    }, false);

    function hideURLbar() {
        window.scrollTo(0, 1);
    }
    </script>
    <!-- bootstrap-css -->
    <!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <!-- font CSS -->
    <link
        href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic'
        rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="css/font.css" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet">
    <!-- //font-awesome icons -->
    <script src="js/jquery2.0.3.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="js/modernizr.js"></script>
    <script src="js/jquery.cookie.js"></script>
    <script src="js/screenfull.js"></script>
    <script>
    $(function() {
        $('#supported').text('Supported/allowed: ' + !!screenfull.enabled);

        if (!screenfull.enabled) {
            return false;
        }



        $('#toggle').click(function() {
            screenfull.toggle($('#container')[0]);
        });
    });
    </script>
    <style>
    .dropdown-toggle::after {
        display: none;
    }

    .show {
        opacity: 1 !important;
        height: 100% !important;
        overflow: visible !important;

    }
    </style>

</head>

<body class="dashboard-page">

    <nav class="main-menu">
        <ul>
            <li>
                <a href="index.php">
                    <i class="fa fa-home nav_icon"></i>
                    <span class="nav-text">
                        Home
                    </span>
                </a>
            </li>
            <li>
                <a href="companies.php">
                    <i class="fa fa-user nav_icon"></i>
                    <span class="nav-text">
                        Companies
                    </span>
                </a>
            </li>
            <li>
                <a href="users.php">
                    <i class="fa fa-user nav_icon"></i>
                    <span class="nav-text">
                        Users
                    </span>
                </a>
            </li>
            <li>
                <a href="complaints.php">
                    <i class="fa fa-cogs" aria-hidden="true"></i> <span class="nav-text">
                        Complaints
                    </span>
                </a>
            </li>

        </ul>
        <ul class="logout">
            <li>
                <a href="javascript:;" onclick="logout()">
                    <i class="icon-off nav-icon"></i>
                    <span class="nav-text">
                        Logout
                    </span>
                </a>
            </li>
        </ul>
    </nav>
    <section class="wrapper scrollable" style="opacity: 1;">
        <nav class="user-menu">
            <a href="javascript:;" class="main-menu-access">
                <i class="icon-proton-logo"></i>
                <i class="icon-reorder"></i>
            </a>
        </nav>
        <section class="title-bar">
            <div class="logo" style="width: 55%;">
                <h1>
                    <a href="index.php" style="display: flex;align-items: center;">
                        <img src="images/logo.png" alt="" style="width:70px;height: auto;margin-right: 0px;" />
                        <span>Crystal Events</span>
                    </a>
                </h1>
            </div>

            <div class="header-right">
                <div class="profile_details_left">
                    <div class="header-right-left">
                        <!--notifications of menu start -->

                    </div>
                    <div class="profile_details"
                        style="background-color: #00bcd4;padding: 5px 15px 5px 5px;border-radius: 20px;width: fit-content;">
                        <ul>
                            <li class="dropdown profile_details_drop">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <div class="profile_img">
                                        <img class="prfil-img" style="width: 33px;height: 33px;border-radius: 50%;"
                                            src="uploads/profile/default.jpg" alt="Profile Image">
                                        <span style="color: white;">Admin</span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu extended">
                                    <li style="width: 100%;padding: 10px 5px;"> <a href="password.php"><i
                                                class="fa fa-cog"></i> Change Password</a> </li>

                                    <li style="width: 100%;padding: 10px 5px;"> <a href="javascript:;"
                                            onclick="logout()"><i class="fa fa-sign-out"></i>
                                            Logout</a> </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </section>