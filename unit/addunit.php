<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_unit.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$floor_no = '';
$unit_type = '';

$unit_no = '';
$ownid = '';
$branch_id = '';
$building_make_year ='';

$title = $_data['add_new_unit'];
$button_text = $_data['save_button_text'];
$successful_msg = $_data['add_unit_successfully'];
$form_url = WEB_URL . "unit/addunit.php";
$id="";
$hdnid="0";

if(isset($_POST['submit'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
		$sql = "INSERT INTO `tbl_add_unit` (
			floor_no,
			unit_no,
			unit_type,
			branch_id,
			ownid
		) VALUES (
			'$_POST[ddlFloorNo]',
			'$_POST[txtUnit]',
			'$_POST[txtUnitType]',
			'$_POST[branch_id]',
			'$_POST[ownid]'
		)";		

		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'unit/unitlist.php?m=add';
		header("Location: $url");
	}
	else{
		$sql = "UPDATE
		`tbl_add_unit`
	SET
		`floor_no` = '$_POST[ddlFloorNo]',
		`unit_type` = '$_POST[txtUnitType]',
		`unit_no` = '$_POST[txtUnit]',
		`branch_id` = '$_POST[branch_id]',
		`ownid` = '$_POST[ownid]'
	WHERE
		`uid` = '$_GET[id]'";
		// print_r($sql);
		// exit;
		
		mysqli_query($link,$sql);
		mysqli_close($link);
		$url = WEB_URL . 'unit/unitlist.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($link,"SELECT * FROM tbl_add_unit where uid = '" . $_GET['id'] . "'");
	
	while($row = mysqli_fetch_array($result)){
		
		$floor_no = $row['floor_no'];
		$unit_no = $row['unit_no'];
		$building_make_year = $row['ownid'];
		$branch_id = $row['branch_id'];
		$unit_type = $row['unit_type'];


		
	
	
		$hdnid = $_GET['id'];
		$title = $_data['update_unit'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['update_unit_successfully'];
		$form_url = WEB_URL . "unit/addunit.php?id=".$_GET['id'];
	}
}

if(isset($_GET['mode']) && $_GET['mode'] == 'view'){
	$title = 'View Unit Details';
}	
?>
<!-- Content Header (Page header) -->


<!-- Main content -->
<section class="content">

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_unit_information_breadcam'];?></li>
    <li class="active"><?php echo $title;?></li>
  </ol>
</section>
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> </div>
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_unit_entry_form'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
		<div class="form-group col-md-12">
          <label for="building_make_year">Owner name:</label>
            <select onchange="getownid(this.value)" name="ownid" id="ownid" class="form-control">
              <option value="">--Select Owner--</option>
              <?php $rs = mysqli_query($link,"SELECT ownid,o_name FROM tbl_add_owner ");
                while($rows = mysqli_fetch_array($rs)){?>
                    <option <?php if($building_make_year == $rows['ownid']){echo 'selected';}?> value="<?php echo $rows['ownid'];?>"><?php echo $rows['o_name'];?></option>
              <?php } ?>
            </select>
          </div> 
		  <div class="form-group col-md-12">
			<label for="building_make_year">Building Name:</label>
			<select onchange="getBuilind(this.value)" name="branch_id" id="branch_id"  class="form-control ddlBuildingNo">
				<option value="">-- Building Name --</option>
				<?php if($branch_id){
					$rs = mysqli_query($link,"SELECT branch_id, branch_name FROM tblbranch");
					while($rows = mysqli_fetch_array($rs)){?>
						<option <?php if($branch_id == $rows['branch_id']){echo 'selected';}?> value="<?php echo $rows['branch_id'];?>"><?php echo $rows['branch_name'];?></option>
				<?php }} ?>
            </select>
          </div>
		
          <div class="form-group col-md-12">
            <label for="ddlFloorNo"><span class="errorStar">*</span> SELECT FLOOR:</label>
            <select onchange="getUnit(this.value)" name="ddlFloorNo" id="ddlFloorNo" class="form-control">
				<option value="">--<?php echo $_data['select_floor'];?>--</option>
				<?php if($floor_no){
						$result_floor = mysqli_query($link,"SELECT * FROM tbl_add_floor WHERE branch_id = " .$branch_id. " order by fid ASC");
					  while($row_floor = mysqli_fetch_array($result_floor)){?>
				<option <?php if($floor_no == $row_floor['fid']){echo 'selected';}?> value="<?php echo $row_floor['fid'];?>"><?php echo $row_floor['floor_no'];?></option>
				<?php }} ?>
            </select>
          </div>
		  <div class="form-group col-md-12 ">
            <label for="txtUnit"><span class="errorStar">*</span> Select Unit Type</label>
			<select name="txtUnitType" class="form-control">
				<option value="">--Select Unit Type--</option>
				<option value="Studio">Studio</option>
				<option value="OneBHK">One BHK</option>
				<option value="TwoBHK">Two BHK</option>
				<option value="ThreeBHK">Three BHK</option>
			</select>

          </div>
          <div class="form-group col-md-12 ">
            <label for="txtUnit"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_2'];?> :</label>
            <input type="text" name="txtUnit" value="<?php echo $unit_no;?>" id="txtUnit" class="form-control" />
          </div>
        </div>
        <div class="box-footer">
          <div class="form-group pull-right">
            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>
            <a class="btn btn-warning" href="<?php echo WEB_URL; ?>unit/unitlist.php"><i class="fa fa-reply"></i> <?php echo $_data['back_text'];?></a> </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
      </form>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
</div>
<!-- /.row -->
<script type="text/javascript">
function validateMe(){
	if($("#ddlFloor").val() == ''){
		alert("<?php echo $_data['floor_required']; ?>");
		$("#ddlFloor").focus();
		return false;
	}
	else if($("#txtUnit").val() == ''){
		alert("<?php echo $_data['unit_required']; ?>");
		$("#txtUnit").focus();
		return false;
	}
	else{
		return true;
	}
}
</script>
<?php include('../footer.php'); ?>
