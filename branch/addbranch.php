<?php 
include('../header.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_branch.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
if(isset($_SESSION['login_type']) && ((int)$_SESSION['login_type'] != 5)){
	header("Location: ".WEB_URL."logout.php");
	die();
}
$success = "none";
$branch_name = '';
$b_email = '';
$b_contact_no = '';
$b_address = '';
$b_status = 1;
$title = $_data['text_1'];
$security_guard_mobile = '';
$secrataty_mobile = '';
$moderator_mobile = '';
$building_make_year = '';
$builder_company_name = '';
$builder_company_phone = '';
$builder_company_address = '';
$building_rule = '';
$button_text = $_data['save_button_text'];
$successful_msg = $_data['text_11'];
$image_building = WEB_URL . 'img/no_image.jpg';
$form_url= WEB_URL . "branch/addbranch.php";
$id="";
$hdnid="0";
$img_track = '';

if(isset($_POST['txtBrName'])){
	$image_url = uploadImage();
	if(isset($_POST['hdn']) && $_POST['hdn'] == '0'){
      $sql_branch = "INSERT INTO `tblbranch` (
          `branch_name`,
          `b_address`,
          `building_make_year`,
          `building_image`,
          `b_status`
      ) VALUES (
          ?,?,?,?,?
      )";
      $stmt = mysqli_prepare($link, $sql_branch);
      mysqli_stmt_bind_param($stmt, "ssiss", $_POST['txtBrName'], $_POST['txtareaAddress'], $_POST['building_make_year'], $image_url, $_POST['radioStatus']);
      if(mysqli_stmt_execute($stmt)){
          mysqli_stmt_close($stmt);
          mysqli_close($link);
          $url = WEB_URL . 'branch/branchlist.php?m=add';
          header("Location: $url");
          exit; 
      } else {
          echo "Error: " . mysqli_error($link);
      }
  }
	else{
		$sql_branch = "UPDATE `tblbranch` SET `branch_name`='".$_POST['txtBrName']."',`b_email`='".$_POST['txtBrEmail']."',`b_contact_no`='".$_POST['txtBrConNo']."',`b_address`='".$_POST['txtareaAddress']."',`security_guard_mobile`='".$_POST['security_guard_mobile']."',`secrataty_mobile`='".$_POST['secrataty_mobile']."',`moderator_mobile`='".$_POST['moderator_mobile']."',`building_make_year`='".$_POST['building_make_year']."',building_image='".$image_url."', `b_status` ='".$_POST['radioStatus']."', `builder_company_name` ='".$_POST['builder_company_name']."', `builder_company_phone` ='".$_POST['builder_company_phone']."', `builder_company_address` ='".$_POST['builder_company_address']."',`building_rule` ='".$_POST['building_rule']."' WHERE branch_id = '".$_GET['id']."'";
		mysqli_query($link,$sql_branch);
		mysqli_close($link);
		$url = WEB_URL . 'branch/branchlist.php?m=up';
		header("Location: $url");
	}
	$success = "block";
}
if(isset($_GET['id']) && $_GET['id'] != ''){
	$result = mysqli_query($link,"SELECT * FROM tblbranch where branch_id = '" . $_GET['id'] . "'");
	while($row = mysqli_fetch_array($result)){ 
		$branch_name = $row['branch_name'];
		$b_email = $row['b_email'];
		$b_contact_no = $row['b_contact_no'];
		$b_address = $row['b_address'];
		$security_guard_mobile = $row['security_guard_mobile'];
		$secrataty_mobile = $row['secrataty_mobile'];
		$moderator_mobile = $row['moderator_mobile'];
		$building_make_year = $row['building_make_year'];
		$builder_company_name = $row['builder_company_name'];
		$builder_company_phone = $row['builder_company_phone'];
		$builder_company_address = $row['builder_company_address'];
		$building_rule = $row['building_rule'];
		$b_status = $row['b_status'];
		$hdnid = $_GET['id'];
		$title = $_data['text_1_1'];
		$button_text = $_data['update_button_text'];
		$successful_msg = $_data['text_12'];
		if(!empty($row['building_image'])){
			$image_building = WEB_URL . 'img/upload/' . $row['building_image'];
		}
		$img_track = $row['building_image'];
		$form_url = WEB_URL . "branch/addbranch.php?id=".$_GET['id'];
	}

}
function uploadImage(){
	if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
	  $filename = basename($_FILES['uploaded_file']['name']);
	  $ext = substr($filename, strrpos($filename, '.') + 1);
	  if(($ext == "jpg" && $_FILES["uploaded_file"]["type"] == 'image/jpeg') || ($ext == "png" && $_FILES["uploaded_file"]["type"] == 'image/png') || ($ext == "gif" && $_FILES["uploaded_file"]["type"] == 'image/gif')){   
	  	$temp = explode(".",$_FILES["uploaded_file"]["name"]);
	  	$newfilename = NewGuid() . '.' .end($temp);
		move_uploaded_file($_FILES["uploaded_file"]["tmp_name"], ROOT_PATH . '/img/upload/' . $newfilename);
		return $newfilename;
	  }
	  else{
	  	return '';
	  }
	}
	return $_POST['img_exist'];
}
function NewGuid() { 
    $s = strtoupper(md5(uniqid(rand(),true))); 
    $guidText = 
        substr($s,0,8) . '-' . 
        substr($s,8,4) . '-' . 
        substr($s,12,4). '-' . 
        substr($s,16,4). '-' . 
        substr($s,20); 
    return $guidText;
}


