<?php 
include('../header.php');
if(!isset($_SESSION['objLogin'])){
	header("Location: " . WEB_URL . "logout.php");
	die();
}
?>
<?php
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_fare_list.php');
$delinfo = 'none';
$addinfo = 'none';
$msg = "";
if(isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0){
	$sqlx= "DELETE FROM `tbl_add_fair` WHERE f_id = ".$_GET['id'];
	mysqli_query($link,$sqlx); 
	$delinfo = 'block';
}
if(isset($_GET['m']) && $_GET['m'] == 'add'){
	$addinfo = 'block';
	$msg = $_data['added_rent_successfully'];
}
if(isset($_GET['m']) && $_GET['m'] == 'up'){
	$addinfo = 'block';
	$msg = $_data['update_rent_successfully'] ;
}
?>
<section class="content-header">
  <h1><?php echo $_data['pdc_list'];?></h1>
  <ol class="breadcrumb">
    <li>
      <a href="<?php echo WEB_URL?>dashboard.php">
        <i class="fa fa-dashboard"></i>
        <?php echo $_data['home_breadcam'];?>
      </a>
    </li>
    <li class="active">
      <?php echo $_data['add_new_rent_information_breadcam'];?>
    </li>
    <li class="active">
      <?php echo $_data['pdc_list'];?>
    </li>
  </ol>
