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
      <li class="nav-item">
        <a class="nav-link" href="profile.php">Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.patreon.com/zniti" target="_blank"><i class="fab fa-patreon"></i></a>
      </li>
    </ul>
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


<?php

require('config.php');
require('class.php');

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $user = new USER();

  // récupérer le nom d'utilisateur et supprimer les antislashes ajoutés par le formulaire
  $user->username = stripslashes($_REQUEST['username']);
  $user->username = mysqli_real_escape_string($conn, $user->username);
  // récupérer l'email et supprimer les antislashes ajoutés par le formulaire
  $user->email = stripslashes($_REQUEST['email']);
  $user->email = mysqli_real_escape_string($conn, $user->email);
  // récupérer le mot de passe et supprimer les antislashes ajoutés par le formulaire
  $user->password = stripslashes($_REQUEST['password']);
  $user->password = mysqli_real_escape_string($conn, $user->password);

  $user->firstname = stripslashes($_REQUEST['firstname']);
  $user->firstname = mysqli_real_escape_string($conn, $user->firstname);

  $user->lastname = stripslashes($_REQUEST['lastname']);
  $user->lastname = mysqli_real_escape_string($conn, $user->lastname);

  $user->photo = stripslashes($_REQUEST['photo']);
  $user->photo = mysqli_real_escape_string($conn, $user->photo);


  //requéte SQL
    $query = "INSERT into user (username, password, email, firstname, lastname, photo)
              VALUES ('$user->username', '$user->password', '$user->email', '$user->firstname' , '$user->lastname' , '$user->photo')";
  // Exécuter la requête sur la base de données
    $res = mysqli_query($conn, $query);
    if($res){
      header("Location: login.php");
    }
}else{
?>
<div class="form-container">
<form class="text-center border border-light p-5" action="" method="post">
    <h1>Register !</h1>
    <input type="text" class="form-control mb-4" name="firstname" placeholder="First name" required />
    <input type="text" class="form-control mb-4" name="lastname" placeholder="Last name" required />
    <input type="text" class="form-control mb-4" name="username" placeholder="Username" required />
    <input type="email" class="form-control mb-4" name="email" placeholder="Email" required />
    <input type="password" class="form-control mb-4" name="password" placeholder="Password" required />
    <input type="text" class="form-control mb-4" name="photo" placeholder="Photo" required />
    <input type="submit" name="submit" value="Register" class="btn btn-outline-dark btn-block my-4" />
    <p class="box-register">Already a user? <a href="login.php">Login here!</a></p>


</div>
<?php } ?>
</body>
</html>
