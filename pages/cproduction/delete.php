<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/cproduction/delete.php'; ?>

<?php
$id = $_GET['id'];
$user_id = $_SESSION['id'];

if($user_id == 10){
$deleteCuttingProduction = new delete();
$message = $deleteCuttingProduction->delete_by_id($id);
}
else {
  $message = "You have not permission to delete this";
}

if($message){
  if(isset($_GET['loc'])){
  	$loc = $_GET['loc'];
  	header("Location: ".$loc);
  }else{
  	$_SESSION['message'] = $message;
  	header("Location: select.php"); // redirect back to your form
  }
  exit;
}

?>
