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
    <link href="../assets/css/font-awesome.min.css" rel="stylesheet">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Custom styles for this template -->
    <link href="../assets/css/homepage.css" rel="stylesheet">
    <link href="../assets/css/search_sidebar.css" rel="stylesheet">

		<!-- external JS file containing initiate_filters() onload event listener (has to be loaded before entering body) -->
		<script src="../assets/js/search.js"></script>

		<style>
      #map {
        height: 300px;
				width: 98%;
				margin: auto;
				margin-bottom: 1rem;
       }
    </style>

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" id="logokidsup" href="index.php">KidsUp</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php" id="index">Αρχική
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="aboutus.php" id="about">Σχετικά με εμάς</a>
            </li>
<?php
ini_set('session.cache_limiter', 'private');
	include("full_text_search.php");
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
    $firstname = $_SESSION['parent_firstname'];
    $lastname = $_SESSION['parent_lastname'];
    $Points = $_SESSION['parent_points'];
?>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" id="logout">Έξοδος</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="parent-profile.php" id="profile"><?php echo $firstname . ' ' . $lastname; ?><br>Πόντοι: <?php echo $Points; ?></a>
            </li>
<?php
  } 
?>

          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->

<?php

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //first check if the index is created in ES and create it if necessary
		create_index();
		$page = 1; //default value
		$page_size = 6;
		$search = array();
		$search['search'] = trim($_POST['search']);
		$search['area'] = trim($_POST['area']);
		if(isset($_POST['age']))
			$search['age'] = trim($_POST['age']);
		else
			$search['age'] = NULL;
		if(isset($_POST['distance']))	
			$search['distance'] = trim($_POST['distance']);
		else
			$search['distance'] = NULL;
		if(isset($_POST['act_kind']))
			$search['act_kind'] = trim($_POST['act_kind']);
		else
			$search['act_kind'] = NULL;
		if(isset($_POST['interval']))
			$search['interval'] = trim($_POST['interval']);
		else
			$search['interval'] = NULL;
		if(isset($_POST['page']))
			$page = trim($_POST['page']);
		$search['from'] = ( $page - 1 ) * $page_size;
		$search['size'] = $page_size;

    $results = do_search($search);
		$activities = $results[0];
		$total_hits = $results[1];
		$hits = count($activities);
		$num_pages = ceil($total_hits / $page_size);
  }else{
		header('Location: index.php');
	}

?>

    <!-- Masthead -->
    <header>
<div class="container" <?php if(isset($_SESSION['login_user'])){?> style="margin-top:2rem" <?php } ?>>
          <p>
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
              <div class="form-row">
                <div class="col-12 col-md-9 mb-2 mb-md-0" style="display: flex;flex-direction:row">
								<input  type="search" name="search" class="form-control form-control-md" placeholder="Γράψτε τον όρο αναζήτησης..."
									<?php if($_POST['search'] != NULL)
													echo "value="."\"".$_POST['search']."\"";
									?>
								>
								<input  type="search" name="area" class="form-control form-control-md" placeholder="Περιοχή"
									<?php if($_POST['area'] != NULL)
													echo "value="."\"".$_POST['area']."\"";
									?>
								>
								<p id="area_coord" hidden>
									<?php
										if($_POST['area'] != NULL)
											echo implode(",", get_coordinates($_POST['area']));
									?>
								</p>
                </div>
                <div class="col-12 col-md-3">
                  <button id="search_button" class="btn btn-block btn-md btn-primary">Αναζήτηση</button>
                </div>
              </div>
            </div>
        </p>
    </div>
    </header>

