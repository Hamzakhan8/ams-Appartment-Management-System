<?php 
	include('../header.php');
	include('../utility/common.php');
	include(ROOT_PATH.'language/'.$lang_code_global.'/lang_add_rented.php');
	if(!isset($_SESSION['objLogin'])){
		header("Location: " . WEB_URL . "logout.php");
		die();
	}
	$success = "none";
	$r_name = '';
	$r_email = '';
	$r_contact = '';
	$r_address = '';
	$r_nid = '';
	$r_passport = '';
	$building_make_year = '';
	$r_building = 0;
	$ownid = '';
	$r_floor_no = "";
	$r_unit_no = 0;
	$r_advance = '';
	$r_rent_pm = '';
	$r_date = '';
	$r_month = '';
	$r_year = '';
	$r_password = '';
	$r_vat = 0;
	$r_property = '';
	$r_bank_name = '';
	$r_total_check = '';
	$r_status = '1';
	$parking_amount = '';
	$discount = '';
	$other_cost = '';
	$final_amount = '';
	

	$start_date = "";
	$end_date = "";

	$branch_id = '';
	$title = $_data['add_new_renter'];
	$button_text = $_data['save_button_text'];
	$successful_msg = $_data['added_renter_successfully'];
	$form_url = WEB_URL . "rent/addrent.php";
	$id="";
	$hdnid="0";
	$image_rnt = WEB_URL . 'img/no_image.jpg';
	$img_track = '';


	if (isset($_POST['txtRName'])) {
		if (isset($_POST['hdn']) && $_POST['hdn'] == '0') {
			$r_password = isset($_POST['txtPassword']) ? $converter->encode($_POST['txtPassword']) : '';
			$image_url = uploadImage();
			$vat = isset($_POST['txtRentedVat']) && $_POST['txtRentedVat'] !== '' ? $_POST['txtRentedVat'] : 0;
			
	

	
			$sql = "INSERT INTO tbl_add_rent (
				r_name, r_email, r_contact, r_address, r_nid, r_passport, ownid, r_building,
				r_floor_no, r_unit_no, r_property, start_date, months, end_date, amount, r_vat,final_amount,
				parking_status,parking_amount, other_cost, discount, r_date, r_status, r_bank_name, r_total_check
			) VALUES (
				'{$_POST['txtRName']}', '{$_POST['txtREmail']}', '{$_POST['txtRContact']}', '{$_POST['txtRAddress']}', '{$_POST['txtRentedNID']}', '{$_POST['txtRentedPassport']}',
				'{$_POST['ownid']}', '{$_POST['branch_id']}', '{$_POST['ddlFloorNo']}', '{$_POST['ddlUnitNo']}', '{$_POST['r_property']}', '{$_POST['startdate']}', '{$_POST['months']}',
				'{$_POST['enddate']}', '{$_POST['amount']}', '{$_POST['vat']}', '{$_POST['finalAmount']}', '{$_POST['showparking']}', '{$_POST['prakingamount']}', '{$_POST['othercost']}', '{$_POST['discount']}',
				'" . date("Y-m-d H:i:s") . "', '{$_POST['chkRStatus']}', '{$_POST['bankName']}', '{$_POST['totalChecks']}'
			)";
	
	
				mysqli_query($link, $sql);
			$last_id = mysqli_insert_id($link);

			$sqlx = "UPDATE `tbl_add_unit` SET status = 1 WHERE floor_no = '" . (int)$_POST['ddlFloorNo'] . "' AND uid = '" . (int)$_POST['ddlUnitNo'] . "'";
			mysqli_query($link, $sqlx);

			$sql_queries = ''; // Initialize the SQL queries variable

			for ($i = 1; $i <= $_POST['totalChecks']; $i++) {
				$check_number = mysqli_real_escape_string($link, $_POST['checknumber' . $i]);
				$bank_name = mysqli_real_escape_string($link, $_POST['bankname']);
				$date = mysqli_real_escape_string($link, $_POST['date' . $i]);
				$amount = mysqli_real_escape_string($link, $_POST['amount' . $i]);

				$sql_queries .= "INSERT INTO tbl_emi_payment (rid, ckeck_number, bank_name, date, amount, created_at) 
								VALUES ('$last_id', '$check_number', '$bank_name', '$date', '$amount', NOW());";
			}

			if (!empty($sql_queries)) {
				if (mysqli_multi_query($link, $sql_queries)) {
					mysqli_close($link);
					$url = WEB_URL . 'rent/rentlist.php?m=add';
					header("Location: $url");
					exit();
				} else {
					echo "Error: " . mysqli_error($link);
				}
			}
		} else {
			$image_url = uploadImage();

			if ($image_url == '') {
				$image_url = $_POST['img_exist'];
			}

			$sql = "UPDATE `tbl_add_rent` SET 
						 	r_name = '{$_POST['txtRName']}',
							r_email = '{$_POST['txtREmail']}',
							r_contact = '{$_POST['txtRContact']}',
							r_address = '{$_POST['txtRAddress']}',
							r_nid = '{$_POST['txtRentedNID']}',
							r_passport = '{$_POST['txtRentedPassport']}',
							ownid = '{$_POST['ownid']}',
							r_building = '{$_POST['branch_id']}',
							r_floor_no = '{$_POST['ddlFloorNo']}',
							r_unit_no = '{$_POST['ddlUnitNo']}',
							r_property = '{$_POST['r_property']}',
							start_date = '{$_POST['startdate']}',
							months = '{$_POST['months']}',
							end_date = '{$_POST['enddate']}',
							amount = '{$_POST['amount']}',
							r_vat = '{$_POST['vat']}',
							final_amount = '{$_POST['finalAmount']}',
							parking_amount = '{$_POST['prakingamount']}',
							other_cost = '{$_POST['othercost']}',
							discount = '{$_POST['discount']}',
							r_date = '" . date("Y-m-d H:i:s") . "',
							r_status = '{$_POST['chkRStatus']}',
							r_bank_name = '{$_POST['bankName']}',
							r_total_check = '{$_POST['totalChecks']}'
					WHERE rid='$_GET[id]'";
				


			mysqli_query($link, $sql);

			$sqlx = "UPDATE `tbl_add_unit` SET status = 0 WHERE floor_no = '" . (int)$_POST['hdnFloor'] . "' AND uid = '" . (int)$_POST['hdnUnit'] . "'";
			mysqli_query($link, $sqlx);

			$sqlxx = "UPDATE `tbl_add_unit` SET status = 1 WHERE floor_no = '" . (int)$_POST['ddlFloorNo'] . "' AND uid = '" . (int)$_POST['ddlUnitNo'] . "'";
			mysqli_query($link, $sqlxx);

			$url = WEB_URL . 'rent/rentlist.php?m=up';
			header("Location: $url");
		}
		$success = "block";
	}
	


	if(isset($_GET['id']) && $_GET['id'] != ''){
		$result = mysqli_query($link,"SELECT * FROM tbl_add_rent where rid = '" . $_GET['id'] . "'");
		if($row = mysqli_fetch_array($result)){
			
			// tanent

			$r_name = $row['r_name'];
			$r_email = $row['r_email'];
			$r_contact = $row['r_contact'];
			$r_address = $row['r_address'];
			$r_nid = $row['r_nid'];
			$r_passport = $row['r_passport'];

			// building
			$ownid = $row['ownid'];
			$branch_id = $row['r_building'];
			$r_floor_no = $row['r_floor_no'];
			$r_unit_no = $row['r_unit_no'];
			$parking_amount = $row['parking_amount'];
			$discount = $row['discount'];
			

			// Contract 
			$start_date = $row['start_date'];
			$end_date = $row['end_date'];
			$months = $row['months'];
			$r_rent_pm = $row['amount'];
			$r_advance = $row['r_advance'];
			$r_date = $row['r_date'];
			$r_property = $row['r_property'];
			$r_vat = $row['r_vat'];
			$r_bank_name = $row['r_bank_name'];
			$r_total_check = $row['r_total_check'];
			$other_cost = $row['other_cost'];
			$final_amount =$row['final_amount'];
			
	
			$r_status = $row['r_status'];
			$r_password = $converter->decode($row['r_password']);
			if($row['image'] != ''){
				$image_rnt = WEB_URL . 'img/upload/' . $row['image'];
				$img_track = $row['image'];
			}
			$hdnid = $_GET['id'];
			$title = $_data['update_rent'];
			$button_text = $_data['update_button_text'];
			$successful_msg = $_data['update_renter_successfully'];
			$form_url = WEB_URL . "rent/addrent.php?id=".$_GET['id'];
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
		return '';
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
?>

<section class="content">

<section class="content-header">
  <h1><?php echo $title;?></h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo WEB_URL?>dashboard.php"><i class="fa fa-dashboard"></i><?php echo $_data['home_breadcam'];?></a></li>
    <li class="active"><?php echo $_data['add_new_renter_information_breadcam'];?></li>
    <li class="active"><?php echo $title;?></li>
  </ol>
</section>
<div class="row">
  <div class="col-md-12">
    <div align="right" style="margin-bottom:1%;"> </div>
    <div class="box box-white">
      <div class="box-header">
        <h3 class="box-title"><b><?php echo $_data['add_new_renter_entry_form'];?></b></h3>
      </div>
	  <form onSubmit="return validateMe();" action="<?php echo $form_url; ?>" method="post" enctype="multipart/form-data" id="frm_renter_entry">
        <div class="box-body row">
		<div class="col-md-2">
				<div class="form-group col-md-12">
					<label for="Prsnttxtarea"><?php echo $_data['add_new_form_field_text_15'];?> :</label>
					<img class="form-control" src="<?php echo $image_rnt; ?>" style="height:150px;width:150px;" id="output"/>
					<input  type="hidden" name="img_exist" value="<?php echo $img_track; ?>" />
				</div>
				<div align="center" class="form-group col-md-12"> <span class="btn btn-file btn btn-default"><?php echo $_data['upload_image'];?>
					<input  type="file" name="uploaded_file" onchange="loadFile(event)" />
					</span> </div>
				</div>
				<div class="col-md-10">
			 <div class="form-group col-md-6">
            <label for="txtRName"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_1'];?> :</label>
            <input type="text" name="txtRName" value="<?php echo $r_name;?>" id="txtRName" class="form-control" />
          </div>
          <div class="form-group col-md-6">
            <label for="txtREmail"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_2'];?> :</label>
            <input type="text" name="txtREmail" value="<?php echo $r_email;?>" id="txtREmail" class="form-control" />
          </div>
      
          <div class="form-group col-md-6">
            <label for="txtRContact"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_4'];?> :</label>
            <input type="text" name="txtRContact" value="<?php echo $r_contact;?>" id="txtRContact" class="form-control" />
          </div>
		  <div class="form-group col-md-6">
			<label for="txtRentedNID"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_6'];?> :</label>
			<input type="text" name="txtRentedNID" value="<?php echo $r_nid;?>" id="txtRentedNID" class="form-control" />
		  </div>
		  <div class="form-group col-md-6">
			<label for="txtRentedPassport"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_19'];?> :</label>
			<input type="text" name="txtRentedPassport" value="<?php echo $r_passport;?>" id="txtRentedPassport" class="form-control" />
		  </div>
          <div class="form-group  col-md-6">
            <label for="txtRAddress"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_5'];?> :</label>
            <textarea name="txtRAddress" id="txtRAddress" class="form-control"><?php echo $r_address;?></textarea>
          </div>
		</div>

		</div>
		
         
		  <div class="col-md-12">
			<div class="box-header">
				<h3 class="box-title"><b><?php echo $_data['add_new_renter_entry_form_builing_info'];?></b></h3>
			</div>
		  </div>
		  <div class="form-group col-md-4">
          <label for="building_make_year"> <span class="errorStar">*</span>Owner name:</label>
            <select onchange="getownid(this.value)" name="ownid" id="ownid" class="form-control">
              <option value="">--Select Owner--</option>
              <?php $rs = mysqli_query($link,"SELECT ownid,o_name FROM tbl_add_owner");
                while($rows = mysqli_fetch_array($rs)){?>
                    <option <?php if($ownid == $rows['ownid']){echo 'selected';}?> value="<?php echo $rows['ownid'];?>"><?php echo $rows['o_name'];?></option>
              <?php } ?>
            </select>
          </div> 
		  <div class="form-group col-md-4">
			<label for="building_make_year"><span class="errorStar">*</span>Building Name:</label>
			<select onchange="getBuilind(this.value)" name="branch_id" id="branch_id"  class="form-control ddlBuildingNo">
				<option value="">-- Building Name --</option>
				
				<?php if($branch_id) {
				$rs = mysqli_query($link,"SELECT branch_id, branch_name FROM tblbranch where building_make_year =".$ownid);
					while($rows = mysqli_fetch_array($rs)){?>
						<option <?php if($branch_id == $rows['branch_id']){echo 'selected';}?> value="<?php echo $rows['branch_id'];?>"><?php echo $rows['branch_name'];?></option>
				<?php } }?>
            </select>
          </div>
		
          <div class="form-group col-md-4">
            <label for="ddlFloorNo"><span class="errorStar">*</span> Select Floor:</label>
            <select onchange="getUnit(this.value)" name="ddlFloorNo" id="ddlFloorNo" class="form-control">
              <option value="">--<?php echo $_data['select_floor'];?>--</option>
              <?php if($r_floor_no){
				  	$result_floor = mysqli_query($link,"SELECT * FROM tbl_add_floor where branch_id = ".$branch_id." order by fid ASC");
					while($row_floor = mysqli_fetch_array($result_floor)){?>
              <option <?php if($r_floor_no == $row_floor['fid']){echo 'selected';}?> value="<?php echo $row_floor['fid'];?>"><?php echo $row_floor['floor_no'];?></option>
              <?php }}?>
            </select>
          </div>
          <div class="form-group col-md-6">
            <label for="ddlUnitNo"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_8'];?> :</label>
            <select name="ddlUnitNo" id="ddlUnitNo" class="form-control">
              <option value="">--<?php echo $_data['select_unit'];?>--</option>
              <?php if($r_unit_no){
				  	$result_unit = mysqli_query($link,"SELECT * FROM tbl_add_unit where floor_no = ".(int)$r_floor_no." order by unit_no ASC");
					while($row_unit = mysqli_fetch_array($result_unit)){?>
              <option <?php if($r_unit_no == $row_unit['uid']){echo 'selected';}?> value="<?php echo $row_unit['uid'];?>"><?php echo $row_unit['unit_no'];?></option>
              <?php }} ?>
            </select>
          </div>
		  <div class="form-group col-md-6">
            <label for="r_property"><span class="errorStar">*</span>Property Type:</label>
            <select name="r_property" id="r_property" class="form-control">
              <option  disabled selected>-- Select Property Type --</option>
              <option <?php if($r_property=='1'){echo 'selected';}?> value="1">R</option>
              <option <?php if($r_property=='0'){echo 'selected';}?> value="0">C</option>
            </select>
          </div>
		  
		<div class="col-md-12" >
			<div class="box-header">
				<h3 class="box-title"><b>Contract Info</b></h3>
			</div>
		  </div>
		
	
		
		  <div class="col-md-6" style="border-bottom:2px;" >
			<div class="box-header">
				<h3 class="box-title"><b></b></h3>
			</div>
		  <div class="form-group col-md-4">
            <label for="txtRDate"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_11'];?> :</label>
            <input type="date" name="startdate" value="<?php echo date('Y-m-d', strtotime($start_date)); ?>"  id="datepicker1" class="form-control date_selection" />
		  </div>
		  <div class="form-group col-md-4">
            <label for=""><span class="errorStar">*</span>Select Months Duration:</label>
			<input type="text" name="months"  id="months" value="<?php echo $months;?>" class="form-control getFinalAmount" />

          </div>
		  <div class="form-group col-md-4">
            <label for="txtRDate"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_111'];?> :</label>
            <input type="date" name="enddate" id="txtRDate2" value="<?php echo date('Y-m-d', strtotime($start_date)); ?>" dias class="form-control date_selection"/>
		  </div>
		  <div class="form-group col-md-4">
		  <label for="txtRentPerMonth"><span class="errorStar">*</span> <?php echo $_data['add_new_form_field_text_10'];?> :</label>
				<div class="input-group">
					<input type="text" name="amount"  value="<?php echo $r_rent_pm;?>" id="txtRentPerMonth" class="form-control getFinalAmount" />
					<div class="input-group-addon"> <?php echo CURRENCY;?> </div>
				</div>
		  </div>
		  <div class="form-group col-md-4">
		  <label for="vatPercentage"><span class="errorStar">*</span> VAT %:</label>
				<div class="input-group">
					<div class="form-check">
						<input class="form-check-input getFinalAmount"type="radio" name="vat" id="flexRadioDefault1">
						<label class="form-check-label" for="flexRadioDefault1">
							Yes
						</label>
						<input class="form-check-input getFinalAmount" type="radio" name="vat" id="flexRadioDefault2">
						<label class="form-check-label" for="flexRadioDefault2">
							No
						</label>
					</div>
					
				</div>

          </div>
		  <div class="form-group col-md-4">
		  <label for="otherCost"><span class="errorStar">*</span> Other Cost   :</label>
				<input type="text" name="othercost" value="<?php echo $other_cost;?>" id="txtOtherCost" class="form-control getFinalAmount" />
		  </div>
	
					
		  <div class="form-group col-md-4">
					<label for="parking"><span class="errorStar">*</span> Parking:</label>
					<div class="input-group">
					<div class="form-check">
						<input class="form-check-input getFinalAmount" type="radio" name="showparking" id="showParkingYes">
						<label class="form-check-label" for="showParkingYes">
						Yes
						</label>
						<input class="form-check-input getFinalAmount" type="radio" name="showparking" id="showParkingNo">
						<label class="form-check-label" for="showParkingNo">
						No
						</label>
					</div>
					</div>
				</div>

				<div class="form-group col-md-4" id="parking_div">
					<label for="parkingAmount"><span class="errorStar">*</span> Parking Amount:</label>
					<input type="text" name="prakingamount" value="<?php echo $parking_amount;?>" id="txtParkingAmount" class="form-control getFinalAmount" />
			</div>
						<div class="form-group col-md-4">
				<label for="discountPercentage"><span class="errorStar">*</span> Discount  :</label>
				<input type="text" name="discount" value="<?php echo ($discount)? $discount:"";?>" id="txtDiscount" class="form-control getFinalAmount" />
			</div>

			<div class="form-group col-md-4">
				<label for="finalAmount"><span class="errorStar">*</span> Final Amount:</label>
				<input type="text" disabled name="finalAmountD" value="<?php echo $final_amount;?>" id="finalAmountD" class="form-control" />
			</div>

			<input type="hidden" name="finalAmount" id="finalAmount">

          <div class="form-group col-md-4">
            <label for="chkRStatus"><?php echo $_data['add_new_form_field_text_14'];?> :</label>
            <select name="chkRStatus" id="chkRStatus" class="form-control">
              <option <?php if($r_status=='1'){echo 'selected';}?> value="1"><?php echo $_data['add_new_form_field_text_16']; ?></option>
              <option <?php if($r_status=='0'){echo 'selected';}?> value="0"><?php echo $_data['add_new_form_field_text_17']; ?></option>
            </select>
          </div>
      
          <div class="form-group col-md-4 ">
            <label for="bankName"><?php echo $_data['add_new_form_field_text_21'];?> :</label>
            <input type="text" name="bankName" id="bankName" class="form-control" value="<?php echo $r_bank_name;?>">
          </div>
          <div class="form-group col-md-4">
			
            <label for="totalChecks"><?php echo $_data['add_new_form_field_text_22'];?> :</label>
			
            <input type="text" onchange="generateFields()"  name="totalChecks" id="totalChecks" class="form-control " value="<?php echo $r_total_check;?>">
          </div>
		  <div class="checksAndAmounts form-group col-md-12"></div>
		 </div>
			<div class="col-md-6" >
				<div class="box-header">
					<h3 class="box-title"><b>Contract Calculations</b></h3>
				</div>
				<div class="form-group col-md-6">
					<label  for="otherCost">
						<span class="errorStar">*</span> Total Amount:
						<span style="margin-left: 155px;" class="totalAmountShow"></span>

					</label>
				</div>
			
				<div class="form-group col-md-12">
					<label  for="otherCost">
						<span class="errorStar">*</span> Other Cost: <span  style="margin-left:150px;" class="other_cost"></span>
					</label>
				</div>
				<div class="form-group col-md-12">
					<label  for="otherCost">
						<span class="errorStar">*</span> Vat 5%:<span  style="margin-left:177px;" class="vat_show"></span>
					</label>
				</div>
				 <div class="form-group col-md-12">
					<label  for="otherCost">
						<span class="errorStar">*</span> Parking Amount :<span  style="margin-left:110px;" class="ParkingAmountShow"></span>
					</label>
				</div>

				<div class="form-group col-md-12">
					<label  for="otherCost">
						<span class="errorStar">*</span> Final Amount : <span  style="margin-left:124px;" class="final_Amount"></span> 
					</label>
				</div>
				
			</div> 
		
			
		 
	    
        
        <div class="box-footer " >
          <div class="form-group pull-right " style="margin-top:20px;" >
            <?php if($hdnid=='0') { ?>
            <button type="button" onclick="renter_email_exist();" name="button" class="btn btn-primary"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>
            <?php } else { ?>
            <button type="submit" name="button" class="btn btn-danger"><i class="fa fa-floppy-o"></i> <?php echo $button_text; ?></button>
            <?php } ?>
            <a class="btn btn-warning" href="<?php echo WEB_URL; ?>rent/rentlist.php"><i class="fa fa-reply"></i> <?php echo $_data['back_text'];?></a> </div>
        </div>
        <input type="hidden" value="<?php echo $hdnid; ?>" name="hdn"/>
        <input type="hidden" value="<?php echo $r_floor_no; ?>" name="hdnFloor"/>

        <input type="hidden" value="<?php echo $r_unit_no; ?>" name="hdnUnit"/>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">

document.addEventListener('DOMContentLoaded', function() {
      // Get radio buttons and parking div
      var showParkingYesRadio = document.getElementById('showParkingYes');
      var showParkingNoRadio = document.getElementById('showParkingNo');
      var parkingDiv = document.getElementById('parking_div');
      var parkingAmountInput = document.getElementById('txtParkingAmount');

      // Set default value for parking amount input
      parkingAmountInput.value = 0;

      parkingDiv.style.display = 'none';

      showParkingYesRadio.addEventListener('change', function() {
        parkingDiv.style.display = this.checked ? 'block' : 'none';
      });

      showParkingNoRadio.addEventListener('change', function() {
        parkingDiv.style.display = this.checked ? 'none' : 'block';

        // Set default value to zero when user clicks on "No"
        if (this.checked) {
          parkingAmountInput.value = 0;
        }
      });
    });

  function getCurrentDate() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    return `${year}-${month}-${day}`;
  }
  document.getElementById('datepicker1').value = getCurrentDate();
	
  function validateMe() {
    // Remove previous error messages
    $('.validation-error').remove();

    // Image validation
    var imgExist = $("input[name='img_exist']").val();
    var uploadedFile = $("input[name='uploaded_file']").val();
    if (imgExist == '0' && uploadedFile == '') {
        showAlert($("#txtRName"), "<?php echo $_data['required_image']; ?>");
        return false;
    }

    // Other validations
    if ($("#txtRName").val() == '') {
        showAlert($("#txtRName"), "<?php echo $_data['required_1']; ?>");
        return false;
    }
    if ($("#txtRContact").val() == '') {
        showAlert($("#txtRContact"), "<?php echo $_data['required_4']; ?>");
        return false;
    }
    if ($("#ownid").val() == '') {
        showAlert($("#ownid"), "Please select Owner");
        return false;
    }
    if ($("#branch_id").val() == '') {
        showAlert($("#branch_id"), "Please select Building Name");
        return false;
    }
    if ($("#ddlFloorNo").val() == '') {
        showAlert($("#ddlFloorNo"), "<?php echo $_data['required_7']; ?>");
        return false;
    }
    // Add similar showAlert calls for other fields...
    if ($("#ddlUnitNo").val() == '') {
        showAlert($("#ddlUnitNo"), "<?php echo $_data['required_8']; ?>");
        return false;
    }
    if ($("#r_property").val() == '') {
        showAlert($("#r_property"), "Please select Property Type");
        return false;
    }
    if ($("input[name='startdate']").val() == '') {
        showAlert($("input[name='startdate']"), "<?php echo $_data['required_11']; ?>");
        return false;
    }
    if ($("#months").val() == '') {
        showAlert($("#months"), "Please enter Select Months Duration");
        return false;
    } if ($("input[name='enddate']").val() == '') {
        showAlert($("input[name='enddate']"), "<?php echo $_data['required_111']; ?>");
        return false;
    }
    if ($("#txtRentPerMonth").val() == '') {
        showAlert($("#txtRentPerMonth"), "<?php echo $_data['required_10']; ?>");
        return false;
    }
    if ($("input[name='vat']:checked").length === 0) {
        showAlert($(".form-check-input[name='vat']"), "Please select VAT");
        return false;
    }
    if ($("#txtOtherCost").val() == '') {
        showAlert($("#txtOtherCost"), "<?php echo $_data['required_other_cost']; ?>");
        return false;
    }
    if ($("input[name='showparking']:checked").length === 0) {
        showAlert($(".form-check-input[name='showparking']"), "Please select Parking");
        return false;
    }
    if ($("#txtParkingAmount").val() == '' && $("input[name='showparking']:checked").val() == 'Yes') {
        showAlert($("#txtParkingAmount"), "Please enter Parking Amount");
        return false;
    }
    if ($("#txtDiscount").val() == '') {
        showAlert($("#txtDiscount"), "<?php echo $_data['required_discount']; ?>");
        return false;
    }
    if ($("#chkRStatus").val() == '') {
        showAlert($("#chkRStatus"), "<?php echo $_data['required_14']; ?>");
        return false;
    }
    if ($("#bankName").val() == '') {
        showAlert($("#bankName"), "<?php echo $_data['required_21']; ?>");
        return false;
    }
	

return true;


}


function showAlert(element, message) {
    element.after('<div class="validation-error" style="padding:5px; color:red;">' + message + '</div>');
}

	function renter_email_exist(){
	var email = $("#txtREmail").val();
	if(email != ''){
		$.ajax({
			url: '../ajax/getunit.php',
			type: 'POST',
			data: 'email='+email+'&token=renter_email_exist',
			dataType: 'json',
			success: function(data) {
				if(data != '-99'){
					if(data.email_exist){
						alert('<?php echo $_data['email_exist']; ?>');
						$("#txtREmail").focus();
					} else {
						jQuery("#frm_renter_entry").submit();
					}
				}
				else{
					window.location.href = '../index.php';
				}
			}
		});
	} else {
			$("#frm_renter_entry").submit();
	}
	}
	function generateFields() {
		var totalChecks = parseInt(document.getElementById('totalChecks').value);

		var totalAmount = parseFloat(document.getElementById('finalAmount').value);
		var bankName = document.getElementById('bankName').value; // Get the bank name
		var checksAndAmountsDiv = document.querySelector('.checksAndAmounts');
		checksAndAmountsDiv.innerHTML = '';
		var startDate = new Date($('#datepicker1').val());
		var endDate = new Date($('#txtRDate2').val());
		var amountPerCheck = (totalAmount / totalChecks).toFixed(2);
		if ($("#totalChecks").val() == '') {
    showAlert($("#totalChecks"), "<?php echo $_data['required_22']; ?>");
    return false;
} else {
    // Parse the input value
    var totalChecksValue = parseInt($("#totalChecks").val());

    // Check if the value is not more than 24
    if (isNaN(totalChecksValue) || totalChecksValue > 24) {
        // If greater than 24, set the value to 24
        $("#totalChecks").val(24);
		totalChecks =24;
        showAlert($("#totalChecks"), "Value automatically set to 24 for Total Checks");
    }
}
 
		for (var i = 1; i <= totalChecks; i++) {
			var div = document.createElement('div');
			div.classList.add('row', 'form-group');

			['Check Number', 'Bank Name', 'Date', 'Amount'].forEach((label, index) => {
				var inputDiv = document.createElement('div');
				inputDiv.classList.add('col-md-3');

				var input = document.createElement('input');
				input.type = (label === 'Date') ? 'date' : 'text';
				input.name = label.toLowerCase().replace(/\s+/g, '') + i;
				input.placeholder = label;
				input.classList.add('form-control');

				var labelElement = document.createElement('label');
				labelElement.textContent = label;

				if (label === 'Bank Name') {
					input.value = bankName;
				}
				if (label === 'Date') {
					var currentDate = new Date(startDate.getTime() + (i - 1) * ((endDate - startDate) / totalChecks));
					input.value = currentDate.toISOString().split('T')[0];
				}
				if (label === 'Amount') {
					input.value = amountPerCheck;
					input.removeAttribute('disabled'); // Remove the disabled attribute
				}

				inputDiv.appendChild(labelElement);
				inputDiv.appendChild(input);
				div.appendChild(inputDiv);

				if ((index + 1) % 4 === 0) {
					checksAndAmountsDiv.appendChild(div);
					div = document.createElement('div');
					div.classList.add('row', 'form-group');
				}
				
			});

			checksAndAmountsDiv.appendChild(div);
		}
	}

	$(document).ready(function() {
		$('#txtRentedVat').on('input', function() {
			this.value = this.value.replace(/[^0-9.]/g, '');
			var decimalIndex = this.value.indexOf('.');
			if (decimalIndex !== -1) {
			var decimalPart = this.value.substring(decimalIndex + 1);
			if (decimalPart.length > 2) {
				this.value = this.value.substring(0, decimalIndex + 3);
			}
			}
		});
	});
$('.getFinalAmount').change(function () { 
    var txtRentPerMonth = parseFloat($('#txtRentPerMonth').val()) || 0;
    var vatPercentage = ($('#flexRadioDefault1').is(':checked')) ? 5 : 0;
    var parkingAmount = parseFloat($('#txtParkingAmount').val()) || 0;
    var otherCost = parseFloat($('#txtOtherCost').val()) || 0;
    var discountAmount = parseFloat($('#txtDiscount').val()) || 0;
    var months = parseFloat($('#months').val()) || 0;

    var totalAmount = txtRentPerMonth;
	var vat_amount = (totalAmount * vatPercentage / 100);
    var totalAmountAfterVAT = totalAmount + (totalAmount * vatPercentage / 100);
    var finalAmount = (totalAmountAfterVAT - discountAmount) + (parkingAmount * months) + otherCost;

    $('#finalAmountD').val(finalAmount.toFixed(1));
    $('#finalAmount').val(finalAmount.toFixed(1));
    $('.final_Amount').html(finalAmount.toFixed(1) +"&nbsp" + "AED" );
    $('.other_cost').html(otherCost.toFixed(1) +"&nbsp" + "AED" );
    $('.vat_show').html(vat_amount.toFixed(1) +"&nbsp" + "AED" );
	$('.totalAmountShow').html(txtRentPerMonth + "&nbsp" + "AED");
	$('.vatShow').html(totalAmount * vatPercentage / 100 +"&nbsp" +"AED");
	$('.ParkingAmountShow').html(parkingAmount + "*" + months + "=" + parkingAmount * months+ "&nbsp" + "AED");
});
$(function () {
	var txtRentPerMonth = parseFloat($('#txtRentPerMonth').val()) || 0;
    var vatPercentage = ($('#flexRadioDefault1').is(':checked')) ? 5 : 0;
    var parkingAmount = parseFloat($('#txtParkingAmount').val()) || 0;
    var otherCost = parseFloat($('#txtOtherCost').val()) || 0;
    var discountAmount = parseFloat($('#txtDiscount').val()) || 0;
    var months = parseFloat($('#months').val()) || 0;

    var totalAmount = txtRentPerMonth;
    var totalAmountAfterVAT = totalAmount + (totalAmount * vatPercentage / 100);
    var finalAmount = (totalAmountAfterVAT - discountAmount) + (parkingAmount * months) + otherCost;

    $('#finalAmountD').val(finalAmount.toFixed(2));
    $('#finalAmount').val(finalAmount.toFixed(2));
});
$(document).ready(function() {
    const $datepicker1 = $('#datepicker1');
    const $monthsInput = $('#months');
    const $txtRDate2 = $('#txtRDate2');

    function calculateEndDate() {
        const startDate = new Date($datepicker1.val());
        const months = parseInt($monthsInput.val());
         const endDate = new Date(startDate.getFullYear(), startDate.getMonth() + months, 0);
        $txtRDate2.val(formatDate(endDate));
    }

    $datepicker1.on('input', calculateEndDate);
    $monthsInput.on('input', calculateEndDate);

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
});
document.addEventListener("DOMContentLoaded", function() {
    const datepicker1 = document.getElementById('datepicker1');
    const monthsInput = document.getElementById('months');months
    const txtRDate2 = document.getElementById('txtRDate2');

    function calculateEndDate() {
        const startDate = new Date(datepicker1.value);
        const months = parseInt(monthsInput.value);
         const endDate = new Date(startDate.getFullYear(), startDate.getMonth() + months , 0);
        txtRDate2.value = formatDate(endDate);
    }

    datepicker1.addEventListener('input', calculateEndDate);
    monthsInput.addEventListener('input', calculateEndDate);

    function formatDate(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
});

</script>

<?php include('../footer.php'); ?>
