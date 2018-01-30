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
                    <a href="./index.php" class="simple-text">
                        KidsUp
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item active">
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
                    <!-- <li>
                        <a class="nav-link" href="#activities">
                            <i class="ti-view-list-alt"></i>
                            <p>Δραστηριότητες</p>
                        </a>
                    </li> -->
                    <li>
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
                    <a class="navbar-brand" href="#pablo"> Διαχείριση </a>
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
                <?php
                    if (isset($_POST['activate'])) {
                        mb_internal_encoding('UTF-8');
                        mb_http_input("utf-8");
                        require('./mysqli_connect.php');
                        $flag=0;
                        // $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                        // OR die('Could not connect to MySQL: ' .
                        // mysqli_connect_error());
                        // mysqli_set_charset($dbc, "utf8");

                        $mail = $_POST['act_mail'];
                        $sql = "UPDATE Parent SET activated=1 WHERE ParEmail ='$mail' ";
                        if ($dbc->query($sql) === TRUE) {
                            if ($dbc->affected_rows == 1) {
                                echo "Parent activated successfully";
                                $flag=1;
                            }
                        }
                        else echo "Error activating user: " . $dbc->error;
                        
                        if ($flag==0) {
                            $sql1 = "UPDATE Provider SET activated=1 WHERE ProvEmail ='$mail' ";
                            if ($dbc->query($sql1) === TRUE) {
                                echo "Provider activated successfully";
                            }
                            else echo "Error activating user:" . $dbc->error;
                        }
                        mysqli_close($dbc);
                    }
                ?>
                <h3>Λογαριασμοί προς ενεργοποίηση:</h3>
                    <?php
                    //error_reporting(0);     //to disable error or warning messages
                    mb_internal_encoding('UTF-8');
                    mb_http_input("utf-8");
                    require('./mysqli_connect.php');
                    mysqli_query($dbc,"SET NAMES UTF8");    //to display greek characters correctly
                    $query = "SELECT ParEmail,firstname,lastname FROM Parent WHERE activated=0";
                    $response = @mysqli_query($dbc, $query);
                    if ($response) {
                        $count = 0;
                        echo '<table class="table table-striped"><caption>Γονείς για ενεργοποίηση</caption>
                        <thead><tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Όνομα</th>
                            <th scope="col">Επώνυμο</th>
                            <th scope="col">Ενεργοποίηση</th>
                        </tr>
                        </thead><tbody>';
                        // mysqli_fetch_array will return a row of data from the query
                        // until no further data is available
                        while($row = mysqli_fetch_array($response)) {
                            echo '<tr><th scope="row">'. $count++ .'</th><td align="left">' . 
                            $row['ParEmail'] . '</td><td align="left">' .
                            $row['firstname'] . '</td><td align="left">' .
                            $row['lastname'] . '</td><td align="left">' ;
                        ?>
                        <form action="admin-dashboard.php" method="post">
                        <input class="btn btn-fill btn-primary" type="submit" name="activate" value="Activate" />
                        <input type="text" value= "<?php echo $row['ParEmail']; ?>" name="act_mail" hidden />
                        <input type="text" value= "<?php echo $row['firstname']; ?>" name="firstname" hidden />
                        <input type="text" value= "<?php echo $row['lastname']; ?>" name="lastname" hidden />
                        </form>
                        <?php
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                    }
                    else {
                        echo "Couldn't issue database query<br />";
                        echo mysqli_error($dbc);
                    }

                    //providers to be activated
                    $query = "SELECT ProvEmail,companyName FROM Provider WHERE activated=0";
                    $response = @mysqli_query($dbc, $query);
                    if ($response) {
                        $count = 0;
                        echo '<table class="table table-striped"><caption>Πάροχοι για ενεργοποίηση</caption>
                        <thead><tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Όνομα Εταιρίας</th>
                            <th scope="col">Ενεργοποίηση</th>
                        </tr>
                        </thead><tbody>';
                        // mysqli_fetch_array will return a row of data from the query
                        // until no further data is available
                        while($row = mysqli_fetch_array($response)) {
                            echo '<tr><th scope="row">'. $count++ .'</th><td align="left">' . 
                            $row['ProvEmail'] . '</td><td align="left">' .
                            $row['companyName'] . '</td><td align="left">' ;
                        ?>
                        <form action="admin-dashboard.php" method="post">
                        <input class="btn btn-fill btn-primary" type="submit" name="activate" value="Activate" />
                        <input type="text" value= "<?php echo $row['ProvEmail']; ?>" name="act_mail" hidden />
                        <input type="text" value= "<?php echo $row['companyName']; ?>" name="firstname" hidden />
                        </form>
                        <?php
                            echo '</tr>';
                        }
                        echo '</tbody></table>';
                    }
                    else {
                        echo "Couldn't issue database query<br />";
                        echo mysqli_error($dbc);
                    }

                    //close connection to database
                    mysqli_close($dbc);
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Email</th>
                            <th scope="col">Όνομα</th>
                            <th scope="col">Επώνυμο</th>
                            <th scope="col">Ενεργοποίηση</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <th scope="row">1</th>
                            <td>t1@mail.com</td>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>
                                   <form action="admin-dashboard.php" method="post">
                                   <input class="btn btn-primary" type="submit" name="activate" value="Activate" />
                                   </form>
                            </td>
                            </tr>
                            <tr>
                            <th scope="row">2</th>
                                <td>something2@mail.com</td>
                                <td>Jacob</td>
                                <td>Thornton</td>
                                <!-- <td><a href="#do_stuff">Activate</td> -->
                                <td>
                                   <form action="admin-dashboard.php" method="post">
                                   <input class="btn btn-primary" type="submit" name="activate" value="Activate" />
                                   </form>
                                </td>
                            </tr>
                            <tr>
                            <th scope="row">3</th>
                            <td>t3@mail.com</td>
                            <td>Larry</td>
                            <td>the Bird</td>
                            <td>
                                   <form action="admin-dashboard.php" method="post">
                                   <input class="btn btn-primary" type="submit" name="activate" value="Activate" />
                                   </form>
                            </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- footer -->
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


</html>