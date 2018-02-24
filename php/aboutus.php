<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>About us</title>
    <link rel="shortcut icon" type="image" href="../assets/img/favicon.ico"/>

    <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template -->
    <link href="../assets/css/signup.css" rel="stylesheet" type="text/css">

  </head>
<style type="text/css">
  .container.my-container {
    margin-top: 40px;
  }
  .container.footer {
    color: #00EFB7;
  }
  .py-5.custom{
    position: fixed;
    /*position: absolute;*/
    /*position: relative;*/
    right: 0;
    bottom: 0;
    left: 0;
    width: 100%;
    text-align: center;
    clear: both;
    }
    .pt-5,.py-5{
    padding-top:1rem!important
    }
    .pr-5,.px-5{
    padding-right:0rem!important
    }
    .pb-5,.py-5{
    padding-bottom:1rem!important
    }
    .pl-5,.px-5{
    padding-left:0rem!important
    }
</style>
<body>

	<!-- Navigation -->
	<?php
	mb_internal_encoding('UTF-8');
	mb_http_input("utf-8");
	session_start();
	if(!isset($_SESSION['login_user'])){
       ?>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">KidsUp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Αρχική
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="aboutus.php">Σχετικά με εμάς</a>
            </li>
            <li class="nav-item dropdown">
			  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSignUp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Σύνδεση ως</a>
			  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownSignUp">
                  <a class="dropdown-item" href="parent-signin.php">Γονέας</a>
                  <a class="dropdown-item" href="provider-signin.php">Πάροχος</a>
              </div>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSignUp" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Εγγραφή ως
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownSignUp">
                  <a class="dropdown-item" href="parent-signup.php">Γονέας</a>
                  <a class="dropdown-item" href="provider-signup.php">Πάροχος</a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>
	   <?php
    }else{
	$user_check = $_SESSION['login_user'];
	$firstname = $_SESSION['parent_firstname'];
	$lastname = $_SESSION['parent_lastname'];
	$Points = $_SESSION['parent_points'];
  ?>
	
	<!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php">KidsUp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Αρχική
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="aboutus.php">Σχετικά με εμάς</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Έξοδος</a>
            </li>
			<li class="nav-item">
				<a class="nav-link" href="parent-profile.php"><?php echo $firstname . ' ' . $lastname; ?><br>Πόντοι:<?php echo $Points; ?></a>
            </li>
          </ul>
        </div>
      </div>
    </nav> <?php } ?>
	
	
    


    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-12 well">
                <h3 align=left><p>&nbsp;&nbsp;&nbsp;&nbsp; Η διαδικτυακή πλατφόρμα δημιουργήθηκε από την ομάδα Team42 ως εργασία για το μάθημα Τεχνολογίας Λογισμικού στην Σχολή ΗΜΜΥ.</p>
				<p>&nbsp;&nbsp;&nbsp;&nbsp; Μέλη της ομάδας είναι :</p>
        <?php 

            echo 'Αδάμης           Δημήτριος      03113114    dimitrisadamis1994@gmail.com' . '<br>' .
                  'Αθανασόπουλος    Γεώργιος       03113085    athanasopoulosgeorge95@gmail.com' . '<br>' . 
                  'Δράγαζης         Νικόλαος       03113162    ndragazis@outlook.com.gr' . '<br>' .
                  'Καράκος          Γεώργιος       03113204    karakosg@hotmail.gr' . '<br>' .
                  'Καραμουσαδάκης   Μιχάλης        03113030    mike95gr@hotmail.com' . '<br>' .
                  'Πέτρου           Γεώργιος       03113145    tedroark7@gmail.com' . '<br>' .
                  'Σκούρας          Κωνσταντίνος   03113096    konst.skouras@gmail.com';


        ?>
				<p>&nbsp;&nbsp;&nbsp;&nbsp;</p></h3>
            </div>
        </div>
    </div>
    <!-- Footer -->

    <footer class="py-5 bg-dark custom">
    <div class="footer container">
        <b>Team 42</b> -
        SoftEng Project 2017 -
        NTUA
    <p class="m-0 text-center text-white">Copyright &copy; KidsUp 2017</p>
    </div>
  </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
