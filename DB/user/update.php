<?php
require_once dirname(__FILE__).('/../db_con.php');

class update_user extends DB_CON
{
    $db = new DB_CON();

    public function updateData($data)
    {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      //profile picture upload function
      if ($_FILES['image']['name'] != '') {
      $tmp_name = $_FILES["image"]["tmp_name"];
      $namefile = $_FILES["image"]["name"];
      $ext = end(explode(".", $namefile));
      $profile_pic = "photo/".time() . "." . $ext;

      $fileUpload = move_uploaded_file($_FILES['image']['tmp_name'], "photo/" . $profile_pic);
      }

      //left menu access Permission
      $l_access_permission = $_POST['l_permission'];
      $l_check = "";
      foreach ($l_access_permission as $chk) {
               $l_check .= $chk . ",";
             }
      $l_permissions = substr($l_check, 0, strlen($l_check) - 1);

      //dashboard access Permission
      $d_access_permission = $_POST['d_permission'];
      $d_check = "";
      foreach ($d_access_permission as $chk) {
               $d_check .= $chk . ",";
             }
      $d_permissions = substr($d_check, 0, strlen($d_check) - 1);

       $sql = "UPDATE `user` SET "
               . "full_name	= '$data[full_name]',"
               . "user_name = '$data[user_name]',"
               . "tel = '$data[tel]',"
               . "address = '$data[address]',"
               . "image = '$profile_pic',"
               . "status = '$data[status]',"
               . "type = '$data[type]',"
               . "lpermissions = '$l_permissions',"
               . "dpermissions = '$d_permissions'"
               . " WHERE id='$data[id]'";


        if (mysqli_query($db_connect, $sql)) {
              $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }

  }

}

?>
