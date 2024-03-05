<?php 
include('../header.php');

if (!isset($_SESSION['objLogin'])) {
    header("Location: " . WEB_URL . "logout.php");
    die();
}

include(ROOT_PATH.'language/'.$lang_code_global.'/lang_rented_list.php');

$delinfo = 'none';
$addinfo = 'none';
$msg = "";

if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    $result = mysqli_query($link, "SELECT * FROM tbl_add_rent WHERE rid = '" . $_GET['id'] . "'");
    if ($row = mysqli_fetch_array($result)) {
        $sqlx = "UPDATE `tbl_add_unit` SET status = 0 WHERE floor_no = '".(int)$row['r_floor_no']."' AND uid = '".(int)$row['r_unit_no']."'";
        mysqli_query($link, $sqlx);
    }
    $sqlx = "DELETE FROM `tbl_add_rent` WHERE rid = ".$_GET['id'];
    mysqli_query($link, $sqlx); 
    $delinfo = 'block';
}

if (isset($_GET['m']) && $_GET['m'] == 'add') {
    $addinfo = 'block';
    $msg = $_data['added_renter_successfully'];
}

if (isset($_GET['m']) && $_GET['m'] == 'up') {
    $addinfo = 'block';
    $msg = $_data['update_renter_successfully'];
}
?>



<section class="content">
<section class="content-header">
    <h1><?php echo $_data['renter_list'];?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
        <li class="active"><?php echo $_data['add_new_renter_information_breadcam'];?></li>
        <li class="active"><?php echo $_data['renter_list'];?></li>
    </ol>
