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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js" charset="utf-8"></script>
  <link rel="stylesheet" href="css/style.css" />
  <script src="script.js" charset="utf-8"></script>
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


  $sql = "SELECT * FROM task WHERE id = '$id'";
        $result = $conn->query($sql);

        $row = $result->fetch_assoc();
   ?>

   <div class="form-container">

       <form class="text-center border border-light p-5" action="" method="post" name="edittask">
         <h1>Edit task!</h1>
         <input type="text" class="form-control mb-4" name="tasktext" value="<?php echo $row['taskText']; ?>" required>
         <input type="hidden" name="id" value="<?php echo $id; ?>"  >
         <input type="submit" value="Edit" name="edittask" class="btn btn-outline-dark btn-block my-4">
       </form>
   </div>

<?php } else { ?>

  <div class="form-container">

      <form class="text-center border border-light p-5" action="" method="post" name="addtask">
        <h1>Add task!</h1>
        <input type="text" class="form-control mb-4" name="tasktext" placeholder="task" required>
        <input type="hidden" name="idtask" class="input" value="<?php echo $_GET['idtask']; ?>"  >
        <input type="submit" value="Add task" name="addtask" class="btn btn-outline-dark btn-block my-4">
        <?php if (! empty($message)) { ?>
        <p class="errorMessage"><?php echo $message; ?></p>
        <?php } ?>
      </form>
  </div>

  <?php

      } ?>
</div>
      <?php


    if (isset($_GET['deltask'])) {

        $task = new TASK();
        $task->id = $_GET['deltask'];

        $res = $task->DeletTask($conn,$id);

      }


    if(isset($_POST["addtask"])) {

    $idtask = $_POST['idtask'];

    $task = new TASK();

    $task->taskText = stripslashes($_REQUEST['tasktext']);
    $task->taskText = mysqli_real_escape_string($conn, $task->taskText);

    $task->done = FALSE;

    $query = "INSERT into task (taskText, done, todolist_id)
    VALUES ('$task->taskText', '$task->done', '$idtask')";

    $res = mysqli_query($conn, $query);

    header("Location: tasks.php?idtask=$idtask");



    }

    ?>

<!-- update -->
<?php

if(isset($_POST["edittask"])){
    $task = new TASK();

  $task->id = $_POST['id'];


  $task->name = stripslashes($_REQUEST['tasktext']);
  $task->name = mysqli_real_escape_string($conn, $task->name);



    $task->ChangeTaskText($conn);
}


?>
<!-- end update -->


<table class="table">

    <thead class="black white-text">
        <tr>
            <th class="tasktableleft" scope="col">Done</th>
            <th scope="col">Tasks</th>
            <th scope="col">Edit</th>
            <th class="tasktableright" scope="col" style="width: 60px;">Delete</th>
        </tr>
    </thead>

    <tbody>

<?php
$sql = "SELECT * FROM task WHERE todolist_id = '{$_GET["idtask"]}'";
$result = $conn->query($sql);


$i = 1;
while($row = $result->fetch_assoc()) {

    ?>



            <tr style="background-color:<?php echo $row['color'] ?>;">

                <td><input name="<?php echo $row['id'] ?>" class="checkboox" id="check" onclick="cheeck('1','<?php echo $row['id'] ?>')" type="checkbox" value="<?php echo $row['done'] ?>" ></td>
                <td><p class="text"> <?php echo $row['taskText']; ?></p> </td>
                <td  scope="row"> <a href="tasks.php?update=<?php echo $row['id'] ?>&idtask=<?php echo $_GET["idtask"] ?>"><i class="far fa-edit"></i></a> </td>
                <td>
                    <a href="tasks.php?deltask=<?php echo $row['id'] ?>&idtask=<?php echo $_GET["idtask"] ?>"><i class="far fa-trash-alt"></i></a>
                </td>
            </tr>

    <?php
    $i++;
  }

?>
    </tbody>
</table>



</div>

<!-- script valid -->
<script>
var checkBox = document.getElementsByClassName("checkboox");
var text= document.getElementsByClassName("text");

for (let i = 0 ; i<checkBox.length ; i++){
    if (checkBox[i].value == 1){

      text[i].style.textDecoration = 'line-through';
      checkBox[i].checked = true;

    }else{
      text[i].style.textDecoration = 'none';
      checkBox[i].checked = false;
    }

  }

</script>

  </body>
</html>
