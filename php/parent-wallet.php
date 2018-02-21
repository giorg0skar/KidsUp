<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Wallet</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" />
    <link href="../assets/css/themify-icons.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/light-bootstrap-dashboard.css?v=2.0.1" rel="stylesheet" />
    <style type="text/css">
        hr {
            display: block;
            margin-top: 0.5em;
            margin-bottom: 0.5em;
            margin-left: auto;
            margin-right: auto;
            border-style: inset;
            border-width: 2px;
        }
        .top10 { margin-top:10px; }
        .top20 { margin-top:20px; }
        .height { height:113px; }
        .activity { border: 1px solid black;
        }
        .left_margin { margin-left: 5px; }
        .margin5 { margin:5px; }
        #points_background { 
            background-color: lightskyblue;
            color: white;
        }
        #points_title { 
            background-color: deepskyblue;
            color: white;
        }
        #card_size { min-width: 40%; }
        #white_font { color: white; }
    </style>
</head>

<body>
<?php
				mb_internal_encoding('UTF-8');
				mb_http_input("utf-8");
				session_start();
				if(!isset($_SESSION['login_user'])){
					header("location:./parent-signin.php");
				}
                               
				$parent_email = $_SESSION['login_user'];
                $parent_points = (int) trim($_SESSION['parent_points']); 
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $tempvar= (int) $_POST["parent_points"];
                    if($tempvar<0){  //In case of negative input
                            $tempvar=0;
                    }
                    if($tempvar!=0){
                        $parent_points=$parent_points + $tempvar;
                        require('mysqli_connect.php'); 
                        $_SESSION["parent_points"]=$parent_points;
                        $query="UPDATE Parent SET Points='".$parent_points."' WHERE ParEmail='".$parent_email."'";
                        $retval= mysqli_query($dbc,$query);
                        if(! $retval ) {
                            printf($query);
                            die('Could not update points: ' . mysqli_error($dbc));
                        }
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
                    <li class="nav-item active">
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
                    <a class="navbar-brand" href="./parent-wallet.php"> Πορτοφόλι </a>
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
                        <div class="card-body">
                            <div class="row top20">

                                <div class="col-md-3">
                                    <!-- Empty element for better formating of the next element -->
                                </div>

                                <div class="card col-md-2 text-center" id="points_background">
                                    <h1 class="height"><?php echo $_SESSION['parent_points'];   ?></h1>
                                    <div class="row">
                                            <h5 class="card-subtitle col-md-12" id="points_title">Τρέχων Ποσό Πόντων</h5>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <!-- Empty element for better formating of the next element -->
                                </div>

                                <div class="card col-md-2 text-center">
                                        <form action="parent-wallet.php" method = "post">
                                            <input type="text" class="form-control border-input top10" name="parent_points" placeholder="Πόντοι">
                                            <select class="form-control top10" id="sel1">
                                                <option>MasterCard</option>
                                                <option>Visa</option>
                                            </select>
                                            <div class="row">
                                                <div class="col-md-6 col-sm-6 col-6"></div>
                                                <input type="submit" class="col-md-4 col-sm-4 col-4 top10 btn btn-info btn-fill btn-xs" value="Αγορά" ></input>
                                                <div class="col-md-2 col-sm-2 col-2"></div>
                                            </div>
                                        </form> 
                                        <div class="row">
                                            <h5 class="card-subtitle col-md-12 top10" id="points_title">Αγοράστε Πόντους</h5>
                                        </div>
                                </div>

                                <div class="col-md-3">
                                    <!-- Empty element for better formating-->
                                </div>
                            </div>

                            <h5 class="left_margin">Ιστορικό Συναλλαγών</h5>
                            <hr>
                            <?php 
                            include_once('mysqli_connect.php');
                            $sellquery="SELECT * FROM Sell WHERE ParEmail = '$parent_email'";
                            $sellresult = mysqli_query($dbc,$sellquery);
                            $sellcount = mysqli_num_rows($sellresult);
                            while($sellrow = mysqli_fetch_array($sellresult,MYSQLI_ASSOC)){
                                $ActID=$sellrow['ActID'];
                                $actquery="SELECT * FROM Activity WHERE ActID = '$ActID'";
                                $actresult = mysqli_query($dbc,$actquery);
                                $actrow = mysqli_fetch_array($actresult,MYSQLI_ASSOC) 
                            ?>
                                <div class="card activity margin5">
                                    <div class="row">
                                        <p class="col-md-3 left_margin"><?php echo $actrow['actName']?></p>
                                        <p class="col-md-8">
                                            <?php echo $actrow['actDate']?> <br> 
                                            Αριθμός Εισητηρίων: <?php echo $sellrow['numberofTickets']?> <br>
                                            Συνολικό Κόστος: <?php echo $sellrow['totalCost'] ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } 
                            mysqli_close($dbc);
                            ?>
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