if(isset($_GET['mode']) && $_GET['mode'] == 'view'){
	$title = 'View Branch Details';
}
?>


<section class="content">
<section class="content-header">
  <h1> <?php echo $title;?> </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><a href="<?php echo WEB_URL?>branch/branchlist.php"><?php echo $_data['text_2'];?></a></li>
    <li class="active"><?php echo $_data['text_1'];?></li>
  </ol>
</section>
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"></div>
    <div class="box box-success box-size">
      <div class="box-header">
        <h3 style="color:red;font-weight:bold;text-decoration:underline;" class="box-title"><?php echo $_data['text_3'];?></h3>
      </div>
      <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data">
        <div class="box-body row">
          <div class="form-group col-md-12">
            <label for="txtBrName"><span style="color:red;">*</span> <?php echo $_data['text_4'];?> :</label>
            <input type="text" name="txtBrName" value="<?php echo $branch_name ;?>" id="txtBrName" class="form-control" />
          </div>
          <div class="form-group col-md-12">
            <label for="building_make_year"><?php echo $_data['text_17'];?> :</label>
            <select name="building_make_year" id="building_make_year" class="form-control">
              <option value="">--<?php echo $_data['text_14'];?>--</option>
              <?php $rs = mysqli_query($link,"SELECT ownid, o_name FROM tbl_add_owner");
                while($rows = mysqli_fetch_array($rs)){?>
                    <option <?php if($building_make_year == $rows['ownid']){echo 'selected';}?> value="<?php echo $rows['ownid'];?>"><?php echo $rows['o_name'];?></option>
              <?php } ?>
            </select>
          </div> 
          <div class="form-group col-md-12">
            <label for="txtareaAddress"><span style="color:red;">*</span> <?php echo $_data['text_7'];?> :</label>
            <textarea rows="3" name="txtareaAddress" id="txtareaAddress" class="form-control"><?php echo $b_address;?></textarea>
          </div>
          <div class="form-group col-md-12">
            <label for="Prsnttxtarea"><?php echo $_data['text_18'];?> :</label>
            <img class="form-control" src="<?php echo $image_building; ?>" style="height:250px;width:200px;" id="output"/>
            <input type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
          </div>
          <div class="form-group col-md-12"> <span class="btn btn-file btn btn-default"><?php echo $_data['upload_image'];?>
            <input type="file" name="uploaded_file" onchange="loadFile(event)" />
            </span> </div>
          <div class="form-group col-md-12">
            <label for="radioStatus"><?php echo $_data['text_8'];?> :</label>
            &nbsp;&nbsp;
            <input class="minimal" type="radio"  name="radioStatus" id="radioStatus" <?php if($b_status == '1'){echo 'checked=checked';}?> value="1" />
            &nbsp;&nbsp;<span><?php echo $_data['text_9'];?></span>&nbsp;&nbsp;
            <input class="minimal" type="radio"  name="radioStatus" id="radioStatus" <?php if($b_status == '0'){echo 'checked=checked';}?>  value="0" />
            &nbsp;&nbsp;<span><?php echo $_data['text_10'];?></span> </div>
          <div class="clearfix">&nbsp;</div>
          <hr />
        <div class="box-footer">
          <div class="form-group pull-right">
            <button type="submit" name="button" class="btn btn-success"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>
            <a class="btn btn-warning" href="<?php echo WEB_URL; ?>branch/branchlist.php"><i class="fa fa-reply"></i> <?php echo $_data['back_text'];?></a> </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
function validateMe(){
	if($("#txtBrName").val() == ''){
		alert("<?php echo $_data['r1']; ?>");
		$("#txtBrName").focus();
		return false;
	}
	else if($("#txtBrEmail").val() == ''){
		alert("<?php echo $_data['r2']; ?>");
		$("#txtBrEmail").focus();
		return false;
	}
	else if($("#txtBrConNo").val() == ''){
		alert("<?php echo $_data['r3']; ?>");
		$("#txtBrConNo").focus();
		return false;
	}
	else if($("#txtareaAddress").val() == ''){
		alert("<?php echo $_data['r4']; ?>");
		$("#txtareaAddress").focus();
		return false;
	}
	else{
		return true;
	}
}
CKEDITOR.replace( 'building_rule',{height: 700});
</script>
<?php include('../footer.php'); ?>
