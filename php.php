<?php
include('config.php');
include('class.php');

if(isset($_POST)){
 $task = new TASK();

 $task->done = $_POST['checked'];
 $task->id = $_POST['r_id'];

 $task->ChangeTaskStatus($conn);
}
?>
