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
	<div class="container">
<h4 class="form-signin" style="text-align:center;">
<?php
   include("mysqli_connect.php");
   session_start();
   mb_internal_encoding('UTF-8');
   mb_http_input("utf-8");
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form

      $myusername = mysqli_real_escape_string($dbc,$_POST['email']);
      $mypassword = mysqli_real_escape_string($dbc,$_POST['pwd']);

      $sql = "SELECT * FROM Admin WHERE email = '$myusername' and pwd = '$mypassword'";
      $result = mysqli_query($dbc,$sql);
      $row = mysqli_fetch_array($result);

      $count = mysqli_num_rows($result);

      // If result matched $myusername and $mypassword, table row must be 1 row

    if($count == 1) {
      $_SESSION['login_user'] = $myusername;
      $_SESSION['pwd'] = $mypassword;
      $_SESSION['firstname'] = $row['firstname'];
      $_SESSION['lastname'] = $row['lastname'];
      $_SESSION['town'] = $row['town'];
      $_SESSION['streetName'] = $row['streetName'];
      $_SESSION['streetNumber'] = $row['streetNumber'];
      $_SESSION['PostalCode'] = $row['PostalCode'];
      $_SESSION['PhoneNumber'] = $row['PhoneNumber'];

      header("location: admin-dashboard.php");
    }
    else {
      $error = "Your Login Name or Password is invalid";
      echo   $error;
      }
   }
?>
</h4>
</div>

    <div class="container">

      <form class="form-signin" action="./adminlogin.php" method="post">
        <h2 class="form-signin-heading">Εισάγετε τα στοιχεία σας</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="pwd" class="form-control" placeholder="Password" required>
		<input type="submit" class="btn btn-lg btn-primary btn-block" value="Σύνδεση" ></input>
      </form>

    </div> <!-- /container -->
  </body>
</html>
