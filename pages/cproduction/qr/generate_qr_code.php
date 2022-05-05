<?php 
clearstatcache();
?>

<?php
if (isset($_GET['name'])) {
    $id = $_GET['id'];
    $purDltinfo = $obj_user->delete_purchases_product_ino($id);
    if ($purDltinfo) {
        $message = $obj_user->delete_product($id);
    }
}
$supplier = $obj_user->select_all_product();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            QR Code Generator
            <small>QR Code Generator</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="./inventory.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Manage</a></li>
            <li class="active">Roll List</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header" style=" background-color: #847f7f;">
                        <h3 class="box-title" style="font-size: 14px;color: #fff">Check to generate qr code</h3>
                        <h4 style="color: #fff; text-align: center">
                            <?php
                            if (isset($message)) {
                                echo $message;
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['message'])) {
                                echo $_SESSION['message'];
                                unset($_SESSION['message']);
                            }
                            ?>
                        </h4>
                    </div>
                    <div class="box-body">
                     
                     <label><input id="checkAll" type="checkbox" style="">      All</label>

                    <div id="cblist">


                   </div>

                  <div class="clearfix form-actions">
                  <div class="col-md-offset-5 col-md-7">
                  <input id="createAttendances" class=" btn btn-success" type="button"
                       value="Generate QR Code" />

            </div>
        </div>
                     
                     
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<?php include './common/link2.php'; ?>
<?php include './common/link.php'; ?>
<script>

$(document).ready(function () {
    
    
     $('#checkAll').click(function () {
            $(':checkbox.checkItem').prop('checked', this.checked);
        });


  $.ajax({
            url: url = 'https://sub.universalitgroup.com/public/api/v1/getProductSetup',
            type: "GET",
            dataType: "JSON",
            data: "",
            success: function (data) {

                 //console.log(data);
                 $("#cblist").empty();
                 
                $.each(data, function (i, product) {
                    
                    console.log(product);
                   
                    var container = $('#cblist');

                    $('<input/>', { type: 'checkbox', class: 'checkItem',style: 'height:25px;width:25px;', id: product.id, value: product.id }).appendTo(container);
                    $('<label />', {style: 'color:green;',
                        'for': '    '+product.pro_group, text: "Serial : " +product.id
                               + '     (' +"Roll : "+ product.roll +"  / Style : " +product.pro_group +" / YDS : " 
                               +product.yds +" / Palette: " +product.brand +" / Po. : " +product.po +" / Season : " +product.season + ')'
                    }).appendTo(container);
                    $('<br>', '').appendTo(container);


                });
                
            }
        });
        
        
        
        $("#createAttendances").click(function () {

        var selected = [];
        $('#cblist input:checked').each(function () {
            selected.push($(this).attr('value'));
            
        });

        console.log(selected);

        var dataJSON = {
            "ids": selected
        };
        
        window.location.href = "/qr/generate.php?ids="+selected;
        });
        
});

</script>
