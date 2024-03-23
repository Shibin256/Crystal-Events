<?php
require('header.php');
?>

<div class="main-grid">
    <div class="agile-grids">
        <!-- blank-page -->

        <div class="banner">
            <h2>
                <a href="index.php">Home</a>
                <i class="fa fa-angle-right"></i>
                <span>Home</span>
            </h2>
        </div>

        <div class="blank">
            <div class="social grid" style="border: none;">
                <div class="grid-info">
                    <div class="row">
                        <div class="col-md-3 " style="flex: none;">
                            <div class="comments likes">
                                <div class="comments-icon">
                                    <i class="fa fa-users"></i>
                                </div>
                                <div class="comments-info likes-info">
                                    <?php
                                    $sql = "select * from users";
                                    $count = num($sql);
                                    ?>
                                    <h3><?php echo $count ?></h3>
                                    <a href="#">Users</a>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="col-md-3 " style="flex: none;">
                            <div class="comments">
                                <div class="comments-icon">
                                    <i class="fa fa-cogs" style="padding: 0px;"></i>
                                </div>
                                <div class=" comments-info">
                                    <?php
                                    $sql = "select * from company";
                                    $count = num($sql);
                                    ?>
                                    <h3><?php echo $count ?></h3>
                                    <a href="#">Companies</a>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-3 " style="flex: none;">
                            <div class="comments tweets" style="height: 100%;">
                                <div class="comments-icon">
                                    <i class="fa fa-inr"></i>
                                </div>
                                <div class="comments-info tweets-info">
                                    <?php
                                    // $sql = "select sum(amount) as amt from payment;";
                                    // $res = sel($sql);
                                    // $row = mysqli_fetch_assoc($res);
                                    ?>
                                    <h5 style="color: #FFF;margin: 0;"><?php //echo $row['amt'] 
                                                                        ?></h5>
                                    <a href="#">Revenue</a>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div>
                        <div class="col-md-3 " style="flex: none;">
                            <div class="comments views">
                                <div class="comments-icon">
                                    <i class="fa fa-eye"></i>
                                </div>
                                <div class="comments-info views-info">
                                    <?php
                                    // $sql = "select * from pro_order";
                                    // $count = num($sql);
                                    ?>
                                    <h3><?php //echo $count 
                                        ?></h3>
                                    <a href="#">Orders</a>
                                </div>
                                <div class="clearfix"> </div>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>

            <div class="blank-page">

                <div class="row">
                    <!-- <div class="col-md-6 agile-grid-left">
                        <div class="w3l-chart">
                            <h3>Revenue </h3>
                            <div id="graph" style="border-width: 1px;" style="width: 800px; height: 400px;"></div>
                           
                        </div>
                    </div> -->
                    <!-- <div class="col-md-10 offset-1 agile-grid-right">
                        <div class="w3l-chart1">
                            <h3>Bikes By Category</h3>
                            <div id="graph2" style="border: none;"></div>
                        </div>
                    </div>
                </div> -->

                </div>
            </div>
        </div>
    </div>

    <?php
require('footer.php');
?>

    <script src="js/graph.js"></script>

    <script>
    // $(function() {



    <?php
        // $sql = "select category_name,count(*) as cs from bike,category where bike.category_id=category.category_id group by category_name;";
        // $res = sel($sql);
        // $cat = $count = [];
        // while ($row = mysqli_fetch_assoc($res)) {
        //     array_push($cat, $row['category_name']);
        //     array_push($count, $row['cs']);
        // }

        ?>
    // $('#graph2').graphify({
    //     start: 'donut',
    //     obj: {
    //         id: 'lol',
    //         legend: false,
    //         showPoints: true,
    //         width: 1000,
    //         legendX: 450,
    //         pieSize: 200,
    //         shadow: true,
    //         height: 400,
    //         animations: true,
    //         x: 
    <?php
                    // echo "[";
                    // foreach ($cat as $item) {
                    //     echo "'" . $item . "',";
                    // }
                    // echo "]";
                    ?>,
    // points: 
    <?php
                        // echo "[";
                        // foreach ($count as $item) {
                        //     echo $item . ",";
                        // }
                        // echo "]";
                        ?>
    //                     ,
    //             xDist: 90,
    //             scale: 10,
    //             yDist: 35,
    //             grid: false,
    //             xName: 'Year',
    //             dataNames: ['Amount'],
    //             design: {
    //                 lineColor: 'red',
    //                 tooltipFontSize: '20px',
    //                 pointColor: 'red',
    //                 barColor: 'blue',
    //                 areaColor: 'orange'
    //             }
    //         }
    //     });
    // });
    </script>