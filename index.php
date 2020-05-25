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
  <!-- Font Awesome -->
  <title>Zniti Blog</title>
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
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
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
          require('config.php');
          require('class.php');

              $sql = "SELECT * FROM user WHERE id = '{$_SESSION[ "id" ]}'";
              $result = $conn->query($sql);
              $row = $result->fetch_assoc();

           echo '<img src="' . $row["photo"] . '" class="rounded-circle z-depth-0" alt="avatar image" height="35">';
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

  <?php
  if(isset($_GET['update'])){
  $id = $_GET["update"];


  $sql = "SELECT * FROM todolist WHERE id = '$id'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
   ?>

   <div class="form-container">

       <form class="text-center border border-light p-5" action="" method="post" name="update">
         <h1>Edit to do list!</h1>
         <input type="text" class="form-control mb-4" name="name" value="<?php echo $row['name']; ?>" required>
         <input type="hidden" name="id" class="input" value="<?php echo $id; ?>"  >
         <select class="browser-default custom-select" name="color" required>
           <option disabled selected>Choose your color</option>
           <option value="#42a5f5">blue</option>
           <option value="#66bb6a">green</option>
           <option value="#ef5350">red</option>
           <option value="#ffa726">orange</option>
         </select><br>
         <input type="submit" value="Edit" name="update" class="btn btn-outline-dark btn-block my-4">
       </form>
   </div>

<?php } else { ?>

  <div class="form-container">

      <form class="text-center border border-light p-5" action="" method="post" name="addtodolist">
        <h1>Add to do list!</h1>
        <input type="text" class="form-control mb-4" name="name" placeholder="Name" required>
        <select class="browser-default custom-select" name="color" required>
          <option value="" disabled selected>Choose your color</option>
          <option value="#42a5f5">blue</option>
          <option value="#66bb6a">green</option>
          <option value="#ef5350">red</option>
          <option value="#ffa726">orange</option>
        </select><br>
        <input type="submit" value="Add list" name="submit" class="btn btn-outline-dark btn-block my-4">
        <?php if (! empty($message)) { ?>
        <p class="errorMessage"><?php echo $message; ?></p>
        <?php } ?>
      </form>
  </div>

  <?php

      } ?>
</div>
  <?php

if (isset($_GET['del'])) {

  $todolist= new TODOLIST();
  $todolist->id = $_GET['del'];

  $res = $todolist->DeleteToDoList($conn);

}

if(isset($_POST["submit"])) {

  $todolist = new TODOLIST();

  $todolist->name = stripslashes($_REQUEST['name']);
  $todolist->name = mysqli_real_escape_string($conn, $todolist->name);

  $todolist->color = stripslashes($_REQUEST['color']);
  $todolist->color = mysqli_real_escape_string($conn, $todolist->color);

  $todolist->user_id = $_SESSION['id'];




  $query = "INSERT into todolist (name, color, user_id)
  VALUES ('$todolist->name', '$todolist->color', '$todolist->user_id')";

  $res = mysqli_query($conn, $query);

  }

?>


<!-- update -->
<?php

if(isset($_POST["update"])){
  $todolist = new TODOLIST();

$todolist->id = $_POST['id'];


$todolist->name = stripslashes($_REQUEST['name']);
$todolist->name = mysqli_real_escape_string($conn, $todolist->name);

$todolist->color = stripslashes($_REQUEST['color']);
$todolist->color = mysqli_real_escape_string($conn, $todolist->color);



  $todolist->UpdateToDolist($todolist->id,$todolist->name,$todolist->color,$conn);
}


?>
<!-- end update -->

<div class="todos-container row">




<?php
$sql = "SELECT * FROM todolist WHERE user_id = '{$_SESSION[ "id" ]}'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
$i = 1;

while($row = $result->fetch_assoc()) {

    ?>

            <div class="todos col-md-3" style="background-color:<?php echo $row['color'] ?>;">
                <span class="cornersleft"> <a href="index.php?update=<?php echo $row['id'] ?>"><i class="far fa-edit"></i></a> </span>
                <span><a href="tasks.php?idtask=<?php echo $row['id']; ?>"> <?php echo $row['name']; ?></a> </span>
                <span  class="cornersright"><a href="index.php?del=<?php echo $row['id'] ?>"><i class="far fa-trash-alt"></i></a></span>
            </div>



    <?php
    $i++;
  }
}
?>
</div>



</div>

  </body>
</html>
