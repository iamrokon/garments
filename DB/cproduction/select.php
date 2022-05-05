<?php
require_once dirname(__FILE__).('/../db_con.php');

class select_cproduction extends DB_CON
{
    public function select_all()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.*,
                (select name from buyer where id = cutting_production.buyer)  as buyer_name,
                (select po_num from po where id = cutting_production.po)  as po_number,
                (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production,
                (select name from color where id = cutting_production.color)  as color,
                (select style_name from style where id = cutting_production.style)  as style_name,
                (select name from shade where id = cutting_production.shade)  as shade,
                (select user_name from user where id = cutting_production.creator_id)  as user_name
                FROM `cutting_production`
                where deletion_status != 1
                order by `cutting_production`.`id` desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_cut_pro_info($start,$length)
    {
        $con = $this->connectToDB();
        if($length!=-1){
        $sql = "SELECT
                cutting_production.*,
                (select name from buyer where id = cutting_production.buyer)  as buyer_name,
                (select po_num from po where id = cutting_production.po)  as po_number,
                (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production,
                (select name from color where id = cutting_production.color)  as color_name,
                (select style_name from style where id = cutting_production.style)  as style_name,
                (select name from shade where id = cutting_production.shade)  as shade_name,
                (select user_name from user where id = cutting_production.creator_id)  as user_name
                FROM `cutting_production`
                where deletion_status != 1
                order by `cutting_production`.`id` desc
                LIMIT ".
                $start."  ,".$length."  ";
          }
          else {
          $sql = "SELECT
                  cutting_production.*,
                  (select name from buyer where id = cutting_production.buyer)  as buyer_name,
                  (select po_num from po where id = cutting_production.po)  as po_number,
                  (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
                  (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production,
                  (select name from color where id = cutting_production.color)  as color_name,
                  (select style_name from style where id = cutting_production.style)  as style_name,
                  (select name from shade where id = cutting_production.shade)  as shade_name,
                  (select user_name from user where id = cutting_production.creator_id)  as user_name
                  FROM `cutting_production`
                  where deletion_status != 1
                  order by `cutting_production`.`id` desc";
            }

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_last_cut_pro_qty()
    {
        $con = $this->connectToDB();
        if($length!=-1){
        $sql = "SELECT
                cutting_production.*,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id)  as cutting_production
                FROM `cutting_production`
                order by `cutting_production`.`id` desc
                LIMIT 1";
        }

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_cut_pro_info2($search)
    {
        $con = $this->connectToDB();
        $sql = "SELECT
                cutting_production_view.*
                FROM `cutting_production_view`
                where 1=1
                and (
                po_number Like '".$search."%'
                OR cut_number Like '".$search."%'
                )
                order by `cutting_production_view`.`id` desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_cut_pro_info1()
    {
        $con = $this->connectToDB();
        $sql = "SELECT COUNT(*) as rowNumber
                FROM cutting_production
                where deletion_status != 1
                order by `cutting_production`.`id` desc";


        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_last_cproduction()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.*
                FROM `cutting_production`
                where deletion_status != 1
                order by `cutting_production`.`id` desc
                LIMIT 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_cut_pro_by_qrcode($qr_code)
    {
        $con = $this->connectToDB();
        //$qr_code = base_convert($qrCode,36,10);
        $sql = "SELECT
                cutting_production.*,
                (select po_num from po where id = cutting_production.po)  as po_number,
                (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
                (select name from color where id = cutting_production.color)  as color_name,
                (select style_name from style where id = cutting_production.style)  as style_name,
                (select name from shade where id = cutting_production.shade)  as shade_name,
                (select sum(quantity) from cut_pro_bundle
                where production_id = cutting_production.id) as total_quantity_bundle
                FROM `cutting_production`
                where `cutting_production`.qr_code <= $qr_code
                and deletion_status != 1
                order by `cutting_production`.`id` desc
                LIMIT 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_po_by_id($po_num)
    {
        $con = $this->connectToDB();
        $sql = "SELECT
                po.*
                FROM `po`
                where po_num = '".$po_num."'
                and deletion_status != 1
                order by `po`.`id` desc
                LIMIT 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }public function select_cut_no_by_id($cut_no)
    {
        $con = $this->connectToDB();
        $sql = "SELECT
                cut_no.*
                FROM `cut_no`
                where cut_num = '".$cut_no."'
                and deletion_status != 1
                order by `cut_no`.`id` desc
                LIMIT 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_with_po_cut_no($cut_no,$po)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.*,
                (select name from buyer where id = cutting_production.buyer)  as buyer_name,
                -- (select po_num from po where id = cutting_production.po)  as po_number,
                -- (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
                (select name from color where id = cutting_production.color)  as color_name,
                (select style_name from style where id = cutting_production.style)  as style_name,
                -- (select name from shade where id = cutting_production.shade)  as shade_name,
                (select sum(quantity) from cut_pro_bundle
                where production_id = cutting_production.id) as total_quantity_bundle
                FROM `cutting_production`
                where `cutting_production`.`po` = '".$po."'
                and `cutting_production`.`cut_num` = '".$cut_no."'
                and deletion_status != 1
                order by `cutting_production`.`id` desc
                LIMIT 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_cut_pro_child_by_qrcode($cut_pro_quantity,$id)
    {
      $con = $this->connectToDB();

      $sql = "SELECT cut_pro_bundle.*,
              (select full_name from country where id = cut_pro_bundle.country_id) as country_name,
              (select name from shade where id = cut_pro_bundle.shade) as shade_name,
              (select size_num from size where id = (select size from cut_pro_size where production_id = cut_pro_bundle.production_id
              and ticket_no = cut_pro_bundle.ticket_no)) as ticket_size,
              (select label from cut_pro_size where production_id = cut_pro_bundle.production_id
              and ticket_no = cut_pro_bundle.ticket_no) as label
              FROM `cut_pro_bundle`
              where production_id = '".$id."'
              and '".$cut_pro_quantity."' >= `cut_pro_bundle`.`from_id`
              and deletion_status != 1
              order by `cut_pro_bundle`.`id` desc
              LIMIT 1";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

    public function select_cut_pro_child_by_qrcode2($cut_pro_quantity,$id,$search)
    {
      $con = $this->connectToDB();

      $sql = "SELECT cut_pro_bundle.*,
              (select full_name from country where id = cut_pro_bundle.country_id and full_name like '".$search."%') as country_name,
              (select name from shade where id = cut_pro_bundle.shade) as shade_name,
              (select size_num from size where id = (select size from cut_pro_size where production_id = cut_pro_bundle.production_id
              and ticket_no = cut_pro_bundle.ticket_no)) as ticket_size,
              (select label from cut_pro_size where production_id = cut_pro_bundle.production_id
              and ticket_no = cut_pro_bundle.ticket_no) as label
              FROM `cut_pro_bundle`
              where production_id = '".$id."'
              and '".$cut_pro_quantity."' >= `cut_pro_bundle`.`from_id`
              and deletion_status != 1
              order by `cut_pro_bundle`.`id` desc
              LIMIT 1";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }

    public function select_shipment_info_by_order($id,$country_id)
    {
      $con = $this->connectToDB();

      $sql = "SELECT cutting_production.*,
              (select shipment from order_country where order_id = order_details.id and country_id='".$country_id."' LIMIT 1) as shipment
              FROM `cutting_production` left join `order_details` on `order_details`.`po` = `cutting_production`.`po`
              -- FROM `cut_pro_bundle` left join `cutting_production` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`
              where `cutting_production`.`id` = '".$id."'
              and cutting_production.deletion_status != 1
              LIMIT 1";

      // $sql = "SELECT cut_pro_bundle.*,
      //         (select full_name from country where id = cut_pro_bundle.country_id) as country_name,
      //         (select name from shade where id = cut_pro_bundle.shade) as shade_name,
      //         IFNULL((select po_num from po where id = (select po from cutting_production where id = cut_pro_bundle.production_id)),'NA') as po,
      //         IFNULL((select style_name from style where id = (select style from cutting_production where id = cut_pro_bundle.production_id)),'NA') as style_name,
      //         IFNULL((select name from color where id = (select color from cutting_production where id = cut_pro_bundle.production_id)),'NA') as color_name,
      //         IFNULL((select distinct size from cut_pro_size where production_id = cut_pro_bundle.production_id and ticket_no = cut_pro_bundle.ticket_no),0) as ticket_size,
      //         IFNULL((select name from buyer where id = cutting_production.buyer),'NA') as buyer_name,
      //         IFNULL((select cut_num from cut_no where id = cutting_production.cut_num),'NA') as cut_number
      //         FROM `cut_pro_bundle` left join `cutting_production` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`
      //         where `cut_pro_bundle`.b_tkt_code = '".$id."'
      //         and `cut_pro_bundle`.deletion_status != 1";

      $query_result = mysqli_query($con, $sql);
      if ($query_result) {
          return $query_result;
      } else {
          die('Query problem' . mysqli_error($con));
      }
    }
    public function select_cut_pro_child2_by_qrcode($id)
    {
      $con = $this->connectToDB();

      $sql = "SELECT cut_pro_bundle.*
              FROM `cut_pro_bundle`
              where production_id = '".$id."'
              and deletion_status != 1
              order by `cut_pro_bundle`.`id` desc
              LIMIT 1";

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

        $sql = "SELECT
                cutting_production.*,
                (select name from buyer where id = cutting_production.buyer)  as buyer_name,
                (select po_num from po where id = cutting_production.po)  as po_number,
                (select cut_num from cut_no where id = cutting_production.cut_num)  as cut_number,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.cut_num)  as cutting_production,
                (select name from color where id = cutting_production.color)  as color_name,
                (select style_name from style where id = cutting_production.style)  as style_name,
                -- (select length_wrap from style where id = cutting_production.style)  as length_wrap,
                -- (select width_weft from style where id = cutting_production.style)  as width_weft,
                (select name from shade where id = cutting_production.shade)  as shade_name,
                (select name from section where id = cutting_production.section)  as section_name,
                (select user_name from user where id = cutting_production.creator_id)  as user_name,
                (select DISTINCT pattern from cut_pro_bundle where production_id = cutting_production.id LIMIT 1)  as onepattern
                FROM `cutting_production`
                where id = $id
                and deletion_status != 1";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_with_id_qr($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                id,
                po,
                style,
                qr_code,
                cut_num,
                (select po_num from po WHERE id = cutting_production.po)  as po_number,
                (select cut_num from cut_no WHERE id = cutting_production.cut_num)  as cut_number,
                (select name from color WHERE id = cutting_production.color)  as color_name,
                (select style_name from style WHERE id = cutting_production.style)  as style_name
                FROM `cutting_production`
                WHERE id = $id
                and `deletion_status` = 0";
        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_with_id_qr_new($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.id,
                cutting_production.po,
                cutting_production.style,
                cutting_production.qr_code,
                cutting_production.cut_num,
                cut_pro_bundle.from_id,
                cut_pro_bundle.to_id,
                cut_pro_bundle.quantity,
                cut_pro_bundle.pattern,
                cut_pro_bundle.country_id,
                cut_pro_bundle.id as b_id,
                (select full_name from country WHERE id = cut_pro_bundle.country_id) as country_name,
                (select country_code from country WHERE id = cut_pro_bundle.country_id) as country_code,
                (select length_wrap from shrinkage WHERE style_id = cutting_production.style and pattern = cut_pro_bundle.pattern and `deletion_status` = 0 )  as length_wrap,
                (select width_weft from shrinkage WHERE style_id = cutting_production.style and pattern = cut_pro_bundle.pattern and `deletion_status` = 0)  as width_weft,
                (select name from shade WHERE id = cut_pro_bundle.shade) as shade_name,
                (select size from cut_pro_size WHERE production_id = cut_pro_bundle.production_id
                and ticket_no = cut_pro_bundle.ticket_no) as ticket_size,
                (select sum(quantity) from cut_pro_bundle
                WHERE production_id = cutting_production.id
                and  ticket_no = cut_pro_bundle.ticket_no) as total_quantity_bundle,
                (select DISTINCT order_country.tod FROM
                (order_country inner join order_details
                on order_country.order_id = order_details.id)
                WHERE order_details.po = cutting_production.po
                and order_country.country_id = cut_pro_bundle.country_id
                and order_country.deletion_status = 0)  as tods,
                (SELECT (select sum(quantity) from order_qtn_size where order_id = order_details.id and country_id = cut_pro_bundle.country_id) as t_quantity
                FROM (order_details inner join order_qtn_size
                on order_qtn_size.order_id = order_details.id)
                where order_details.po = cutting_production.po
                and order_qtn_size.country_id = cut_pro_bundle.country_id
                and order_details.deletion_status != 1 LIMIT 1) as total_quantity,
                (SELECT (select sum(quantity) from order_qtn_size
                where order_id = order_details.id) as tot_quantity
                FROM (order_details inner join order_qtn_size
                on order_qtn_size.order_id = order_details.id)
                where order_details.po = cutting_production.po
                and order_details.deletion_status != 1 LIMIT 1) as po_total_quantity,
                (SELECT (select name from line WHERE id = bp_issue.line) as l_name
                FROM bp_issue WHERE
                bp_issue.b_tkt_code = cut_pro_bundle.id
                and bp_issue.deletion_status = 0
                ORDER BY bp_issue.id DESC LIMIT 1) as line_name,
                (select po_num from po WHERE id = cutting_production.po)  as po_number,
                (select cut_num from cut_no WHERE id = cutting_production.cut_num)  as cut_number,
                (select name from color WHERE id = cutting_production.color)  as color_name,
                (select style_name from style WHERE id = cutting_production.style)  as style_name
                FROM cutting_production left join cut_pro_bundle on cutting_production.id = cut_pro_bundle.production_id
                WHERE cutting_production.id = '$id'
                and cutting_production.deletion_status = 0";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_with_id_qrrrr($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.id,
                cutting_production.po,
                cutting_production.style,
                cutting_production.qr_code,
                cutting_production.cut_num,
                cut_pro_bundle.from_id,
                cut_pro_bundle.to_id,
                cut_pro_bundle.quantity,
                cut_pro_bundle.pattern,
                cut_pro_bundle.country_id,
                cut_pro_bundle.id as b_id,
                (select full_name from country WHERE id = cut_pro_bundle.country_id) as country_name,
                (select country_code from country WHERE id = cut_pro_bundle.country_id) as country_code,
                (select length_wrap from shrinkage WHERE style_id = cutting_production.style and pattern = cut_pro_bundle.pattern and `deletion_status` = 0 )  as length_wrap,
                (select width_weft from shrinkage WHERE style_id = cutting_production.style and pattern = cut_pro_bundle.pattern and `deletion_status` = 0)  as width_weft,
                (select name from shade WHERE id = cut_pro_bundle.shade) as shade_name,
                (select size from cut_pro_size WHERE production_id = cut_pro_bundle.production_id
                and ticket_no = cut_pro_bundle.ticket_no) as ticket_size,
                (select sum(quantity) from cut_pro_bundle
                WHERE production_id = cutting_production.id
                and  ticket_no = cut_pro_bundle.ticket_no) as total_quantity_bundle,
                (select DISTINCT order_country.tod FROM
                (order_country inner join order_details
                on order_country.order_id = order_details.id)
                WHERE order_details.po = cutting_production.po
                and order_country.country_id = cut_pro_bundle.country_id
                and order_country.deletion_status = 0)  as tods,
                (SELECT (select sum(quantity) from order_qtn_size where order_id = order_details.id and country_id = cut_pro_bundle.country_id) as t_quantity
                FROM (order_details inner join order_qtn_size
                on order_qtn_size.order_id = order_details.id)
                where order_details.po = cutting_production.po
                and order_qtn_size.country_id = cut_pro_bundle.country_id
                and order_details.deletion_status != 1 LIMIT 1) as total_quantity,
                (SELECT (select sum(quantity) from order_qtn_size
                where order_id = order_details.id) as tot_quantity
                FROM (order_details inner join order_qtn_size
                on order_qtn_size.order_id = order_details.id)
                where order_details.po = cutting_production.po
                and order_details.deletion_status != 1 LIMIT 1) as po_total_quantity,
                (SELECT (select name from line WHERE id = bp_issue.line) as l_name
                FROM bp_issue WHERE
                bp_issue.b_tkt_code = cut_pro_bundle.id
                and bp_issue.deletion_status = 0
                ORDER BY bp_issue.id DESC LIMIT 1) as line_name,
                (select po_num from po WHERE id = cutting_production.po)  as po_number,
                (select serial from iissue_scan WHERE po = cutting_production.po and cut_num = cutting_production.cut_num) as serial,
                (select name from line WHERE id=(select line from iissue_scan WHERE po = cutting_production.po and cut_num = cutting_production.cut_num)) as line_name_new,
                (select cut_num from cut_no WHERE id = cutting_production.cut_num)  as cut_number,
                (select name from color WHERE id = cutting_production.color)  as color_name,
                (select style_name from style WHERE id = cutting_production.style)  as style_name
                FROM cutting_production left join cut_pro_bundle on cutting_production.id = cut_pro_bundle.production_id
                WHERE cutting_production.id = '$id'
                and cutting_production.deletion_status = 0";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_with_id_qr_again($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT * from qr_code_view where id = '$id' ";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_last_id()
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.*
                FROM `cutting_production`
                order by id desc LIMIT 1";
        // $sql = "SELECT
        //         cutting_production.*
        //         FROM `cutting_production`
        //         where deletion_status != 1
        //         order by id desc LIMIT 1";
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

        $sql = "SELECT cut_pro_bundle.*,
        (select full_name from country where id = cut_pro_bundle.country_id) as country_name,
        (select name from shade where id = cut_pro_bundle.shade) as shade_name,
        (select size from cut_pro_size where production_id = cut_pro_bundle.production_id
        and ticket_no = cut_pro_bundle.ticket_no) as ticket_size,
        (select label from cut_pro_size where production_id = cut_pro_bundle.production_id
        and ticket_no = cut_pro_bundle.ticket_no) as label,
        (select sum(quantity) from cut_pro_bundle
        where production_id = '".$id."'
        and  ticket_no = cut_pro_bundle.ticket_no) as total_quantity_bundle,
        (select inseam from size where id = (select size from cut_pro_size where production_id = cut_pro_bundle.production_id
        and ticket_no = cut_pro_bundle.ticket_no) ) as inseam
        FROM `cut_pro_bundle`
        where production_id = '".$id."'
        and deletion_status != 1
        order by `cut_pro_bundle`.`id` asc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_child_with_id2($id,$style)
    {
        $con = $this->connectToDB();

        $sql = "SELECT cut_pro_bundle.*,
        (select full_name from country where id = cut_pro_bundle.country_id) as country_name,
        (select length_wrap from shrinkage where style_id = '$style' and pattern = cut_pro_bundle.pattern and deletion_status != 1 )  as length_wrap,
        (select width_weft from shrinkage where style_id = '$style' and pattern = cut_pro_bundle.pattern and deletion_status != 1)  as width_weft,
        (select name from shade where id = cut_pro_bundle.shade) as shade_name,
        (select size from cut_pro_size where production_id = cut_pro_bundle.production_id
        and ticket_no = cut_pro_bundle.ticket_no) as ticket_size,
        -- (select size_num from size where id = (select size from cut_pro_size where production_id = cut_pro_bundle.production_id
        -- and ticket_no = cut_pro_bundle.ticket_no)) as ticket_size,
        (select label from cut_pro_size where production_id = cut_pro_bundle.production_id
        and ticket_no = cut_pro_bundle.ticket_no) as label,



        (select sum(quantity) from cut_pro_bundle
        where production_id = '".$id."'
        and  ticket_no = cut_pro_bundle.ticket_no) as total_quantity_bundle

        FROM `cut_pro_bundle`
        where production_id = '".$id."'
        and deletion_status != 1
        order by `cut_pro_bundle`.`id` asc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_child_with_id2_qr($id,$style)
    {
        $con = $this->connectToDB();

        $sql = "SELECT id,
              from_id,
              to_id,
              quantity,
              pattern,
              country_id,
              (select full_name from country WHERE id = cut_pro_bundle.country_id) as country_name,
              (select country_code from country WHERE id = cut_pro_bundle.country_id) as country_code,
              (select length_wrap from shrinkage WHERE style_id = '$style' and pattern = cut_pro_bundle.pattern and `deletion_status` = 0 )  as length_wrap,
              (select width_weft from shrinkage WHERE style_id = '$style' and pattern = cut_pro_bundle.pattern and `deletion_status` = 0)  as width_weft,
              (select name from shade WHERE id = cut_pro_bundle.shade) as shade_name,
              (select size from cut_pro_size WHERE production_id = cut_pro_bundle.production_id
              and ticket_no = cut_pro_bundle.ticket_no) as ticket_size,
              (select sum(quantity) from cut_pro_bundle
              WHERE production_id = '".$id."'
              and  ticket_no = cut_pro_bundle.ticket_no) as total_quantity_bundle
              FROM `cut_pro_bundle`
              WHERE production_id = '".$id."'
              and `deletion_status` = 0
              ORDER BY `cut_pro_bundle`.`id` asc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_bundle_process_with_production_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT cut_process.pro_id as id,
        (select name from process_c where id = cut_process.pro_id) as process_name
        FROM `cut_process`
        where production_id = '".$id."'
        and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }





    public function select_child_with_btkt_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT cut_pro_bundle.*,
        (select full_name from country where id = cut_pro_bundle.country_id) as country_name,
        (select name from shade where id = cut_pro_bundle.shade) as shade_name,
        IFNULL((select po_num from po where id = (select po from cutting_production where id = cut_pro_bundle.production_id)),'NA') as po,
        IFNULL((select style_name from style where id = (select style from cutting_production where id = cut_pro_bundle.production_id)),'NA') as style_name,
        IFNULL((select name from color where id = (select color from cutting_production where id = cut_pro_bundle.production_id)),'NA') as color_name,
        IFNULL((select distinct size from cut_pro_size where production_id = cut_pro_bundle.production_id and ticket_no = cut_pro_bundle.ticket_no),0) as ticket_size,
        IFNULL((select name from buyer where id = cutting_production.buyer),'NA') as buyer_name,
        IFNULL((select cut_num from cut_no where id = cutting_production.cut_num),'NA') as cut_number
        FROM `cut_pro_bundle` left join `cutting_production` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`
        where `cut_pro_bundle`.b_tkt_code = '".$id."'
        and `cut_pro_bundle`.deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_child_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT cut_pro_bundle.*,
        (select full_name from country where id = cut_pro_bundle.country_id) as country_name,
        (select name from shade where id = cut_pro_bundle.shade) as shade_name,
        IFNULL((select po_num from po where id = (select po from cutting_production where id = cut_pro_bundle.production_id)),'NA') as po,
        IFNULL((select style_name from style where id = (select style from cutting_production where id = cut_pro_bundle.production_id)),'NA') as style_name,
        IFNULL((select name from color where id = (select color from cutting_production where id = cut_pro_bundle.production_id)),'NA') as color_name,
        IFNULL((select size_num from size where id = (select distinct size from cut_pro_size where production_id = cut_pro_bundle.production_id and ticket_no = cut_pro_bundle.ticket_no)),'NA') as ticket_size,
        (select label from cut_pro_size where production_id = cut_pro_bundle.production_id
        and ticket_no = cut_pro_bundle.ticket_no) as label,
        IFNULL((select name from buyer where id = cutting_production.buyer),'NA') as buyer_name,
        IFNULL((select cut_num from cut_no where id = cutting_production.cut_num),'NA') as cut_number,

        IFNULL((select sum(quantity) from cut_pro_bundle
        where ticket_no = cut_pro_bundle.ticket_no),0) as total_quantity_bundle

        FROM `cut_pro_bundle` left join `cutting_production` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`
        where `cut_pro_bundle`.id = '".$id."'
        and `cut_pro_bundle`.deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_child_with_pro_id_and_ticket_no($pro_id,$ticket_no)
    {
        $con = $this->connectToDB();

        $sql = "SELECT cut_pro_bundle.*,
                (select size_num from size where id = (select size from cut_pro_size where production_id = '".$pro_id."'
                and ticket_no = '".$ticket_no."') ) as ticket_size,
                (select inseam from size where id = (select size from cut_pro_size where production_id = '".$pro_id."'
                and ticket_no = '".$ticket_no."') ) as inseam,
                (select label from cut_pro_size where production_id = '".$pro_id."'
                and ticket_no = '".$ticket_no."' ) as label,
                (select name from shade where id = cut_pro_bundle.shade) as shade_name
                FROM `cut_pro_bundle`
                where production_id = '".$pro_id."'
                and ticket_no = '".$ticket_no."'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_previous_child_with_pro_id_and_ticket_no($pro_id,$ticket_no)
    {
        $con = $this->connectToDB();

        $sql = "SELECT cut_pro_bundle.*
                FROM `cut_pro_bundle`
                where production_id = '".$pro_id."'
                and ticket_no < '".$ticket_no."'
                and deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_tod_complete_qr_code(
                                                $production_id,
                                                $pro_child_id
                                                )
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                DISTINCT order_country.tod FROM
                (((cutting_production left join `cut_pro_bundle`
                on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`)
                left join `order_details` on `cutting_production`.`po` = `order_details`.`po`
                and `cutting_production`.`style` = `order_details`.`style`
                and `cutting_production`.`buyer` = `order_details`.`buyer`)
                left join order_country on order_details.id = order_country.order_id)

                 where `cut_pro_bundle`.`production_id` = '".$production_id."'
                 and `cut_pro_bundle`.`id` = '".$pro_child_id."'
                 and cutting_production.deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_tod_complete_qr_code2(
                                                $po,
                                                $country_id
                                                )
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                DISTINCT order_country.tod FROM
                (order_country inner join `order_details`
                on `order_country`.`order_id` = `order_details`.`id`)
                 where `order_details`.`po` = '".$po."'
                 and `order_country`.`country_id` = '".$country_id."'
                 and order_country.deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_tod_complete_qr_code2_qr(
                                                $po,
                                                $country_id
                                                )
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                DISTINCT order_country.tod FROM
                (order_country inner join `order_details`
                on `order_country`.`order_id` = `order_details`.`id`)
                 WHERE `order_details`.`po` = '".$po."'
                 and `order_country`.`country_id` = '".$country_id."'
                 and order_country.`deletion_status` = 0";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_order_qty_by_po_country(
                                                $po,
                                                $country_id
                                                )
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.id,
                (select sum(quantity) from order_qtn_size where order_id = order_details.id and country_id = '".$country_id."') as total_quantity
                -- (select size from order_qtn_size where order_id = order_details.id and country_id = '".$country_id."' LIMIT 1) as size
                FROM (order_details inner join `order_qtn_size`
                on `order_qtn_size`.`order_id` = `order_details`.`id`)
                where `order_details`.`po` = '".$po."'
                and `order_qtn_size`.`country_id` = '".$country_id."'
                and order_details.deletion_status != 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_order_qty_by_po_country_new(
                                                $po,
                                                $country_id
                                                )
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                (select sum(quantity) from order_qtn_size where order_id = order_details.id and country_id = '".$country_id."') as total_quantity
                FROM (order_details inner join `order_qtn_size`
                on `order_qtn_size`.`order_id` = `order_details`.`id`)
                where `order_details`.`po` = '".$po."'
                and `order_qtn_size`.`country_id` = '".$country_id."'
                and order_details.deletion_status != 1";

        // $sql = "SELECT
        //         DISTINCT order_country.tod FROM
        //         (order_country inner join `order_details`
        //         on `order_country`.`order_id` = `order_details`.`id`)
        //          WHERE `order_details`.`po` = '".$po."'
        //          and `order_country`.`country_id` = '".$country_id."'
        //          and order_country.`deletion_status` = 0";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_order_qty_by_po($po)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                order_details.id,
                (select sum(quantity) from order_qtn_size
                where order_id = order_details.id) as total_quantity
                FROM (order_details inner join `order_qtn_size`
                on `order_qtn_size`.`order_id` = `order_details`.`id`)
                where `order_details`.`po` = '".$po."'
                and order_details.deletion_status != 1";

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

    public function select_all_lower_id_values($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.*,
                IFNULL((select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id),0)  as cutting_production
                FROM `cutting_production`
                where `cutting_production`.`id` < $id
                and deletion_status != 1
                order by `cutting_production`.`id` desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_line_name($po,$cut_num)
    {
        $con = $this->connectToDB();

        $sql = "SELECT iissue_scan.*,
                (select name from line where id=iissue_scan.line) as line_name
                FROM `iissue_scan`
                where po = $po
                and cut_num = $cut_num
                and deletion_status != 1
                order by `iissue_scan`.id desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_line_name_qr($po,$cut_num)
    {
        $con = $this->connectToDB();

        $sql = "SELECT serial,
                line,
                (select name from line WHERE id=iissue_scan.line) as line_name
                FROM `iissue_scan`
                WHERE po = $po
                and cut_num = $cut_num
                and `deletion_status` = 0
                ORDER BY `iissue_scan`.id DESC";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_line_name_by_id($id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `bp_issue`.id as id,
                (select name from line where id = bp_issue.line) as line_name
                FROM ((`bp_issue` left join `cut_pro_bundle`
                on `cut_pro_bundle`.id = `bp_issue`.b_tkt_code)
                left join `cutting_production`
                on `cut_pro_bundle`.production_id = `cutting_production`.id)
                where bp_issue.deletion_status != 1
                and cut_pro_bundle.production_id = $id
                order by `bp_issue`.id desc";


        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }



    public function select_line_name_by_child_id($id)
    {
        $con = $this->connectToDB();
        $sql = "SELECT
                `bp_issue`.id as id,
                `bp_issue`.line as line,
                (select name from line where id = bp_issue.line) as line_name
                FROM `bp_issue` where
                `bp_issue`.b_tkt_code = '".$id."'
                and bp_issue.deletion_status != 1
                order by `bp_issue`.id desc LIMIT 1";


        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_line_name_by_child_id_qr($id)
    {
        $con = $this->connectToDB();
        $sql = "SELECT
                -- `bp_issue`.id as id,
                -- `bp_issue`.line as line,
                (select name from line WHERE id = bp_issue.line) as line_name
                FROM `bp_issue` WHERE
                `bp_issue`.b_tkt_code = '".$id."'
                and bp_issue.`deletion_status` = 0
                ORDER BY `bp_issue`.id DESC LIMIT 1";


        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }


    public function select_cut_pro_info_by_po($po,$size_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cutting_production.id,
                (select sum(quantity) from cut_pro_bundle where production_id = cutting_production.id and ticket_no = cut_pro_size.ticket_no and country_id = '".$country_id."') as total_quantity
                FROM `cutting_production` inner join `cut_pro_size` on `cutting_production`.`id` = `cut_pro_size`.`production_id` and `cut_pro_size`.`size` = '".$size_id."'
                where `cutting_production`.po = '".$po."'
                and cutting_production.deletion_status != 1
                order by `cutting_production`.`id` desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }
    public function select_iissue_scan_qty_by_po($po,$size_id,$country_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                `cutting_production`.id as cut_pro_id,
                (select sum(quantity) from bp_issue where b_tkt_code = cut_pro_bundle.id and cut_pro_bundle.ticket_no = cut_pro_size.ticket_no and cut_pro_bundle.country_id = '".$country_id."')  as total_scan_quantity FROM
                (`cutting_production` inner join `cut_pro_bundle` on `cutting_production`.`id` = `cut_pro_bundle`.`production_id`)
                inner join `cut_pro_size` on `cutting_production`.`id` = `cut_pro_size`.`production_id` and `cut_pro_size`.`size` = '".$size_id."'
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
    public function select_size_id($size_num)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                size.*
                FROM `size`
                where `size`.size_num = '".$size_num."'
                and deletion_status != 1 LIMIT 1";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    public function select_process_by_cut_pro_id($cut_pro_id)
    {
        $con = $this->connectToDB();

        $sql = "SELECT
                cut_process.pro_id
                FROM `cut_process`
                where cut_process.production_id = '".$cut_pro_id."'
                and deletion_status != 1
                order by `cut_process`.`id` desc";

        $query_result = mysqli_query($con, $sql);
        if ($query_result) {
            return $query_result;
        } else {
            die('Query problem' . mysqli_error($con));
        }
    }

    // public function select_ticket_no_by_size_cut_pro_id($cut_pro_id,$size_id)
    // {
    //     $con = $this->connectToDB();

    //     $sql = "SELECT
    //             cut_pro_size.*
    //             FROM `cut_pro_size`
    //             where `cut_pro_size`.production_id = $cut_pro_id
    //             and `cut_pro_size`.size = '".$size_id."'
    //             and deletion_status != 1
    //             order by `cut_pro_size`.`id` desc";

    //     $query_result = mysqli_query($con, $sql);
    //     if ($query_result) {
    //         return $query_result;
    //     } else {
    //         die('Query problem' . mysqli_error($con));
    //     }
    // }
    // public function select_qty_by_size_cut_pro_id($cut_pro_id,$ticket_no,$country_id)
    // {
    //     $con = $this->connectToDB();

    //     $sql = "SELECT
    //             sum(quantity) as total_quantity
    //             FROM `cut_pro_bundle`
    //             where `cut_pro_bundle`.production_id = $cut_pro_id
    //             and `cut_pro_bundle`.ticket_no = $ticket_no
    //             and `cut_pro_bundle`.country_id = $country_id
    //             and deletion_status != 1
    //             order by `cut_pro_bundle`.`id` desc";

    //     $query_result = mysqli_query($con, $sql);
    //     if ($query_result) {
    //         return $query_result;
    //     } else {
    //         die('Query problem' . mysqli_error($con));
    //     }
    // }



}

?>
