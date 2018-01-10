<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>KidsUp</title>
    <link rel="shortcut icon" type="image" href="./img/favicon.ico"/>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template -->
    <!-- <style>
      body {
        padding-top: 80px;
        font-family: 'Lato', 'Helvetica Neue', Helvetica, Arial, sans-serif;
      }
    </style> -->
    <link href="css/TicketCSS.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
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
              <a class="nav-link" href="index.php">Έξοδος</a>
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
			<li class="nav-item">
				<a class="nav-link" href="parentProfile.php">Όνομα Επώνυμο<br>Πόντοι:</a>
            </li>
          </ul>
        </div>
      </div>
    </nav> -->

    <!-- Page Content -->



	<div class="col-lg-4 col-md-6 mb-4" style="float:left;" id="ticket">
              <div class="card h-100">
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="eventClicked.php">Item One</a>
                  </h4>
                  <h5>Τιμή εισιτηρίου:$24.99</h5>
                  <p class="card-text">Οργανωτής:Το πράσινο αερόστατο</p>
                  <p class="card-text">Πόλη: Αθήνα, Δήμος: Περιστέρι</p>
                  <p class="card-text">Διεύθυνση: Ανθέων 14</p>
                  <p class="card-text">Σύντομη περιγραφή:Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                  <p class="card-text"><b>Αριθμός εισιτηρίων: 4</b></p>
                  <p class="card-text"><b>Συνολική τιμή: 119.96 $ </b></p>
                  <p class="card-text"><b>Ημερομηνία διεξαγωγής: 25/1/18</b></p>
                </div>

              </div>
  </div>

  <!-- <h3>Εισιτήριο</h3> -->
  <div class="col-lg-4 col-md-6 col-xs-12" style="float:left;" id="map"></div>
  <script>
      function initMap() {
        var uluru = {lat: 37.98722, lng: 23.72750};
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
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
