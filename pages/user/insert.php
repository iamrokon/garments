    <?php require_once '../../layout/main.php'; ?>
    <?php
    if (isset($_POST['btn'])) {
    $message = $db->save_user_info($_POST);
    }
    ?>

    <div class="content-inner">

        <div class="w3-animate-right">

            <!-- Begin Page Header-->
            <div class="box-default widget-body">
                <div class="box-header with-border " style=" background-color: red;padding: 5px; margin-top: 5px;">
                    <h3 class="box-title"></h3>
                    <span style="font-size: 20px;color: #fff;margin-left:10px;">
                        Add User Information
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
                    <form method="post" enctype="multipart/form-data" action="" class="needs-validation w3-card-4" novalidate>


                        <div class="row" style="padding-right: 10px;padding-left: 10px; padding-top: 10px;">

                         <div class="col-md-6">
                            <div class="form-group">

                                <label class="form-control-label">Full Name <span style="color:red;">*</span></label>

                                <div class="input-group">
                                    <span class="input-group-addon addon-primary">
                                        <i class="la la-user"></i>
                                    </span>
                                    <input type="text" name="full_name" class="form-control" placeholder ="Enter Full Name" required="">
                                </div>

                            </div>


                          <div class="form-group">

                          <label class="form-control-label">Password <span style="color:red;">*</span></label>

                          <div class="input-group">
                          <span class="input-group-addon addon-primary">
                          <i class="la la-unlock"></i>
                          </span>
                          <input type="text" name="password" class="form-control" placeholder ="Enter Password" required="">
                          </div>
                          </div>


                            <div class="form-group">

                                <label class="form-control-label">Telephone <span style="color:red;">*</span></label>

                                <div class="input-group">
                                    <span class="input-group-addon addon-primary">
                                        <i class="la la-phone"></i>
                                    </span>
                                    <input type="text" name="tel" class="form-control" placeholder ="Enter Telephone" required="">
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
                            <input type="text" name="user_name" class="form-control" placeholder ="Enter User Name" required="">
                        </div>

                    </div>


                    <div class="form-group">
                        <label class="form-control-label">Address </label>
                        <div class="input-group">
                            <span class="input-group-addon addon-primary">
                                <i class="la la-building-o"></i>
                            </span>
                            <input type="text" name="address" class="form-control" placeholder ="Enter Address">
                        </div>

                    </div>


                    <div class="form-group">

                        <label class="form-control-label">Image</label>

                        <div class="input-group">
                            <span class="input-group-addon addon-primary">
                                <i class="la la-image"></i>
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
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
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
                                   <input type="checkbox" id="checkAll" name="l_permission[]" value="ALL">
                                   <label style="margin-left: 8px;color: black;">ALL</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="cproduction" class="checkItem">
                                    <label style="margin-left: 8px;">Cutting Production</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="swing_output" class="checkItem">
                                    <label style="margin-left: 8px;">Swing Output</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="efficiency" class="checkItem">
                                    <label style="margin-left: 8px;">Efficiency</label>
                              </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="nqc_rqc" class="checkItem">
                                    <label style="margin-left: 8px;">NQC/RQC</label>
                              </div>
                            </div>

                            <div class="col-md-3" style="padding:20px;">
                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="umanagement"  class="checkItem">
                                  <label style="margin-left: 8px;">User Management</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="iissue" class="checkItem">
                                  <label style="margin-left: 8px;">Input Issue</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="finishing" class="checkItem">
                                  <label style="margin-left: 8px;">Finishing</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="trims_inhouse" class="checkItem">
                                  <label style="margin-left: 8px;">Trims Inhouse</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="planning" class="checkItem">
                                  <label style="margin-left: 8px;">Planning</label>
                              </div>
                            </div>

                            <div class="col-md-3" style="padding:20px;">
                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="pro_setup" class="checkItem">
                                  <label style="margin-left: 8px;">Product Setup</label>
                              </div>

                             <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="cplan" class="checkItem">
                                  <label style="margin-left: 8px;">Cutting Plan</label>
                              </div>

                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="shipment" class="checkItem">
                                  <label style="margin-left: 8px;">Shipment</label>
                              </div>


                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="display_system" class="checkItem">
                                  <label style="margin-left: 8px;">Display System</label>
                              </div>

                            </div>

                            <div class="col-md-3" style="padding:20px;">
                              <div class="form-group">
                                  <input type="checkbox" id="checkItem" name="l_permission[]" value="order_processing"  class="checkItem">
                                  <label style="margin-left: 8px;">Order Processing</label>
                              </div>

                              <div class="form-group">
                                   <input type="checkbox" id="checkItem" name="l_permission[]" value="wash_send" class="checkItem">
                                   <label style="margin-left: 8px;">Wash Send</label>
                               </div>

                              <div class="form-group">
                                    <input type="checkbox" id="checkItem" name="l_permission[]" value="dhu_style" class="checkItem">
                                    <label style="margin-left: 8px;">DHU Style</label>
                              </div>

                             <div class="form-group">
                                   <input type="checkbox" id="checkItem" name="l_permission[]" value="maintenance" class="checkItem">
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
                                                            <input type="checkbox" id="checkAllD" name="d_permission[]" value="ALL">
                                                            <label style="margin-left: 8px;color: black;">ALL</label>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="checkbox" id="checkItemD" name="d_permission[]" value="daily_trims_inhouse" class="checkItemD">
                                                            <label style="margin-left: 8px;">Daily Trims Inhouse</label>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="checkbox" id="checkItemD" name="d_permission[]" value="swing_output" class="checkItemD">
                                                            <label style="margin-left: 8px;">Swing Output</label>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="checkbox" id="checkItemD" name="d_permission[]" value="dhu" class="checkItemD">
                                                            <label style="margin-left: 8px;">DHU %</label>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="checkbox" id="checkItemD" name="d_permission[]" value="wash_recieved" class="checkItemD">
                                                            <label style="margin-left: 8px;">Wash Recieve</label>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="checkbox" id="checkItemD" name="d_permission[]" value="finishing_wip" class="checkItemD">
                                                            <label style="margin-left: 8px;">Finishing WIP</label>
                                                        </div>

                                                        <div class="form-group">
                                                            <input type="checkbox" id="checkItemD" name="d_permission[]" value="auto_send_email" class="checkItemD">
                                                            <label style="margin-left: 8px;">Auto Email Send</label>
                                                        </div>
                                            </div>



                                            <div class="col-md-3" style="padding:20px;">
                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="order" class="checkItemD">
                                                  <label style="margin-left: 8px;">Order</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="monthly_trims_inhouse" class="checkItemD">
                                                  <label style="margin-left: 8px;">Monthly Trims Inhouse</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="swing_wip" class="checkItemD">
                                                  <label style="margin-left: 8px;">Swing WIP</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="ncq_inline_inspection" class="checkItemD">
                                                  <label style="margin-left: 8px;">NCQ Inline Inspection</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="wash_wip" class="checkItemD">
                                                  <label style="margin-left: 8px;">Wash WIP</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="shipment" class="checkItemD">
                                                  <label style="margin-left: 8px;">Shipment</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="maintenance" class="checkItemD">
                                                  <label style="margin-left: 8px;">Maintenance</label>
                                              </div>
                                            </div>



                                            <div class="col-md-3" style="padding:20px;">
                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="cutting_production" class="checkItemD">
                                                  <label style="margin-left: 8px;">Cutting Production</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="input_issue_to_swing" class="checkItemD">
                                                  <label style="margin-left: 8px;">Input Issue To Swing</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="hr" class="checkItemD">
                                                  <label style="margin-left: 8px;">HR</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="rqs_inspection_audit" class="checkItemD">
                                                  <label style="margin-left: 8px;">RQS Inspection & Audit</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="finishing_input" class="checkItemD">
                                                  <label style="margin-left: 8px;">Finishing Input</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="shipment_short_excess" class="checkItemD">
                                                  <label style="margin-left: 8px;">Shipment Short/Excess</label>
                                              </div>
                                            </div>

                                            <div class="col-md-3" style="padding:20px;">
                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="cutting_wip" class="checkItemD">
                                                  <label style="margin-left: 8px;">Cutting WIP</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="pro_planning" class="checkItemD">
                                                  <label style="margin-left: 8px;">Production Planning</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="eff_calculation" class="checkItemD">
                                                  <label style="margin-left: 8px;">Efficiency Calculation</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="wash_send" class="checkItemD">
                                                  <label style="margin-left: 8px;">Wash Send</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="finishing_output" class="checkItemD">
                                                  <label style="margin-left: 8px;">Finishing Output</label>
                                              </div>

                                              <div class="form-group">
                                                  <input type="checkbox" id="checkItemD" name="d_permission[]" value="display_system" class="checkItemD">
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
    $('#checkAll').click(function () {
    $(':checkbox.checkItem').prop('checked', this.checked);
 });
    $('#checkAllD').click(function () {
    $(':checkbox.checkItemD').prop('checked', this.checked);
 });
</script>
