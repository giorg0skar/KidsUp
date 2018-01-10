<!DOCTYPE html>
<html lang="en">

  <head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Νέα Δραστηριότητα</title>
  <link rel="shortcut icon" type="image" href="../assets/img/favicon.ico"/>

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
        <a class="nav-link" href="parentProfile.php">Όνομα παρόχου ή εταιρείας</a>
      </li>
      </ul>
    </div>
    </div>
  </nav>




 <div class="my-container container">
    <div class="row mb-4">
      <div class="col-lg-12 well ">
        <h1 align=left>Φόρμα Εισαγωγής Δραστηριότητας</h1>
      </div>
    </div>
    <div class="row">
    <div class="col-lg-12 well">
          <div class="row">
          <form action="parentProfile.php">
            <div class="col-sm-12">
              <div class="form-group">
                  <input type="text" placeholder="Τίτλος Δραστηριότητας" class="form-control" required>
              </div>
              <div class="form-group">
                  <label for="exampleFormControlSelect1">Είδος Δραστηριότητας:</label>
                  <select class="form-control" id="exampleFormControlSelect1">
                  <option selected="">Μουσική</option>
                  <option>Άθλημα</option>
                  <option>Θέατρο</option>
                  <option>Παιδικό Πάρτυ</option>
                  <option>Άλλο</option>
                  </select>
              </div>
              <div class="row">
                <div class="col-sm-5 form-group">
                  <input type="text" placeholder="Πόλη Δραστηριότητας" class="form-control" required="true">
                </div>
                <div class="col-sm-4 form-group">
                  <input type="text" placeholder="Οδός Δραστηριότητας" class="form-control" required>
                </div>
                <div class="col-sm-3 form-group">
                  <input type="number" min = "1" placeholder="Αριθμός οδού " class="form-control" required>
                </div>
              </div>

              <div class="row">
                &nbsp;&nbsp;&nbsp;
                <label for="age1">Ηλικία Από:</label>
                <div class="col-sm-4 form-group">
                  <input type="text" type="number" min = "1" id="age1" placeholder="Ελάχιστη" class="form-control" required="true">
                </div>
                <label for="age2">Έως:</label>
                <div class="col-sm-4 form-group">
                  <input type="text" type="number" max = "18" id="age2" placeholder="Μέγιστη" class="form-control" required>
                </div>
              </div>

              <div class="row">
                  &nbsp;&nbsp;&nbsp;
                  <label for="example-date-input" class="col-xs-3 control-label">Date:</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="date" value="2017-08-19" id="example-date-input">
                    </div>
                  <label for="example-time-input" class="col-xs-3 control-label">Time:</label>
                  <div class="col-sm-4">
                    <input class="form-control" type="time" value="13:45:00" id="example-time-input">
                  </div>
              </div>
              <br>

              <div class="form-group">
				<div class="row">
					<div id="dv1" class="col-xs-3">
						&nbsp;
						&nbsp;
						Price:
						<input type="number" step="any" min = "1" id="txtPassportNumber" required/>Πόντοι
					</div>
					<div id="dv1" class="col-xs-3">
						&nbsp;
						&nbsp;
						Available Tickets:
						<input type="number" min = "1" id="txtPassportNumber" required/>
					</div>
				</div>
            </div>

            <div class="form-group">
				<label for="exampleFormControlFile1">Φωτογραφία Δραστηριότητας:</label>
				<input type="file" class="form-control-file" id="exampleFormControlFile1" required>
            </div>
            <div class="form-group">
               <label for="exampleFormControlTextarea1">Περιγραφή</label>
               <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" required></textarea>
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
