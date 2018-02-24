<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Dashboard</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="../assets/css/themify-icons.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />

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
            $sql = "SELECT * FROM Activity WHERE ((ProvEmail = '$provider_user') AND actDate >= NOW()) ORDER BY ((maxTickets-availableTickets)/visits) DESC"; # Order by Apixisi = bought_tickets / visits
            $result_active = mysqli_query($dbc,$sql);

            ### Info of active activities ###
            $sql_info =  "SELECT COUNT(ActID) as number_of_activities,
                                SUM((maxTickets - availableTickets) * price) AS earnings_sum,
                                SUM(maxTickets - availableTickets) AS bought_tickets,
                                SUM(visits) AS visits
            FROM Activity WHERE ((ProvEmail = '$provider_user') AND actDate >= NOW())";
            $result_info = mysqli_query($dbc,$sql_info);
            if($result_info) $total_info = mysqli_fetch_array($result_info,MYSQLI_ASSOC);
        ?>


    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg" data-color="black">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="./index.php" class="simple-text">
                        KidsUp
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item active">
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
                    <li>
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
                    <a class="navbar-brand" href="#pablo"> Διαχείριση </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="#do_something">
                                    <span class="no-icon">Αρχική</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="aboutus-provider.php">
                                    <span class="no-icon">Σχετικά με εμάς</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./logout.php">
                                    <span class="no-icon">Αποσύνδεση</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->



            <!-- Start of initial statistics -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-3 col-sm-6">
                            <div class="card bg-success text-white ">
                                <div class="card-body bg-success">
                                    <div class="rotate">
                                        <i class="fa fa-list fa-3x"></i>
                                    </div>
                                    <h6 class="text-uppercase">Ενεργές Δραστηριότητες</h6>
                                    <h1 class="display-4"><?php echo $total_info['number_of_activities']; ?> </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card text-white bg-danger">
                                <div class="card-body bg-danger">
                                    <div class="rotate">
                                        <i class="fa fa-star fa-3x"></i>
                                    </div>
                                    <h6 class="text-uppercase">Κέρδη Ενεργών Δραστ.</h6>
                                    <h1 class="display-4"><?php echo $total_info['earnings_sum'] / 10 ;?> €</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card text-white bg-info">
                                <div class="card-body bg-info">
                                    <div class="rotate">
                                        <i class="fa fa-user fa-3x"></i>
                                    </div>
                                    <h6 class="text-uppercase">Επισκέπτες</h6>
                                    <h1 class="display-4"><?php if($total_info['visits']) echo $total_info['visits'];
                                                                else echo 0; ?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-sm-6">
                            <div class="card text-white bg-warning">
                                <div class="card-body bg-warning">
                                    <div class="rotate">
                                        <i class="fa fa-ticket fa-3x"></i>
                                    </div>
                                    <h6 class="text-uppercase">Πωληθέντα Εισιτήρια</h6>
                                    <h1 class="display-4"><?php if($total_info['bought_tickets']) echo '+' , $total_info['bought_tickets'];
                                                                else echo 0;?>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>

            <!-- End of initial statistics -->
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-info btn-fill btn-wd" href="./activity_form.php" role="button">Νέα Δραστηριότητα</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header ">
                                    <h3 class="card-title">Δραστηριότητες με την μεγαλύτερη απήχηση</h3>
                                    <h5 class="card-category">*Απήχηση = Προβολές / Αγορασμένα Εισιτήρια</h5>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table id="dash-table" class="table table-hover table-striped">
                                        <thead>
                                            <th>Φωτογραφία</th>
                                            <th>Δραστηριότητα</th>
                                            <th>Ημερομηνία Δραστηριότητας</th>
                                            <th>Προβολές</th>
                                            <th>Αγορασμένα Εισιτήρια</th>
                                            <th>Κέρδη</th>
                                            <th>Απήχηση</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($result_active){
                                                    while($row = mysqli_fetch_array($result_active,MYSQLI_ASSOC)){
                                                        echo '<tr>';
                                                                $image_name = $row['pictureURL'];
                                                                echo '<td>'. '<img src="'.$image_name.'" alt="HTML5 Icon" style="width:128px;height:128px">'.'</td>';
                                                                echo '<td>'. $row['actName'].'</td>';
                                                                echo '<td>'. $row['actDate'].'</td>';
                                                                echo '<td>'. $row['visits'].'</td>';
                                                                $bought_tickets = $row['maxTickets'] - $row['availableTickets'];
                                                                echo '<td>'. $bought_tickets .' / '.$row['maxTickets'] .'</td>'; # bought_tickets ανά maxTickets
                                                                $earnings = $bought_tickets * $row['price'] / 10; # convert earnings in Euros
                                                                echo '<td>'.$earnings.' €</td>';
                                                                $apixisi = 100 * $row['visits'] / $bought_tickets; # create percentage of visits / bought_tickets
                                                                echo '<td>'.round($apixisi).'% </td>';
                                                        echo '</tr>';

                                                    }
                                                }
                                             ?>
                                        </tbody>
                                    </table>
                                </div>
                             </div>
                       </div>
                    </div>

            <footer class="footer">
                <div class="container">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="#">
                                    Αρχική
                                </a>
                            </li>
                            <li>
                                <a href="aboutus-provider.php">
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

<!--   External JS Files   -->
<script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<script>
    $(document).ready(function() {
        $('#dash-table').DataTable();
    } );
</script>

</html>
