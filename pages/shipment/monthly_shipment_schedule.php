<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/shipment/select.php'; ?>
<?php require_once '../../DB/order/search_c_plan.php'; ?>
<?php require_once '../../DB/size/select.php'; ?>
<?php require_once '../../DB/country/select.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>

<?php
      $ob = new select_shipment();
      $result = $ob->select_all_child_current_month_shipment();

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

    <div class="w3-animate-right" style="margin-top:15px;margin-bottom:15px;">

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


              <table id="export-table" class="table table-striped w3-hoverable display nowrap w3-table-all w3-small" style="width:100%" style="overflow-x:auto;">
                  <thead>
                      <tr  class="btn-gradient-02">
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;"><span style="width:100px;">Style Name</span></th>
                                    <th style="color:white;">PO Number</th>
                                    <th style="color:white;">Country</th>
                                    <th style="color:white;">TOD</th>
                                    <th style="color:white;">Shipping Quantity</th>
                                    <th style="color:white;">Week</th>
                                    <th style="color:white;">Creation Date</th>
                                    <th style="color:white;">Creation Time</th>
                                    <th style="color:white;">Creator</th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:black;" class="text-center"><?php echo $info['id']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['style_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['po_number']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['country_name']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['TOD']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['shipment_quantity']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo "Week-".$info['week_number']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['creation_date']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['creation_time']; ?> </td>
                                      <td style="color:black;" class="text-center"><?php echo $info['user_name']; ?> </td>
                                      <td class="td-actions" class="text-center">
                                          <a href="./pages/shipment/details_shipment.php?id=<?php echo $info['id']; ?>"><button class="btn  btn-xs btn-success">Details</button></a>
                                      </td>
                                  </tr>
                                 <?php $i++;} ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
