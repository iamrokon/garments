<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/pe_operator/select.php'; ?>
<?php require_once '../../DB/pe_operator/search.php'; ?>
<?php require_once '../../DB/style/select.php'; ?>
<?php require_once '../../DB/line/select.php'; ?>
<?php require_once '../../DB/operator/select.php'; ?>
<?php require_once '../../DB/process_e/select.php'; ?>

<?php
      $ob = new select_pe();

      $selectStyle = new select_style();
      $style_list = $selectStyle->select_all();

      $selectLine = new select_line();
      $line_list = $selectLine->select_all();

      $selectOperator = new select_pe();
      $operator_list = $selectOperator->select_all();

      $selectProcessE = new select_process_e();
      $process_e_list = $selectProcessE->select_all();

      if (isset($_POST['search'])) {
          $search= new search_pe();
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
                                <div class="input-group margin">
                                               <select class="form-control col-md-12" name="style_select" id="style_select">
                                                  <option value="">Select Style Name</option>

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
                              <label class="btn btn-info">Operator</label>
                              <div class="input-group margin" style="background-color:white;">
                                               <select class="form-control col-md-12" name="operator_select" id="operator_select">
                                                <option value="">Select Operator</option>

                                                <?php
                                                  while ($row = mysqli_fetch_assoc($operator_list))
                                                      {
                                                ?>
                                                <option value="<?php echo $row['operator_id']; ?>"><?php echo $row['name']."(".$row['operator_id'].")"; ?></option>
                                                <?php
                                                      }
                                                ?>
                                              </select>
                             </div>
                             </div>

                             <div class="form-group col-md-4">
                                 <label class="btn btn-info">Process</label>
                                 <div class="input-group margin" style="background-color:white;">
                                                  <select class="form-control col-md-12" name="process_select" id="process_select">
                                                   <option value="">Select Process</option>

                                                   <?php
                                                     while ($row = mysqli_fetch_assoc($process_e_list))
                                                         {
                                                   ?>
                                                   <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
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

                   <label class="btn btn-info" style="margin-right:10px;margin-top:10px;">Line List</label>
                   <div>
                   <input id="checkAllLine" value="0" type="checkbox" style="margin-left:10px;height:20px;width:20px;">
                   <text style="color:black;">  All</text>
                   </div>
                   <div id="size_list_div">
                   <div class="row" id="line_list_creation">
                   <?php
                         while ($row = mysqli_fetch_assoc($line_list))
                              {
                   ?>
                   <div class="col-md-2">
                   <input type="checkbox"  class="checkItem" style="margin-left:10px;height:20px;width:20px;" name="l_selection[]" value="<?php echo $row['id']; ?>">
                   <text style="color:black;" id="<?php echo "line_value_".$row['id']; ?>">  <?php echo $row['name']; ?></text>
                   </div>
                   <?php
                              }
                    ?>
                   </div>
                   </div>

                 <div class="text-center" style="padding-top: 10px;">
                 <button id="search" name="search" type="submit" class="btn btn-danger center-block">SEARCH</button>
                 </div>

                </form>
              </div>

              <div class="table-responsive table-striped w3-hoverable w3-small">
              <table id="export-table" class="table mb-0" style="width:100%" style="overflow-x:auto;">
                  <thead class="btn-gradient-01">
                      <tr>
                                    <th style="color:white;">Operator Name</th>
                                    <th style="color:white;">Line</th>
                                    <th style="color:white;">Operator ID</th>
                                    <th style="color:white;">Process Name</th>
                                    <th style="color:white;">SMV</th>
                                    <th style="color:white;">Target</th>
                                    <th style="color:white;">1st</th>
                                    <th style="color:white;">2nd</th>
                                    <th style="color:white;">3rd</th>
                                    <th style="color:white;">4th</th>
                                    <th style="color:white;">5th</th>
                                    <th style="color:white;">6th</th>
                                    <th style="color:white;">7th</th>
                                    <th style="color:white;">8th</th>
                                    <th style="color:white;">9th</th>
                                    <th style="color:white;">10th</th>
                                    <th style="color:white;">Total</th>
                                    <th style="color:white;">AVG</th>
                                    <th style="color:white;">Eff%</th>
                                    <th style="color:white;">Date</th>
                                    <th style="color:white;">Edit</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:black;"><?php echo $info['opt_name']; ?> </td>
                                      <td style="color:black;"><?php echo $info['line_name']; ?> </td>
                                      <td style="color:black;"><?php echo $info['opt_id']; ?> </td>
                                      <td style="color:black;"> <?php echo $info['process_name']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo number_format((float)$info['smv'], 2, '.', ''); ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $info['target']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $one = $info['one']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $two = $info['two']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $three = $info['three']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $four = $info['four']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $five = $info['five']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $six = $info['six']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $seven = $info['seven']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $eight = $info['eight']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $nine = $info['nine']; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $ten = $info['ten']; ?> </td>

                                      <?php
                                            $total = $one + $two + $three + $four + $five + $six + $seven + $eight + $nine + $ten;
                                      ?>

                                      <td style="color:black;" class="text-center"> <?php echo $total; ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo (int)$total/10; ?> </td>
                                      <td class="btn-gradient-02" style="color:white;"> <?php echo sprintf("%.2f", (($total/10)/$info['target']) * 100); ?> </td>
                                      <td style="color:black;" class="text-center"> <?php echo $info['e_date']; ?> </td>
                                      <td class="td-actions">
                                          <a href="pages/efficiency/update.php?id=<?php echo $info['id']; ?>"><i class="la la-edit edit"></i></a>
                                      </td>
                                  </tr>
                                 <?php $i++; } ?>
                              </tbody>
                          </table>
                         </div>
                      </div>
                  </div>
              </div>
