<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Σύνδεση</title>
    <link rel="shortcut icon" type="image" href="../assets/img/favicon.ico"/>

    <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../assets/css/signin.css" rel="stylesheet">
  </head>

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

<div class="container">
<h4 class="form-signin" style="text-align:center;">
<?php
   include("mysqli_connect.php");
   session_start();
   mb_internal_encoding('UTF-8');
   mb_http_input("utf-8");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($dbc,$_POST['ProvEmail']);
      $mypassword = mysqli_real_escape_string($dbc,$_POST['pwd']);

      $sql = "SELECT * FROM Provider WHERE ProvEmail = '$myusername'";
      $result = mysqli_query($dbc,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

      if($count == 1) {
			if( !password_verify($mypassword, $row['pwd'])){
					$error = "Your Login Name or Password is invalid";
					echo   $error;
			}else{
				if($row['activated']=='0'){
					session_destroy();
					header("location: waiting_activation.php");
				}else{
					$_SESSION['login_user'] = $myusername;
					$_SESSION['pwd'] = $mypassword;
					$_SESSION['companyName'] = $row['companyName'];
					$_SESSION['town'] = $row['town'];
					$_SESSION['streetName'] = $row['streetName'];
					$_SESSION['streetNumber'] = $row['streetNumber'];
					$_SESSION['PostalCode'] = $row['PostalCode'];
					$_SESSION['PhoneNumber'] = $row['PhoneNumber'];
					$_SESSION['VAT'] = $row['VAT'];
					$_SESSION['IBAN'] = $row['IBAN'];
					header("location: provider-profile.php");
				}
			}
		}else {
			$error = "Your Login Name or Password is invalid";
			echo $error;
		}
	}
?>
</h4>
</div>



    <div class="container">

      <form class="form-signin" action="./provider-signin.php" method="post">
        <h2 class="form-signin-heading">Εισάγετε τα στοιχεία σας</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email"  name="ProvEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" name="pwd" id="inputPassword" class="form-control" placeholder="Password" required>
		<a  href="./reset-pass-prov.php">Reset password</a>
        <input type="submit" class="btn btn-sm btn-info" value="Σύνδεση" style="width:100%;height:200%;"></input>
      </form>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>
</html>