</section>
<section class="content">
<div class="row">
  <div class="col-xs-12">
    <div id="me" class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-ban"></i><?php echo $_data['delete_text'];?> !</h4>
      <?php echo $_data['delete_rent_information'];?> </div>
    <div id="you" class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>">
      <button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-close"></i></button>
      <h4><i class="icon fa fa-check"></i><?php echo $_data['success'];?> !</h4>
      <?php echo $msg; ?> </div>
    <!-- <div align="right" style="margin-bottom:1%;"> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>fair/addfair.php" data-original-title="<?php echo $_data['add_new_rent_breadcam'];?>"><i class="fa fa-plus"></i></a> <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['home_breadcam'];?>"><i class="fa fa-dashboard"></i></a> </div> -->
    <div class="box box-success">
      <div class="box-header">
        <h3 class="box-title"><?php echo $_data['pdc_list'];?></h3>
      </div>
      <div class="box-body">
        <table class="table sakotable table-bordered table-striped dt-responsive">
          <thead>
            <tr>
              <th><?php echo $_data['invoice_no'];?></th>
              <th><?php echo $_data['add_new_form_field_text_6'];?></th>
              <th><?php echo $_data['add_new_form_field_text_16'];?></th>
              <th><?php echo $_data['add_new_form_field_text_1'];?></th>
              <th><?php echo $_data['add_new_form_field_text_3'];?></th>
              <th><?php echo $_data['add_new_form_field_text_17'];?></th>
              <th><?php echo $_data['add_new_form_field_text_18'];?></th>
              <th><?php echo $_data['add_new_form_field_text_77'];?></th>
              <th><?php echo $_data['add_new_form_field_text_01'];?></th>
              <th><?php echo $_data['add_new_form_field_text_14'];?></th>
              <th><?php echo $_data['action_text'];?></th>
            </tr>
          </thead>
          <tbody>
            <?php
              $result = mysqli_query($link, "SELECT 
              ar.rid,ar.amount ,ar.r_name,ao.o_name,tb.branch_name,fl.floor_no,u.unit_no
              FROM tbl_add_rent AS ar 
              LEFT JOIN tbl_add_unit u ON ar.r_unit_no = u.uid 
              LEFT JOIN tbl_add_floor fl ON u.floor_no = fl.fid 
              LEFT JOIN tblbranch tb ON fl.branch_id = tb.branch_id 
              LEFT JOIN tbl_add_owner ao ON ar.ownid = ao.ownid 
              ORDER BY ar.rid DESC");

              if (!$result) {
                die('Error: ' . mysqli_error($link));
              }
              while($row = mysqli_fetch_array($result)){
            ?>
            <tr>
            <td> # </td>
            <!-- <td> <?php echo $row['rid']; ?> </td> -->
            <td><?php echo $row['r_name']; ?></td>
            <td><?php echo $row['o_name']; ?></td>
            <td><?php echo $row['branch_name']; ?></td>
            <td><?php echo $row['floor_no']; ?></td>
            <td><?php echo $row['unit_no']; ?></td>
            <td>
            <?php 
                $emi_Amount = 0;
                $res = mysqli_query($link, "SELECT * FROM `tbl_emi_payment` AS emi WHERE rid =" . $row['rid']);
                $payments = mysqli_fetch_all($res, MYSQLI_ASSOC);
                foreach ($payments as $payment) {
                    $emi_Amount = 0;
                    if ($payment['status'] == 1) {
                        $query = "SELECT amount FROM `tbl_full_payments` WHERE ep_id = " . $payment['id'];
                    } else {
                        $query = "SELECT amount FROM `tbl_particle_payments` WHERE ep_id = " . $payment['id'];
                    } 
                    $resxx = mysqli_query($link, $query);
                    if ($resxx) {
                        while ($amountResult = mysqli_fetch_array($resxx)) {
                            $emi_Amount += $amountResult['amount'];
                        }
                    }
                    if (number_format($emi_Amount) !=  number_format($payment['amount'])) {
                        echo "<b class=''>".number_format($payment['amount']) ." ". (($payment['status'] == 0) ? "Due"  : (($payment['status'] == 2)? "Partial":"unknown")) ."</b>"; 
                        echo '<br>';
                    }
                }
              ?>

            </td>
            <td>
            <?php 
                $resxx = mysqli_query($link, "SELECT id, `status` FROM tbl_emi_payment 
                WHERE rid = " . $row['rid'] . " 
                AND MONTH(date) = MONTH(CURDATE())");
                $emiAmount = 0;
                if ($resxx) {
                    while ($pay = mysqli_fetch_array($resxx)) {
                        $query = '';
                        if ($pay['status'] == 1) {
                            $query = "SELECT amount FROM `tbl_full_payments` WHERE ep_id = " . $pay['id'];
                        } else {
                            $query = "SELECT amount FROM `tbl_particle_payments` WHERE ep_id = " . $pay['id'];
                        } 
                        $resx = mysqli_query($link, $query);
                
                        if ($resx) {
                            while ($amountResult = mysqli_fetch_array($resx)) {
                                $emiAmount += $amountResult['amount'];
                            }
                        }
                    }
                }

                echo number_format($emiAmount);
              ?>

            </td>
            <td>
              <?php   echo number_format($row['amount'] - $emiAmount) ;?>
            </td>
            <td><?php echo number_format($row['amount']); ?></td>
            <td>
              <a class="btn< ams_btn_special" data-toggle="tooltip" href="javascript:;" onClick="$('#nurse<?php echo $row['rid']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>">
                <i class="fa fa-eye"></i>
              </a> 
              <?php
                if ($emiAmount !=  $payment['amount']) {?>
                  <a class="btn< ams_btn_special"  data-toggle="tooltip" id="pencil_i" href="javascript:;" onClick="$('#nurse_view_<?php echo $row['rid']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text'];?>">
                    <i class="fa fa-edit"></i>
                  </a> 
               <?php }
              ?>
            <div id="nurse<?php echo $row['rid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header green_header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                    <h3 class="modal-title"><?php echo $_data['fare_details'];?></h3>
                  </div>
                  <div class="modal-body model_view" align="center">&nbsp;
                    <div class="model_title"><?php echo $row['r_name']; ?></div>
                  </div>
				          <div class="modal-body">
                    <h3 style="text-decoration:underline;text-align:left"><?php echo $_data['details_information'];?></h3><br/>
                    <div class="row">
                      <div class="col-xs-6"> 
                        <b><?php echo $_data['add_new_form_field_text_6'];?> :</b> <?php echo $row['r_name']; ?><br/>
                        <b><?php echo $_data['add_new_form_field_text_16'];?> :</b> <?php echo $row['o_name']; ?><br/>
                        <b><?php echo $_data['add_new_form_field_text_1'];?> :</b> <?php echo $row['branch_name']; ?><br/>
                        <b><?php echo $_data['add_new_form_field_text_3'];?> :</b> <?php echo $row['floor_no'];?><br/>
						            <b><?php echo $_data['add_new_form_field_text_17'];?> :</b> <?php echo $row['unit_no'];?><br/>
                        <b><?php echo $_data['add_new_form_field_text_18'];?> : </b> 
                  
                        </div>
                        <div class="col-xs-6">
                        <?php
                          $amountData = 0;
                          $getAmount = mysqli_query($link, "SELECT amount ,id ,`status`,check_status
                                      FROM tbl_emi_payment 
                                      WHERE rid = ". $row['rid']); 
                          $newData = mysqli_fetch_array($getAmount);
                          if ($newData['status'] == 2) {
                              $getParticlePayment = mysqli_query($link, "SELECT amount ,`invoice_no`
                                                      FROM tbl_particle_payments 
                                                      WHERE ep_id = ". $newData['id']); 
                              $getDataParticlePayment = mysqli_fetch_all($getParticlePayment, MYSQLI_ASSOC);
                              foreach ($getDataParticlePayment as $payment) {
                                  $invoice_no = $payment['invoice_no'];
                                  $amountData += $payment['amount'];
                              }
                          }
                        ?>
						            <b><?php echo $_data['add_new_form_field_text_20'];?> :</b> <span id="paidAmont"></span><br/>
						            <b><?php echo $_data['add_new_form_field_text_21'];?> :</b> <span id="blneAmont"></span><br/>
                        <? if ($newData['status'] == 2) { ?>
                          <b>Paid Amount:</b> <?php echo $getDataParticlePayment['amount'] ?? 'No data found'; ?><br/>
                          <b>Remaining Amount:</b> <?php echo $newData['amount'] - $amountData  ?? 'No data found'; ?><br/>
                        <? } ?>
                          <b><?php echo $_data['add_new_form_field_text_22'];?> :</b> <?php echo $newData['amount'] ?? 'No data found'; ?><br/>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="nurse_view_<?php echo $row['rid']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header green_header">
                    <button aria-label="Close" data-dismiss="modal" class="close" type="button"><span aria-hidden="true"><i class="fa fa-close"></i></span></button>
                    <h3 class="modal-title"><?php echo $_data['fare_details'];?></h3>
                  </div>
				          <div class="modal-body">
                    <h3 style="text-decoration:underline;text-align:left"><?php echo $_data['details_information'];?></h3><br/>
                    <div class="row">
                     <div class="col-xs-12">
                      <form action="#" method="post" id="saveData">
                          <div class="mb-12">
                          <input type="hidden" class="form-control  " id="id" value="<?php echo $newData['id']; ?>" />
                            <label for="paymentBy" class="form-label"><?php echo $_data['add_new_form_field_text_25']; ?></label><br>
                            <select class="form-control" name="paymentBy" id="paymentBy">
                                <option value="" disabled selected><?php echo $_data['add_new_form_field_text_25']; ?></option>
                                <option value="2" <?php echo ($newData['check_status'] == 2) ? "selected" : ""; ?>><?php echo $_data['add_new_form_field_text_23']; ?></option>
                                <option value="1" <?php echo ($newData['check_status'] == 1) ? "selected" : ""; ?>><?php echo $_data['add_new_form_field_text_24']; ?></option>
                            </select>
                            <div id="paymentByError" style="color: red;"></div>
                          </div>
                          <div class="mb-12">
                            <label for="paymentStatus" class="form-label"><?php echo $_data['status_field_text_20']; ?></label><br>
                            <select class="form-control" name="paymentStatus" id="paymentStatus">
                              <option value="default" disabled selected><?php echo $_data['status_field_text_21']; ?></option>
                              <option value="2" <?php echo ($newData['status'] == 2) ? "selected" : ""; ?>>Partial</option>
                              <option value="1" <?php echo ($newData['status'] == 1) ? "selected" : ""; ?>><?php echo $_data['status_field_text_19']; ?></option>
                            </select>
                            <div id="paymentStatusError" style="color: red;"></div>
                          </div>
                          <div>
                            <?php
                              if ($newData) {
                                if ($newData['status'] == 2) {
                                $amount = $newData['amount'] - $amountData;
                                }else {
                                  $amount = $newData['amount'];
                                }
                              }
                            ?>
                            <input type="hidden" class="form-control" id="newDataAmount" value="<?php echo $amount ; ?>" />
                            <label for="paidAmountField" class="form-label">Amount</label><br>
                            <input type="text" name="paidAmount" id="paidAmountField" class="form-control" oninput="setData()">
                            <div id="paidAmountError" style="color: red;"></div>
                          </div>
                          <div>
                            <label for="number" class="form-label"><?php echo $_data['status_field_text_24']; ?></label><br>
                            <input type="text" name="number" id="number" class="form-control">
                            <div id="numberError" style="color: red;"></div>
                          </div>
                          <div style="margin-top:2em;">
                            <button type="button" class="btn btn-primary" onclick="validateForm()">Submit</button>
                          </div>
                      </form>
                  
                     </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </td>
            </tr>
            <?php } mysqli_close($link);$link = NULL; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
function deleteFair(Id){
  	var iAnswer = confirm("<?php echo $_data['confirm']; ?>");
	if(iAnswer){
		window.location = '<?php echo WEB_URL; ?>fair/fairlist.php?id=' + Id;
	}
  }
  
  $( document ).ready(function() {
	setTimeout(function() {
		  $("#me").hide(300);
		  $("#you").hide(300);
	}, 3000);
});
function setData() {
  // debugger;
  let newDataAmount = parseFloat(document.getElementById("newDataAmount").value);
  let paidAmount = parseFloat(document.getElementById("paidAmountField").value);
  let data = newDataAmount - paidAmount;
  console.log(newDataAmount+  ",,"  +paidAmount);
  if (newDataAmount < paidAmount) {
    document.getElementById("paidAmountField").value = newDataAmount;
    data = newDataAmount - newDataAmount;
    document.getElementById("paidAmont").innerHTML = newDataAmount;
    document.getElementById("blneAmont").innerHTML = data;
  } else {
    document.getElementById("newDataAmount").disabled = true;
    

     // Disable the input field if newDataAmount is less than or equal to paidAmount
    document.getElementById("paidAmont").innerHTML = paidAmount;
    document.getElementById("blneAmont").innerHTML = data;
  }
}
function serializeForm(form) {
    var formData = {};
    for (var i = 0; i < form.elements.length; i++) {
      var field = form.elements[i];
      if (field.name && !field.disabled && field.type !== 'file' && field.type !== 'reset' && field.type !== 'submit') {
        if (field.type === 'select-multiple') {
          formData[field.name] = [];
          for (var j = 0; j < field.options.length; j++) {
            if (field.options[j].selected) {
              formData[field.name].push(field.options[j].value);
            }
          }
        } else if ((field.type !== 'checkbox' && field.type !== 'radio') || field.checked) {
          formData[field.name] = field.value;
        }
      }
    }
    return formData;
  }




  function validateForm() {
    var form = document.getElementById('saveData');
    var paymentBy = form.elements['paymentBy'].value;
    var paymentStatus = form.elements['paymentStatus'].value;
    var paidAmount = form.elements['paidAmount'].value;
    var number = form.elements['number'].value;
    var id = document.getElementById('id').value;
    var isValid = true;
    
    if (paymentBy === '') {
        document.getElementById('paymentByError').innerText = 'Please select payment method.';
        isValid = false;
    } else {
        document.getElementById('paymentByError').innerText = '';
    }

    if (paymentStatus === '') {
        document.getElementById('paymentStatusError').innerText = 'Please select payment status.';
        isValid = false;
    } else {
        document.getElementById('paymentStatusError').innerText = '';
    }

    if (isValid) {
        var serializedData = {
            paymentBy: paymentBy,
            paymentStatus: paymentStatus,
            paidAmount: paidAmount,
            number: number,
            id: id
        };

        $.ajax({
            url: '../ajax/addPayment.php',
            type: 'POST',
            data: { data: JSON.stringify(serializedData), token: 'setDataForPayment' },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                if (data.success) {
                    var doneMessage = document.createElement('div');
                    doneMessage.innerText = 'Done!';
                    doneMessage.style.color = 'green';
                    form.appendChild(doneMessage);
                } else {
                    // Show error message on the form
                    var errorMessage = document.createElement('div');
                    errorMessage.innerText = data.message;
                    errorMessage.style.color = 'red';
                    form.appendChild(errorMessage);
                }
            }
        });
    }
}

</script>
<?php include('../footer.php'); ?>