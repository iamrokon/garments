<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
  public function add_buyer_name($buyer_name)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $query = mysqli_query($db_connect, "SELECT * FROM buyer WHERE name ='" . $buyer_name ."'");
      if (mysqli_num_rows($query) > 0) {
          $message = "Sorry Field is unique . This Data is alrady exits !!";
          return $message;
      } else {
      $sql = "INSERT INTO `buyer`
                           (
                             name
                           )
                          VALUES
                          ( '$buyer_name'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "Info Saved Successfully";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }
  }
}





}

?>
