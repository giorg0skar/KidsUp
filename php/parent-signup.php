<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Εγγραφή</title>
    <link rel="shortcut icon" type="image" href="../favicon.ico"/>

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
              <a class="nav-link" href="#about">Σχετικά με εμάς</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#services">Υπηρεσίες</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#contact">Επικοινωνία</a>
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

	<div class="container">
		<div class="row mb-3">
            <div class="col-lg-12 well">
				<?php
				header('Content-type: text/html; charset=UTF-8');
				mb_internal_encoding('UTF-8');
				mb_http_input("utf-8");
				if($_SERVER["REQUEST_METHOD"] == "POST"){
					$flag=0;
					
					$ParEmail = trim($_POST['ParEmail']);
					$pwd = trim($_POST['pwd']);
					$firstname = trim($_POST['firstname']);
					$lastname = trim($_POST['lastname']);
					$town = trim($_POST['town']);
					$streetName = trim($_POST['streetName']);
					$streetNumber = trim($_POST['streetNumber']);
					$PostalCode = trim($_POST['PostalCode']);
					$PhoneNumber = trim($_POST['PhoneNumber']);
					
					$address = $streetName . ' ' .$streetNumber .' , ' .$PostalCode .' , ' .$town;
					$url='https://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyBsLUCKMjlmcDrvL6IXYlaHez6AUb01O8U&sensor=false';
					$geocode = file_get_contents($url);
					$output= json_decode($geocode , true);
					$latitude = $output['results'][0]['geometry']['location']['lat'];
					$longitude = $output['results'][0]['geometry']['location']['lng'];
					$Points = 0;
					$online = 1;
					$activated =1;
					if( $streetNumber<=0 || $PostalCode<=9999 || $PostalCode>=100000 || $PhoneNumber<=0 || $PhoneNumber>=10000000000)
						$flag=1;
						if ( $flag==0){
							require_once('./mysqli_connect.php');
							$query = "INSERT INTO parent(ParEmail, pwd , firstname , lastname , town, streetName , streetNumber , PostalCode , PhoneNumber , latitude , longitude , Points , online, activated) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							$stmt = mysqli_prepare($dbc, $query);
							mysqli_stmt_bind_param($stmt, "ssssssiiiddiii", $ParEmail, $pwd , $firstname , $lastname , $town, $streetName , $streetNumber , $PostalCode , $PhoneNumber , $latitude , $longitude , $Points , intval($online), intval($activated));
							mysqli_stmt_execute($stmt);
							$affected_rows = mysqli_stmt_affected_rows($stmt);
							if($affected_rows == 1){
								echo '<h1>Εγγραφήκατε επιτυχώς !</h1>';
								mysqli_stmt_close($stmt);
								mysqli_close($dbc); 
								header("location: waiting_activation.php");	
							} else {
								echo 'Το email αυτό ήδη χρησιμοποιείται! Παρακαλώ διαλέξτε ένα άλλο<br/>';
								mysqli_stmt_close($stmt);
								mysqli_close($dbc);
							}
						}
						else {
							echo 'Remember: Ο ταχυδρομικός κώδικας είναι ένας 5ψήφιος αριθμός<br/>
											Ο αριθμός τηλεφώνου είναι ένας 10ψήφιος αριθμός<br/>
											';
						}
					 
				}
?>
			</div>
		</div>
	</div>
    <div class="container">
        <div class="row mb-3">
            <div class="col-lg-12 well">
                <h1 align=left>Φόρμα Εγγραφής</h1>
            </div>
        </div>
        <div class="row">
        <div class="col-lg-12 well">
        <div class="row">
                <div class="row">
                    <form action="parent-signup.php" method = "post">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="firstname" placeholder="Όνομα" class="form-control" required autofocus>
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="lastname"placeholder="Επώνυμο" class="form-control" required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="streetName"placeholder="Οδός κατοικίας" class="form-control" required >
                                </div>
                                <div class="col-sm-6 form-group">
                                    <input type="number" min="1" name="streetNumber" placeholder="Αριθμός οδού κατοικίας" class="form-control" required >
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 form-group">
                                    <input type="text" name="town"placeholder="Πόλη κατοικίας" class="form-control" required >
                                </div>
                                <div class="col-sm-6 form-group">
                                        <input type="number" name="PostalCode" min="10000" placeholder="Ταχυδρομικός κώδικας" class="form-control" required  >
                                </div>
                            </div>
                        <div class="form-group">
                            <input type="number" name="PhoneNumber" min="100000000"placeholder="Τηλέφωνο" class="form-control" required >
                        </div>
                        <div class="form-group">
                            <input type="email" id="inputEmail" name="ParEmail" class="form-control" placeholder="Email address" required >
                        </div>
                        <div class="form-group">
                            <input type="password" name="pwd" placeholder="Password" class="form-control" required >
                        </div>
							<input type="submit" class="btn btn-sm btn-info" value="Υποβολή Δήλωσης" ></input>
                        </div>
                    </form>
                </div>
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
