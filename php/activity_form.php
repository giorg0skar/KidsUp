<!DOCTYPE html>
<html lang="en">

  <head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Νέα Δραστηριότητα</title>
  <link rel="shortcut icon" type="image" href="../favicon.ico"/>

  <!-- Bootstrap core CSS -->
  <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">


  <!-- Custom styles for this template -->
  <link href="../assets/css/activity.css" rel="stylesheet">

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
        <a class="nav-link" href="#about">Σχετικά με εμάς</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#services">Υπηρεσίες</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#contact">Επικοινωνία</a>
      </li>
      <li class="nav-item">
        <a class="nav-link"  href="index.php">Έξοδος</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="provider-profile.php"><?php session_start(); echo $_SESSION['companyName']; ?></a>
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
					
					$ProvEmail = $_SESSION['login_user'];
					$actName = trim($_POST['actName']);
					$actType = trim($_POST['actType']);
					$actDate = trim($_POST['actDate']);
					$actTime = trim($_POST['actTime']);
					$price = trim($_POST['price']);
					$MinAge = trim($_POST['MinAge']);
					$MaxAge = trim($_POST['MaxAge']);
					$maxTickets = trim($_POST['maxTickets']);
					$availableTickets = $maxTickets;
					$town = trim($_POST['town']);
					$streetName = trim($_POST['streetName']);
					$streetNumber = trim($_POST['streetNumber']);
					$PostalCode = trim($_POST['PostalCode']);
					$PhoneNumber = trim($_POST['PhoneNumber']);
					$actDescription = trim($_POST['actDescription']);
					$pictureURL = trim($_POST['pictureURL']);
          $visits = 0;
          $actDateTime = $actDate." ".$actTime;
					
					$address = $streetName . ' ' .$streetNumber .' , ' .$PostalCode .' , ' .$town;
					$url='https://maps.google.com/maps/api/geocode/json?address='.urlencode($address).'&key=AIzaSyBsLUCKMjlmcDrvL6IXYlaHez6AUb01O8U&sensor=false';
					$geocode = file_get_contents($url);
					$output= json_decode($geocode , true);
					$latitude = $output['results'][0]['geometry']['location']['lat'];
					$longitude = $output['results'][0]['geometry']['location']['lng'];
					
					if( $streetNumber<=0 || $PostalCode<=9999 || $PostalCode>=100000 || $PhoneNumber<=0 || $PhoneNumber>=10000000000 || $MinAge>$MaxAge) // kialloi elegxoi
						$flag=1;
						if ( $flag==0){
							require_once('./mysqli_connect.php');
							$query = "INSERT INTO Activity(ProvEmail,actName,actType,actDate,price,MinAge,MaxAge,maxTickets,availableTickets,town,streetName,streetNumber,PostalCode,PhoneNumber,latitude,longitude,actDescription,pictureURL,visits) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							$stmt = mysqli_prepare($dbc, $query);
              mysqli_stmt_bind_param($stmt, "ssssiiiiissiiiddssi", $ProvEmail, $actName, $actType, $actDateTime, $price, $MinAge, $MaxAge, $maxTickets, $availableTickets, $town, $streetName, $streetNumber, $PostalCode, $PhoneNumber, $latitude, $longitude, $actDescription, $pictureURL, $visits);
              mysqli_stmt_execute($stmt);
							$affected_rows = mysqli_stmt_affected_rows($stmt);
							if($affected_rows == 1){
                echo '<h1>Επιτυχής δημιουργία δραστηριότητας  !</h1>';
                
                //get the auto-increment key from the last-insert (PROBLEM IN CONCURRENT SUBMITS) 
                $id = mysqli_insert_id($dbc);
                $new_activity = [
                  'ActID' => $id,
                  'actName' => $actName,
                  'actType' => $actType,
                  'actDate' => $actDateTime,
                  'MinAge' => $MinAge,
                  'MaxAge' => $MaxAge,
                  'availableTickets' => $availableTickets,
                  'latitude' => $latitude,
                  'longitude' => $longitude,
                  'actDescription' => $actDescription
                ];
                include('./full_text_search.php');
                //insert new activity to ElasticSearch
                insert_activity($new_activity);

								mysqli_stmt_close($stmt);
								mysqli_close($dbc); 
								header("location: provider-activities.php");	
							} else {
								echo 'Το email αυτό ήδη χρησιμοποιείται! Παρακαλώ διαλέξτε ένα άλλο<br/>';
								mysqli_stmt_close($stmt);
								mysqli_close($dbc);
							}
						}
						else {
							echo '<h3>Remember:</h3> Ο ταχυδρομικός κώδικας είναι ένας 5ψήφιος αριθμός<br/>
											Ο αριθμός τηλεφώνου είναι ένας 10ψήφιος αριθμός<br/>
											Η ελάχιστη ηλικία παιδιών στην οποία απευθύνεται η δραστηριότητα πρέπει να είναι μικρότερη από την μέγιστη ηλικία <br/>
											
											';
						}
					 
				}
				