</section>
    <div class="row">
        <div class="col-xs-12">
            <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-ban"></i><?php echo $_data['delete_text'];?> !</h4>
                <?php echo $_data['delete_renter_information'];?> 
            </div>
            <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
                <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?> !</h4>
                <?php echo $msg; ?> 
            </div>
            <div align="right" style="margin-bottom:1%;"> 
                <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>rent/addrent.php" data-original-title="<?php echo $_data['add_new_rent_breadcam'];?>"><i class="fa fa-plus"></i></a> 
                <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['home_breadcam'];?>"><i class="fa fa-dashboard"></i></a>  -->
            </div>
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $_data['renter_list'];?></h3>
                </div>
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th><?php echo $_data['add_new_form_field_text_0'];?></th>
                                <th><?php echo $_data['add_new_form_field_text_1'];?></th>
                                <th><?php echo $_data['add_new_form_field_text_4'];?></th>
                                <th><?php echo $_data['add_new_form_field_text_8'];?></th>
                                <th>Final Amount</th>
                                <th><?php echo $_data['add_new_form_field_text_10'];?></th>
                                <th><?php echo $_data['add_new_form_field_text_14'];?></th>
                                <th><?php echo $_data['action_text'];?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = mysqli_query($link,"SELECT *,f.floor_no as ffloor,u.unit_no FROM tbl_add_rent r 
                                    
                                      INNER JOIN tbl_add_floor f ON f.fid = r.r_floor_no INNER JOIN tbl_add_unit u ON u.uid = r.r_unit_no 
                                      -- WHERE r.branch_id = " . (int)$_SESSION['objLogin']['branch_id'] . "
                                       ORDER BY r.r_unit_no ASC");
                            while ($row = mysqli_fetch_array($result)) {
                                $image = WEB_URL . 'img/no_image.jpg';	
                                if (file_exists(ROOT_PATH . '/img/upload/' . $row['image']) && $row['image'] != '') {
                                    $image = WEB_URL . 'img/upload/' . $row['image'];
                                }
                            ?>
                            <tr>
                                <td><img class="photo_img_round" style="width:50px;height:50px;" src="<?php echo $image;  ?>" /></td>
                                <td><?php echo $row['r_name']; ?></td>
                                <td><?php echo $row['r_contact']; ?></td>
                                <td><label class="label label-success ams_label"><?php echo $row['unit_no']; ?></label></td>
                                <td><?php echo $ams_helper->currency($localization, $row['final_amount']); ?></td>
                                <td><?php echo $ams_helper->currency($localization, $row['amount']); ?></td>
                                <td><?php if ($row['r_status'] == '1') {echo '<label class="label label-success ams_label">'.$_data['add_new_form_field_text_16'].'</label>';} else {echo '<label class="label label-danger ams_label">'.$_data['add_new_form_field_text_17'].'</label>';}?></td>
                                <td>
                                    <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['rid']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a> 
                                    <a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL;?>rent/addrent.php?id=<?php echo $row['rid']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> 
                                    <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onClick="deleteRent(<?php echo $row['rid']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
                                    <div id="nurse_view_<?php echo $row['rid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel"><?php echo $_data['rented_details'];?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="pdfContent">
                <div class="invoice-details" style="margin-top: 20px; text-align: left;">

                    <h3 style="font-size: 1.2em; margin-bottom: 15px;">Tenant Detail</h3>
                    <div class="profile-section" style="margin-bottom: 20px;">
                        <img src="<?php echo $image; ?>" alt="Profile Image" style="width: 80px; height: 80px; border-radius: 50%;">
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong><?php echo $_data['add_new_form_field_text_1'];?>:</strong> <?php echo $row['r_name']; ?></p>
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong><?php echo $_data['add_new_form_field_text_2'];?>:</strong> <?php echo $row['r_email']; ?></p>
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong><?php echo $_data['add_new_form_field_text_6'];?>:</strong> <?php echo $row['r_nid']; ?></p>
                        </div>
                            <div class="col-md-6">
                              <p style="font-size: 0.9em; line-height: 1.6;"><strong><?php echo $_data['add_new_form_field_text_7'];?>:</strong> <?php echo $row['ffloor']; ?></p>
                              <p style="font-size: 0.9em; line-height: 1.6;"><strong><?php echo $_data['add_new_form_field_text_8'];?>:</strong> <?php echo $row['unit_no']; ?></p>
                              <p style="font-size: 0.9em; line-height: 1.6;"><strong>Final Amount:</strong> <?php echo $row['final_amount']; ?></p>
                            </div>
                    </div>
                </div>
                <hr>
                <div class="invoice-details" style="margin-top: 20px; text-align: left;">
                    <div class="row">
                        <div class="col-md-6">
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong>Owner Name:</strong> <?php echo $row['o_owner']; ?></p>
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong>Building No:</strong> <?php echo $row['o_owner']; ?></p>

                        </div>
                        <div class="col-md-6">
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong><?php echo $_data['add_new_form_field_text_7'];?>:</strong> <?php echo $row['ffloor']; ?></p>
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong><?php echo $_data['add_new_form_field_text_8'];?>:</strong> <?php echo $row['unit_no']; ?></p>
                       
                        </div>
                    </div>
                </div>
                <hr>
                <div class="invoice-details" style="margin-top: 20px; text-align: left;">

                    <h3 style="font-size: 1.2em; margin-bottom: 15px;">Tenant Check Status</h3>
                    
                    <?php  
                        $emi_payments = mysqli_query($link, "SELECT * FROM tbl_emi_payment WHERE rid=" . intval($row['rid']));

                       
                            $emi_payment = mysqli_fetch_array($emi_payments, MYSQLI_ASSOC);
                
                        
                    ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong>Amount:</strong> <?php echo $emi_payment['amount']; ?></p>

                        </div>
                        <div class="col-md-6">
                            <p style="font-size: 0.9em; line-height: 1.6;"><strong>Check Status:</strong> <?php if ($row['status'] == '1') {echo '<label class="label label-success ams_label">'."paid".'</label>';} else {echo '<label class="label label-danger ams_label">'."Due".'</label>';}?></p>
                            
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="downloadPDF()">Download PDF</button>
            </div>
        </div>
    </div>
</div>

                                </td>
                                
                            </tr>
                            <?php } 
                            mysqli_close($link);
                            $link = NULL; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function deleteRent(Id){
        var iAnswer = confirm("<?php echo $_data['confirm']; ?>");
        if(iAnswer){
            window.location = '<?php echo WEB_URL; ?>rent/rentlist.php?id=' + Id;
        }
    }
    function downloadPDF() {
            var pdfContent = document.getElementById('pdfContent');
            html2pdf(pdfContent);
        }
  
    $( document ).ready(function() {
        setTimeout(function() {
            $("#me").hide(300);
            $("#you").hide(300);
        }, 3000);
    });

    //write a sum code
</script>

<?php include('../footer.php'); ?>
