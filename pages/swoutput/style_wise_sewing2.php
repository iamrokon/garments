<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/swoutput/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/cproduction/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>



<?php

$user_id = $_SESSION['id'];
$order_id = $_GET['id'];
$from_date = $_GET['from_date'];
$to_date = $_GET['to_date'];

 $selectOrder = new select_order();
 $order_result = $selectOrder->select_with_id($order_id);
 $selectCProduction = new select_cproduction();
// $order_child_size_country = $selectOrder->select_child_with_order($order_id);
// while ($row = mysqli_fetch_assoc($order_child_size_country)){
//   echo '<pre>';
//   print_r($row['size']);
//   echo '</pre>';
// }

$order_details = mysqli_fetch_assoc($order_result);

      $selectLine = new select_line();

      $ob = new select_swoutput();
      $date = date("d-m-Y");

      $selectLine = new select_line();
      $line_list =  $selectLine->select_all();

      $ob_c = new select_cproduction();

      $selectSize = new select_size();
      $size_list =  $selectSize->select_all();

      $selectCountry = new select_country();
      $country_list =  $selectCountry->select_all();

      $selectPO = new select_po();
      $po_list =  $selectPO->select_all();

      $selectStyle = new select_style();
      $style_list =  $selectStyle->select_all();


      if (isset($_POST['search'])) {
          $search= new search_c_plan();
          $result = $search->search($_POST);
      }
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-right:10px;margin-left:10px;">

            <div class="w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


              <div style="margin-right: 10px;margin-top: 10px;" id ="search">

                <form method="POST" action="">

                          <div class="row">
                            <input type="hidden" id="order_id" value="<?php echo $order_id;?>">
                            <input type="hidden" id="user_id" value="<?php echo $user_id;?>">
                            <input type="hidden" id="from_date" value="<?php echo $from_date;?>">
                            <input type="hidden" id="to_date" value="<?php echo $to_date;?>">
                            <!-- <div class="form-group col-md-4">
                                <label class="btn btn-info">Style Name</label>
                                <div class="input-group margin" style="margin-top: 0px">
                                               <select class="form-control col-md-12" name="style_select" id="style_select">
                                                  <option value="">Select Name</option>

                                                  <?php
                                                    // while ($row = mysqli_fetch_assoc($style_list))
                                                    //     {
                                                  ?>
                                                  <option value="<?php //echo $row['id']; ?>"><?php //echo $row['style_name']; ?></option>
                                                  <?php
                                                        //}
                                                  ?>
                                                </select>
                                </div>
                          </div> -->

                     <!-- <div class="form-group col-md-4">
                         <label class="btn btn-info">PO Number</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                          <select class="form-control col-md-12" name="po_select" id="po_select">
                                           <option value="">Select PO</option>

                                           <?php
                                             // while ($row = mysqli_fetch_assoc($po_list))
                                             //     {
                                           ?>
                                           <option value="<?php //echo $row['id']; ?>"><?php //echo $row['po_num']; ?></option>
                                           <?php
                                                 //}
                                           ?>
                                         </select>
                        </div>
                        </div> -->

                     <!-- <div class="form-group col-md-4">
                         <label class="btn btn-info">Line</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="line_select" id="line_select">
                                           <option value="">Select Line</option>

                                           <?php
                                             // while ($row = mysqli_fetch_assoc($line_list))
                                             //     {
                                           ?>
                                           <option value="<?php //echo $row['id']; ?>"><?php //echo $row['name']; ?></option>
                                           <?php
                                                 //}
                                           ?>
                                         </select>
                                      </div>
                                     </div> -->

                   </div>

                   <!-- <div class="row">

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">From Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="from_date" name="from_date" autocomplete="off">
                     </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">To Date</label>
                         <input style="margin-top: 2px;" class="form-control" type="date" id="to_date" name="to_date" autocomplete="off">
                     </div>

                 </div>

                 <div class="text-center" style="padding-top: 10px;">
                 <button id="search" name="search" type="submit" class="btn btn-danger center-block">SEARCH</button>
                 </div> -->

                </form>
              </div>



          <div class="table-responsive table-striped w3-hoverable w3-small" style="padding:25px;">
              <table id="example" class="table table-soutput table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                            <th style="color:white;">Line No</th>
                            <th style="color:white;">Style</th>
                            <th style="color:white;">PO</th>
                            <th style="color:white;">Country</th>
                            <?php
                              $order_child_size_country = $selectOrder->select_child_with_order($order_id);
                                  while ($row = mysqli_fetch_assoc($order_child_size_country)){

                            ?>
                            <th style="color:white;">
                              <?php
                                     echo $row['size'];
                                     $size_id[] = $row['size_id'];
                              ?>
                            </th>
                            <?php
                                  }
                            ?>
                            <th>Total</th>

                          </tr>
                      </thead>

                  </table>
               </div>
            </div>
          </div>
      </div>

      <script>
        $(document).ready(function(){
          var o_id = $('#order_id').val();
          var u_id = $('#user_id').val();
          var f_date = $("#from_date").val();
          var t_date = $("#to_date").val();
             var dataTable=$('#example').DataTable({
                 "processing": true,
                 "serverSide":true,
                 "ajax":{
                     url:"pages/swoutput/fetch_style_wise_sewing2.php",
                     type:"post",
                     data: { order_id: o_id,user_id: u_id,from_date: f_date,to_date: t_date}
                 },
                  dom: 'lBfrtip',
                  "lengthMenu": [[10, 25, 50, 100, 200, 500, 1000, -1], [10, 25, 50, 100, 200, 500, 1000, "All"]],
                  buttons: [
                      'copy', 'csv', 'excel', 'pdf', 'print'
                  ]
             });
         });
      </script>
