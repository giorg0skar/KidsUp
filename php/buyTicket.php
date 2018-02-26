<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KidsUp</title>
    <link rel="shortcut icon" type="image" href="../assets/img/favicon.ico"/>

    <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">   
    <link href="../assets/css/tickets.css" rel="stylesheet">

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

        
          <?php 

              
                session_start();

              if(isset($_SESSION['login_user'])){

                  echo"
                    <li class=\"nav-item\">
                      <a class=\"nav-link\" href=\"logout.php\">Έξοδος</a>
                    </li>
                    <li class=\"nav-item\">
                       <a class=\"nav-link\" href=\"parent-profile.php\">" . ' '. $_SESSION['parent_firstname'] . ' ' .  $_SESSION['parent_lastname'] . ' ' . "<br>Πόντοι:" . ' ' . $_SESSION['parent_points'] . ' ' . "</a>
                    </li> ";

                }
                  else echo " 
                    <li class=\"nav-item dropdown\"> 
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownSignUp\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">Σύνδεση ως</a> 
                        <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownSignUp\"> 
                              <a class=\"dropdown-item\" href=\"parent-signin.php\">Γονέας</a> 
                              <a class=\"dropdown-item\" href=\"provider-signin.php\">Πάροχος</a> 
                        </div> 
                    </li> 
                    <li class=\"nav-item dropdown\"> 
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdownSignUp\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"> 
                            Εγγραφή ως 
                        </a> 
                        <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"navbarDropdownSignUp\"> 
                              <a class=\"dropdown-item\" href=\"parent-signup.php\">Γονέας</a> 
                              <a class=\"dropdown-item\" href=\"provider-signup.php\">Πάροχος</a> 
                        </div> 
                    </li> ";

           ?>

      </ul>
    </div>
    </div>
  </nav>



	<div class="col-lg-4 col-md-6 mb-4" style="float:left;" id="ticket">
              <div class="card h-100" style="margin-top: 2rem">


                 <?php

                    header('Content-type: text/html; charset=UTF-8');
                    mb_internal_encoding('UTF-8');
                    mb_http_input("utf-8");


                    if($_SERVER["REQUEST_METHOD"] == "POST" ){
                        $flag=0;

                        if(isset($_SESSION['login_user'])){
                            $ParEmail = $_SESSION['login_user'];
                            $Points   = $_SESSION['parent_points'];
                        }else $Points = 0;

                        $id = trim($_POST['ActId']); 
                        require('./mysqli_connect.php'); 


                        $q = "SELECT * FROM Activity WHERE (ActID='$id') ";
                        $r = mysqli_query($dbc, $q);
  
                        if (mysqli_num_rows($r)==1){

                            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

                            $actName = $row['actName'];
                            $actType = $row['actType'];
                            $actDate = $row['actDate'];
                            $price   = $row['price'];
                            $MinAge  = $row['MinAge'];
                            $MaxAge  = $row['MaxAge'];
                            $maxTickets = $row['maxTickets'];
                            $availableTickets = $row['availableTickets'];
                            $town = $row['town'];
                            $streetName = $row['streetName'];
                            $streetNumber = $row['streetNumber'];
                            $PostalCode = $row['PostalCode'];
                            $PhoneNumber = $row['PhoneNumber'];
                            $actDescription = $row['actDescription'];
                            $pictureURL = $row['pictureURL'];
                            $visits = $row['visits'];
                            $latitude = $row['latitude'];
                            $longitude = $row['longitude'];

                            mysqli_free_result($r);
                            $q = "UPDATE Activity SET visits=visits+1 WHERE ActID='$id' ";
                            $r = mysqli_query($dbc, $q);

                            if (mysqli_affected_rows($dbc)!=1){
                              echo '<h1>Αποτυχία ενημέρωσης των visits  !</h1>';
                            }
    

                        }else {
                          echo '<h1>Αποτυχία εύρεσης δραστηριότητας  !</h1>';
                        }


                        if(isset($_POST['number'])){

                            $ticket_count = trim($_POST['number']);

                            mysqli_query($dbc, "START TRANSACTION");

                              mysqli_query($dbc, "SET TRANSACTION ISOLATION LEVEL SERIALIZABLE");
                              mysqli_query($dbc, "SET autocommit=0");
                              $q = "UPDATE Activity SET  availableTickets=availableTickets - '$ticket_count' WHERE ActID='$id' ";
                              $r = mysqli_query($dbc, $q);

                              if (mysqli_affected_rows($dbc)!=1){
                                echo '<h1>Αποτυχία ενημέρωσης των availableTickets  !</h1>';
                                mysqli_query($dbc, "ROLLBACK");
                              }else {

                                  $q = "SELECT availableTickets FROM Activity WHERE (ActID='$id') ";
                                  $r = mysqli_query($dbc, $q);

                                  if (mysqli_num_rows($r)==1){
                                     $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
                                     
                                    $NewAvailable = $row['availableTickets'];
                                     if($NewAvailable >= 0 ){

                                          mysqli_free_result($r);
                                          $newPoints = $_SESSION['parent_points'] - ($ticket_count * $price); 

                                          $q = "UPDATE Parent SET Points='$newPoints' WHERE (ParEmail='$ParEmail') ";
                                          $r = mysqli_query($dbc, $q);

                                          if (mysqli_affected_rows($dbc)!=1){
                                            echo '<h1>Αποτυχία ενημέρωσης των πόντων  !!</h1>';
                                            mysqli_query($dbc, "ROLLBACK");
                                          }else {
                                            

                                              date_default_timezone_set("Europe/Athens");
                                              $d=strtotime("now");
                                              $d = substr(date("Y-m-d H:i:sa", $d), 0, -2) ;
                                              $totalCost= $ticket_count * $price;

                                              $q = "INSERT INTO Sell values(NULL,'$ParEmail','$id', '$d', '$ticket_count', '$totalCost')";
                                              $r = mysqli_query($dbc, $q);

                                              if (mysqli_affected_rows($dbc)==1){
                                                //SUCCESS !!!!!!
                                                    if($NewAvailable == 0) //update ES doc
                                                    { 
                                                         require_once('full_text_search.php');
                                                         update_avail_tickets_to_false($id);
                                                    }
                                                    
                                                    //header("location: parentSignedInHomePage.php");
                                                    require('./utilities.php');

                                                    $ticket_ids = array();
                                                    for($x = 0; $x < $ticket_count; $x++) {
                                                        $ticket_ids[$x] = $maxTickets - $NewAvailable - $x;
                                                        // echo $ticket_ids[$x];
                                                        // echo "<br>";
                                                    }

                                                   $pdf = create_pdf_from_ticket( $_SESSION['parent_lastname'] . ' ' .  $_SESSION['parent_firstname'], $actName , $ticket_ids);
                                                   $subject= "KidsUp";
                                                   $to = $_SESSION['login_user'];
                                                   send_ticket_with_email($to,$subject,$pdf);

                                                   mysqli_query($dbc, "COMMIT");
                                                    mysqli_close($dbc); 

                                                    $_SESSION['parent_points'] = $newPoints;

                                                   // echo "<script> window.alert(\"Η αγορά ολοκληρώθηκε !!! \\n Σας έχει αποσταλεί email\"); window.location.href='index.php';</script>";

                                                   echo "<script> window.alert(\"Η αγορά ολοκληρώθηκε !!! \\n Σας έχει αποσταλεί email\"); window.close();</script>";

                                              }else{
                                                echo '<h1>Can\'t insert in Sell !!</h1>';
                                                 mysqli_query($dbc, "ROLLBACK");
                                              }
 
                                          }

                                     }else {
                                      echo '<h1>Κάποιος πρόλαβε τα τελευταία εισητήρια !!</h1>';
                                      mysqli_query($dbc, "ROLLBACK");
                                     }

                                  }else{
                                      echo '<h1>Αποτυχία διαβάσματος των availableTickets  !</h1>';
                                      mysqli_query($dbc, "ROLLBACK");
                                  }

                              }

                          //mysqli_close($dbc);
                        }
  
                    }
                    

              ?>



                <img class="card-img-top" src= <?php echo $pictureURL; ?> alt="">
                <div class="card-body">
                  <h4 class="card-title">
                    <p class="card-text"><b><u>Δραστηριότητα: </u></b><?php echo $actName; ?> </p>
                  </h4>
                  <p class="card-text"><b><u>Τιμή εισιτηρίου:</u></b> <?php echo $price; ?> </h5></p>
                  <p class="card-text"><b><u>Τύπος:</u></b> <?php echo $actType; ?> </p>
                  <p class="card-text"><b><u>Ημερομηνία-Ώρα:</u></b> <?php echo $actDate; ?> </p>
                  <p class="card-text"><b><u>Ελάχιστη Ηλικία:</u></b> <?php echo $MinAge; ?> </p>
                  <p class="card-text"><b><u>Μέγιστη  Ηλικία:</u></b> <?php echo $MaxAge; ?> </p>
                  <p class="card-text"><b><u>Διαθέσιμα Εισιτήρια:</u></b> <?php echo $availableTickets; ?> </p>
                  <p class="card-text"><b><u>Πόλη:</u></b> <?php echo $town; ?> </p>
                  <p class="card-text"><b><u>Οδός:</u></b> <?php echo $streetName; ?> </p>
                  <p class="card-text"><b><u>Αριθμός:</u></b> <?php echo $streetNumber; ?> </p>
                  <p class="card-text"><b><u>Τηλέφωνο:</u></b> <?php echo $PhoneNumber; ?> </p>
                  <p class="card-text"><b><u>Ταχυδρομικός Κώδικας:</u></b> <?php echo $PostalCode; ?> </p>
                  <p class="card-text"><b><u>Επισκέφτηκε:</u></b> <?php echo $visits; ?> Φορές </p>
                  <p class="card-text"><b><u>Σύντομη Περιγραφή:</u></b> <?php echo $actDescription; ?> </p>
                </div>
                <div class="card-body">

                          <script>

                            function calculateTotal()
                            {

                                var divobj = document.getElementById('totalPrice');
                                var count = document.getElementById('count').value;
                                var available = (<?php echo $availableTickets; ?>) ;
                                divobj.style.display='block';
                                divobj.innerHTML = "Total Price: "+ (<?php echo $price; ?> * count )+" Points";
                                if( count > available){
                                  $(":submit").prop('disabled', true);
                                  window.alert("There aren't so many available tickets !!!");
                                }
                                else $(":submit").prop('disabled', false);

                            }

                            function check_points() {
                                //document.write("Help >>>");
                                var count = document.getElementById('count').value;
                                var points = <?php echo $Points; ?>;
                                var total =  count * <?php echo $price; ?>;

                                if( points < total){
                                  window.alert("Not enough points !!!");
                                  return false; // return false to cancel form action
                                }
                                return true; 
                            };

                          </script>

                          <form action="buyTicket.php" id = "myform" method="post" onsubmit="return check_points()">
                              <div class="col-sm-8 form-group">
                                <input type="number" name='number' onchange="calculateTotal()"  onkeyup="calculateTotal()" id="count"  min = "1" placeholder="Εισιτήρια" class="form-control" required>
                              </div>

                              <?php  if (isset($_SESSION['login_user']))  echo " <div id=\"totalPrice\">Total Price: 0</div><br> ";
                                     else echo '<b><u><span style="color:#FF0000 ;text-align:center;">Συνδεθείτε για να αγοράσετε εισιτήρια!</span></u></b>'; 
                              ?>

                              <input id="ActId" name='ActId' type = "hidden" value = <?php echo $id; ?> > </input>
                              <input type="submit" id="submit" class="btn btn-sm btn-info" value="Αγορά Εισιτηρίων" ></input>
                                                              
                          </form>
                          <?php 
                                if (!isset($_SESSION['login_user'])) {
                                  echo "<script> document.getElementById('submit').style.display = 'none'; </script> "; 
                                  echo "<script> document.getElementById('count').type = 'hidden'; </script> ";  
                                }
                          ?> 

                </div>

            </div>
  </div>




  <!-- <h3>Εισιτήριο</h3> -->
  <div class="col-lg-4 col-md-6 col-xs-12" style="float:left;" id="map"></div>
  <script>
      function initMap() {
        var uluru = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 12,
          center: uluru
        });
        var marker = new google.maps.Marker({
          position: uluru,
          map: map
        });
      }
    </script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsLUCKMjlmcDrvL6IXYlaHez6AUb01O8U&callback=initMap">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>



  </body>

      <!-- Footer -->
  <footer class="custom py-5 bg-dark">
    <div class="footer container">
        <b>Team 42</b> -
        SoftEng Project 2017 -
        NTUA
    <p class="m-0 text-center text-white">Copyright &copy; KidsUp 2017</p>
    </div>
  </footer>

</html>