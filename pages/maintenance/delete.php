<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/maintenance/delete.php'; ?>

<?php
$id = $_GET['id'];
$user_id = $_SESSION['id'];

if($user_id == 10){
  $deleteMaintenance = new delete();
  $message = $deleteMaintenance->delete_by_id($id);
}
else {
  $message = "You have not permission to delete this";
}

if($message){
  $_SESSION['message'] = $message;
  header("Location: select.php"); // redirect back to your form
  exit;
}

?>
