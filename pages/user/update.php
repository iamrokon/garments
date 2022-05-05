<?php require_once '../../layout/main.php'; ?>

<?php
  $id = $_GET['id'];

  $result = $db->select_user($id);
  $data = mysqli_fetch_assoc($result);

  //left menu check
  $lmenuCheck = $data['lpermissions'];
  $lmenuCheckArray = explode(",", $lmenuCheck);

  //dashboard check
  $dashCheck = $data['dpermissions'];
  $dashCheckArray = explode(",", $dashCheck);

  if (isset($_POST['btn'])) {
    $message = $db->update_user($_POST);
    }
?>

<div class="content-inner">

    <div class=" w3-animate-right">

        <!-- Begin Page Header-->
        <div class="box-default widget-body">
            <div class="box-header with-border " style=" background-color: #3c8dbc;padding: 15px; margin-top: 5px;">
                <h3 class="box-title"></h3>
                <span style="font-size: 14px;color: #fff">
                    All star marked ( <span style="color:red;">*</span> ) fields are mandatory, please fill up all mandatory fields.
                </span>
              <h4 style="color: #fff; text-align: center">
               <?php
               if (isset($message)) {
                   echo $message;
                   unset($message);
               }
               ?>
               </h4>
            </div>
            <!-- End Page Header -->
            <div class="box-body">
                <form method="post" enctype="multipart/form-data" id="update-form"  action="" class="needs-validation w3-card-4" novalidate>


                    <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

                     <div class="col-md-6">
                        <div class="form-group">

                            <label class="form-control-label">Full Name <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-user"></i>
                                </span>
                                <input type="text" name="full_name" class="form-control" value="<?php echo $data['full_name']; ?>" placeholder ="Enter First Name" required="">
                                <input type="hidden" name="id" class="form-control" id="id" value="<?php echo $data['id']; ?>" required="">
                                <input type="hidden" name="pImage" class="form-control" id="pImage" value="<?php echo $data['image']; ?>" required="">
                            </div>

                        </div>


                        <div class="form-group">

                            <label class="form-control-label">Password <span style="color:red;">*</span></label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-unlock"></i>
                                </span>
                                <input type="text" name="password" value="" class="form-control" placeholder ="Enter Password To Update" required="">
                            </div>

                        </div>



                        <div class="form-group">

                            <label class="form-control-label">Telephone</label>

                            <div class="input-group">
                                <span class="input-group-addon addon-primary">
                                    <i class="la la-phone"></i>
                                </span>
                                <input type="Email" name="tel" value="<?php echo $data['tel']; ?>" class="form-control" placeholder ="Enter Telephone">
                            </div>

                        </div>


                        <div class="form-group">

                            <label class="form-control-label">User Type<span style="color:red;">*</span></label>

                            <div class="input-group">
                               <span class="input-group-addon addon-primary">
                                <i class="la la-group"></i>
                            </span>
                            <select name="type" class="form-control" required="">
                                <option value="">Select Type</option>
                                <option value="1">User</option>
                                <option value="2">Controller</option>
                            </select>
                        </div>

                    </div>


            </div>



            <div class="col-md-6">
              <div class="form-group">

                  <label class="form-control-label">User Name <span style="color:red;">*</span></label>

                  <div class="input-group">
                      <span class="input-group-addon addon-primary">
                          <i class="la la-user"></i>
                      </span>
                      <input type="text" name="user_name" value="<?php echo $data['user_name']; ?>" class="form-control" placeholder ="Enter User Name" required="">
                  </div>

              </div>


              <div class="form-group">
                  <label class="form-control-label">Address </label>
                  <div class="input-group">
                      <span class="input-group-addon addon-primary">
                          <i class="la la-building-o"></i>
                      </span>
                      <input type="text" value="<?php echo $data['address']; ?>" name="address" class="form-control" placeholder ="Enter Address">
                  </div>

              </div>



              <div class="form-group">

                  <label class="form-control-label">Image</label>

                  <div class="input-group">
                    <span >
                        <img src=./pages/user/<?php echo $data['image']; ?> alt="name" height="45px" width="50px">
                    </span>
                      <input type="file" name="image" class="form-control" required="">
                  </div>

              </div>

                <div class="form-group">

                    <label class="form-control-label">Status <span style="color:red;">*</span></label>

                    <div class="input-group">
                       <span class="input-group-addon addon-primary">
                        <i class="la la-unsorted"></i>
                    </span>
                    <select name="status" class="form-control" required="">
                        <option value="">Select Status</option>

                        <?php if($data['status'] == 1) { ?>

                        <option value="1" selected>Active</option>

                      <?php } else if($data['status'] == 0){ ?>

                        <option value="0">Inactive</option>

                      <?php }?>

                    </select>
                </div>

            </div>

        </div>

    </div>


    <div class="box-header with-border " style=" background-color: red;padding: 5px; margin-top: 5px;margin-right:5px;margin-left:5px;">
        <h3 class="box-title"></h3>
        <span style="font-size: 14px;color: #fff">
            Select Left Menu Permission
        </span>
    </div>



        <div class="row" style="margin-left:10px;" id="lpermission_list_div">
                           <div class="col-md-3" style="padding:20px;">
                              <div class="form-group">
                                   <input type="checkbox" id="checkAllLpermission" name="l_permission[]" value="ALL">
                                   <label style="margin-left: 8px;color: black;">ALL</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="cproduction" <?php echo(in_array('cproduction', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                    <label style="margin-left: 8px;">Cutting Production</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="swing_output" <?php echo(in_array('swing_output', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                    <label style="margin-left: 8px;">Swing Output</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="efficiency" <?php echo(in_array('efficiency', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                    <label style="margin-left: 8px;">Efficiency</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="nqc_rqc" <?php echo(in_array('nqc_rqc', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                    <label style="margin-left: 8px;">NQC/RQC</label>
                              </div>
                            </div>

                            <div class="col-md-3" style="padding:20px;">
                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="umanagement" <?php echo(in_array('umanagement', $lmenuCheckArray) ? "checked='checked'" : "") ?>  class="checkItem">
                                  <label style="margin-left: 8px;">User Management</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="iissue" <?php echo(in_array('iissue', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Input Issue</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="finishing" <?php echo(in_array('finishing', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Finishing</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="trims_inhouse" <?php echo(in_array('trims_inhouse', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Trims Inhouse</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="planning" <?php echo(in_array('planning', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Planning</label>
                              </div>
                            </div>

                            <div class="col-md-3" style="padding:20px;">
                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="pro_setup" <?php echo(in_array('pro_setup', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Product Setup</label>
                              </div>

                             <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="cplan" <?php echo(in_array('cplan', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Cutting Plan</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="shipment" <?php echo(in_array('shipment', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Shipment</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="display_system" <?php echo(in_array('display_system', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Display System</label>
                              </div>
                            </div>

                            <div class="col-md-3" style="padding:20px;">
                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="order_processing" <?php echo(in_array('order_processing', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                  <label style="margin-left: 8px;">Order Processing</label>
                              </div>

                              <div class="form-group">
                                   <input type="checkbox" id="checkItem" name="l_permission[]" value="wash_send" <?php echo(in_array('wash_send', $lmenuCheckArray) ? "checked='checked'" : "") ?> class="checkItem">
                                   <label style="margin-left: 8px;">Wash Send</label>
                               </div>

                               <div class="form-group">
                                     <input type="checkbox" id="checkItem" name="l_permission[]" value="dhu_style" <?php echo(in_array('dhu_style', $lmenuCheckArray) ? "checked='checked'" : "") ?>  class="checkItem">
                                     <label style="margin-left: 8px;">DHU Style</label>
                               </div>

                               <div class="form-group">
                                     <input type="checkbox" id="checkItem" name="l_permission[]" value="maintenance" <?php echo(in_array('maintenance', $lmenuCheckArray) ? "checked='checked'" : "") ?>  class="checkItem">
                                     <label style="margin-left: 8px;">Maintenance</label>
                               </div>
                            </div>

                    </div>


                    <div class="box-header with-border " style=" background-color: red;padding: 5px; margin-top: 5px;margin-right:5px;margin-left:5px;">
                        <h3 class="box-title"></h3>
                        <span style="font-size: 14px;color: #fff">
                            Select Dashboard Permission
                        </span>
                    </div>


                    <div class="row" style="margin-left:10px;" id="dpermission_list_div">
                                       <div class="col-md-3" style="padding:20px;">
                                                  <div class="form-group">
                                                        <input type="checkbox" id="checkAllDpermission" name="d_permission[]" value="ALL">
                                                        <label style="margin-left: 8px;color: black;">ALL</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkItem" name="d_permission[]" value="daily_trims_inhouse" <?php echo(in_array('daily_trims_inhouse', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                                        <label style="margin-left: 8px;">Daily Trims Inhouse</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkItem" name="d_permission[]" value="swing_output" <?php echo(in_array('swing_output', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                                        <label style="margin-left: 8px;">Swing Output</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkItem" name="d_permission[]" value="dhu" <?php echo(in_array('dhu', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                                        <label style="margin-left: 8px;">DHU %</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkItem" name="d_permission[]" value="wash_recieved" <?php echo(in_array('wash_recieved', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                                        <label style="margin-left: 8px;">Wash Recieve</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkItem" name="d_permission[]" value="finishing_wip" <?php echo(in_array('finishing_wip', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                                        <label style="margin-left: 8px;">Finishing WIP</label>
                                                    </div>

                                                    <div class="form-group">
                                                        <input type="checkbox" id="checkItem" name="d_permission[]" value="auto_send_email" <?php echo(in_array('auto_send_email', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                                        <label style="margin-left: 8px;">Auto Email Send</label>
                                                    </div>
                                        </div>



                                        <div class="col-md-3" style="padding:20px;">
                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="order" <?php echo(in_array('order', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Order</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="monthly_trims_inhouse" <?php echo(in_array('monthly_trims_inhouse', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Monthly Trims Inhouse</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="swing_wip" <?php echo(in_array('swing_wip', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Swing WIP</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="ncq_inline_inspection" <?php echo(in_array('ncq_inline_inspection', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">NCQ Inline Inspection</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="wash_wip" <?php echo(in_array('wash_wip', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Wash WIP</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="shipment" <?php echo(in_array('shipment', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Shipment</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="maintenance" <?php echo(in_array('maintenance', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Maintenance</label>
                                          </div>
                                        </div>



                                        <div class="col-md-3" style="padding:20px;">
                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="cutting_production" <?php echo(in_array('cutting_production', $dashCheckArray) ? "checked='checked'" : "") ?>  class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Cutting Production</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="input_issue_to_swing" <?php echo(in_array('input_issue_to_swing', $dashCheckArray) ? "checked='checked'" : "") ?>  class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Input Issue To Swing</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="hr" <?php echo(in_array('hr', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">HR</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="rqs_inspection_audit" <?php echo(in_array('rqs_inspection_audit', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">RQS Inspection & Audit</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="finishing_input" <?php echo(in_array('finishing_input', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Finishing Input</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="shipment_short_excess" <?php echo(in_array('shipment_short_excess', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Shipment Short/Excess</label>
                                          </div>
                                        </div>

                                        <div class="col-md-3" style="padding:20px;">
                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="cutting_wip" <?php echo(in_array('cutting_wip', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Cutting WIP</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="pro_planning" <?php echo(in_array('pro_planning', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Production Planning</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="eff_calculation" <?php echo(in_array('eff_calculation', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Efficiency Calculation</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="wash_send" <?php echo(in_array('wash_send', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Wash Send</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="finishing_output" <?php echo(in_array('finishing_output', $dashCheckArray) ? "checked='checked'" : "") ?>  class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Finishing Output</label>
                                          </div>

                                          <div class="form-group">
                                              <input type="checkbox" id="checkItem" name="d_permission[]" value="display_system" <?php echo(in_array('display_system', $dashCheckArray) ? "checked='checked'" : "") ?> class="checkItemDashboard">
                                              <label style="margin-left: 8px;">Display System</label>
                                          </div>
                                        </div>

                                </div>


    <div class="text-center" style="padding-bottom: 10px;">
        <button name="btn" class="btn btn-gradient-03" type="submit">Save Info</button>
        <button class="btn btn-gradient-05" type="reset">  Reset  </button>
    </div>


</form>

</div>
</div>
</div>
</div>

<script>

   // $('#checkAllDpermission').click(function () {
   //     $("#dpermission_list_div :checkbox").attr('checked', true);
   // });
   //
   // $('#checkAllLpermission').click(function () {
   //        $("#lpermission_list_div :checkbox").attr('checked', true);
   //    });

</script>

<script>
    $('#checkAllLpermission').click(function () {
    $(':checkbox.checkItem').prop('checked', this.checked);
 });
    $('#checkAllDpermission').click(function () {
    $(':checkbox.checkItemDashboard').prop('checked', this.checked);
 });
</script>
