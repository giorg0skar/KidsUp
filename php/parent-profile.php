<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Profile</title>
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
<?php
				mb_internal_encoding('UTF-8');
				mb_http_input("utf-8");
				session_start();
				if(!isset($_SESSION['login_user'])){
					header("location:./parent-signin.php");
				}
                require('mysqli_connect.php');                
				$parent_email = $_SESSION['login_user'];
                $parent_pwd = $_SESSION['parent_pwd'];  
                $parent_firstname = $_SESSION['parent_firstname'];
                $parent_lastname = $_SESSION['parent_lastname'];
                $parent_street = $_SESSION['parent_street'];
                $parent_street_num = $_SESSION['parent_street_num'];
                $parent_town = $_SESSION['parent_town'];
                $parent_zipcode = $_SESSION['parent_zipcode'];  
                $parent_PhoneNumber = $_SESSION['parent_PhoneNumber'];     
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $comparable="UPDATE Parent SET ";
                    $query="UPDATE Parent SET ";
                    $tempEmail = $parent_email;
                    if($_POST["parent-email"] && $_POST["parent-email"] != $parent_email) {
                        $_SESSION['parent_email'] = $_POST["parent-email"];
                        $parent_email = $_POST["parent-email"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."ParEmail = '".$parent_email."' ";
                    }
                    if($_POST["parent-pwd"]) {                        
                        $_SESSION['parent_pwd'] = $_POST["parent-pwd"];
                        $parent_pwd = $_POST["parent-pwd"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."pwd = '".$parent_pwd."' ";
                    }
                    if($_POST["parent-firstname"] && $_POST["parent-firstname"] != $parent_firstname) {
                        $_SESSION['parent_firstname'] = $_POST["parent-firstname"];
                        $parent_firstname = $_POST["parent-firstname"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."firstname = '".$parent_firstname."' ";
                    }
                    if($_POST["parent-lastname"] && $_POST["parent-lastname"] != $parent_lastname) {
                        $_SESSION['parent_lasttname'] = $_POST["parent-lastname"];
                        $parent_lastname = $_POST["parent-lastname"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."lastname = '".$parent_lastname."' ";
                    }
                    if($_POST["parent-town"] && $_POST["parent-town"] != $parent_town) {
                        $_SESSION['parent_town'] = $_POST["parent-town"];
                        $parent_town = $_POST["parent-town"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."town = '".$parent_town."' ";
                    }
                    if($_POST["parent-street"] && $_POST["parent-street"] != $parent_street) {
                        $_SESSION['parent_street'] = $_POST["parent-street"];
                        $parent_street = $_POST["parent-street"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."streetName = '".$parent_street."' ";
                    }
                    if($_POST["parent-street_num"] && $_POST["parent-street_num"] != $parent_street_num) {
                        $_SESSION['parent_street_num'] = $_POST["parent-street_num"];
                        $parent_street_num  = $_POST["parent-street_num"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."streetNumber = '".$parent_street_num."' ";
                    }
                    if($_POST["parent-zipcode"] && $_POST["parent-zipcode"] != $parent_zipcode) {
                        $_SESSION['parent_zipcode'] = $_POST["parent-zipcode"];
                        $parent_zipcode = $_POST["parent-zipcode"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."PostalCode = '".$parent_zipcode."' ";
                    }  
                    if($_POST["parent-PhoneNumber"] && $_POST["parent-PhoneNumber"] != $parent_PhoneNumber) {
                        $_SESSION['parent_PhoneNumber'] = $_POST["parent-PhoneNumber"];
                        $parent_PhoneNumber = $_POST["parent-PhoneNumber"];
                        if($query != $comparable){
                            $query=$query." , ";
                        }
                        $query=$query."PhoneNumber = '".$parent_PhoneNumber."' ";
                    }                                        
                    if($query != $comparable){
                        $query=$query." WHERE ParEmail= '".$tempEmail."'";
                        $retval= mysqli_query($dbc,$query);
                        if(! $retval ) {
                            printf($query);
                          die('Could not update data: ' . mysqli_error($dbc));
                       }
                    }
                    mysqli_close($dbc);
                }             
?>
    <div class="wrapper">
        <div class="sidebar" data-image="../assets/img/sidebar-5.jpg" data-color="black">
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="./parentSignedInHomePage.php" class="simple-text">
                        KidsUp
                    </a>
                </div>
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="./parent-profile.php">
                            <i class="ti-user"></i>
                            <p>Προφίλ</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./parent-wallet.php">
                            <i class="ti-wallet"></i>
                            <p>Πορτοφόλι</p>
                        </a>
                    </li>                    
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class=" container-fluid  ">
                    <a class="navbar-brand" href="./parent-profile.php"> Προφίλ </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="parentSignedInHomePage.php">
                                    <span class="no-icon">Αρχική</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#contact">
                                    <span class="no-icon">Επικοινωνία</span>
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

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Επεξεργασία προφίλ</h4>
                                </div>
                                <div class="card-body">
                                    <form action="parent-profile.php" method = "post">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="parent-firstname">Όνομα</label>
                                                    <input type="text" class="form-control border-input" id="parent-firstname" name="parent-firstname" placeholder="Όνομα" value="<?php echo  $parent_firstname; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="parent-lastname">Επώνυμο</label>
                                                    <input type="text" class="form-control border-input" id="parent-lastname" name="parent-lastname" placeholder="Επώνυμο" value="<?php echo $parent_lastname;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="parent-street">Οδός</label>
                                                    <input type="text" class="form-control border-input" id="parent-street" name="parent-street" placeholder="Οδός" value="<?php echo      $parent_street; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 col-lg-2">
                                                    <!-- Empty element to format properly the next one -->
                                            </div>
                                            <div class="col-md-2 col-lg-2 float-right">
                                                <div class="form-group">
                                                    <label for="parent-street_num">Αριθμός Οδού</label>
                                                    <input type="text" class="form-control border-input" id="parent-street_num" name="parent-street_num" placeholder="Αριθμός Οδού" value="<?php echo $parent_street_num;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="parent-town">Πόλη</label>
                                                    <input type="text" class="form-control border-input" id="parent-town" name="parent-town" placeholder="Πόλη" value="<?php echo      $parent_town; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="parent-zipcode">Ταχυδρομικός κώδικας</label>
                                                    <input type="text" class="form-control border-input" id="parent-zipcode" name="parent-zipcode" placeholder="Ταχυδρομικός κώδικας" value="<?php echo $parent_zipcode;?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="parent-zipcode">Αριθμός τηλεφώνου</label>
                                                    <input type="text" class="form-control border-input" id="parent-PhoneNumber" name="parent-PhoneNumber" placeholder="Αριθμός τηλεφώνου" value="<?php echo $parent_PhoneNumber;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="parent-email">Email</label>
                                                    <input type="text" readonly="readonly" class="form-control border-input" id="parent-email" name="parent-email" placeholder="Email" value="<?php echo $parent_email; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="parent-pwd">Password</label>
                                                    <input type="text" class="form-control border-input" id="parent-pwd" name="parent-pwd" placeholder="Password" value="<?php echo $parent_pwd; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <!--Επιβεβαίωση για την αλλαγή κωδικού, ισως με popup. Η αντικατάσταση αυτού του div με κουμπί που να πάει σε άλλη σελίδα για αλλαγή κωδικού-->
                                        <div class="text-center">
                                        <!-- <button type="submit" class="btn btn-info btn-fill btn-wd">Ενημέρωση Προφίλ</button> -->
                                        <input type="submit" class="btn btn-info btn-fill btn-wd" value="Ενημέρωση Προφίλ" ></input>
                                        </div>
                                    <div class="clearfix"></div>
                                    </form>
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