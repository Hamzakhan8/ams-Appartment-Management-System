<?php 
include('../header.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>
<?php
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_maintenance_cost_list.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$sqlx= "DELETE FROM `tbl_add_maintenance_cost` WHERE mcid = ".$_GET['id'];
	mysqli_query($link,$sqlx); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['add_msg'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['update_msg'];
}
?>
<!-- Content Header (Page header) -->

<section class="content-header">
  <h1><?php echo $_data['add_title_text'];?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['m_cost'];?></li>
	<li class="active"><?php echo $_data['add_title_text'];?></li>
  </ol>
</section>
<!-- Main content -->
<section class="content">
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-ban"></i> <?php echo $_data['delete_text'];?> !</h4>
      <?php echo $_data['delete_msg'];?> </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i> <?php echo $_data['success'];?>!</h4>
      <?php echo $msg; ?> </div>
    <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>maintenance/add_maintenance_cost.php" data-original-title="<?php echo $_data['add_m_cost'];?>"><i class="fa fa-plus"></i></a> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['home_breadcam'];?>"><i class="fa fa-dashboard"></i></a> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_title_text'];?></h3>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo $_data['text_1'];?></th>
              <th>Owner Name</th>
              <th>Building Name</th>
              <th>Floor No</th>
              <th>Unit No :</th>
              <th><?php echo $_data['date'];?></th>
              <th><?php echo $_data['text_2'];?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
        <?php
			$result = mysqli_query($link,"SELECT * 
      FROM tbl_add_maintenance_cost AS mc
      LEFT JOIN tbl_add_owner AS o ON mc.ownid = o.ownid
      LEFT JOIN tbl_add_floor AS f ON mc.fid = f.fid
      LEFT JOIN tblbranch AS b ON mc.branch_id = b.branch_id
      LEFT JOIN tbl_add_unit AS u ON mc.uid = u.uid

      ORDER BY mc.uid DESC;
  
                             ");
			while($row = mysqli_fetch_array($result)){?>
            <tr>
            <td><?php echo $row['m_title']; ?></td>
            <td><?php echo $row['o_name']; ?></td>
                          <td><?php echo $row['branch_name']; ?></td>
                          <td><?php echo $row['floor_no']; ?></td>
                          <td><?php echo $row['unit_no']; ?></td>

            <td><?php echo $row['m_date']; ?></td>
            <td><?php echo $ams_helper->currency($localization, $row['m_amount']); ?></td>
            <td>
            <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="javascript:;" onclick="$('#nurse_view_<?php echo $row['mcid']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>"><i class="fa fa-eye"></i></a> <a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL;?>maintenance/add_maintenance_cost.php?id=<?php echo $row['mcid']; ?>" data-original-title="<?php echo $_data['edit_text'];?>"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteMaintenanceCost(<?php echo $row['mcid']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text'];?>"><i class="fa fa-trash-o"></i></a>
            <div id="nurse_view_<?php echo $row['mcid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header green_header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                    <h3 class="modal-title"><?php echo $_data['m_cost_details'];?></h3>
                  </div>
                  
				  <div class="modal-body">
                    <h3 style="text-decoration:underline;"><?php echo $_data['details_information'];?></h3>
                    <div class="row">
                      <div class="col-xs-6"> 
					    <b><?php echo $_data['text_1'];?> :</b> <?php echo $row['m_title']; ?><br/>
                        <b><?php echo $_data['date'];?> :</b> <?php echo $row['m_date']; ?><br/>
                        <b><?php echo $_data['text_2'];?> : </b> <?php echo $ams_helper->currency($localization, $row['m_amount']); ?><br/>
						<!-- <b><?php echo $_data['month'];?> :</b> <?php echo $row['month_name']; ?><br/>
						<b><?php echo $_data['year'];?> :</b> <?php echo $row['xyear']; ?><br/> -->
                      </div>
					  <div class="col-xs-6">
					  	<b><?php echo $_data['text_3'];?> :</b> <?php echo $row['m_details']; ?><br/>
					  </div>
                    </div>
                  </div>
				  
                </div>
                <!-- /.modal-content -->
              </div>
            </div>
            </td>
            </tr>
            <?php } mysqli_close($link);$link = NULL; ?>
          </tbody>
        </table>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
<script type="text/javascript">
function deleteMaintenanceCost(Id){
  	var iAnswer = confirm("<?php echo $_data['confirm']; ?>");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>maintenance/maintenance_cost_list.php?id=' + Id;
	}
  }
  $(document).ready(function() {
	setTimeout(function() {
		  $("#me").hide(300);
		  $("#you").hide(300);
	}, 3000);
});
</script>
<?php include('../footer.php'); ?>
