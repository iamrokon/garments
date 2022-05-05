<?php require_once '../../layout/main.php'; ?>
<?php require_once '../../DB/po/select.php'; ?>

<?php
      $ob = new select_po();
      $result = $ob->select_all();
?>

<div class="content-inner">

    <div class="w3-animate-right" style="margin-left:15px;margin-right:15px;">

            <div class="table-responsive w3-card-4 table-striped w3-hoverable w3-small" style="padding:25px;">
                          <table id="export-table" class="table mb-0">
                              <thead class="btn-gradient-02">
                                  <tr>
                                    <th style="color:white;">ID</th>
                                    <th style="color:white;"><span style="width:100px;">PO Number</span></th>
                                    <th style="color:white;">Actions</th>
                                  </tr>
                              </thead>
                              <tbody>
                                <?php
                                   $i = 1;
                                   while ($info = mysqli_fetch_assoc($result)) {
                                   ?>
                                  <tr>
                                      <td style="color:gray;"><?php echo $info['id']; ?> </td>
                                      <td style="color:gray;"><?php echo $info['po_num']; ?> </td>
                                      <td class="td-actions">
                                          <a href="./pages/po/update.php?id=<?php echo $info['id']; ?>"><i class="la la-edit edit"></i></a>
                                          <a href="./pages/po/delete.php?id=<?php echo $info['id']; ?>"><i class="la la-close delete"></i></a>
                                      </td>
                                  </tr>
                                 <?php $i++;} ?>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
