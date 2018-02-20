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


    <!-- Custom styles for this template -->
    <link href="../assets/css/homepage.css" rel="stylesheet">

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
<?php
  include("mysqli_connect.php");
  mb_internal_encoding('UTF-8');
  mb_http_input("utf-8");
  session_start();
  if(!isset($_SESSION['login_user'])){
?>
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
<?php 
  }else{
    $user_check = $_SESSION['login_user'];
    $firstname = $_SESSION['parent_firstname'];
    $lastname = $_SESSION['parent_lastname'];
    $Points = $_SESSION['parent_points'];
    $town = $_SESSION['parent_town'];
    $streetName = $_SESSION['parent_street'];
    $streetNumber = $_SESSION['parent_street_num'];
?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">Έξοδος</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="parent_profile.php"><?php echo $firstname . ' ' . $lastname; ?><br>Πόντοι: <?php echo $Points; ?></a>
            </li>
<?php
  } 
?>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->

    <!-- Masthead -->
      <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container">
          <div class="row">
            <div class="col-xl-9 mx-auto">
              <h1 class="mb-5">Αναζητήστε δραστηριότητες για τα παιδιά σας!</h1>
            </div>
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
              <form action="./search_activities.php" method="post">
                <div class="form-row">
                  <div class="col-12 col-md-9 mb-2 mb-md-0" style="display: flex;flex-direction:row">
                    <input  type="search" name="search" class="form-control form-control-md" placeholder="Γράψτε τον όρο αναζήτησης...">
					          <input  type="search" name="area" class="form-control form-control-md" placeholder="Περιοχή"
                    <?php 
                      if(isset($_SESSION['login_user']))
											  echo "value="."\"".$streetName." ".$streetNumber." ".$town."\"";
									  ?>
                    >
                  </div>
                  <div class="col-12 col-md-3">
                    <button type="submit" class="btn btn-block btn-md btn-primary">Αναζήτηση</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </header>

    <div class="container mt-5">

          <div class="row">

<?php
    
  $sql = "SELECT * FROM Activity WHERE actDate >= CURDATE() AND availableTickets > 0";
  $result = mysqli_query($dbc,$sql);
  for($i=0; $i< mysqli_num_rows($result); $i++){
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      $datetime = explode(" ", $row['actDate']);
?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
              <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                  <a href="#" onclick="post_actid(<?php echo $row['ActID'] ?>);return false;">
										<?php echo $row['actName']?>
									</a>
                </h4>
                <h5>Τιμή εισιτηρίου: <?php echo $row['price']?> πόντοι</h5>
  		          <p class="card-text">Ημερομηνία: <?php echo $datetime[0]?></p>
	  	          <p class="card-text">Ώρα: <?php echo $datetime[1]?></p>
                <p class="card-text">Οργανωτής: <?php echo $row['ProvEmail']?></p>
		            <p class="card-text">Πόλη: <?php echo $row['town']?></p>
			          <p class="card-text">Διεύθυνση: <?php echo $row['streetName']?> <?php echo $row['streetNumber']?></p>
			          <p class="card-text">ΤΚ: <?php echo $row['PostalCode']?></p>
                <p class="card-text">
                  <?php
                    $descr = $row['actDescription']; 
                    $str = mb_substr($descr, 0, 100);
                    if(mb_strlen($descr, 'utf8') > 100)
                      $str = $str."...";
                    echo $str;                  
                  ?>
                </p>
              </div>
              <div class="card-footer">
                <small class="text-muted"><?php echo $row['visits']?> times visited</small>
              </div>
            </div>
          </div>
<?php
  }
?>              
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

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
		<script>
			function post_actid(id){
        var form = document.createElement("form");
        
        var elem = document.createElement("input"); 
        
        form.method = "POST";
        form.action = "buyTicket.php";   
    
        elem.value=id;
        elem.name="ActId";
    
        form.appendChild(elem);  
        document.body.appendChild(form);
    
        form.submit();            
			}
		</script>
  </body>

</html>
