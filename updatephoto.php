<?php
  // Initialiser la session
  session_start();
  // Vérifiez si l'utilisateur est connecté, sinon redirigez-le vers la page de connexion
  if(!isset($_SESSION["username"])){
    header("Location: login.php");
    exit();
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Zniti Blog</title>
  <!-- Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
<!-- Google Fonts -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
<!-- Material Design Bootstrap -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.18.0/css/mdb.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Permanent+Marker&display=swap" rel="stylesheet">
<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.18.0/js/mdb.min.js"></script>
  <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark lighten-5">
  <a class="navbar-brand" href="index.php">ZNITI</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText"
    aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.patreon.com/zniti" target="_blank"><i class="fab fa-patreon"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto nav-flex-icons">
      <li class="nav-item avatar">
        <a class="nav-link p-0" href="profile.php">
          <?php
           echo '<img src="' . $_SESSION["photo"] . '" class="rounded-circle z-depth-0" alt="avatar image" height="35">';
          ?>

        </a>
      </li>
    </ul>&nbsp&nbsp&nbsp
    <span class="navbar-text white-text">
          <?php




        if(!isset($_SESSION["username"])){

          echo '<a href="login.php">Sign in</a>';

        }else {
          echo '<a href="logout.php">Sign out</a>';
        }
      ?>
    </span>
  </div>
</nav>


<div class="container">
<div class="row inputs">

  <div class="form-container">
  <form class="text-center border border-light p-5" action="" method="post">

  <h1>Update photo!</h1>

    <input type="text" class="form-control mb-4" name="photo" placeholder="New photo" required />
    <input type="submit" name="submit" value="Update !" class="btn btn-outline-dark btn-block my-4 " />
    </form>
  </div>

  <?php


  require('class.php');
  require('config.php');

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = new USER();

    $user->photo = stripslashes($_REQUEST['photo']);
    $user->photo = mysqli_real_escape_string($conn, $user->photo);

    $user->ChangePhoto($_GET['id'], $user->photo ,$conn);



    }

  ?>

</div>
</div>


  </body>
</html>
