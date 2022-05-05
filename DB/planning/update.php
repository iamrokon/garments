<?php
require_once dirname(__FILE__).('/../db_con.php');

class update extends DB_CON
{
    public function updateData($data)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `style` SET "
               . "style_name	= '$data[style_name]',"
               . "length_wrap	= '$data[length_wrap]',"
               . "width_weft	= '$data[width_weft]',"
               . "details = '$data[details]'"
               . " WHERE id='$data[id]'";

            if (mysqli_query($db_connect, $sql)) {
                $message = "<span style='color: white;background:#f44336;padding:8px;'>Info Updated Successfully</span>";
                return $message;
            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


    public function updateStyleProcess($data,$style_id)
    {
        $db_connect = $this->connectToDB();

        $sql = "UPDATE `style_process` SET "
               . "deletion_status	= '1'"
               . " WHERE style_id='$style_id'";

            if (mysqli_query($db_connect, $sql)) {

                $totalCount = count($data['style_insert']);

                for($i=0; $i<$totalCount; $i++){

                  $pro_id = $data['style_insert'][$i];

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
                        $message = $pro_id;
                  } else {
                    die('Query problem' . mysqli_error($db_connect));
                }

                }

                return $message;

            } else {
                die('Query Problem' . mysqli_error($db_connect));
            }
    }


}

?>
