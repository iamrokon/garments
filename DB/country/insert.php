<?php
require_once dirname(__FILE__).('/../db_con.php');

class insert extends DB_CON
{
    public function save($data)
    {
        $db = new DB_CON();
        $db_connect = $db->connectToDB();

        $name = $data['full_name'];
        $query = mysqli_query($db_connect, "SELECT * FROM country WHERE full_name ='" . $name ."'");
        if (mysqli_num_rows($query) > 0) {
            $message = "<span style='color: white;background:#f44336;padding:8px;'>Sorry Name is unique . This Name is alrady exits !!</span>";
            return $message;
        } else {
        $sql = "INSERT INTO `country`
                             (
                               full_name,
                               short_name,
                               cut_off,
                               country_code
                             )
                            VALUES
                            ( '$data[full_name]',
                              '$data[short_name]',
                              '$data[cut_off]',
                              '$data[country_code]'
                            )";

          if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Country Saved Successfully</span>";
                return $message;
          } else {
            die('Query problem' . mysqli_error($db_connect));
        }
    }
  }

  public function add_country($name,$cut,$country_code=NULL)
  {
      $db = new DB_CON();
      $db_connect = $db->connectToDB();

      $query = mysqli_query($db_connect, "SELECT * FROM country WHERE full_name ='" . $name ."'");
      if (mysqli_num_rows($query) > 0) {
          $message = "Sorry Name is unique . This Name is alrady exits !!";
          return $message;
      } else {
      $sql = "INSERT INTO `country`
                           (
                             full_name,
                             cut_off,
                             country_code
                           )
                          VALUES
                          (
                             '$name',
                             '$cut',
                             '$country_code'
                          )";

        if (mysqli_query($db_connect, $sql)) {
              $message = "Country Saved Successfully";
              return $message;
        } else {
          die('Query problem' . mysqli_error($db_connect));
      }
   }
}

}

?>