<div class="container-fluid">
		
    <div class="row">
			<div id="map">
			</div>
		</div>

    <div class="row">
		<div class="col-xs-6 col-sm-3">
			<div id="accordion" class="panel panel-primary behclick-panel">
				<div class="panel-heading">
					<h3 class="panel-title">Φίλτρα Αναζήτησης</h3>
					<div id="curr_filters" style="color:grey">
						<p>Εφαρμ. Φίλτρα:</p>
				  </div>	
				</div>
				<div class="panel-body">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#age">
								<i class="indicator fa fa-caret-down" aria-hidden="true"></i> Ηλικία
							</a>
						</h4>
					</div>
					<div id="age" class="panel-collapse collapse in" >
						<ul class="list-group">
							<li class="list-group-item">
								<div class="radio" >
									<label>
										<input type="radio" name="age_radio" value="1,3">
										1-3 έτη
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="age_radio" value="3,6">
										3-6 έτη
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="age_radio" value="6,12">
										6-12 έτη
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="age_radio" value="12,15">
										12-15 έτη
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="age_radio" value="15,17">
										15-17 έτη
									</label>
								</div>
							</li>
						</ul>
					</div>

					<div class="panel-heading " >
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#distance">
								<i class="indicator fa fa-caret-down" aria-hidden="true"></i> Απόσταση από Τοποθεσία
							</a>
						</h4>
					</div>
					<div id="distance" class="panel-collapse collapse in" >
						<ul class="list-group">
							<li class="list-group-item">
								<div class="radio">
									<label>
										<input type="radio" name="distance_radio" value="1">
										1km
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio" >
									<label>
										<input type="radio" name="distance_radio" value="5">
										5km
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="distance_radio" value="10">
										10km
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="distance_radio" value="50">
										50km
									</label>
								</div>
							</li>
						</ul>
					</div>
					<div class="panel-heading" >
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#act_kind"><i class="indicator fa fa-caret-down" aria-hidden="true"></i> Είδος Δραστηριότητας</a>
						</h4>
					</div>
					<div id="act_kind" class="panel-collapse collapse in">
						<ul class="list-group">
							<li class="list-group-item">
								<div class="radio">
									<label>
										<input type="radio" name="act_kind_radio" value="Ποδόσφαιρο">
										Ποδόσφαιρο
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio" >
									<label>
										<input type="radio" name="act_kind_radio" value="Μπάσκετ">
										Μπάσκετ
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="act_kind_radio" value="Κολύμβηση">
										Κολύμβηση
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="act_kind_radio" value="Μουσική">
										Μουσική
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="act_kind_radio" value="Χορός">
										Χορός
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="act_kind_radio" value="Θέατρο">
										Θέατρο
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="act_kind_radio" value="Παιδικό Πάρτυ">
										Παιδικό Πάρτυ
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio"  >
									<label>
										<input type="radio" name="act_kind_radio" value="Γενικού Τύπου">
										Άλλο
									</label>
								</div>
							</li>
						</ul>
					</div>
					<div class="panel-heading" >
						<h4 class="panel-title">
							<a data-toggle="collapse" href="#interval"><i class="indicator fa fa-caret-down" aria-hidden="true"></i> Χρονικό Διάστημα</a>
						</h4>
					</div>
					<div id="interval" class="panel-collapse collapse">
						<ul class="list-group">
							<li class="list-group-item">
								<div class="radio">
									<label>
										<input type="radio" name="interval_radio" value="1d">
										1 μέρα
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio" >
									<label>
										<input type="radio" name="interval_radio" value="10d">
										10 μέρες
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio">
									<label>
										<input type="radio" name="interval_radio" value="30d">
										1 μήνας
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio" >
									<label>
										<input type="radio" name="interval_radio" value="90d">
										3 μήνες
									</label>
								</div>
							</li>
							<li class="list-group-item">
								<div class="radio" >
									<label>
										<input type="radio" name="interval_radio" value="180d">
										6 μήνες
									</label>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	<!--/div-->
<!--/div-->

					<div class="col-xs-6 col-sm-9">

						<div class="row" id="activities">

