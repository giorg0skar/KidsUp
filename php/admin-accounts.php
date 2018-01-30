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
                    <li>
                        <a class="nav-link" href="./admin-dashboard.php">
                            <i class="ti-blackboard"></i>
                            <p>Διαχειριση</p>
                        </a>
                    </li>
                    <li class="nav-item active">
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
                    <a class="navbar-brand" href="#pablo"> Λογαριασμοί </a>
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
                    mb_internal_encoding('UTF-8');
                    mb_http_input("utf-8");
                    //lock a user's account
                    if (isset($_POST['lock'])) {
                        $flag1=0;
                        require('./mysqli_connect.php');
                        $mail = $_POST['mail'];
                        $sql = "UPDATE Parent SET activated=0 WHERE ParEmail='$mail' ";
                        if ($dbc->query($sql) === TRUE) {
                            if ($dbc->affected_rows == 1) {
                                $flag1=1;
                                echo "Parent deactivated successfully";
                            }
                        }
                        else {
                            echo "Error updating record: " . $dbc->error;
                        }
                        if ($flag1 == 0) {
                            $sql1 = "UPDATE Provider SET activated=0 WHERE ProvEmail='".$mail."' ";
                            if ($dbc->query($sql1) === TRUE) {
                                if ($dbc->affected_rows == 1) echo "Provider deactivated successfully";
                            }
                            else echo "Error deleting record:" . $dbc->error;
                        }
                        mysqli_close($dbc);
                    }
                    //change a user's password
                    if (isset($_POST['submit'])) {
                        $flag2=0;
                        require('./mysqli_connect.php');
                        $mail = $_POST['mail'];
                        $pwd = $_POST['password'];
                        $sql = "UPDATE Parent SET pwd='".$pwd."' WHERE ParEmail='".$mail."' ";
                        if ($dbc->query($sql) === TRUE) {
                            if ($dbc->affected_rows == 1) {
                                $flag2=1;
                                echo "Parent's password changed";
                            }
                        }
                        else {
                            echo "Error deleting record: " . $dbc->error;
                        }
                        if ($flag2 == 0) {
                            $sql1 = "UPDATE Provider SET pwd='".$pwd."' WHERE ProvEmail='".$mail."' ";
                            if ($dbc->query($sql1) === TRUE) {
                                if ($dbc->affected_rows == 1) echo "Provider's password changed";
                            }
                            else echo "Error deleting record:" . $dbc->error;
                        }
                        mysqli_close($dbc);
                    }
                ?>
                    <h3>Λογαριασμοι:</h3>
                    <?php
                    mb_internal_encoding('UTF-8');
                    mb_http_input("utf-8");
                    require('./mysqli_connect.php');

                    //list of parents
                    $query = "SELECT ParEmail FROM Parent WHERE activated=1";
                    $response = @mysqli_query($dbc, $query);
                    if ($response) {
                        echo '<table class="table"><thead>
                        <tr>
                            <th scope="col">Λογαριασμος</th>
                            <th scope="col">Νεος κωδικος</th>
                            <th scope="col">Αλλαγη δικαιωματων</th>
                            <th scope="col">Κλειδωμα λογαριασμου</th>
                        </tr>
                        </thead><tbody>';
                        // mysqli_fetch_array will return a row of data from the query
                        // until no further data is available
                        while($row = mysqli_fetch_array($response)) {
                            echo '<tr><td>' . 
                            $row['ParEmail'] . '</td><td>' ;
                        ?>
                            
                            <form class="form-inline" action="admin-accounts.php" method="post">
                                <!-- <div class="form-group mb-2" > -->
                                <input type="text" class="form-control border-input" id="pwd" name="password" placeholder="Νέος Κωδικός">
                                <!-- </div> -->
                                <!-- <div class="form-group mb-2"> -->
                                <input class="btn btn-fill btn-primary" type="submit" name="submit" value="Submit" >
                                <input type="text" value= "<?php echo $row['ParEmail']; ?>" name="mail" hidden />
                                <!-- </div> -->
                            </form>
                            
                        <?php
                            echo '</td><td>';
                        ?>
                            <button type="button" class="btn btn-link">Αλλαγή δικαιωμάτων</button>
                        <?php
                            echo '</td><td>';
                        ?>
                            <form action="admin-accounts.php" method="post">
                            <input class="btn btn-fill btn-danger" type="submit" name="lock" value="Lock" >
                            <input type="text" value= "<?php echo $row['ParEmail']; ?>" name="mail" hidden />
                            </form>
                        <?php
                            echo '</td></tr>';
                        }
                        echo '</tbody></table>';
                    }
                    else {
                        echo "Couldn't issue database query<br />";
                        echo mysqli_error($dbc);
                    }

                    //list of providers
                    $query = "SELECT ProvEmail FROM Provider WHERE activated=1";
                    $response = @mysqli_query($dbc, $query);
                    if ($response) {
                        echo '<table class="table"><thead>
                        <tr>
                            <th scope="col">Λογαριασμος</th>
                            <th scope="col">Νεος κωδικος</th>
                            <th scope="col">Αλλαγη δικαιωματων</th>
                            <th scope="col">Κλειδωμα λογαριασμου</th>
                        </tr>
                        </thead><tbody>';
                        // mysqli_fetch_array will return a row of data from the query
                        // until no further data is available
                        while($row = mysqli_fetch_array($response)) {
                            echo '<tr><td>' . 
                            $row['ProvEmail'] . '</td><td>' ;
                        ?>
                            <form class="form-inline" action="admin-accounts.php" method="post">
                            <input type="text" class="form-control border-input" id="pwd" name="password" placeholder="Νέος Κωδικός">
                            <input class="btn btn-fill btn-primary" type="submit" name="submit" value="Submit" >
                            <input type="text" value= "<?php echo $row['ProvEmail']; ?>" name="mail" hidden />
                            </form>
                        <?php
                            echo '</td><td>';
                        ?>
                            <button type="button" class="btn btn-link">Αλλαγή δικαιωμάτων</button>
                            <!-- haven't figured out what this is supposed to do for now -->
                        <?php
                            echo '</td><td>';
                        ?>
                            <form action="admin-accounts.php" method="post">
                            <input class="btn btn-fill btn-danger" type="submit" name="lock" value="Lock" >
                            <input type="text" value= "<?php echo $row['ProvEmail']; ?>" name="mail" hidden />
                            </form>
                        <?php
                            echo '</td></tr>';
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
