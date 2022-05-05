<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save($data)
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        $size_num = $data['size_num'];
        $query = mysqli_query($db_connect, "SELECT * FROM size WHERE size_num ='" . $size_num ."'");
        if (mysqli_num_rows($query) > 0) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Sorry Field is unique . This Data is alrady exits !!</span>";
            return $message;
        } else {
        $sql = "INSERT INTO `size`
                             (
                               size_num,
                               details
                             )
                            VALUES
                            ( '$data[size_num]',
                              '$data[details]'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Saved Successfully</span>";
                return $message;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }
    }
  }


  public function add_size($size_number,$inseam_number)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      // $query = mysqli_query($db_connect, "SELECT * FROM size WHERE size_num ='" . $size_number ."'");
      // if (mysqli_num_rows($query) > 0) {
      //     $message = "Sorry Field is unique . This Data is alrady exits !!";
      //     return $message;
      // } else {
      $sql = "INSERT INTO `size`
                           (
                             size_num,
                             inseam
                           )
                          VALUES
                          (
                            '$size_number',
                            '$inseam_number'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "Info Saved Successfully";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }
  //}
}





}

?>