<?php

  for($i=0; $i<$hits; $i++){
    $datetime = explode(" ", $activities[$i]['actDate']);
    ?>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card h-100">
	            <a href="#" onclick="post_actid(<?php echo $activities[$i]['ActID'] ?>);return false;"><img class="card-img-top" src= <?php echo $activities[$i]['pictureURL']; ?> alt=""></a>
                <div class="card-body">
                  <h4 class="card-title">
										<a href="#" onclick="post_actid(<?php echo $activities[$i]['ActID'] ?>);return false;">
											<?php echo $activities[$i]['actName']?>
										</a>
									</h4>
                  <h5>Τιμή εισιτηρίου: <?php echo $activities[$i]['price']?> πόντοι</h5>
				  <p class="card-text">Ημερομηνία: <?php echo $datetime[0]?></p>
				  <p class="card-text">Ώρα: <?php echo $datetime[1]?></p>
                  <p class="card-text">Οργανωτής: <?php echo $activities[$i]['ProvEmail']?></p>
				  <p class="card-text">Πόλη: <?php echo $activities[$i]['town']?></p>
				  <p class="card-text">Διεύθυνση: <?php echo $activities[$i]['streetName']?> <?php echo $activities[$i]['streetNumber']?></p>
				  <p class="card-text">ΤΚ: <?php echo $activities[$i]['PostalCode']?></p>

                  <p class="card-text">
										<?php
                      $descr = $activities[$i]['actDescription']; 
                      $str = mb_substr($descr, 0, 100);
                      if(mb_strlen($descr, 'utf8') > 100)
                        $str = $str."...";
                      echo $str;                  
                    ?>
									</p>
									<p class="card-text" hidden><?php echo $activities[$i]['latitude'].','.$activities[$i]['longitude']?></p>
								</div>
                <div class="card-footer">
                  <small class="text-muted"><?php echo $activities[$i]['visits']?> times visited</small>
                </div>
              </div>
            </div>
<?php
  }
?>              
      </div>
						<!-- row -->

      <div class="row" id="pagination">
        <nav aria-label="Search results pages" style="margin: auto;">
          <ul class="pagination">
            <li class="page-item <?php if($page == 1) {echo "disabled";}?>">
              <a class="page-link" href="#" onclick="submit_form(1); return false;">
                Previous
              </a>
            </li>
<?php
          for($i=1; $i <= $num_pages; $i++){
?>          
            <li class="page-item <?php if($i == $page) {echo "active";}?>">
              <a class="page-link" href="#" onclick="submit_form(<?php echo $i;?>); return false;">
                <?php
                  echo $i;
                ?>
              </a>
            </li>
<?php
          }
?>
            <li class="page-item <?php if($page == $num_pages) {echo "disabled";}?>">
              <a class="page-link" href="#" onclick="submit_form(<?php echo $num_pages;?>); return false;">
                Next
              </a>
            </li>
          </ul>
        </nav>
      </div>
				
				</div>	
				<!-- col-->
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
		<!--script src="../assets/js/search.js"--><!--/script-->
		<script src="../assets/js/create_map.js"></script>

	<?php
		if($search['area'] != NULL && $search['area'] != ""){
	?>	
    <script async defer
    	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBsLUCKMjlmcDrvL6IXYlaHez6AUb01O8U&callback=initMap">
				document.getElementById('map').style.display = 'initial';
    </script>
	<?php
		}else{
	?>		
			<script>
				document.getElementById('map').style.display = 'none';
			</script>
	<?php		
		}
	?>

	<?php 
		if($num_pages == 0){
	?>	
		<script>
			document.getElementById('pagination').style.display = 'none';
		</script>
	<?php
		}else{
	?>
		<script>
			document.getElementById('pagination').style.display = 'initial';
		</script>
	<?php
		}
	?>
	
		<script>
			document.body.addEventListener("load", initiate_filters());
			document.getElementById("search_button").addEventListener("click", function(){submit_form(1);});
			document.getElementById("age").addEventListener("change", function(){submit_form(1);});
			document.getElementById("distance").addEventListener("change", function(){submit_form(1);}); 
			document.getElementById("act_kind").addEventListener("change", function(){submit_form(1);}); 
			document.getElementById("interval").addEventListener("change", function(){submit_form(1);});
			document.getElementById("logokidsup").addEventListener("click", function(){remove_cookies(); return true;});
			document.getElementById("index").addEventListener("click", function(){remove_cookies(); return true;});
			document.getElementById("about").addEventListener("click", function(){remove_cookies(); return true;});
			if(document.getElementById("logout")!=null){			
				document.getElementById("logout").addEventListener("click", function(){remove_cookies(); return true;});
				document.getElementById("profile").addEventListener("click", function(){remove_cookies(); return true;});
			}
	  </script>
		<script>
			function post_actid(id){
        var form = document.createElement("form");
        
        var elem = document.createElement("input"); 
        
        form.method = "POST";
        form.action = "buyTicket.php"; 
        form.style.display='none';  
        form.setAttribute("target","_blank");
    
        elem.value=id;
        elem.name="ActId";
    
        form.appendChild(elem);  
        document.body.appendChild(form);
    
        form.submit();            
			}
		</script>
  </body>

</html>
