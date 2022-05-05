<?php

class DB_CON {

    public function connectToDB() {
           $host_name = 'localhost';
           $user_name = 'root';
           $password = '';
           $database_name = 'bdsdlcutps_cutting';
           //$database_name = 'sdldts_cutting';
           $db_connect = mysqli_connect($host_name, $user_name, $password);

           if ($db_connect) {
               $db_select = mysqli_select_db($db_connect, $database_name);
               if ($db_select) {
                   return $db_connect;
               } else {
                   die("Sorry Database is not selected." . mysqli_error($db_connect));
               }
           } else {
               die("Sorry Database is not connected." . mysqli_error($db_connect));
           }
       }


    public function getAllType() {
        $db_connect = $this->__construct();

        $sql = "SELECT DISTINCT(type) FROM newspaper_magazine_details WHERE status = '1'";

        $query_result = mysqli_query($db_connect, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($db_connect));
        }
    }

    //----------------------------- update user information -----------------------------------------
    public function update_user($data)
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



  //-------------------------- save user information ----------------------------
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
    foreach ($l_access_permission as $chkd) {
             $l_check .= $chkd . ",";
           }
    $l_permissions = substr($l_check, 0, strlen($l_check) - 1);

    //dashboard access Permission
    $d_access_permission = $_POST['d_permission'];
    $d_check = "";
    foreach ($d_access_permission as $chkl) {
             $d_check .= $chkl . ",";
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
                           dpermissions
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


   //----------------------------------------- select all users ---------------------------------------

   public function select_all_users() {

      $db_connect = $this->__construct();

      $sql = "SELECT * FROM user";
      $query_result = mysqli_query($db_connect, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($db_connect));
      }
  }


  //----------------------------------------- select user with id---------------------------------------

  public function select_user($id) {

     $db_connect = $this->connectToDB();

     $sql = "SELECT * FROM `user` where id = '".$id."'";
     $query_result = mysqli_query($db_connect, $sql);
     if ($query_result) {
         return $query_result;
     } else {
         die('Query problem' . mysqli_error($db_connect));
     }
  }


    }
?>
