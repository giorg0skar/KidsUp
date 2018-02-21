<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Αλλαγή Κωδικού</title>
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
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST["parent-pwd"] && $_POST["parent-Confirmpwd"]) { 
            require('mysqli_connect.php');  
            $pwd=mysqli_real_escape_string($dbc,$_POST['parent-pwd']);
            $Confirmpwd=password_hash(mysqli_real_escape_string($dbc,$_POST['parent-Confirmpwd']), PASSWORD_DEFAULT);
            if(password_verify($pwd,$Confirmpwd)) {                            
                $parent_email = $_SESSION['login_user'];
                $query="UPDATE Parent SET pwd = '".$Confirmpwd."' WHERE ParEmail= '".$parent_email."'";                                                                         
                $retval= mysqli_query($dbc,$query);
                if(! $retval ) {
                    printf($query);
                    die('Could not update data: ' . mysqli_error($dbc));
                }
                $_SESSION['parent_pwd'] = $Confirmpwd; //only after a successful store in database the session is updated.
            }
            else {
                echo "The passwords you typed in are not identical. Please try again.";
            }
            mysqli_close($dbc);
        } 
        if ($_POST["parent-pwd"] && !$_POST["parent-Confirmpwd"]) {
            echo "You need to confirm the password. Please fill both forms with the identical new password.";
        } 
        if (!$_POST["parent-pwd"] && $_POST["parent-Confirmpwd"]) {
            echo "You need to type in the password. Please fill both forms with the identical new password.";
        }                        
    }             
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
                    <li class="nav-item">
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
                    <li class="nav-item active">
                        <a class="nav-link" href="./parent-changePassword.php">
                            <i class="ti-lock"></i>
                            <p>Αλλαγή Κωδικού</p>
                        </a>
                    </li>                      
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg " color-on-scroll="500">
                <div class=" container-fluid  ">
                    <a class="navbar-brand" href="./parent-changePassword.php"> Αλλαγή Κωδικού </a>
                    <button href="" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                        <span class="navbar-toggler-bar burger-lines"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="index.php">
                                    <span class="no-icon">Αρχική</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./aboutus.php">
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
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Πληκτρολογήστε τον νέο κωδικό και επαληθεύστε τον</h4>
                                </div>
                                <div class="card-body">
                                    <form action="parent-changePassword.php" method = "post">                                        
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="parent-pwd">Password</label>
                                                    <input type="text" class="form-control border-input" id="parent-pwd" name="parent-pwd" placeholder="New Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="parent-Confirmpwd">Confirm Password</label>
                                                    <input type="text" class="form-control border-input" id="parent-Confirmpwd" name="parent-Confirmpwd" placeholder="Confirm New Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                        <input type="submit" class="btn btn-info btn-fill btn-wd" value="Ενημέρωση Κωδικού" ></input>
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
                                <a href="./index.php">
                                    Αρχική
                                </a>
                            </li>
                            <li>
                                <a href="./aboutus.php">
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