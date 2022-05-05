<?php $lmenuCheckArray = $_SESSION['lpermissionsArray']; ?>

<div class="default-sidebar">
<!-- Begin Side Navbar -->
<!-- <nav class="side-navbar box-scroll sidebar-scroll"> -->

    <nav class="main-sidebar side-navbar box-scroll sidebar-scroll">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">

        <?php
             $permission = (in_array('umanagement', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>

        <?php
            $activeUserMenu = "";
            $active_link = ['./pages/user/insert.php', './pages/user/select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeUserMenu = "active";
                $UserMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeUserMenu; ?>">
          <a href="#">
            <i class="la la-user-secret"></i> <span <?php echo $UserMenuColor; ?>>User Setting</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                <li><a href="./pages/user/insert.php" <?= ($_SESSION['active_page'] == './pages/user/insert.php') ? "style='color:#ffff'" : ""; ?>>Add User</a></li>
                <li><a href="./pages/user/select.php" <?= ($_SESSION['active_page'] == './pages/user/select.php') ? "style='color:#ffff'" : ""; ?>>Manage User</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('pro_setup', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>


        <?php
            $activeSetupMenu = "";
            $active_link = ['./pages/country/insert.php',
                            './pages/size/insert.php',
                            './pages/style/insert.php',
                            './pages/po/insert.php',
                            './pages/country/select.php',
                            './pages/size/select.php',
                            './pages/style/select.php',
                            './pages/po/select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeSetupMenu = "active";
                $SetupMenuColor = "style=\"color:white;\"";
            }
         ?>


         <li class="treeview <?php echo $activeSetupMenu; ?>">
          <a href="#">
            <i class="la la-gears"></i> <span <?php echo $SetupMenuColor; ?>>Setup</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="./pages/country/insert.php" <?= ($_SESSION['active_page'] == './pages/country/insert.php') ? "style='color:#ffff'" : ""; ?>>Add Country</a></li>
            <li><a href="./pages/size/insert.php" <?= ($_SESSION['active_page'] == './pages/size/insert.php') ? "style='color:#ffff'" : ""; ?>>Add Size</a></li>
            <li><a href="./pages/style/insert.php" <?= ($_SESSION['active_page'] == './pages/style/insert.php') ? "style='color:#ffff'" : ""; ?>>Add Style</a></li>
            <li><a href="./pages/po/insert.php" <?= ($_SESSION['active_page'] == './pages/po/insert.php') ? "style='color:#ffff'" : ""; ?>>Add PO</a></li>
            <li><a href="./pages/country/select.php" <?= ($_SESSION['active_page'] == './pages/country/select.php') ? "style='color:#ffff'" : ""; ?>>Manage Country</a></li>
            <li><a href="./pages/size/select.php" <?= ($_SESSION['active_page'] == './pages/size/select.php') ? "style='color:#ffff'" : ""; ?>>Manage Size</a></li>
            <li><a href="./pages/style/select.php" <?= ($_SESSION['active_page'] == './pages/style/select.php') ? "style='color:#ffff'" : ""; ?>>Manage Style</a></li>
            <li><a href="./pages/po/select.php" <?= ($_SESSION['active_page'] == './pages/po/select.php') ? "style='color:#ffff'" : ""; ?>>Manage PO</a></li>
            </li>
          </ul>

        <?php } ?>

        <?php
             $permission = (in_array('order_processing', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>

        <?php
            $activeOrderMenu = "";
            $active_link = ['./pages/order/insert.php', './pages/order/select.php','./pages/order/select_order_list.php','./pages/order/order_to_ship.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeOrderMenu = "active";
                $OrderMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeOrderMenu; ?>">
          <a href="#">
            <i class="la la-shopping-cart"></i> <span <?php echo $OrderMenuColor; ?>>Order Processing</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                <li><a href="./pages/order/insert.php" <?= ($_SESSION['active_page'] == './pages/order/insert.php') ? "style='color:#ffff'" : ""; ?>>Order Entry</a></li>
                <!-- <li><a href="./pages/order/select.php" <?= ($_SESSION['active_page'] == './pages/order/select.php') ? "style='color:#ffff'" : ""; ?>>Order List</a></li> -->
                <li><a href="./pages/order/select_order_list.php" <?= ($_SESSION['active_page'] == './pages/order/select_order_list.php') ? "style='color:#ffff'" : ""; ?>>Total Order List</a></li>
                <li><a href="./pages/order/order_to_ship.php" <?= ($_SESSION['active_page'] == './pages/order/order_to_ship.php') ? "style='color:#ffff'" : ""; ?>>Order To Ship</a></li>
            </li>
          </ul>
        </li>
       <?php } ?>


       <?php
            $permission = (in_array('cplan', $lmenuCheckArray) ? "1" : "0");
            if($permission == '1'){
       ?>
       <?php
           $activeCproductionMenu = "";
           $active_link = ['./pages/cplan/insert.php', './pages/cplan/select.php', './pages/cproduction/insert.php', './pages/cproduction/select.php'];
           if (in_array($_SESSION['active_page'], $active_link)) {
               $activeCproductionMenu = "active";
               $CproductionMenuColor = "style=\"color:white;\"";
           }
        ?>

       <li class="treeview <?php echo $activeCproductionMenu; ?>">
          <a href="#">
            <i class="la la-cut"></i> <span <?php echo $CproductionMenuColor; ?>>Cutting Production</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/cplan/insert.php" <?= ($_SESSION['active_page'] == './pages/cplan/insert.php') ? "style='color:#ffff'" : ""; ?>>Cutting Plan</a></li>
                    <li><a href="./pages/cplan/select.php" <?= ($_SESSION['active_page'] == './pages/cplan/select.php') ? "style='color:#ffff'" : ""; ?>>Cutting Plan List</a></li>
                    <li><a href="./pages/cproduction/insert.php" <?= ($_SESSION['active_page'] == './pages/cproduction/insert.php') ? "style='color:#ffff'" : ""; ?>>Cutting Production</a></li>
                    <li><a href="./pages/cproduction/select.php" <?= ($_SESSION['active_page'] == './pages/cproduction/select.php') ? "style='color:#ffff'" : ""; ?>>Cutting Production List</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('iissue', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeIissueMenu = "";
            $active_link = ['./pages/iissue/scan.php', './pages/iissue/scan_select.php',
                            './pages/iissue/insert.php', './pages/iissue/select.php',
                            './pages/iissue/select.php','./pages/iissue/n_scan.php','./pages/iissue/n_scan_select.php',];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeIissueMenu = "active";
                $IissueMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeIissueMenu; ?>">
          <a href="#">
            <i class="la la-spinner"></i> <span <?php echo $IissueMenuColor; ?>>Input Issue</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/iissue/scan.php" <?= ($_SESSION['active_page'] == './pages/iissue/scan.php') ? "style='color:#ffff'" : ""; ?>>Input Issue Scan</a></li>
                    <li><a href="./pages/iissue/scan_select.php" <?= ($_SESSION['active_page'] == './pages/iissue/scan_select.php') ? "style='color:#ffff'" : ""; ?>>Scan List</a></li>
                    <li><a href="./pages/iissue/n_scan.php" <?= ($_SESSION['active_page'] == './pages/iissue/n_scan.php') ? "style='color:#ffff'" : ""; ?>>New Input Issue Scan</a></li>
                    <li><a href="./pages/iissue/n_scan_select.php" <?= ($_SESSION['active_page'] == './pages/iissue/n_scan_select.php') ? "style='color:#ffff'" : ""; ?>>New Scan List</a></li>
                    <li><a href="./pages/iissue/insert.php" <?= ($_SESSION['active_page'] == './pages/iissue/insert.php') ? "style='color:#ffff'" : ""; ?>>Input Issue</a></li>
                    <li><a href="./pages/iissue/select.php" <?= ($_SESSION['active_page'] == './pages/iissue/select.php') ? "style='color:#ffff'" : ""; ?>>Input Issue List</a></li>
                    <li><a href="./pages/iissue/select.php" <?= ($_SESSION['active_page'] == './pages/iissue/select.php') ? "style='color:#ffff'" : ""; ?>>Issue Scan Details</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('swing_output', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeSwingOutputMenu = "";
            $active_link = ['./pages/swoutput/scan.php', './pages/swoutput/insert.php',
                            './pages/swoutput/select.php','./pages/swoutput/scan_select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeSwingOutputMenu = "active";
                $SwingOutputMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeSwingOutputMenu; ?>">
          <a href="#">
            <i class="la la-tag"></i> <span <?php echo $SwingOutputMenuColor; ?>>Sewing output</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">

              <li><a href="./pages/swoutput/scan.php" <?= ($_SESSION['active_page'] == './pages/swoutput/scan.php') ? "style='color:#ffff'" : ""; ?>>Sewing Output Scan</a></li>

              <li><a href="./pages/swoutput/scan_select.php" <?= ($_SESSION['active_page'] == './pages/swoutput/scan_select.php') ? "style='color:#ffff'" : ""; ?>>Sewing Output Scan List</a></li>

              <li><a href="./pages/swoutput/style_wise_report.php" <?= ($_SESSION['active_page'] == './pages/swoutput/style_wise_report.php') ? "style='color:#ffff'" : ""; ?>>Style Wise Sewing Output</a></li>

          </ul>
        </li>
        <?php } ?>
<!-------------------------------------------------------->
        <?php
             $permission = (in_array('wash_send', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeWashSendMenu = "";
            $active_link = ['./pages/wsend/scan.php', './pages/wsend/insert.php',
                            './pages/wsend/select.php','./pages/wsend/scan_select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeWashSendMenu = "active";
                $WashSendMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeWashSendMenu; ?>">
          <a href="#">
            <i class="la la-archive"></i> <span <?php echo $WashSendMenuColor; ?>>Wash Send</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                     <li><a href="./pages/wsend/scan.php" <?= ($_SESSION['active_page'] == './pages/wsend/scan.php') ? "style='color:#ffff'" : ""; ?>>Wash Send Scan</a></li>
                     <li><a href="./pages/wsend/scan_select.php" <?= ($_SESSION['active_page'] == './pages/wsend/scan_select.php') ? "style='color:#ffff'" : ""; ?>>Wash Send Scan List</a></li>
                     <li><a href="./pages/wsend/insert.php" <?= ($_SESSION['active_page'] == './pages/wsend/insert.php') ? "style='color:#ffff'" : ""; ?>>Wash Send</a></li>
                     <li><a href="./pages/wsend/select.php" <?= ($_SESSION['active_page'] == './pages/wsend/select.php') ? "style='color:#ffff'" : ""; ?>>Wash Send List</a></li>
          </ul>
        </li>
        <?php } ?>
<!-------------------------------------------------------->
        <?php
             $permission = (in_array('wash_received', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeWashReceMenu = "";
            $active_link = ['./pages/wsend/wrscan.php','./pages/wsend/wrscan_select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeWashReceMenu = "active";
                $WashReceMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeWashReceMenu; ?>">
          <a href="#">
            <i class="la la-check-circle"></i> <span <?php echo $WashReceMenuColor; ?>>Wash Received</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                     <li><a href="./pages/wsend/wrscan.php" <?= ($_SESSION['active_page'] == './pages/wsend/wrscan.php') ? "style='color:#ffff'" : ""; ?>>Wash Received Scan</a></li>
                     <li><a href="./pages/wsend/wrscan_select.php" <?= ($_SESSION['active_page'] == './pages/wsend/wrscan_select.php') ? "style='color:#ffff'" : ""; ?>>Wash Received Scan List</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('finishing', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeFinishingMenu = "";
            $active_link = ['./pages/fin/fi_scan.php','./pages/fin/scan.php','./pages/fin/hourly_input.php',
                            './pages/fin/hourly_input_select.php','./pages/fin/monthly_plan_input.php',
                            './pages/fin/monthly_plan_select.php','./pages/fin/insert.php','./pages/fin/output_select.php',
                            './pages/fin/scan_select.php','./pages/fin/fi_scan_select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeFinishingMenu = "active";
                $FinishingMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeFinishingMenu; ?>">
          <a href="#">
            <i class="la la-hourglass-end"></i> <span <?php echo $FinishingMenuColor; ?>>Finishing</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/fin/fi_scan.php" <?= ($_SESSION['active_page'] == './pages/fin/fi_scan.php') ? "style='color:#ffff'" : ""; ?>>Finishing Input Scan</a></li>
                    <li><a href="./pages/fin/fi_scan_select.php" <?= ($_SESSION['active_page'] == './pages/fin/fi_scan_select.php') ? "style='color:#ffff'" : ""; ?>>Finishing Input Scan List</a></li>
                    <li><a href="./pages/fin/scan.php" <?= ($_SESSION['active_page'] == './pages/fin/scan.php') ? "style='color:#ffff'" : ""; ?>>Finishing Output Scan</a></li>
                    <li><a href="./pages/fin/scan_select.php" <?= ($_SESSION['active_page'] == './pages/fin/scan_select.php') ? "style='color:#ffff'" : ""; ?>>Finishing Output Scan List</a></li>
                    <li><a href="./pages/fin/hourly_input.php" <?= ($_SESSION['active_page'] == './pages/fin/hourly_input.php') ? "style='color:#ffff'" : ""; ?>>Finishing Hourly Input</a></li>
                    <li><a href="./pages/fin/hourly_input_select.php" <?= ($_SESSION['active_page'] == './pages/fin/hourly_input_select.php') ? "style='color:#ffff'" : ""; ?>>Hourly Input List</a></li>
                    <li><a href="./pages/fin/monthly_plan_input.php" <?= ($_SESSION['active_page'] == './pages/fin/monthly_plan_input.php') ? "style='color:#ffff'" : ""; ?>>Monthly Finishing Plan</a></li>
                    <li><a href="./pages/fin/monthly_plan_select.php" <?= ($_SESSION['active_page'] == './pages/fin/monthly_plan_select.php') ? "style='color:#ffff'" : ""; ?>>Monthly Plan List</a></li>
                    <li><a href="./pages/fin/insert.php" <?= ($_SESSION['active_page'] == './pages/fin/insert.php') ? "style='color:#ffff'" : ""; ?>>Finishing Output</a></li>
                    <li><a href="./pages/fin/output_select.php" <?= ($_SESSION['active_page'] == './pages/fin/output_select.php') ? "style='color:#ffff'" : ""; ?>>Output List</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('shipment', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeShipmentMenu = "";
            $active_link = ['./pages/shipment/scan.php', './pages/shipment/insert.php',
                            './pages/shipment/select.php','./pages/shipment/weekly_shipment_schedule.php',
                            './pages/shipment/monthly_shipment_schedule.php','./pages/shipment/monthly_finishing_plan.php','./pages/shipment/scan_select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeShipmentMenu = "active";
                $ShipmentMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeShipmentMenu; ?>">
          <a href="#">
            <i class="la la-pencil-square"></i> <span <?php echo $ShipmentMenuColor; ?>>Shipment</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/shipment/scan.php" <?= ($_SESSION['active_page'] == './pages/shipment/scan.php') ? "style='color:#ffff'" : ""; ?>>Shipment Scan</a></li>
                    <li><a href="./pages/shipment/scan_select.php" <?= ($_SESSION['active_page'] == './pages/shipment/scan_select.php') ? "style='color:#ffff'" : ""; ?>>Shipment Scan List</a></li>
                    <li><a href="./pages/shipment/insert.php" <?= ($_SESSION['active_page'] == './pages/shipment/insert.php') ? "style='color:#ffff'" : ""; ?>>Shipment</a></li>
                    <li><a href="./pages/shipment/select.php" <?= ($_SESSION['active_page'] == './pages/shipment/select.php') ? "style='color:#ffff'" : ""; ?>>Shipment List</a></li>
                    <li><a href="./pages/shipment/weekly_shipment_schedule.php" <?= ($_SESSION['active_page'] == './pages/shipment/weekly_shipment_schedule.php') ? "style='color:#ffff'" : ""; ?>>Weekly Shedule</a></li>
                    <li><a href="./pages/shipment/monthly_shipment_schedule.php" <?= ($_SESSION['active_page'] == './pages/shipment/monthly_shipment_schedule.php') ? "style='color:#ffff'" : ""; ?>>Monthly Shedule</a></li>
                    <li><a href="./pages/shipment/monthly_finishing_plan.php" <?= ($_SESSION['active_page'] == './pages/shipment/monthly_finishing_plan.php') ? "style='color:#ffff'" : ""; ?>>Monthly Finishing Plan</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('dhu_style', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeDhuMenu = "";
            //$active_link = ['./pages/dhu/insert.php', './pages/dhu/select_style_wise.php', './pages/dhu/sewing_report.php', './pages/dhu/sewing_report_list.php'];
            $active_link = ['./pages/dhu/insert.php','./pages/dhu/sewing_report.php', './pages/dhu/sewing_report_list.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeDhuMenu = "active";
                $DhuMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeDhuMenu; ?>">
          <a href="#">
            <i class="la la-bookmark"></i> <span <?php echo $DhuMenuColor; ?>>QA Department</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">

                <li><a href="./pages/dhu/sewing_report.php" <?= ($_SESSION['active_page'] == './pages/dhu/sewing_report.php') ? "style='color:#ffff'" : ""; ?>>Sewing DHU Report</a></li>
                <li><a href="./pages/dhu/sewing_report_list.php" <?= ($_SESSION['active_page'] == './pages/dhu/sewing_report_list.php') ? "style='color:#ffff'" : ""; ?>>Sewing DHU Report List</a></li>
                <li><a href="./pages/dhu/insert.php" <?= ($_SESSION['active_page'] == './pages/dhu/insert.php') ? "style='color:#ffff'" : ""; ?>>Sewing DHU Insert</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('efficiency', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeEfficiencyMenu = "";
            $active_link = ['./pages/efficiency/process_list.php', './pages/efficiency/insert.php',
                            './pages/efficiency/select_daily_operator_efficiency.php',
                            './pages/efficiency/transfer_operator.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeEfficiencyMenu = "active";
                $EfficiencyMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeEfficiencyMenu; ?>">
          <a href="#">
            <i class="la la-calculator"></i> <span <?php echo $EfficiencyMenuColor; ?>>IE Department</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/efficiency/process_list.php" <?= ($_SESSION['active_page'] == './pages/efficiency/process_list.php') ? "style='color:#ffff'" : ""; ?>>Process List</a></li>
                    <li><a href="./pages/efficiency/insert.php" <?= ($_SESSION['active_page'] == './pages/efficiency/insert.php') ? "style='color:#ffff'" : ""; ?>>Operator Wise Input</a></li>
                    <li><a href="./pages/efficiency/select_daily_operator_efficiency.php" <?= ($_SESSION['active_page'] == './pages/efficiency/select_daily_operator_efficiency.php') ? "style='color:#ffff'" : ""; ?>>Daily Operator Efficiency</a></li>
                    <li><a href="./pages/efficiency/transfer_operator.php" <?= ($_SESSION['active_page'] == './pages/efficiency/transfer_operator.php') ? "style='color:#ffff'" : ""; ?>>Transfer Operator</a></li>
          </ul>
        </li>
        <?php } ?>



        <?php
             $permission = (in_array('trims_inhouse', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeTrimsMenu = "";
            $active_link = ['./pages/trinhouse/insert.php', './pages/trinhouse/select.php', './pages/trinhouse/po_sheet.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeTrimsMenu = "active";
                $TrinhouseMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeTrimsMenu; ?>">
          <a href="#">
            <i class="la la-share-alt-square"></i> <span <?php echo $TrinhouseMenuColor; ?>>Trims Inhouse</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/trinhouse/po_sheet.php" <?= ($_SESSION['active_page'] == './pages/trinhouse/po_sheet.php') ? "style='color:#ffff'" : ""; ?>>PO Sheet</a></li>
                    <li><a href="./pages/trinhouse/select.php" <?= ($_SESSION['active_page'] == './pages/trinhouse/select.php') ? "style='color:#ffff'" : ""; ?>>Trims Inhouse List</a></li>
          </ul>
        </li>
        <?php } ?>


        <?php
             $permission = (in_array('maintenance', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeMaintenanceMenu = "";
            $active_link = ['./pages/maintenance/insert.php', './pages/maintenance/select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeMaintenanceMenu = "active";
                $MaintenanceMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeMaintenanceMenu; ?>">
          <a href="#">
            <i class="la la-share-alt-square"></i> <span <?php echo $MaintenanceMenuColor; ?>>Maintenance</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/maintenance/insert.php" <?= ($_SESSION['active_page'] == './pages/maintenance/insert.php') ? "style='color:#ffff'" : ""; ?>>Maintenance Entry</a></li>
                    <li><a href="./pages/maintenance/select.php" <?= ($_SESSION['active_page'] == './pages/maintenance/select.php') ? "style='color:#ffff'" : ""; ?>>Total Maintenance List</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php
             $permission = (in_array('nqc_rqc', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeNqcRqcMenu = "";
            $active_link = ['./pages/nqc_rqc/insert.php', './pages/nqc_rqc/select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeNqcRqcMenu = "active";
                $NqcRqceMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeNqcRqcMenu; ?>">
          <a href="#">
            <i class="la la-share-alt-square"></i> <span <?php echo $NqcRqceMenuColor; ?>>NQC/RQC</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/nqc_rqc/insert.php" <?= ($_SESSION['active_page'] == './pages/nqc_rqc/insert.php') ? "style='color:#ffff'" : ""; ?>>NQC/RQC Entry</a></li>
                    <li><a href="./pages/nqc_rqc/select.php" <?= ($_SESSION['active_page'] == './pages/nqc_rqc/select.php') ? "style='color:#ffff'" : ""; ?>>Total NQC List</a></li>
          </ul>
        </li>
        <?php } ?>

        <?php
             $permission = (in_array('planning', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeNqcRqcMenu = "";
            $active_link = ['./pages/planning/insert.php', './pages/planning/select.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeNqcRqcMenu = "active";
                $NqcRqceMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeNqcRqcMenu; ?>">
          <a href="#">
            <i class="la la-share-alt-square"></i> <span <?php echo $NqcRqceMenuColor; ?>>Planning</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                    <li><a href="./pages/planning/insert.php" <?= ($_SESSION['active_page'] == './pages/planning/insert.php') ? "style='color:#ffff'" : ""; ?>>Planning Entry</a></li>
                    <li><a href="./pages/planning/select.php" <?= ($_SESSION['active_page'] == './pages/planning/select.php') ? "style='color:#ffff'" : ""; ?>>Total Planning List</a></li>
          </ul>
        </li>

        <?php } ?>



        <?php
             $permission = (in_array('display_system', $lmenuCheckArray) ? "1" : "0");
             if($permission == '1'){
        ?>
        <?php
            $activeDisplayMenu = "";
            $active_link = ['./pages/display.php','./pages/display2.php'];
            if (in_array($_SESSION['active_page'], $active_link)) {
                $activeDisplayMenu = "active";
                $DisplayMenuColor = "style=\"color:white;\"";
            }
         ?>

        <li class="treeview <?php echo $activeDisplayMenu; ?>">
          <a href="#">
            <i class="la la-laptop"></i> <span <?php echo $DisplayMenuColor; ?>>Display</span>
            <span class="pull-right-container">
                <i class="la la-angle-down w3-small"></i>
            </span>
          </a>
          <ul class="treeview-menu">

              <li><a href="./pages/display.php" <?= ($_SESSION['active_page'] == './pages/display.php') ? "style='color:#ffff'" : ""; ?>>Display Monitor</a></li>

              <li><a href="./pages/display2.php" <?= ($_SESSION['active_page'] == './pages/display2.php') ? "style='color:#ffff'" : ""; ?>>Display Monitor 2</a></li>

              <li><a href="./pages/display3.php" <?= ($_SESSION['active_page'] == './pages/display3.php') ? "style='color:#ffff'" : ""; ?>>Display Monitor 3</a></li>

              <li><a href="./pages/display4.php" <?= ($_SESSION['active_page'] == './pages/display4.php') ? "style='color:#ffff'" : ""; ?>>Display Monitor 4</a></li>

              <li><a href="./pages/daily_report.php" <?= ($_SESSION['active_page'] == './pages/daily_report.php') ? "style='color:#ffff'" : ""; ?>>Display Daily</a></li>

          </ul>
        </li>
        <?php } ?>

      </ul>

    </section>
    <!-- /.sidebar -->
  </nav>
<!-- </nav> -->

</div>
