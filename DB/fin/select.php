<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_finishing extends DB_CON
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
                (select sum(quantity) from wash_send where order_id = order_details.id)  as total_wsend_quantity,
                (select sum(quantity) from finishing where order_id = order_details.id)  as total_finishing_quantity,
                (select user_name from user where id = finishing.user_id)  as user_name
                FROM `order_details` left join `finishing` on order_details.id = finishing.order_id
                and order_details.id not in (select order_id from shipment)
                where finishing.deletion_status != 1
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_wash_send_not_in_finishing()
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
                and order_details.id in (select order_id from swing_output)
                and order_details.id in (select order_id from wash_send)
                and order_details.id not in (select order_id from finishing)
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
                (select sum(quantity) from wash_send where order_id = order_details.id)  as total_wsend_quantity,
                (select sum(quantity) from finishing where order_id = order_details.id)  as total_finishing_quantity,
                (select user_name from user where id = finishing.user_id)  as user_name
                FROM `order_details` left join `finishing` on order_details.id = finishing.order_id
                where finishing.deletion_status != 1
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

        $sql = "SELECT * FROM `finishing` where order_id = '".$id."' and deletion_status != 1";
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

        $sql = "SELECT * FROM `finishing` where order_id = '".$order_id."' and country_id = '".$country_id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_scan_fin_history()
    {
      $con = $this->connectToDB();

      $sql = "SELECT * FROM `fin_scan`
              where deletion_status != 1
              order by fin_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_inp_scan_fin_history()
    {
      $con = $this->connectToDB();

      $sql = "SELECT * FROM `fin_in_scan`
              where deletion_status != 1
              order by fin_in_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_fin_total()
    {
      $con = $this->connectToDB();

      $sql = "SELECT *,
              COUNT(id) as total_scan
              FROM `fin_scan`
              where deletion_status != 1
              order by fin_scan.id desc";


      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_inp_scan_fin_total()
    {
      $con = $this->connectToDB();

      $sql = "SELECT *,
              COUNT(id) as total_scan
              FROM `fin_in_scan`
              where deletion_status != 1
              order by fin_in_scan.id desc";


      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

}

?>
