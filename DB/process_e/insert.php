<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
  public function add_process_name($process_name,$smv)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $query = mysqli_query($db_connect, "SELECT * FROM process_e WHERE name ='" . $process_name ."'");
      if (mysqli_num_rows($query) > 0) {
          $message = "Sorry Field is unique . This Data is alrady exits !!";
          return $message;
      } else {
      $sql = "INSERT INTO `process_e`
                          (
                            name,
                            smv
                          )
                          VALUES
                          (
                            '$process_name',
                            '$smv'
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
