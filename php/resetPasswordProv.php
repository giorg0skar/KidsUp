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
	
	


<?php
	if (isset($_POST['resPas'])) {
        require_once('./mysqli_connect.php');
		$mail = $_POST['mail'];
		$pwd = password_hash( $_POST['pwd'] , PASSWORD_DEFAULT);
        $sql = "UPDATE Provider SET pwd='".$pwd."' WHERE ProvEmail='".$mail."' ";
        $result = mysqli_query($dbc,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
		if( $count ==1 ){
			header("./provider-signin.php");
		}else{
			echo "Try again";
		}
    }
	if( isset($_GET["email"]) && isset($_GET["token"]) ){
		require_once("mysqli_connect.php");
		$email = mysqli_real_escape_string($dbc,$_GET['email']);
		$token = mysqli_real_escape_string($dbc,$_GET['token']);
		
		$sql = "SELECT * FROM Provider WHERE ProvEmail = '$email' AND token='$token'";
        $result = mysqli_query($dbc,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        $count = mysqli_num_rows($result);
		
		if( $count ==1){
			?>
			<div class="container">
				<form  class="form-signin" action="resetPasswordProv.php" method="post">
					<input class="form-control" type="password" name="pwd" placeholder="New Password"><br>
					<input type="text" value= "<?php echo $email; ?>" name="mail" hidden />
					<input class="btn btn-sm btn-info" type="submit" name="resPas" value="Set Password" style="width:100%;height:200%;" />
				</form>
			</div>

			<?php
			
		} else{
			echo "Please check your link";
			
		}
		
	}else{
		header("location: provider-signin.php");
	}
?>

<!-- Bootstrap core JavaScript -->
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
      
  </body>
</html>

