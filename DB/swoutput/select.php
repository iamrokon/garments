<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_swoutput extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT distinct
                order_details.id,
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select sum(quantity) from input_issue where order_id = order_details.id)  as total_issue_quantity,
                (select sum(quantity) from swing_output where order_id = order_details.id)  as total_output_quantity,
                (select user_name from user where id = swing_output.user_id)  as user_name
                FROM `order_details` left join `swing_output` on order_details.id = swing_output.order_id
                where swing_output.deletion_status != 1
                and order_details.id not in (select order_id from wash_send)
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_input_issue_not_in_swing()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                0  as total_issue_quantity,
                (select user_name from user where id = order_details.cutting_user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                and cutting_plan > 0
                and cutting_production = 0
                and order_details.id in (select order_id from input_issue)
                and order_details.id not in (select order_id from swing_output)
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT distinct
                order_details.id,
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select sum(issue_quantity) from order_qtn_size where order_id = order_details.id)  as total_issue_quantity,
                (select sum(quantity) from swing_output where order_id = order_details.id)  as total_output_quantity,
                (select user_name from user where id = swing_output.user_id)  as user_name
                FROM `order_details` left join `swing_output` on order_details.id = swing_output.order_id
                where swing_output.deletion_status != 1
                and id = '".$id."'";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_child_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `swing_output` where order_id = '".$id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_child_with_order_and_country($order_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT * FROM `swing_output` where order_id = '".$order_id."' and country_id = '".$country_id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_max_id_from_sweing_output()
    {
        $con = $this->connectToDB();

        $sql = "SELECT IFNULL(max(id),0) as max_id FROM `sewing_output` where deletion_status != 1";
        $query_result = mysqli_query($con, $sql);

        if ($result = mysqli_fetch_assoc($query_result)) {
            return $result['max_id'];
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_scan_swoutput_history()
    {
      $con = $this->connectToDB();


      $sql = "SELECT *
              FROM swing_output_scan
              WHERE id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              order by id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_swoutput_today($date)
    {
      $con = $this->connectToDB();

      $sql = "SELECT *
              FROM swing_output_scan
              WHERE id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              and date = '$date'
              order by id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_swoutput_by_style_po($line,$style,$po,$country_id,$size)
    {
      $con = $this->connectToDB();

      $sql = "SELECT *
              FROM swing_output_scan
              WHERE id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              and line = '$line'
              and style = '$style'
              and po = '$po'
              and country = '$country_id'
              and size = '$size'
              order by id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_swoutput_by_style_po2($line,$style,$po,$country_id,$size,$from_date,$to_date)
    {
      $con = $this->connectToDB();

      $sql = "SELECT *
              FROM swing_output_scan
              WHERE id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              and line = '$line'
              and style = '$style'
              and po = '$po'
              and country = '$country_id'
              and size = '$size'
              and date between '$from_date' and '$to_date'
              order by id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_swoutput_history1()
    {
      $con = $this->connectToDB();

      $sql = "SELECT COUNT(*) as rowNumber
              FROM swing_output_scan
              WHERE id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              order by id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_swoutput_history3($search)
    {
      $con = $this->connectToDB();


      $sql = "SELECT *
              FROM swing_output_scan
              WHERE 1=1
              and (id Like '".$search."%'
                OR complete_qr_code Like '".$search."%')
              and id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              order by id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_swoutput_history2($start,$length)
    {
      $con = $this->connectToDB();

      if($length!=-1){
      $sql = "SELECT *
              FROM swing_output_scan
              WHERE id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              order by id desc
              LIMIT ".
              $start."  ,".$length." ";
      }
      else {
      $sql = "SELECT *
              FROM swing_output_scan
              WHERE id IN (
                SELECT MAX(id) FROM swing_output_scan
                GROUP BY complete_qr_code)
              and deletion_status != 1
              order by id desc";
      }

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_swoutput_total()
    {
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT *,
              COUNT(id) as total_scan
              FROM `swing_output_scan`
              where swing_output_scan.date like '%".$monthYear."'
              and deletion_status != 1
              order by swing_output_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

}

?>
