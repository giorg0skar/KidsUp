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
					header("location:./provider-signin.php");
				}
				$provider_user = $_SESSION['login_user'];
				$pwd = $_SESSION['pwd'];
				$town = $_SESSION['town'];
				$companyName = $_SESSION['companyName'];
				$streetName = $_SESSION['streetName'];
				$streetNumber = $_SESSION['streetNumber'];
				$PostalCode = $_SESSION['PostalCode'];
				$PhoneNumber = $_SESSION['PhoneNumber'];
				$VAT = $_SESSION['VAT'];
				$IBAN = $_SESSION['IBAN'];
				
				
  
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
                    <li class="nav-item active">
                        <a class="nav-link" href="./provider-profile.php">
                            <i class="ti-user"></i>
                            <p>Προφίλ</p>
                        </a>
                    </li>
                    <li>
                        <a class="nav-link" href="provider-activities.php">
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
                    <a class="navbar-brand" href="#do_something"> Προφίλ </a>
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
                                    <form>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="company-name">Εταιρία</label>
                                                    <input type="text" class="form-control border-input" id="company-name" disabled placeholder="Company" value="<?php echo $companyName; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="afm">ΑΦΜ</label>
                                                    <input type="text" class="form-control border-input" id="afm" placeholder="Εταιρικό ΑΦΜ" value="<?php echo $VAT;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="bank-account">Τραπεζικός Λογαριασμός</label>
                                                    <input type="text" class="form-control border-input" id="bank-account" placeholder="Τραπεζικός Λογαριασμός για λήψη χρημάτων" value="<?php echo $IBAN; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="company-town">Εδρα Εταιρίας</label>
                                                    <input type="text" class="form-control border-input" id="company-town" placeholder="Πόλη" value="<?php echo $town; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company-street">Οδός</label>
                                                    <input type="text" class="form-control border-input" id="company-street" placeholder="Οδός" value="<?php echo $streetName; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company-street-number">Αριθμός</label>
                                                    <input type="number" class="form-control border-input" id="company-street-number" placeholder="Αριθμός" value="<?php echo $streetNumber; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company-tk">ΤΚ</label>
                                                    <input type="number" class="form-control border-input" id="company-tk" placeholder="Ταχυδρομικός κώδικας" value="<?php  echo $PostalCode;?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company-phone">Τηλέφωνο</label>
                                                    <input type="text" class="form-control border-input" id="company-phone" placeholder="Τηλέφωνο" value="<?php echo $PhoneNumber?> ">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="company-email">Email</label>
                                                    <input type="email" class="form-control border-input" id="company-email" placeholder="Email" value="<?php echo $provider_user; ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="provider-password">Κωδικός</label>
                                                    <input type="text" class="form-control border-input" id="provider-password" placeholder="Κωδικός Πρόσβασης" value="<?php echo $pwd;?>">
                                                </div>
                                            </div>
                                        </div> <!--Επιβεβαίωση για την αλλαγή κωδικού, ισως με popup. Η αντικατάσταση αυτού του div με κουμπί που να πάει σε άλλη σελίδα για αλλαγή κωδικού-->
                                        <div class="text-center">
                                        <button type="submit" class="btn btn-info btn-fill btn-wd">Ενημέρωση Προφίλ</button>
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