?>
  
  


 <div class="my-container container">
    <div class="row mb-4">
      <div class="col-lg-12 well ">
        <h1 align=left>Φόρμα Εισαγωγής Δραστηριότητας</h1>
      </div>
    </div>
    <div class="row">
    <div class="col-lg-12 well">
          <div class="row">
          <form action="activity_form.php" method="post">
            <div class="col-sm-12">
              <div class="form-group">
                  <input type="text" name="actName" placeholder="Τίτλος Δραστηριότητας" class="form-control" required>
              </div>
              <div class="form-group">
					<input type="text" name="actType" placeholder="Τύπος Δραστηριότητας" class="form-control" required>
              </div>
              <div class="row">
                <div class="col-sm-6 form-group">
                  <input type="text" name="streetName" placeholder="Οδός Δραστηριότητας" class="form-control" required>
                </div>
                <div class="col-sm-6 form-group">
                  <input type="number" name="streetNumber"  min = "1" placeholder="Αριθμός οδού " class="form-control" required>
                </div>
              </div>
			<div class="row">
				<div class="col-sm-6 form-group">
                  <input type="text" name="town" placeholder="Πόλη Δραστηριότητας" class="form-control" required="true">
                </div>
				<div class="col-sm-6 form-group">
					<input type="text" name="PostalCode" placeholder="Ταχυδρομικός Κώδικας" class="form-control" required="true">
				</div>
			</div>
			<div class="form-group">
                  <input type="number" min="1000000000"name="PhoneNumber" placeholder="Τηλέφωνο Επικοινωνίας" class="form-control" required>
              </div>
              <div class="row">
                &nbsp;&nbsp;&nbsp;
                <label for="age1">Ηλικία Από:</label>
                <div class="col-sm-4 form-group">
                  <input type="text" name="MinAge" type="number" min = "1" id="age1" placeholder="Ελάχιστη" class="form-control" required="true">
                </div>
                <label for="age2">Έως:</label>
                <div class="col-sm-4 form-group">
                  <input type="text" name="MaxAge"type="number" min="1" max = "18" id="age2" placeholder="Μέγιστη" class="form-control" required>
                </div>
              </div>

              <div class="row">
                  &nbsp;&nbsp;&nbsp;
                  <label for="example-date-input" class="col-xs-6 control-label">Date:</label>
                  <div class="col-sm-4">
                    <input class="form-control" name="actDate" type="date" value="2017-08-19" id="example-date-input">
                    </div>
                  <label for="example-time-input"  class="col-xs-6 control-label">Time:</label>
                  <div class="col-sm-4">
                    <input class="form-control" name="actTime" type="time" value="13:45:00" id="example-time-input">
                  </div>
              </div>
              <br>

              <div class="form-group">
				<div class="row">
					<div id="dv1" class="col-xs-3">
						&nbsp;
						&nbsp;
						Τιμή:
						<input type="number" name="price" step="any" min = "1" id="txtPassportNumber" required/>Πόντοι
					</div>
					<div id="dv1" class="col-xs-3">
						&nbsp;
						&nbsp;
						Διαθέσιμα Εισιτήρια:
						<input type="number" name="maxTickets" min = "1" id="txtPassportNumber" required/>
					</div>
				</div>
            </div>

            <div class="form-group">
				<label for="exampleFormControlFile1">Φωτογραφία Δραστηριότητας:</label>
				<input type="file" name="pictureURL" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
            <div class="form-group">
               <label for="exampleFormControlTextarea1">Περιγραφή</label>
               <textarea name="actDescription" class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
            </div>
				<input type="submit" class="btn btn-sm btn-info" value="Υποβολή Δήλωσης" ></input>
            </div>
          </form>
          </div>
    </div>
    </div>
<br/>

    <!-- Footer -->
  <footer class="custom py-5 fixed-bottom bg-dark">
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

</html>
