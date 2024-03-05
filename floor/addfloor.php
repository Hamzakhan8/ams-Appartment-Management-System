<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_floor.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
$success = "none";
$floor_no = '';
$branch_id = '';

$title = $_data['add_new_floor_top_title'];
$button_text = $_data['save_button_text'];
$form_url = WEB_URL . "floor/addfloor.php";
$id="";
$building_make_year="";
$hdnid="0";

if(isset($_POST['txtFloor'])){
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
		$sql = "INSERT INTO `tbl_add_floor` (floor_no, `branch_id`, `ownid`) VALUES (?, ?, ?)";
		$stmt = mysqli_prepare($link, $sql);
		if ($stmt) {
			mysqli_stmt_bind_param($stmt, "sii", $_POST['txtFloor'], $_POST['branch_id'], $_POST['ownid']);
			mysqli_stmt_execute($stmt);
			mysqli_stmt_close($stmt);
			mysqli_close($link);
			$url = WEB_URL . 'floor/floorlist.php?m=add';
			header("Location: $url");
		} else {
			echo "Error: " . mysqli_error($link);
		}

	}
	//hello world
	else{
		$sql = "UPDATE `tbl_add_floor` SET `floor_no`='".$_POST['txtFloor']."',`ownid`='".$_POST['ownid']."', `branch_id`='".$_POST['branch_id']."' WHERE fid='".$_GET['id']."'";
		mysqli_query($link,$sql);
		$url = WEB_URL . 'floor/floorlist.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}

if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($link,"SELECT * FROM tbl_add_floor where fid = '" . $_GET['id'] . "'");
	while($row = mysqli_fetch_array($result)){
	
		$floor_no = $row['floor_no'];

		$branch_id = $row['branch_id'];
		$building_make_year = $row['ownid'];
		

		$hdnid = $_GET['id'];
		$title = $_data['update_floor_top_title'];
		$button_text = $_data['update_button_text'];
		$form_url = WEB_URL . "floor/addfloor.php?id=".$_GET['id'];
	}
	//mysqli_close($link);

}
if(isset($_GET['mode']) && $_GET['mode'] == 'view'){
	$title = 'View Floor Details';
}
print_r($building_make_year);	
?>
<!-- Content Header (Page header) -->

<!-- Main content -->
<section class="content">
<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_floor_information_breadcam'];?></li>
    <li class="active"><?php echo $title;?></li>
  </ol>
</section>
<!-- Full Width boxes (Stat box) -->
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"></div>
    <div class="box box-success box-size">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['add_new_floor_entry_text'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body row">
		<div class="form-group col-md-12">
     <label for="building_make_year"><?php echo $_data['text_17'];?> owner name:</label>
            <select onchange="getownid(this.value)" name="ownid" id="ownid" class="form-control">
              <option value="">--<?php echo $_data['text_14'];?>--</option>
              <?php $rs = mysqli_query($link,"SELECT ownid,o_name FROM tbl_add_owner");
                while($rows = mysqli_fetch_array($rs)){?>
                    <option <?php if($building_make_year == $rows['ownid']){echo 'selected';}?> value="<?php echo $rows['ownid'];?>"><?php echo $rows['o_name'];?></option>
            
					<?php } ?>
					
            </select>
		
          </div> 
          <div class="form-group col-md-12">
			<label for="building_make_year">Building Name:</label>
			<select name="branch_id" id="branch_id" class="form-control">
				<option value="">-- Building Name --</option>
				<?php if ($branch_id){  $rs = mysqli_query($link,"SELECT branch_id, branch_name FROM tblbranch");
					while($rows = mysqli_fetch_array($rs)){?>
						<option <?php if($branch_id == $rows['branch_id']){echo 'selected';}?> value="<?php echo $rows['branch_id'];?>"><?php echo $rows['branch_name'];?></option>
				<?php } }?>
            </select>
          </div>
          <div class="form-group col-md-12">
            <label for="txtFloor"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_1'];?> :</label>
            <input type="text" name="txtFloor" value="<?php echo $floor_no;?>" id="txtFloor" class="form-control" />
          </div>
		 
        </div>
		
        <div class="box-footer">
          <div class="form-group pull-right">
            <button type="submit" name="submit" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>
            <a class="btn btn-warning" title="" data-toggle="tooltip" href="<?php echo WEB_URL; ?>floor/floorlist.php"><i class="fa fa-reply"></i> <?php echo $_data['back_text'];?></a> </div>
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
	if($("#txtFloor").val() == ''){
		alert("<?php echo $_data['floor_required']; ?>");
		$("#txtFloor").focus();
		return false;
	}
	else{
		return true;
	}
}

</script>
<?php include('../footer.php'); ?>
