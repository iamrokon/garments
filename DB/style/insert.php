<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save($data)
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        $check = $data['style_name'];
        $query = mysqli_query($db_connect, "SELECT * FROM style WHERE style_name ='" . $check ."'");
        if (mysqli_num_rows($query) > 0) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Sorry Field is unique . This Data is alrady exits !!</span>";
            return $message;
        } else {
        $sql = "INSERT INTO `style`
                             (
                               style_name,
                               details
                             )
                            VALUES
                            ( '$data[style_name]',
                              '$data[details]'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                $insert_id = $db_connect->insert_id;
                return $insert_id;
          } else {
            die('Query problem' . mysqli_error($db_connect));
          }
    }
  }



  public function add_style($style_name)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $query = mysqli_query($db_connect, "SELECT * FROM style WHERE style_name ='" . $style_name ."'");
      if (mysqli_num_rows($query) > 0) {
          $message = "Sorry Field is unique . This Data is alrady exits !!";
          return $message;
      } else {
      $sql = "INSERT INTO `style`
                           (
                             style_name
                           )
                          VALUES
                          (
                            '$style_name'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "Info Saved Successfully";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }
  }
}

public function add_style_process(
                                  $style_id,
                                  $pro_id
                                 )
{
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $sql = "INSERT INTO `style_process`
                          (
                            style_id,
                            pro_id
                          )
                          VALUES
                          (
                            '$style_id',
                            '$pro_id'
                          )";

      if (mysqli_query($db_connect, $sql)) {
            $message = '<span style="color: white;background:#f44336;padding:8px;">Saved Successfully</span>';
            return $message;
      } else {
        die('Query problem' . mysqli_error($db_connect));
    }
}

public function add_shrinkage(
                                  $style_id,
                                  $pattern,
                                  $length_wrap,
                                  $width_weft
                                 )
{
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $sql = "INSERT INTO `shrinkage`
                          (
                            style_id,
                            pattern,
                            length_wrap,
                            width_weft
                          )
                          VALUES
                          (
                            '$style_id',
                            '$pattern',
                            '$length_wrap',
                            '$width_weft'
                          )";

      if (mysqli_query($db_connect, $sql)) {
            $message = '<span style="color: white;background:#f44336;padding:8px;">Saved Successfully</span>';
            return $message;
      } else {
        die('Query problem' . mysqli_error($db_connect));
    }
}


}

?>
