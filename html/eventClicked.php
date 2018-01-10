<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Δραστηριότητα</title>
    <link rel="shortcut icon" type="image" href="../assets/img/favicon.ico"/>

    <!-- Bootstrap core CSS -->
    <link href="../assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- Custom styles for this template -->
    <link href="../assets/css/eventCss.css" rel="stylesheet">

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
            <li class="nav-item">
              <a class="nav-link" href="index.php">Έξοδος</a>
            </li>
			<li class="nav-item">
				<a class="nav-link" href="parentProfile.php">Όνομα Επώνυμο<br>Πόντοι:</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->



	<div class="col-lg-4 col-md-6 mb-4" style="float:left;" >
              <div class="card h-100">
                <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
                    <a href="eventClicked.php">Item One</a>
                  </h4>
                  <h5>Τιμή εισητηρίου:$24.99</h5>
				  <p class="card-text">Οργανωτής:Το πράσινο αερόστατο</p>
				  <p class="card-text">Πόλη: Αθήνα, Δήμος: Περιστέρι</p>
				  <p class="card-text">Διεύθυνση: Ανθέων 14</p>
                  <p class="card-text">Σύντομη περιγραφή:Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur!</p>
                </div>

              </div>
	</div>
	<div class="col-lg-4 col-md-6 mb-4" style="float:left;">
		Plirofories kahsfiulsadkhjgnsujkldg,bnsd,jkgnhs.lkfndjgl.
		Vale kai xarti mia teleutaia fora na kserei pou na paei
		Διαθέσιμα εισιτήρια:\\\\\
		<form action="buyTickets.php">
		Εισητήρια:<input type="text" required></input>
		<p><input type="submit" value="Αγορά" ></input></p>

		</form>
	</div>
	<div style="float:left;">
		Google Map
  </div>
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
	<div style="clear:both;"></div>


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
