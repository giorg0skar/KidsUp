<?php
    session_start();
    if(!isset($_SESSION['admin_user'])){
        header("location:adminlogin.php");
    }
?>
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

</head>

<body>
    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg" data-color="black">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="./logout-admin.php" class="simple-text">
                        KidsUp
                    </a>
                </div>
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="./admin-dashboard.php">
                            <i class="ti-blackboard"></i>
                            <p>Διαχειριση</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="./admin-accounts.php">
                            <i class="ti-user"></i>
                            <p>Λογαριασμοι</p>
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="./admin-statistics.php">
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
                    <a class="navbar-brand" href="#pablo"> Στατιστικά </a>
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
                                <a class="nav-link" href="aboutus.php">
                                    <span class="no-icon">Σχετικά με εμάς</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout-admin.php">
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
                <?php
                    mb_internal_encoding('UTF-8');
                    mb_http_input("utf-8");
                    
                    //$num_of_users = $_SESSION['num_of_users'];
                ?>
                    <h3>Στατιστικά:</h3>
                    <?php
                    require('./mysqli_connect.php');
                    mysqli_query($dbc,"SET NAMES UTF8");
                    //we calculate number of active users
                    $query = "SELECT ParEmail FROM Parent WHERE activated=1";
                    @mysqli_query($dbc, $query);
                    $num_of_users = mysqli_affected_rows($dbc);
                    $query = "SELECT ProvEmail FROM Provider WHERE activated=1";
                    @mysqli_query($dbc,$query);
                    $num_of_users += mysqli_affected_rows($dbc);

                    $query = "SELECT totalCost FROM Sell";
                    $profits = 0;
                    $response = @mysqli_query($dbc,$query);
                    if ($response) {
                        while($row = mysqli_fetch_array($response)) {
                            $profits += $row['totalCost'];
                        }
                        $profits = $profits*0.05;
                    }
                    
                    ?>
                    <div class="col-lg-4 col-sm-6">
                        <div class="card h-100">
                            
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#">Αριθμός ενεργών χρηστών</a>
                                </h4>
                                <p class="card-text">Αριθμός:<?php echo $num_of_users?></p>
                                
                            </div>
                        </div>
                    </div>
                    <!-- profits -->
                    <div class="col-xl-3 col-sm-6">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <a href="#">Έσοδα εφαρμογής</a>
                                </h4>
                                <p class="card-text">Ποσό:<?php echo $profits?> €</p>
                                
                            </div>
                        </div>
                    </div>
                    <?php
                        //popular providers
                        $query = "SELECT Provider.ProvEmail, Provider.companyName, Sell.numberoftickets FROM Provider JOIN Activity ON Provider.ProvEmail=Activity.ProvEmail JOIN Sell ON Sell.ActID=Activity.ActID ORDER BY Provider.ProvEmail";
                        //
                        $response = @mysqli_query($dbc,$query);
                        if ($response) {
                            $count = 1;
                            $row = mysqli_fetch_array($response);
                            $check_mail = $row['ProvEmail'];
                            $pmail = $check_mail;
                            $cname = $row['companyName'];
                            $amount = $row['numberoftickets'];
                            ?>
                            <caption>Αριθμός εισιτηρίων που πουλήθηκαν ανά πάροχο</caption><table class="table table-striped">
                            <thead><tr>
                                <th scope="col">#</th>
                                <th scope="col">Email Παρόχου</th>
                                <th scope="col">Όνομα Εταιρίας</th>
                                <th scope="col">Αριθμός εισιτηρίων</th>
                            </tr>
                            </thead><tbody>
                            <?php
                            //echo '<tr>';
                            while($row = mysqli_fetch_array($response)) {
                                
                                if ($row['ProvEmail'] == $check_mail) {
                                    $amount += $row['numberoftickets'];
                                }
                                else {
                                    //once we find a different mail we print the line with total numOfTickets we calculated so far
                                    echo '<tr><th scope="row">'. $count++ .'</th><td align="left">' .
                                    $pmail . '</td><td align="left">' .
                                    $cname . '</td><td align="left">' .
                                    $amount . '</td></tr>';

                                    $amount = $row['numberoftickets'];
                                    $check_mail = $row['ProvEmail'];
                                }
                                $pmail = $row['ProvEmail'];
                                $cname = $row['companyName'];
                            }
                            //we print the last row
                            echo '<tr><th scope="row">'. $count++ .'</th><td align="left">' .
                                $pmail . '</td><td align="left">' .
                                $cname . '</td><td align="left">' .
                                $amount . '</td></tr>';
                            ?>
                            </tbody></table>
                            <?php
                        }
                        else {
                            echo "Couldn't issue this database query<br />";
                            echo mysqli_error($dbc);
                        }

                        mysqli_close($dbc);
                    ?>
                </div>
            </div>
            <!-- footer -->
            <footer class="footer">
                <div class="container">
                    <nav>
                        <ul class="footer-menu">
                            <li>
                                <a href="./logout.php">
                                    Αρχική
                                </a>
                            </li>
                            <li>
                                <a href="aboutus.php">
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


</html>
