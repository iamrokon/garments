<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/shipment/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/order/select.php'; ?>

<?php
      // $ob = new select_shipment();
      // $result = $ob->select_all_order_list();

      $select_order = new select_order();

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

    <div class="w3-animate-right" style="margin-left:15px;margin-right:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">


              <div style="margin-right: 10px;margin-top: 10px;" id ="search">

                <form method="POST" action="">

                          <div class="row">

                            <div class="form-group col-md-4">
                                <label class="btn btn-info">Style Name</label>
                                <div class="input-group margin" style="margin-top: 0px">
                                               <select class="form-control col-md-12" name="style_select" id="style_select">
                                                  <option value="">Select Name</option>

                                                  <?php
                                                    while ($row = mysqli_fetch_assoc($style_list))
                                                        {
                                                  ?>
                                                  <option value="<?php echo $row['id']; ?>"><?php echo $row['style_name']; ?></option>
                                                  <?php
                                                        }
                                                  ?>
                                                </select>
                                </div>
                          </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">PO Number</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                          <select class="form-control col-md-12" name="po_select" id="po_select">
                                           <option value="">Select PO</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($po_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['po_num']; ?></option>
                                           <?php
                                                 }
                                           ?>
                                         </select>
                        </div>
                        </div>

                     <div class="form-group col-md-4">
                         <label class="btn btn-info">Country</label>
                         <div class="input-group margin" style="margin-top: 0px">
                                           <select class="form-control col-md-12" name="country_select" id="country_select">
                                           <option value="">Select Country</option>

                                           <?php
                                             while ($row = mysqli_fetch_assoc($country_list))
                                                 {
                                           ?>
                                           <option value="<?php echo $row['id']; ?>"><?php echo $row['full_name']; ?></option>
                                           <?php
                                                 }
                                           ?>
                                         </select>
                                      </div>
                                     </div>

                   </div>

                   <div class="row">

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
                 </div>

                </form>
              </div>

              <h4 style="color: #fff; text-align: center" id="mgs">
               <?php
               if (isset($_SESSION['message'])) {
                   echo $_SESSION['message'];
                   unset($_SESSION['message']);
               }
               ?>
               </h4>


              <table id="example" class="table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;"><span style="width:100px;">Style Name</span></th>
                                    <th style="color:white;">PO Number</th>
                                    <th style="color:white;">Country</th>
                                    <th style="color:white;">Order Quantity</th>
                                    <th style="color:white;">Cutting(%)</th>
                                    <th style="color:white;">Creation Date</th>
                                    <th style="color:white;">Creation Time</th>
                                    <th style="color:white;">Creator</th>
                                    <th style="color:white;" class="text-center">Actions</th>
                                  </tr>
                              </thead>






                              <tfoot>
                                  <tr class="btn-gradient-02">
                                      <td style="font-weight: bold;">Count</td>
                                      <td style="font-weight: bold;"><span style="width:80px;"><?php //echo $i; ?></span></td>
                                      <td style="font-weight: bold;"><span style="width:80px;"></span></td>
                                      <td style="font-weight: bold;"></td>
                                      <td style="font-weight: bold;">Total&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php //echo $total_order_qty; ?></td>
                                      <td style="font-weight: bold;"></td>
                                      <td colspan="4" style="font-weight: bold;"></td>
                                  </tr>
                              </tfoot>


                          </table>
                      </div>
                  </div>
              </div>

<script>
  $(document).ready(function(){
       var dataTable=$('#example').DataTable({
           "processing": true,
           "serverSide":true,
           "ajax":{
               url:"pages/order/fetch.php",
               type:"post",
               dataSrc: function ( data ) {
                  recordsTotal = data.recordsTotal;
                  total_order_qty = data.total_order_qty;

                  return data.data;
               }
           },
            dom: 'lBfrtip',
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],


            drawCallback: function( settings ) {
              var api = this.api();

              $( api.column( 0 ).footer() ).html(
                'Total Records: '+recordsTotal
              );
              $( api.column( 4 ).footer() ).html(
                'Total: '+total_order_qty
              );
            }
       });
   });
</script>
