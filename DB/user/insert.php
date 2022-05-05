<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save_user_info($data)
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

      $passwordEncode = md5($data['password']);

      $user_name = $data['user_name'];
      $query = mysqli_query($db_connect, "SELECT * FROM user WHERE user_name ='" . $user_name ."'");
      if (mysqli_num_rows($query) > 0) {
          $message = "<span style='color: white;background:black;padding:8px;'>Sorry User Name is unique . This Name is alrady exits !!</span>";
          return $message;
      } else {
      $sql = "INSERT INTO `user`
                           (
                             full_name,
                             user_name,
                             tel,
                             address,
                             password,
                             image,
                             status,
                             type,
                             lpermissions,
                             dpermission
                           )
                          VALUES
                          ( '$data[full_name]',
                            '$data[user_name]',
                            '$data[tel]',
                            '$data[address]',
                            '$passwordEncode',
                            '$profile_pic',
                            '$data[status]',
                            '$data[type]',
                            '$l_permissions',
                            '$d_permissions'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }
    }
  }

}

?>
