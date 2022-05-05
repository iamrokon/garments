<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_order extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select name from buyer where id = order_details.buyer)  as buyer_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select user_name from user where id = order_details.user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                and cutting_plan = 0
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

        $sql = "SELECT order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select name from buyer where id = order_details.buyer)  as buyer_name,
                (select name from color where id = order_details.color)  as color_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select user_name from user where id = order_details.user_id)  as user_name
                FROM `order_details` where id = '".$id."' and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_with_po($po)
    {
        $con = $this->connectToDB();

        $sql = "SELECT order_details.*,
        (select po_num from po where id = order_details.po)  as po_number,
        (select style_name from style where id = order_details.style)  as style_name,
        (select name from buyer where id = order_details.buyer)  as buyer_name,
        (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
        (select user_name from user where id = order_details.user_id)  as user_name
        FROM `order_details` where po = '".$po."' and deletion_status != 1";
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

        $sql = "SELECT * FROM `order_qtn_size` where order_id = '".$id."' and deletion_status != 1";
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

        $sql = "SELECT order_qtn_size.*
                FROM `order_qtn_size`
                where order_id = '".$order_id."'
                and country_id = '".$country_id."'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_child_with_order($order_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT order_qtn_size.*
                FROM `order_qtn_size`
                where order_id = '".$order_id."'
                and deletion_status != 1 group by size order by id asc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_child_with_order_and_country_without_p($order_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT order_qtn_size.*
                FROM `order_qtn_size`
                where order_id = '".$order_id."'
                and country_id = '".$country_id."'
                and `size` NOT LIKE '%P'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_size_with_order_and_country_with_p($order_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT DISTINCT size
                FROM order_qtn_size
                where order_id = '".$order_id."'
                and country_id = '".$country_id."'
                and `size` LIKE '%P'
                and deletion_status != 1";
        //$sql = "SELECT DISTINCT size FROM order_qtn_size";
                // $sql = "SELECT DISTINCT `order_qtn_size`.size
                //         FROM `order_qtn_size`
                //         where order_id = '".$order_id."'
                //         and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_child_with_order_and_country_with_p($order_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT order_qtn_size.*
                FROM `order_qtn_size`
                where order_id = '".$order_id."'
                and country_id = '".$country_id."'
                and `size` LIKE '%P'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_quantity_sum_order_and_country($order_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT `order_qtn_size`.*
                FROM `order_qtn_size`
                where order_id = '".$order_id."'
                and country_id = '".$country_id."'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_issue_count_with_po_country_size($po,$country,$size)
    {
        $con = $this->connectToDB();

        $sql = "SELECT IFNULL(`bp_issue`.`part`,0) as partNumber FROM
                (((`cut_pro_bundle` left join `cutting_production`
                on `cut_pro_bundle`.`production_id` = `cutting_production`.`id`)
                left join `cut_pro_size`
                on `cut_pro_size`.`production_id` = `cutting_production`.`id`
                AND `cut_pro_size`.`ticket_no` = `cut_pro_bundle`.`ticket_no`)
                left join `bp_issue` on `bp_issue`.`b_tkt_code` = `cut_pro_bundle`.`b_tkt_code`)
                where `cutting_production`.`po` = '".$po."'
                and `cut_pro_bundle`.`country_id` = '".$country."'
                and `cut_pro_size`.`size` = '".$size."'";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_oder_country_with_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT order_country.*,
                order_country.id as id,
                (select full_name from country where order_country.country_id = id) as country_name,
                (select name from color where order_country.color_id = id) as color_name,
                (select cut_off from country where order_country.country_id = id order by cut_off asc) as cut_off
                FROM `order_country`
                left join `country`
                on `order_country`.country_id = `country`.id
                where order_country.order_id = '".$id."' and order_country.deletion_status != 1
                order by order_country.tod asc,
                 country.cut_off asc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_oder_country_and_line_with_id($id)
    {
        $con = $this->connectToDB();
        $sql = "SELECT order_country.*,
                order_country.id as id,
                line.id as line_id,
                line.name as line_name,
                (select full_name from country where order_country.country_id = id) as country_name,
                (select name from color where order_country.color_id = id) as color_name,
                (select cut_off from country where order_country.country_id = id order by cut_off asc) as cut_off
                FROM `line` inner join (`order_country`
                left join `country`
                on `order_country`.country_id = `country`.id)
                on 1 = 1
                where order_country.order_id = '".$id."' and order_country.deletion_status != 1
                order by line.id asc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_oder_country_and_line_with_id_by_length($id,$start,$length)
    {
        $con = $this->connectToDB();
        $sql = "SELECT order_country.*,
                order_country.id as id,
                line.id as line_id,
                line.name as line_name,
                (select full_name from country where order_country.country_id = id) as country_name,
                (select name from color where order_country.color_id = id) as color_name,
                (select cut_off from country where order_country.country_id = id order by cut_off asc) as cut_off
                FROM `line` inner join (`order_country`
                left join `country`
                on `order_country`.country_id = `country`.id)
                on 1 = 1
                where order_country.order_id = '".$id."' and order_country.deletion_status != 1
                order by line.id asc
                LIMIT ".
                $start."  ,".$length." ";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_oder_country_and_line_with_id_by_length1($id)
    {
      $con = $this->connectToDB();

      // $sql = "SELECT COUNT(*) as rowNumber
      //         FROM swing_output_scan
      //         WHERE id IN (
      //           SELECT MAX(id) FROM swing_output_scan
      //           GROUP BY complete_qr_code)
      //         and deletion_status != 1
      //         order by id desc";

      $sql = "SELECT COUNT(*) as rowNumber,
              order_country.*,
              order_country.id as id,
              line.id as line_id,
              line.name as line_name,
              (select full_name from country where order_country.country_id = id) as country_name,
              (select name from color where order_country.color_id = id) as color_name,
              (select cut_off from country where order_country.country_id = id order by cut_off asc) as cut_off
              FROM `line` inner join (`order_country`
              left join `country`
              on `order_country`.country_id = `country`.id)
              on 1 = 1
              where order_country.order_id = '".$id."' and order_country.deletion_status != 1
              order by line.id asc";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

    public function select_all_cutting_plan()
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
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_all_cutting_plan_with_po_number($po_number)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.*,
                (select po_num from po where id = order_details.po)  as po_number,
                (select style_name from style where id = order_details.style)  as style_name,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id)  as total_quantity,
                (select user_name from user where id = order_details.cutting_user_id)  as user_name
                FROM `order_details`
                where deletion_status != 1
                and cutting_plan > 0
                and cutting_production = 0
                and order_details.po = $po_number
                order by order_details.id desc";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_unique_size_list_order($order_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT DISTINCT `order_qtn_size`.size_id
                FROM `order_qtn_size`
                where order_id = '".$order_id."'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

}

?>
