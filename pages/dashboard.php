<?php require_once dirname(__FILE__).'/../layout/main.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/dashboard.php'; ?>
<?php $dashCheckArray = $_SESSION['dpermissionsArray']; ?>
<?php require_once dirname(__FILE__).'/../DB/swoutput/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/wsend/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/fin/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/shipment/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/trims_inhouse/select.php'; ?>
<?php require_once dirname(__FILE__).'/../DB/trims_inhouse/search.php'; ?>

<?php
$dashboard = new dashboard();
$totalOrderQuantity = $dashboard->getTotalOrderQuantity();
$totalCutProQuantity = $dashboard->getTotalCuttingProductionQuantity();

$totalInputIssue = $dashboard->getTotalInputIssue();
// echo '<pre/>';
// print_r($totalInputIssue);
// exit();
$result = $dashboard->getTotalTrimsInhouse();

?>


<div class="content-inner">
        <div class="">
               <div class="row" style="margin-top: 4px;margin-right:4px;margin-left:4px;">

                           <?php
                                $permission = (in_array('order', $dashCheckArray) ? "1" : "0");
                                if($permission == '1'){
                           ?>
                            <div class="col-xl-3 ">
                                <div class="widget widget-12 has-shadow">
                                  <a href="./pages/order/insert.php">
                                    <div class="widget-body">
                                        <div class="media">
                                            <div class="align-self-center ml-2 mr-2">
                                                <i class="la la-shopping-cart" style="color:red;"></i>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <div class="title text-facebook"><?php echo $totalOrderQuantity; ?></div>
                                                <div class="number" style="color:red;">Order</div>
                                            </div>
                                        </div>
                                    </div>
                                  </a>
                                </div>
                            </div>
                          <?php } ?>



                            <?php
                                 $permission = (in_array('cutting_production', $dashCheckArray) ? "1" : "0");
                                 if($permission == '1'){
                            ?>
                            <div class="col-xl-3 col-md-6 col-sm-6">
                                <div class="widget widget-12 has-shadow">
                                  <a href="./pages/cproduction/insert.php">
                                    <div class="widget-body">
                                        <div class="media">
                                            <div class="align-self-center ml-2 mr-2">
                                                <i class="la la-cut" style="color:orange;"></i>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <div class="title text-linkedin"><?php echo $totalCutProQuantity; ?></div>
                                                <div class="number"  style="color:orange;">Cutting Production</div>
                                            </div>
                                        </div>
                                    </div>
                                  </a>
                                </div>
                            </div>
                            <?php } ?>


                            <?php
                                 $permission = (in_array('cutting_wip', $dashCheckArray) ? "1" : "0");
                                 if($permission == '1'){
                            ?>
                            <div class="col-xl-3 col-md-6 col-sm-6">
                                <div class="widget widget-12 has-shadow">
                                    <div class="widget-body">
                                        <div class="media">
                                            <div class="align-self-center ml-2 mr-2">
                                                <i class="la la-chain-broken" style="color:purple;"></i>
                                            </div>
                                            <div class="media-body align-self-center">
                                                <div class="title text-linkedin"><?php echo $totalCutProQuantity-$totalInputIssue; ?></div>
                                                <div class="number" style="color:purple;">Cutting WIP</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>


                            <?php
                                 $permission = (in_array('cutting_wip', $dashCheckArray) ? "1" : "0");
                                 if($permission == '1'){
                            ?>
                            <div class="col-xl-3 ">
                                <div class="widget widget-12 has-shadow">
                                  <a href="./pages/trinhouse/po_sheet.php">
                                    <div class="widget-body">
                                        <div class="media">
                                            <div class="align-self-center ml-2 mr-2">
                                                <i class="la la-university" style="color:green;"></i>
                                            </div>
                                            <?php
                                               $i = 1; $Balance = 0;
                                               while ($info = mysqli_fetch_assoc($result)){
                                                   $Balance += $info['total_balance'];
                                               }
                                            ?>
                                            <div class="media-body align-self-center">
                                                <div class="title text-facebook">
                                                    <?php echo $Balance; ?>
                                                </div>
                                                <div class="number" style="color:green;">Trims Store</div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                                </div>
                            </div>
                            <?php } ?>


                                   <?php
                                     $permission = (in_array('monthly_trims_inhouse', $dashCheckArray) ? "1" : "0");
                                     if($permission == '1'){
                                   ?>
                                     <div class="col-xl-3 col-md-6 col-sm-6">
                                         <div class="widget widget-12 has-shadow">
                                           <a href="./pages/trinhouse/po_sheet.php">
                                             <div class="widget-body">
                                                 <div class="media">
                                                     <div class="align-self-center ml-2 mr-2">
                                                         <i class="la la-university" style="color:crimson;"></i>
                                                     </div>
                                                     <div class="media-body align-self-center">
                                                         <div class="title text-twitter"><?php //echo $o_data['total'] ?></div>
                                                         <div class="number"  style="color:crimson;">Maintenance</div>
                                                     </div>
                                                 </div>
                                             </div>
                                           </a>
                                         </div>
                                     </div>
                                     <?php } ?>



                                     <?php
                                       $permission = (in_array('input_issue_to_swing', $dashCheckArray) ? "1" : "0");
                                       if($permission == '1'){
                                     ?>
                                     <div class="col-xl-3 col-md-6 col-sm-6">
                                         <div class="widget widget-12 has-shadow">
                                           <a href="./pages/iissue/insert.php">
                                             <div class="widget-body">
                                                 <div class="media">
                                                     <div class="align-self-center ml-2 mr-2">
                                                         <i class="la la-spinner" style="color:chocolate;"></i>
                                                     </div>
                                                     <div class="media-body align-self-center">
                                                         <div class="title text-linkedin"><?php echo $totalInputIssue ?></div>
                                                         <div class="number"  style="color:chocolate;">Input Issue Status</div>
                                                     </div>
                                                 </div>
                                             </div>
                                           </a>
                                         </div>
                                     </div>
                                     <?php } ?>


                                     <?php
                                       $permission = (in_array('pro_planning', $dashCheckArray) ? "1" : "0");
                                       if($permission == '1'){
                                     ?>
                                     <div class="col-xl-3 col-md-6 col-sm-6">
                                         <div class="widget widget-12 has-shadow">
                                             <div class="widget-body">
                                                 <div class="media">
                                                     <div class="align-self-center ml-2 mr-2">
                                                         <i class="la la-recycle" style="color:darkgoldenrod;"></i>
                                                     </div>
                                                     <div class="media-body align-self-center">
                                                         <div class="title text-linkedin"><?php //echo $s_data['total'] ?></div>
                                                         <div class="number" style="color:darkgoldenrod;">Production Planning</div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                      <?php } ?>



                                  <?php
                                      $permission = (in_array('pro_planning', $dashCheckArray) ? "1" : "0");
                                      if($permission == '1'){
                                  ?>
                                     <div class="col-xl-3 ">
                                         <div class="widget widget-12 has-shadow">
                                           <a href="./pages/swoutput/scan.php">
                                             <div class="widget-body">
                                                 <div class="media">
                                                     <div class="align-self-center ml-2 mr-2">
                                                         <i class="la la-tag" style="color:darkolivegreen;"></i>
                                                     </div>
                                                     <div class="media-body align-self-center">
                                                       <?php
                                                       $ob = new select_swoutput();
                                                       $result_sw = $ob->select_scan_swoutput_total();
                                                       while ($info = mysqli_fetch_assoc($result_sw)) {
                                                         $total_scan = $info['total_scan'];
                                                         // echo '<pre>';
                                                         // print_r("a");
                                                         // echo  '</pre>';
                                                       }
                                                       ?>
                                                         <div class="title text-facebook"><?php echo $total_scan; ?></div>
                                                         <div class="number" style="color:darkolivegreen;">Sewing Output</div>
                                                     </div>
                                                 </div>
                                             </div>
                                           </a>
                                         </div>
                                     </div>
                                    <?php } ?>


                                    <?php
                                        $permission = (in_array('swing_wip', $dashCheckArray) ? "1" : "0");
                                        if($permission == '1'){
                                    ?>
                                        <div class="col-xl-3 col-md-6 col-sm-6">
                                              <div class="widget widget-12 has-shadow">
                                                  <div class="widget-body">
                                                      <div class="media">
                                                          <div class="align-self-center ml-2 mr-2">
                                                              <i class="la la-rotate-left" style="color:darkslategray;"></i>
                                                           </div>
                                                           <div class="media-body align-self-center">
                                                              <div class="title text-twitter"><?php echo $totalInputIssue-$total_scan; ?></div>
                                                                  <div class="number"  style="color:darkslategray;">Sewing WIP</div>
                                                            </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <?php } ?>


                                              <?php
                                                  $permission = (in_array('hr', $dashCheckArray) ? "1" : "0");
                                                  if($permission == '1'){
                                              ?>
                                              <div class="col-xl-3 col-md-6 col-sm-6">
                                                  <div class="widget widget-12 has-shadow">
                                                      <div class="widget-body">
                                                          <div class="media">
                                                              <div class="align-self-center ml-2 mr-2">
                                                                  <i class="la la-life-bouy" style="color:fuchsia;"></i>
                                                              </div>
                                                              <div class="media-body align-self-center">
                                                                  <div class="title text-linkedin"><?php //echo $s_data['total'] ?></div>
                                                                  <div class="number"  style="color:fuchsia;">HR Department</div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <?php } ?>

                                              <?php
                                                  $permission = (in_array('eff_calculation', $dashCheckArray) ? "1" : "0");
                                                  if($permission == '1'){
                                              ?>
                                              <div class="col-xl-3 col-md-6 col-sm-6">
                                                  <div class="widget widget-12 has-shadow">
                                                    <a href="./pages/efficiency/insert.php">
                                                      <div class="widget-body">
                                                          <div class="media">
                                                              <div class="align-self-center ml-2 mr-2">
                                                                  <i class="la la-calculator" style="color:indianred;"></i>
                                                              </div>
                                                              <div class="media-body align-self-center">
                                                                  <div class="title text-linkedin"><?php //echo $s_data['total'] ?></div>
                                                                  <div class="number" style="color:indianred;">IE Department</div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                    </a>
                                                  </div>
                                              </div>
                                              <?php } ?>



                                              <?php
                                                  $permission = (in_array('eff_calculation', $dashCheckArray) ? "1" : "0");
                                                  if($permission == '1'){
                                              ?>
                                              <div class="col-xl-3 ">
                                                  <div class="widget widget-12 has-shadow">
                                                      <div class="widget-body">
                                                          <div class="media">
                                                              <div class="align-self-center ml-2 mr-2">
                                                                  <i class="la la-bookmark" style="color:maroon;"></i>
                                                              </div>
                                                              <div class="media-body align-self-center">
                                                                  <div class="title text-facebook"><?php //echo $m_data['total'] ?></div>
                                                                  <div class="number" style="color:maroon;">QA Department</div>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                              <?php } ?>


                                              <?php
                                                  $permission = (in_array('ncq_inline_inspection', $dashCheckArray) ? "1" : "0");
                                                  if($permission == '1'){
                                              ?>
                                                  <div class="col-xl-3 col-md-6 col-sm-6">
                                                       <div class="widget widget-12 has-shadow">
                                                            <div class="widget-body">
                                                                <div class="media">
                                                                    <div class="align-self-center ml-2 mr-2">
                                                                           <i class="la la-database" style="color:orangered;"></i>
                                                                    </div>
                                                                    <div class="media-body align-self-center">
                                                                        <div class="title text-twitter"><?php //echo $o_data['total'] ?></div>
                                                                        <div class="number"  style="color:orangered;">NQC Department</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                   </div>
                                                  <?php } ?>


                                                    <?php
                                                       $permission = (in_array('rqs_inspection_audit', $dashCheckArray) ? "1" : "0");
                                                       if($permission == '1'){
                                                    ?>
                                                       <div class="col-xl-3 col-md-6 col-sm-6">
                                                           <div class="widget widget-12 has-shadow">
                                                               <div class="widget-body">
                                                                   <div class="media">
                                                                       <div class="align-self-center ml-2 mr-2">
                                                                           <i class="la la-eye" style="color:teal;"></i>
                                                                       </div>
                                                                       <div class="media-body align-self-center">
                                                                           <div class="title text-linkedin"><?php //echo $s_data['total'] ?></div>
                                                                           <div class="number"  style="color:teal;">RQS Department</div>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                           </div>
                                                       </div>
                                                       <?php } ?>


                                                       <?php
                                                          $permission = (in_array('wash_send', $dashCheckArray) ? "1" : "0");
                                                          if($permission == '1'){
                                                       ?>
                                                       <div class="col-xl-3 col-md-6 col-sm-6">
                                                           <div class="widget widget-12 has-shadow">
                                                             <a href="./pages/wsend/scan.php">
                                                               <div class="widget-body">
                                                                   <div class="media">
                                                                       <div class="align-self-center ml-2 mr-2">
                                                                           <i class="la la-archive" style="color:olive;"></i>
                                                                       </div>
                                                                       <div class="media-body align-self-center">
                                                                         <?php
                                                                               $ob_w = new select_washsend();
                                                                               $result_w = $ob_w->select_scan_wsend_total();
                                                                               while ($info_w = mysqli_fetch_assoc($result_w)) {
                                                                                 $total_scan_w = $info_w['total_scan'];
                                                                               }
                                                                         ?>
                                                                           <div class="title text-linkedin"><?php echo $total_scan_w; ?></div>
                                                                           <div class="number" style="color:olive;">Wash Send</div>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                             </a>
                                                           </div>
                                                       </div>
                                                       <?php } ?>


                                                       <?php
                                                          $permission = (in_array('wash_received', $dashCheckArray) ? "1" : "0");
                                                          if($permission == '1'){
                                                       ?>
                                                       <div class="col-xl-3 ">
                                                           <div class="widget widget-12 has-shadow">
                                                             <a href="./pages/wsend/wrscan.php">
                                                               <div class="widget-body">
                                                                   <div class="media">
                                                                       <div class="align-self-center ml-2 mr-2">
                                                                           <i class="la la-check-circle" style="color:darkblue;"></i>
                                                                       </div>
                                                                       <div class="media-body align-self-center">
                                                                         <?php
                                                                               $ob_w = new select_washsend();
                                                                               $result_rw = $ob_w->select_scan_wrece_total();
                                                                               while($info_rw = mysqli_fetch_assoc($result_rw)) {
                                                                                 $total_scan_wr = $info_rw['total_scan'];
                                                                               }
                                                                         ?>
                                                                           <div class="title text-facebook">
                                                                               <?php echo $total_scan_wr; ?>
                                                                           </div>
                                                                           <div class="number" style="color:darkblue;">Wash Received</div>
                                                                       </div>
                                                                   </div>
                                                               </div>
                                                             </a>
                                                           </div>
                                                       </div>
                                                      <?php } ?>


                                                             <?php
                                                                  $permission = (in_array('wash_wip', $dashCheckArray) ? "1" : "0");
                                                                  if($permission == '1'){
                                                              ?>
                                                                <div class="col-xl-3 col-md-6 col-sm-6">
                                                                    <div class="widget widget-12 has-shadow">
                                                                        <div class="widget-body">
                                                                            <div class="media">
                                                                                <div class="align-self-center ml-2 mr-2">
                                                                                    <i class="la la-cog" style="color:brown;"></i>
                                                                                </div>
                                                                                <div class="media-body align-self-center">
                                                                                    <div class="title text-twitter">
                                                                                <?php echo $total_scan_w-$total_scan_wr; ?>
                                                                                    </div>
                                                                                    <div class="number"  style="color:brown;">Wash WIP</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>


                                                                <?php
                                                                     $permission = (in_array('finishing_input', $dashCheckArray) ? "1" : "0");
                                                                     if($permission == '1'){
                                                                 ?>
                                                                <div class="col-xl-3 col-md-6 col-sm-6">
                                                                    <div class="widget widget-12 has-shadow">
                                                                        <div class="widget-body">
                                                                            <div class="media">
                                                                                <div class="align-self-center ml-2 mr-2">
                                                                                    <i class="la la-hourglass-end" style="color:DarkSlateBlue;"></i>
                                                                                </div>
                                                                                <div class="media-body align-self-center">
                                                                              <?php

                                                                                    $ob_f = new select_finishing();
                                                                                    $result_finp = $ob_f->select_inp_scan_fin_total();
                                                                                while ($info_finp = mysqli_fetch_assoc($result_finp)) {
                                                                                      $total_scan_finp = $info_finp['total_scan'];
                                                                                    }
                                                                              ?>
                                                                                    <div class="title text-linkedin">
                                                                                        <?php echo $total_scan_finp;?>
                                                                                    </div>
                                                                                    <div class="number"  style="color:DarkSlateBlue;">Finishing Input</div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php } ?>


                                                        <?php
                                                        $permission = (in_array('finishing_output', $dashCheckArray) ? "1" : "0");
                                                        if($permission == '1'){
                                                        ?>
                                                        <div class="col-xl-3 col-md-6 col-sm-6">
                                                                  <div class="widget widget-12 has-shadow">
                                                                    <a href="./pages/fin/scan.php">
                                                                      <div class="widget-body">
                                                                          <div class="media">
                                                                            <div class="align-self-center ml-2 mr-2">
                                                                                <i class="la la-level-up" style="color:DarkViolet;"></i>
                                                                            </div>
                                                                            <div class="media-body align-self-center">
                                                                              <?php

                                                                                    $ob_f = new select_finishing();
                                                                                    $result_f = $ob_f->select_scan_fin_total();
                                                                                    while ($info_f = mysqli_fetch_assoc($result_f)) {
                                                                                      $total_scan_f = $info_f['total_scan'];
                                                                                    }
                                                                              ?>
                                                                            <div class="title text-linkedin"><?php echo $total_scan_f; ?></div>
                                                                            <div class="number" style="color:DarkViolet;">Finishing Output</div>
                                                                          </div>
                                                                      </div>
                                                                  </div>
                                                                </a>
                                                               </div>
                                                            </div>
                                                         <?php } ?>



                                                          <?php
                                                          $permission = (in_array('finishing_wip', $dashCheckArray) ? "1" : "0");
                                                          if($permission == '1'){
                                                          ?>
                                                          <div class="col-xl-3 ">
                                                              <div class="widget widget-12 has-shadow">
                                                                  <div class="widget-body">
                                                                          <div class="media">
                                                                          <div class="align-self-center ml-2 mr-2">
                                                                          <i class="la la-pencil-square" style="color:darkcyan;"></i>
                                                                          </div>
                                                                          <div class="media-body align-self-center">
                                                                          <div class="title text-facebook">
                                                              <?php echo $total_scan_finp - $total_scan_f;?>
                                                                          </div>
                                                                        <div class="number" style="color:darkcyan;">Finishing WIP</div>
                                                                      </div>
                                                                  </div>
                                                              </div>
                                                           </div>
                                                        </div>
                                                     <?php } ?>


                                                     <?php
                                                        $permission = (in_array('shipment', $dashCheckArray) ? "1" : "0");
                                                        if($permission == '1'){
                                                      ?>
                                                          <div class="col-xl-3 col-md-6 col-sm-6">
                                                              <div class="widget widget-12 has-shadow">
                                                                <a href="./pages/shipment/scan.php">
                                                                 <div class="widget-body">
                                                                    <div class="media">
                                                                        <div class="align-self-center ml-2 mr-2">
                                                                                <i class="la la-refresh" style="color:indigo;"></i>
                                                                        </div>
                                                                        <div class="media-body align-self-center">
                                                                          <?php
                                                                            $ob_sh = new select_shipment();
                                                                            $result_sh = $ob_sh->select_scan_shipment_total();
                                                                            while ($info_sh = mysqli_fetch_assoc($result_sh)) {
                                                                              $total_scan_sh = $info_sh['total_scan'];
                                                                            }
                                                                          ?>

                                                                        <div class="title text-twitter"><?php echo $total_scan_sh; ?></div>
                                                                        <div class="number"  style="color:indigo;">Shipment Status</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                          </a>
                                                         </div>
                                                      </div>
                                                    <?php } ?>






                    </div>

                 </div>
