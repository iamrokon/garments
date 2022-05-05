<?php
require_once dirname(__FILE__).('/../db_con.php');

class login extends DB_CON
{
  //------------------------ authinticate log in member --------------------
  public function member_login_check($data) {

      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $password = md5($data['password']);

      $update_sql = "UPDATE `user` SET "
             . "last_login = NOW()"
             . " WHERE user_name ='$data[user_name]' AND password='$password' ";

      mysqli_query($db_connect, $update_sql);

      $sql = "SELECT * FROM user WHERE user_name ='$data[user_name]' AND password='$password' ";
      $query_result = mysqli_query($db_connect, $sql);

      if ($query_result) {
          $row = mysqli_fetch_assoc($query_result);
          if ($row) {

              //left menu check
              $lmenuCheck = $row['lpermissions'];
              $lmenuCheckArray = explode(",", $lmenuCheck);

              //dashboard check
              $dashCheck = $row['dpermissions'];
              $dashCheckArray = explode(",", $dashCheck);

              $_SESSION['id'] = $row['id'];
              $_SESSION['type'] = $row['type'];
              $_SESSION['image'] = $row['image'];
              $_SESSION['name'] = $row['full_name'];
              $_SESSION['lpermissionsArray'] = $lmenuCheckArray;
              $_SESSION['dpermissionsArray'] = $dashCheckArray;
              $_SESSION['last_login'] = $row['last_login'];
              $_SESSION['LAST_ACTIVITY'] = time();

              header('Location: ./index.php');

          } else {
              $ex_message = "Please use valid user name and password";
              return $ex_message;
          }
      } else {
          die('Query problem' . mysqli_error($db_connect));
      }
  }

  //---------------- user log out----------------
  public function user_logout() {
      unset($_SESSION['id']);
      unset($_SESSION['type']);
      unset($_SESSION['image']);
      unset($_SESSION['name']);
      unset($_SESSION['lpermissionsArray']);
      unset($_SESSION['dpermissionsArray']);

      header('Location: ./login.php');
      exit();
  }

}

?>
