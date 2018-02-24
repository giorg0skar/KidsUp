<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Στατιστικά</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="../assets/css/themify-icons.css" rel="stylesheet">

    <!-- Main CSS Files -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet"/>
    <link href="../assets/css/metric.css" rel="stylesheet"/>


    <!-- Chart CSS File-->
    <link href="../assets/css/css.mdb.min.css" rel="stylesheet" />


    <!-- External CSS Files -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css" rel="stylesheet" />

</head>

<body>
    <?php
            include("./mysqli_connect.php");
            mb_internal_encoding('UTF-8');
            mb_http_input("utf-8");
            session_start();
            if(!isset($_SESSION['login_user'])){
                header("location:./provider-signin.php");
            }
            $provider_user = $_SESSION['login_user'];
            $companyName = $_SESSION['companyName'];

            ### Active Activities order by Apixisi ###
            $sql = "SELECT
                            SUM(CASE WHEN actDate= 'Ποδόσφαιρο' THEN 1 ELSE 0 END) AS mpala,
                            FROM Activity WHERE ((ProvEmail = '$provider_user') AND actDate >= NOW()) ORDER BY ((maxTickets-availableTickets)/visits) DESC"; # Order by Apixisi = bought_tickets / visits
            $result_active = mysqli_query($dbc,$sql);

            ### Info of total activities [total_activities, total_earnings, total_visits, total_bought_tickets] ###
            $sql_info =  "SELECT COUNT(ActID) as total_activities,
                                SUM((maxTickets - availableTickets) * price *0.95) AS total_earnings,
                                SUM(maxTickets - availableTickets) AS total_bought_tickets
            FROM Activity WHERE ((ProvEmail = '$provider_user'))";
            $result_info = mysqli_query($dbc,$sql_info);
            if($result_info) $total_info = mysqli_fetch_array($result_info,MYSQLI_ASSOC);

            ### Earnings per month (Line Chart) ###
            $sql = "SELECT
                            SUM(CASE WHEN MONTH(actDate) = 1 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS jan,
                            SUM(CASE WHEN MONTH(actDate) = 2 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS feb,
                            SUM(CASE WHEN MONTH(actDate) = 3 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS mar,
                            SUM(CASE WHEN MONTH(actDate) = 4 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS apr,
                            SUM(CASE WHEN MONTH(actDate) = 5 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS may,
                            SUM(CASE WHEN MONTH(actDate) = 6 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS jun,
                            SUM(CASE WHEN MONTH(actDate) = 7 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS jul,
                            SUM(CASE WHEN MONTH(actDate) = 8 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS aug,
                            SUM(CASE WHEN MONTH(actDate) = 9 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS sep,
                            SUM(CASE WHEN MONTH(actDate) = 10 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS oct,
                            SUM(CASE WHEN MONTH(actDate) = 11 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS nov,
                            SUM(CASE WHEN MONTH(actDate) = 12 THEN ((maxTickets - availableTickets) * price * 0.95) ELSE 0 END) AS dece
                            FROM Activity WHERE ((ProvEmail = '$provider_user') AND YEAR(actDate) = YEAR(NOW()) AND actDate < NOW())"; # we want only the expired activities

            $result_earn_count = mysqli_query($dbc,$sql);
            if($result_earn_count) $earn_count = mysqli_fetch_array($result_earn_count,MYSQLI_ASSOC);
            $earnings_count = array($earn_count['jan'],$earn_count['feb'],$earn_count['mar'],$earn_count['apr'],$earn_count['may'],
                                            $earn_count['jun'],$earn_count['jul'], $earn_count['aug'],$earn_count['sep'],
                                            $earn_count['oct'],$earn_count['nov'], $earn_count['dece']);

            $earn_count_str = implode(",",$earnings_count);

            ### Sold tickets per moth line chart ###
            $sql = "SELECT
                            SUM(CASE WHEN MONTH(actDate) = 1 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS jan,
                            SUM(CASE WHEN MONTH(actDate) = 2 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS feb,
                            SUM(CASE WHEN MONTH(actDate) = 3 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS mar,
                            SUM(CASE WHEN MONTH(actDate) = 4 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS apr,
                            SUM(CASE WHEN MONTH(actDate) = 5 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS may,
                            SUM(CASE WHEN MONTH(actDate) = 6 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS jun,
                            SUM(CASE WHEN MONTH(actDate) = 7 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS jul,
                            SUM(CASE WHEN MONTH(actDate) = 8 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS aug,
                            SUM(CASE WHEN MONTH(actDate) = 9 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS sep,
                            SUM(CASE WHEN MONTH(actDate) = 10 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS oct,
                            SUM(CASE WHEN MONTH(actDate) = 11 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS nov,
                            SUM(CASE WHEN MONTH(actDate) = 12 THEN ((maxTickets - availableTickets)) ELSE 0 END) AS dece
                            FROM Activity WHERE ((ProvEmail = '$provider_user') AND YEAR(actDate) = YEAR(NOW()) AND actDate < NOW())"; # we want only the expired activities

            $result_tickets_count = mysqli_query($dbc,$sql);
            if($result_tickets_count) $tickets_count = mysqli_fetch_array($result_tickets_count,MYSQLI_ASSOC);
            $tickets_count_array = array($tickets_count['jan'],$tickets_count['feb'],$tickets_count['mar'],$tickets_count['apr'],$tickets_count['may'],
                                            $tickets_count['jun'],$tickets_count['jul'], $tickets_count['aug'],$tickets_count['sep'],
                                            $tickets_count['oct'],$tickets_count['nov'], $tickets_count['dece']);

            $tickets_count_str = implode(",",$tickets_count_array);
            #echo $tickets_count_str;

            ### Activities per type (Doghnut chart) ###
            $sql = "SELECT
                        SUM(CASE WHEN actType= 'Ποδόσφαιρο' THEN 1 ELSE 0 END) AS mpala,
                        SUM(CASE WHEN actType= 'Μπάσκετ' THEN 1 ELSE 0 END) AS mpasket,
                        SUM(CASE WHEN actType= 'Κολύμβηση' THEN 1 ELSE 0 END) AS kolibi,
                        SUM(CASE WHEN actType= 'Μουσική' THEN 1 ELSE 0 END) AS mousiki,
                        SUM(CASE WHEN actType= 'Θέατρο' THEN 1 ELSE 0 END) AS theatro,
                        SUM(CASE WHEN actType= 'Παιδικό Πάρτυ' THEN 1 ELSE 0 END) AS parti,
                        SUM(CASE WHEN actType= 'Χορός' THEN 1 ELSE 0 END) AS xoros,
                        SUM(CASE WHEN actType= 'Άλλο' THEN 1 ELSE 0 END) AS allo
                        FROM Activity WHERE ((ProvEmail = '$provider_user') )";
            $result_act_count = mysqli_query($dbc,$sql);
            if($result_act_count) $act_count = mysqli_fetch_array($result_act_count,MYSQLI_ASSOC);
            $activities_count = array($act_count['mpala'],$act_count['mpasket'],$act_count['kolibi'],$act_count['mousiki'],$act_count['theatro'],$act_count['parti'],$act_count['xoros'], $act_count['allo']);
            $my_str = implode(",",$activities_count);

            ### Activities per age (Pie Chart) ###
            $sql = "SELECT
                        SUM(CASE WHEN ((MaxAge < 1 AND MinAge < 1) OR ( MaxAge >= 3 AND MinAge >= 3)) THEN 0 ELSE 1 END) AS three,
                        SUM(CASE WHEN ((MaxAge < 3 AND MinAge < 3) OR ( MaxAge >= 6 AND MinAge >= 6)) THEN 0 ELSE 1 END) AS six,
                        SUM(CASE WHEN ((MaxAge < 6 AND MinAge < 6) OR ( MaxAge >= 9 AND MinAge >= 9)) THEN 0 ELSE 1 END) AS nine,
                        SUM(CASE WHEN ((MaxAge < 9 AND MinAge < 9) OR ( MaxAge >= 12 AND MinAge >= 12)) THEN 0 ELSE 1 END) AS twelve,
                        SUM(CASE WHEN ((MaxAge < 12 AND MinAge < 12) OR ( MaxAge >= 15 AND MinAge >= 15)) THEN 0 ELSE 1 END) AS fifteen,
                        SUM(CASE WHEN ((MaxAge < 15 AND MinAge < 15) OR ( MaxAge > 17 AND MinAge > 17)) THEN 0 ELSE 1 END) AS seventeen
                        FROM Activity WHERE ((ProvEmail = '$provider_user') )";
            $result_ages_count = mysqli_query($dbc,$sql);
            if($result_ages_count) $ages_count = mysqli_fetch_array($result_ages_count,MYSQLI_ASSOC);
            $ages_count_array = array($ages_count['three'],$ages_count['six'],$ages_count['nine'],$ages_count['twelve'],$ages_count['fifteen'],$ages_count['seventeen']);
            $my_age_str = implode(",",$ages_count_array);

            ### Age's popularity per age
            $sql = "SELECT
                        SUM(CASE WHEN ((MaxAge < 1 AND MinAge < 1) OR ( MaxAge >= 3 AND MinAge >= 3)) THEN 0 ELSE ((maxTickets - availableTickets)/maxTickets) END) AS three_ap,
                        SUM(CASE WHEN ((MaxAge < 3 AND MinAge < 3) OR ( MaxAge >= 6 AND MinAge >= 6)) THEN 0 ELSE ((maxTickets - availableTickets)/maxTickets) END) AS six_ap,
                        SUM(CASE WHEN ((MaxAge < 6 AND MinAge < 6) OR ( MaxAge >= 9 AND MinAge >= 9)) THEN 0 ELSE ((maxTickets - availableTickets)/maxTickets) END) AS nine_ap,
                        SUM(CASE WHEN ((MaxAge < 9 AND MinAge < 9) OR ( MaxAge >= 12 AND MinAge >= 12)) THEN 0 ELSE ((maxTickets - availableTickets)/maxTickets) END) AS twelve_ap,
                        SUM(CASE WHEN ((MaxAge < 12 AND MinAge < 12) OR ( MaxAge >= 15 AND MinAge >= 15)) THEN 0 ELSE ((maxTickets - availableTickets)/maxTickets) END) AS fifteen_ap,
                        SUM(CASE WHEN ((MaxAge < 15 AND MinAge < 15) OR ( MaxAge >= 17 AND MinAge >= 17)) THEN 0 ELSE ((maxTickets - availableTickets)/maxTickets) END) AS seventeen_ap
                        FROM Activity WHERE ((ProvEmail = '$provider_user') AND YEAR(actDate) = YEAR(NOW()) AND actDate < NOW())";

            $result_ages_ap = mysqli_query($dbc,$sql);
            if($result_ages_ap) $ages_ap = mysqli_fetch_array($result_ages_ap,MYSQLI_ASSOC);
            ##echo implode(",", $ages_ap);

            $ages_ap_array = array();
            foreach ($ages_count as $key => $value ) {
                if($value == 0) {
                    array_push($ages_ap, 0);
                }
                else {
                    $ages_ap_key= $key.'_ap';
                    $push_val = 100*$ages_ap[$ages_ap_key]/$ages_count[$key];
                    array_push($ages_ap_array, $push_val);
                }
            }
            $ages_ap_str = implode(",",$ages_ap_array);

            ##echo $ages_ap_str;
            ### Activity's popularity per type
            $sql = "SELECT
                        SUM(CASE WHEN actType= 'Ποδόσφαιρο' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS mpala_ap,
                        SUM(CASE WHEN actType= 'Μπάσκετ' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS mpasket_ap,
                        SUM(CASE WHEN actType= 'Κολύμβηση' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS kolibi_ap,
                        SUM(CASE WHEN actType= 'Μουσική' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS mousiki_ap,
                        SUM(CASE WHEN actType= 'Θέατρο' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS theatro_ap,
                        SUM(CASE WHEN actType= 'Παιδικό Πάρτυ' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS parti_ap,
                        SUM(CASE WHEN actType= 'Χορός' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS xoros_ap,
                        SUM(CASE WHEN actType= 'Άλλο' THEN ((maxTickets - availableTickets)/maxTickets) ELSE 0 END) AS allo_ap
                        FROM Activity WHERE ((ProvEmail = '$provider_user') AND YEAR(actDate) = YEAR(NOW()) AND actDate < NOW())";

            $result_act_ap = mysqli_query($dbc,$sql);
            if($result_act_ap) $act_ap = mysqli_fetch_array($result_act_ap,MYSQLI_ASSOC);

            $activities_ap = array();
            foreach ($act_count as $key => $value ) {
                if($value == 0) {
                    array_push($activities_ap, 0);
                }
                else {
                    $ap_key= $key.'_ap';
                    array_push($activities_ap, 100*$act_ap[$ap_key]/$act_count[$key]);
                }
            }
            $act_ap_str = implode(",",$activities_ap);


        ?>

    <span id="act-earnings" data-earnings="<?php echo $earn_count_str; ?>"></span>
    <span id="act-tickets" data-tickets="<?php echo $tickets_count_str; ?>"></span>
    <span id="act-types" data-types="<?php echo $my_str; ?>"></span>
    <span id="act-ages" data-ages="<?php echo $my_age_str; ?>"></span>
    <span id="act-ap" data-ap="<?php echo $act_ap_str; ?>"></span>
    <span id="ages-ap" data-agesap="<?php echo $ages_ap_str; ?>"></span>



    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg" data-color="black">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="./index.php" class="simple-text">
                        KidsUp
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="./provider-dashboard.php">
                            <i class="ti-blackboard"></i>
                            <p>Διαχείριση</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./provider-profile.php">
                            <i class="ti-user"></i>
                            <p>Προφίλ</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./provider-activities.php">
                            <i class="ti-view-list-alt"></i>
                            <p>Δραστηριότητες</p>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./provider-statistics.php">
                            <i class="ti-panel"></i>
                            <p>Στατιστικά</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class=" container-fluid  ">
                    <a class="navbar-brand" href="./provider-statistics.php"> Στατιστικά </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="./index.php">
                                    <span class="no-icon">Αρχική</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./aboutus-provider.php">
                                    <span class="no-icon">Σχετικά με εμάς</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php">
                                    <span class="no-icon">Αποσύνδεση</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4">
							<div class="metric">
								<span class="icon"><i class="fa fa-list"></i></span>
								<p>
									<span class="number"><?php echo $total_info['total_activities']?></span>
									<span class="title">Συνολικές Δραστηριότητες</span>
								</p>
							</div>
						</div>
                        <div class="col-md-4">
							<div class="metric">
								<span class="icon"><i class="fa fa-star"></i></span>
								<p>
									<span class="number"><?php echo $total_info['total_earnings']?> €</span>
									<span class="title">Συνολικά κέρδη μέχρι τώρα</span>
								</p>
							</div>
						</div>
						<div class="col-md-4">
							<div class="metric">
								<span class="icon"><i class="fa fa-ticket"></i></span>
								<p>
									<span class="number"><?php echo $total_info['total_bought_tickets']?></span>
									<span class="title">Συνολικά πωληθέντα εισιτήρια</span>
								</p>
							</div>
						</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h5 class="section-title featured">Πωληθέντα Εισιτήρα ανά μήνα</h5>
                            <canvas id="lineChart" height="345" width="691" style="width: 691px; height: 345px;"></canvas>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h5 class="section-title featured">Κέρδη ανά μήνα </h5>
                            <canvas id="barChart" height="345" width="691" style="width: 691px; height: 455px;"></canvas>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h5 class="section-title featured">Δραστηριότητες ανά τύπο</h5>
                            <canvas id="pieChart" height="345" width="691" style="width: 691px; height: 345px;"></canvas>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h5 class="section-title featured">Δραστηριότητες ανάλογα με την απήχησή τους</h5>
                            <canvas id="ap-barChart" height="345" width="691" style="width: 691px; height: 345px;"></canvas>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h5 class="section-title featured">Δραστηριότητες ανά ηλικία</h5>
                            <canvas id="doughnutChart" height="345" width="691" style="width: 691px; height: 345px;"></canvas>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <h5 class="section-title featured">Δημοφιλείς ηλικιακές κατηγορίες</h5>
                            <canvas id="ap-ages-barChart" height="345" width="691" style="width: 691px; height: 345px;"></canvas>
                        </div>
                    </div>

                </div>
            </div>



            <footer class="footer">
                <div class="container">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href=".index.php">
                                    Αρχική
                                </a>
                            </li>
                            <li>
                                <a href="./aboutus-provider.php">
                                    Σχετικά με εμάς
                                </a>
                            </li>

                        </ul>
                        <p class="copyright text-center">
                            Copyright &copy; <script>document.write(new Date().getFullYear())</script>, made with <i class="fa fa-heart heart"></i> by <a href="./index.php">Team42</a>
                        </p>
                    </nav>
                </div>
            </footer>
        </div>
    </div>


</body>
<!--   Core JS Files   -->
<script src="../assets/js/core/jquery.3.2.1.min.js" type="text/javascript"></script>
<script src="../assets/js/core/bootstrap.min.js" type="text/javascript"></script>

<!-- Control Center for Light Bootstrap Dashboard: scripts for the example pages etc -->
<script src="../assets/js/light-bootstrap-dashboard.js?v=2.0.1" type="text/javascript"></script>

<!-- Chart JS Files -->
<script src="../assets/js/mdb.min.js" type="text/javascript"></script>


<!--   External JS Files   -->
<script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<script>
$(document).ready(function() {

var earnings_count = undefined;
earnings_str = document.getElementById("act-earnings").getAttribute("data-earnings");
var earnings_data= earnings_str.split(",");

var tickets_count = undefined;
tickets_str = document.getElementById("act-tickets").getAttribute("data-tickets");
var tickets_data= tickets_str.split(",");

var activities_count = undefined;
activities_str = document.getElementById("act-types").getAttribute("data-types");
var act_data= activities_str.split(",");

var ages_count = undefined;
ages_str = document.getElementById("act-ages").getAttribute("data-ages");
var ages_data= ages_str.split(",");

var activities_ap = undefined;
activities_ap_str = document.getElementById("act-ap").getAttribute("data-ap");
var act_ap_data= activities_ap_str.split(",");

var ages_ap = undefined;
ages_ap_str = document.getElementById("ages-ap").getAttribute("data-agesap");
var ages_ap_data= ages_ap_str.split(",");
//line
var ctxL = document.getElementById("lineChart").getContext('2d');
var myLineChart = new Chart(ctxL, {
    type: 'line',
    data: {
        labels: ["Ιαν", "Φεβ", "Μαρτ", "Απρ", "Μάιος", "Ιούν", "Ιούλ", "Αύγ", "Σεπ", "Οκτ", "Νοε", "Δεκ"],
        datasets: [
            {
                label: "Πωληθέντα Εισιτήρια",
                fillColor: "rgba(220,220,220,0.2)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: tickets_data
            }

        ]
    },
    options: {
        responsive: true
    }
});

//bar
var ctxB = document.getElementById("barChart").getContext('2d');
var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
        labels: ["Ιαν", "Φεβ", "Μαρ", "Απρ", "Μάιο", "Ιούν", "Ιούλ", "Αύγ", "Σεπ", "Οκτ", "Νοε", "Δεκ"],
        datasets: [{
            label: 'Κέρδη σε €',
            data: earnings_data,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(156, 39, 176, 0.1)',
                'rgba(255, 159, 64, 0.2)',
                'rgba(255, 193, 7, 0.1)',
                'rgba(255, 235, 59, 0.1)',
                'rgba(0, 150, 136, 0.1)',
                'rgba(63, 81, 181, 0.1)',
                'rgba(156, 39, 176, 0.1)'

            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(156, 39, 176, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(255, 193, 7, 0.7)',
                'rgba(255, 235, 59, 0.7)',
                'rgba(0, 150, 136, 0.7)',
                'rgba(63, 81, 181, 0.7)',
                'rgba(156, 39, 176, 0.7)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});

//pie
var ctxP = document.getElementById("pieChart").getContext('2d');
var myPieChart = new Chart(ctxP, {
    type: 'pie',
    data: {
        labels: ["Ποδόσφαιρο", "Μπάσκετ", "Κολύμβηση", "Μουσική", "Χορός", "Θέατρο", "Παιδικό Πάρτι", "Αλλο"],
        datasets: [
            {
                data: act_data,
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360", "#4D3310", "#4D2360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
            }
        ]
    },
    options: {
        responsive: true
    }
});



//ap-bar
var ctxB = document.getElementById("ap-barChart").getContext('2d');
var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
        labels: ["Ποδόσφαιρο", "Μπάσκετ", "Κολύμβηση", "Μουσική", "Χορός", "Θέατρο", "Παιδικό Πάρτι", "Αλλο"],
        datasets: [{
            label: 'Απήχηση Κατηγορίας',
            data: act_ap_data,
            backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360", "#4D3310", "#4D2360"],
            borderColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360", "#4D3310", "#4D2360"],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


//ages-ap-bar
var ctxB = document.getElementById("ap-ages-barChart").getContext('2d');
var myBarChart = new Chart(ctxB, {
    type: 'bar',
    data: {
        labels: ["1-3", "3-6", "6-9", "9-12", "12-15", "15-17"],
        datasets: [{
            label: 'Απήχηση Ηλικίας',
            data: ages_ap_data,
            backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
            borderColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});


//doughnut
var ctxD = document.getElementById("doughnutChart").getContext('2d');
var myLineChart = new Chart(ctxD, {
    type: 'doughnut',
    data: {
        labels: ["1-3", "3-6", "6-9", "9-12", "12-15", "15-17"],
        datasets: [
            {
                data: ages_data,
                backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C", "#949FB1", "#4D5360"],
                hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870", "#A8B3C5", "#616774"]
            }
        ]
    },
    options: {
        responsive: true
    }


});

});


</script>

</html>
