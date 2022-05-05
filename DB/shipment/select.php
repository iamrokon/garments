<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_shipment extends DB_CON
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
                (select sum(quantity) from shipment where order_id = order_details.id)  as total_shipment_quantity,
                (select user_name from user where id = shipment.user_id)  as user_name
                FROM `order_details` left join `shipment` on order_details.id = shipment.order_id
                where shipment.deletion_status != 1
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_order_list()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select name from buyer where id = order_details.buyer)  as buyer_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                -- (select id from cutting_production where cutting_production.po = order_details.po)  as cut_pro_id,
                (select user_name from user where id = order_details.user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_order_list_info($start,$length)
    {
        $con = $this->connectToDB();
        if($length!=-1){
        $sql ="SELECT *,
              (select po_num from po where id = order_details.po)  as po_number,
              (select style_name from style where id = order_details.style)  as style_name,
              (select name from buyer where id = order_details.buyer)  as buyer_name,
              (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
              (select user_name from user where id = order_details.user_id)  as user_name
              FROM order_details
              where deletion_status != 1
              order by id desc
              LIMIT ".
              $start."  ,".$length."  ";
        }
        else {
          $sql ="SELECT *,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select name from buyer where id = order_details.buyer)  as buyer_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select user_name from user where id = order_details.user_id)  as user_name
                FROM order_details
                where deletion_status != 1
                order by id desc";
        }
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_order_list_info1()
    {
      $con = $this->connectToDB();
      $sql ="SELECT  COUNT(*) as rowNumber,
            (select sum(quantity) from order_qtn_size)  as total_qty
            FROM order_details
            where deletion_status != 1
            order by id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_soutput_qty($po)
    {
      $con = $this->connectToDB();
      $sql ="SELECT  COUNT(*) as rowNumber
            FROM swing_output_scan
            where po = '".$po."'
            and deletion_status != 1
            order by id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_tot_soutput_qty()
    {
      $con = $this->connectToDB();
      $sql ="SELECT  COUNT(*) as totRow
            FROM swing_output_scan
            where deletion_status != 1
            order by id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_soutput_qty_date($po,$from_date,$to_date)
    {
      $con = $this->connectToDB();
      $sql ="SELECT  COUNT(*) as rowNumber
            FROM swing_output_scan
            where date between '$from_date' and '$to_date'
            and po = '".$po."'
            and deletion_status != 1
            order by id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_tot_soutput_qty_date($from_date,$to_date)
    {
      $con = $this->connectToDB();
      $sql ="SELECT  COUNT(*) as totRow
            FROM swing_output_scan
            where date between '$from_date' and '$to_date'
            and deletion_status != 1
            order by id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_cut_pro_id($po)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `cutting_production`.id as cut_pro_id
                -- (select id from cutting_production where cutting_production.po = order_details.po)  as cut_pro_id,
                FROM `cutting_production`
                where cutting_production.po = '".$po."'
                and deletion_status != 1
                order by cutting_production.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_cut_pro_qty($po)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.id,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id) as total_quantity
                FROM `cutting_production`
                where `cutting_production`.po = '".$po."'
                and deletion_status != 1
                order by `cutting_production`.`id` desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_iissue_scan_qty2($po)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `cutting_production`.id as cut_pro_id,
                (select sum(quantity) from bp_issue where b_tkt_code = cut_pro_bundle.id )  as total_scan_quantity
                FROM `cutting_production` inner join `cut_pro_bundle` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`
                where cutting_production.po = '".$po."'
                and cutting_production.deletion_status != 1
                order by cutting_production.id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_today_iissue_scan_qty($po)
    {
        $con = $this->connectToDB();
        $curr_date = date("d-m-Y");

        $sql = "SELECT
                `cutting_production`.id as cut_pro_id,
                (select sum(quantity) from bp_issue where b_tkt_code = cut_pro_bundle.id and date = '.$curr_date.')  as total_scan_quantity
                FROM `cutting_production` inner join `cut_pro_bundle` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`
                where cutting_production.po = '".$po."'
                and cutting_production.deletion_status != 1
                order by cutting_production.id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_iissue_scan_qty($cut_pro_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `cut_pro_bundle`.id as cut_pro_bundle_id,
                (select sum(quantity) from bp_issue where b_tkt_code = cut_pro_bundle.id)  as scan_quantity
                -- (select id from cutting_production where cutting_production.po = order_details.po)  as cut_pro_id,
                FROM `cut_pro_bundle`
                where cut_pro_bundle.production_id = '".$cut_pro_id."'
                and deletion_status != 1
                order by cut_pro_bundle.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_s_output_scan_qty($cut_pro_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `swing_output_scan`.id as swing_output_scan_id
                FROM `swing_output_scan`
                where swing_output_scan.production_id = '".$cut_pro_id."'
                and deletion_status != 1
                order by swing_output_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_today_s_output($cut_pro_id)
    {
        $con = $this->connectToDB();
        $curr_date = date("d-m-Y");

        $sql = "SELECT
                `swing_output_scan`.id as swing_output_scan_id
                FROM `swing_output_scan`
                where swing_output_scan.production_id = '".$cut_pro_id."'
                and date = '".$curr_date."'
                and deletion_status != 1
                order by swing_output_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_today_w_send($cut_pro_id)
    {
        $con = $this->connectToDB();
        $curr_date = date("d-m-Y");

        $sql = "SELECT
                `wsend_scan`.id as wsend_scan_id
                FROM `wsend_scan`
                where wsend_scan.production_id = '".$cut_pro_id."'
                and date = '".$curr_date."'
                and deletion_status != 1
                order by wsend_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_w_send_scan_qty($cut_pro_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `wsend_scan`.id as wsend_scan_id
                FROM `wsend_scan`
                where wsend_scan.production_id = '".$cut_pro_id."'
                and deletion_status != 1
                order by wsend_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_fin_in_scan_qty($cut_pro_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `fin_in_scan`.id as wsend_scan_id
                FROM `fin_in_scan`
                where fin_in_scan.production_id = '".$cut_pro_id."'
                and deletion_status != 1
                order by fin_in_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_fin_scan_qty($cut_pro_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `fin_scan`.id as wsend_scan_id
                FROM `fin_scan`
                where fin_scan.production_id = '".$cut_pro_id."'
                and deletion_status != 1
                order by fin_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_ship_scan_qty($cut_pro_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `shipment_scan`.id as ship_scan_id
                FROM `shipment_scan`
                where shipment_scan.production_id = '".$cut_pro_id."'
                and deletion_status != 1
                order by shipment_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_today_fin_in($cut_pro_id)
    {
        $con = $this->connectToDB();
        $curr_date = date("d-m-Y");

        $sql = "SELECT
                `fin_in_scan`.id as fin_in_scan_id
                FROM `fin_in_scan`
                where fin_in_scan.production_id = '".$cut_pro_id."'
                and date = '".$curr_date."'
                and deletion_status != 1
                order by fin_in_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_today_fin_out($cut_pro_id)
    {
        $con = $this->connectToDB();
        $curr_date = date("d-m-Y");

        $sql = "SELECT
                `fin_scan`.id as fin_out_scan_id
                FROM `fin_scan`
                where fin_scan.production_id = '".$cut_pro_id."'
                and date = '".$curr_date."'
                and deletion_status != 1
                order by fin_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_today_ship_scan($cut_pro_id)
    {
        $con = $this->connectToDB();
        $curr_date = date("d-m-Y");

        $sql = "SELECT
                `shipment_scan`.id as ship_scan_id
                FROM `shipment_scan`
                where shipment_scan.production_id = '".$cut_pro_id."'
                and date = '".$curr_date."'
                and deletion_status != 1
                order by shipment_scan.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_finishing_not_in_shipment()
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
                and order_details.id in (select order_id from finishing)
                and order_details.id not in (select order_id from shipment)
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
                (select sum(quantity) from shipment where order_id = order_details.id)  as total_shipment_quantity,
                (select user_name from user where id = shipment.user_id)  as user_name
                FROM `order_details` left join `shipment` on order_details.id = shipment.order_id
                where shipment.deletion_status != 1
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

        $sql = "SELECT * FROM `shipment` where order_id = '".$id."' and deletion_status != 1";
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

        $sql = "SELECT * FROM `shipment` where order_id = '".$order_id."' and country_id = '".$country_id."' and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_child_current_month_shipment()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `order_qtn_size`.*,
                `order_details`.tod as TOD,
                `order_details`.creation_time,
                `order_details`.creation_date,
                (select style_name from style where id = `order_details`.style) as style_name,
                (select po_num from po where id = `order_details`.po) as po_number,
                (select full_name from country where id = `order_qtn_size`.country_id) as country_name,
                (select sum(quantity) from order_qtn_size where order_id = `order_details`.id) as shipment_quantity,
                WEEK(TOD) as week_number,
                (select user_name from user where id = `order_qtn_size`.user_id) as user_name
                FROM `order_qtn_size` left join `order_details`
                on `order_qtn_size`.order_id = `order_details`.id
                where `order_qtn_size`.deletion_status != 1
                and MONTH(TOD) = MONTH(CURDATE())
                and YEAR(TOD) = YEAR(CURDATE())
                order by TOD desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_all_child_current_week()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `order_qtn_size`.*,
                `order_details`.tod as TOD,
                `order_details`.creation_time,
                `order_details`.creation_date,
                (select style_name from style where id = `order_details`.style) as style_name,
                (select po_num from po where id = `order_details`.po) as po_number,
                (select full_name from country where id = `order_qtn_size`.country_id) as country_name,
                (select sum(quantity) from order_qtn_size where order_id = `order_details`.id) as shipment_quantity,
                WEEK(TOD) as week_number,
                (select user_name from user where id = `order_qtn_size`.user_id) as user_name
                FROM `order_qtn_size` left join `order_details`
                on `order_qtn_size`.order_id = `order_details`.id
                where `order_qtn_size`.deletion_status != 1
                and MONTH(TOD) = MONTH(CURDATE())
                and YEAR(TOD) = YEAR(CURDATE())
                and WEEK(TOD) = WEEK(CURDATE())
                order by TOD desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_scan_shipment_history()
    {
      $con = $this->connectToDB();

      $sql = "SELECT * FROM `shipment_scan`
              where deletion_status != 1
              order by shipment_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_scan_shipment_total()
    {
      $con = $this->connectToDB();

      date_default_timezone_set("Asia/Dhaka");
      $year = date("Y");
      $month = date("m");
      $monthYear = $month."-".$year;

      $sql = "SELECT *,
              COUNT(id) as total_scan
              FROM `shipment_scan`
              where shipment_scan.date like '%".$monthYear."'
              and deletion_status != 1
              order by shipment_scan.id desc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

}

?>
