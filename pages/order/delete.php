<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/order/delete.php'; ?>

<?php
$order_id = $_GET['id'];
$user_id = $_SESSION['id'];
// echo '<pre>';
// print_r($user_id);
// echo  '</pre>';
if($user_id == 10){
  $deleteOrder = new delete();
  $message = $deleteOrder->delete_by_id($order_id);
}
else {
  $message = "You have not permission to delete this";
}
if($message){
  $_SESSION['message'] = $message;
  header("Location: select_order_list.php"); // redirect back to your form
  exit;
}
?>
