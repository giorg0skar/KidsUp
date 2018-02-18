<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Δραστηριότητες</title>
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
            $sql = "SELECT * FROM Activity WHERE ((ProvEmail = '$provider_user') AND actDate >= NOW()) ORDER BY ActID DESC"; # we want only the active activities
            $result_active = mysqli_query($dbc,$sql);

            $sql = "SELECT * FROM Activity WHERE ((ProvEmail = '$provider_user') AND actDate < NOW()) ORDER BY ActID DESC"; # we want only the expired activities
            $result_inactive = mysqli_query($dbc,$sql);

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
                    <li class="nav-item active">
                        <a class="nav-link" href="./provider-activities.php">
                            <i class="ti-view-list-alt"></i>
                            <p>Δραστηριότητες</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="#statistics">
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
                                <a class="nav-link" href="#do_something">
                                    <span class="no-icon">Επικοινωνία</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#do_something">
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
                    <div class="card">
                        <div class="card-body">
                            <a class="btn btn-info btn-fill btn-wd" href="./activity_form.php" role="button">Νέα Δραστηριότητα</a>                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card strpied-tabled-with-hover">
                                <div class="card-header ">
                                    <h4 class="card-title">Ενεργές Δραστηριότητες</h4>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table id="active-table" class="table table-hover table-striped">
                                        <thead>
                                            <th>Φωτογραφία</th>
                                            <th>Δραστηριότητα</th>
                                            <th>Ημερομηνία Δραστηριότητας</th>
                                            <th>Προβολές</th>
                                            <th>Αγορασμένα Εισιτήρια</th>
                                            <th>Κέρδη</th>
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
                                                        echo '</tr>';

                                                    }
                                                }
                                             ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card card-plain table-plain-bg">
                                <div class="card-header ">
                                    <h4 class="card-title">Ανενεργές Δραστηριότητες</h4>
                                </div>
                                <div class="card-body table-full-width table-responsive">
                                    <table id="inactive-table" class="table table-hover">
                                        <thead>
                                            <th>Φωτογραφία</th>
                                            <th>Δραστηριότητα</th>
                                            <th>Ημερομηνία Δραστηριότητας</th>
                                            <th>Προβολές</th>
                                            <th>Αγορασμένα Εισιτήρια</th>
                                            <th>Κέρδη</th>
                                        </thead>
                                        <tbody>
                                            <?php
                                                if($result_inactive){
                                                    while($row = mysqli_fetch_array($result_inactive,MYSQLI_ASSOC)){
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
                </div>

            </div>


            <div class="content">
                <div class="container-fluid">

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
                                <a href="#">
                                    Επικοινωνία
                                </a>
                            </li>
                            <li>
                                <a href="#">
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
        $('#active-table').DataTable();
        $('#inactive-table').DataTable();
    } );
</script>

</html>
