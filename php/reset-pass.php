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
<?php use PHPMailer\PHPMailer\PHPMailer; ?>
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
		if(isset($_POST["resPas"])){
			require_once("mysqli_connect.php");
			$email = mysqli_real_escape_string($dbc,$_POST['email']);
			$sql = "SELECT * FROM Parent WHERE ParEmail = '$email'";
			$result = mysqli_query($dbc,$sql);
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $count = mysqli_num_rows($result);
			if($count==1){
				$str = "0123456789qwertyuiopasdfghjklzxcvbnm";
				$str = str_shuffle($str);
				$str = substr($str , 0 , 15);
				$url = "http://localhost/php/resetPassword.php?token=$str&email=$email";
				
				$sql = "UPDATE Parent SET token='$str' WHERE ParEmail='$email'";
				$result = mysqli_query($dbc,$sql);
				


				//Import PHPMailer classes into the global namespace
				
				require './vendor/autoload.php';
				$mail = new PHPMailer;
				$mail->isSMTP();
				//$mail->SMTPDebug = 2;
				$mail->Host = 'smtp.gmail.com';
				$mail->Port = 587;
				$mail->SMTPSecure = 'tls';
				$mail->SMTPAuth = true;
				
				$mail->Username = "KidsUp42@gmail.com";
				$mail->Password = 'Q23G$_9#er4!';
				$mail->setFrom('KidsUp42@gmail.com', 'KidsUp');
				$mail->SMTPOptions = array(
					'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
					)
				);
				$mail->AddAddress($email);
				//Set the subject line
				$mail->Subject = 'Reset Password';
				//Replace the plain text body with one created manually
				$mail->Body = "This the link to to reset your password $url" ;
				//send the message, check for errors
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					?>
					<div class="container">
					<h4 class="form-signin" style="text-align:center;"><?php
					echo "Email sent!";
					?> </h4></div> <?php
				}	
			}else{
				echo "Παρακαλώ βάλτε το σωστό email για το οποίο χάσατε τον κωδικό";
			}
		}
	?>
	
	
	
	
    <div class="container">
		<form  class="form-signin" action="reset-pass.php" method="post">
			<input class="form-control" type="text" name="email" placeholder="Email"><br>
			<input class="btn btn-sm btn-info" type="submit" name="resPas" value="Reset Password" style="width:100%;height:200%;" />
		</form>

    </div>
  	<!-- /container -->

    <!-- Bootstrap core JavaScript -->
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
      
  </body>
</html>