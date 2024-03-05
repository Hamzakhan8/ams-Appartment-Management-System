<?php
ob_start();
session_start();
include("../config.php");

if(!isset($_SESSION['objLogin'])){
	header("Location: ".WEB_URL."logout.php");
	die();
}

include(ROOT_PATH.'partial/report_top_common.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_fair_info_all.php');
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_common.php');
include(ROOT_PATH.'library/helper.php');
$ams_helper = new ams_helper();
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php echo $building_name; ?></title>
<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
<?php include(ROOT_PATH.'/partial/header_script.php'); ?>
<script type="text/javascript">
function printContent(area,title){
	$("#"+area).printThis({
		 pageTitle: title
	});
}
</script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<section class="content">
<div id="printable">
  <div align="center" style="margin:20px 50px 50px 50px;">
    <input type="hidden" id="web_url" value="<?php echo WEB_URL; ?>" />
    <div class="row">
      <div class="col-xs-12">
	  	<?php include(ROOT_PATH.'partial/report_top_title.php'); ?>
        <div class="box box-success">
		  <div class="box-header">
            <h3 style="text-decoration:underline;font-weight:bold;color:#000" class="box-title"><?php echo $_data['text_1'];?></h3>
          </div>
          <div class="box-body">
            <div style="overflow:auto;">
			<table style="font-size:13px;" class="table sakotable table-bordered table-striped dt-responsive">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Owner Name</th>
                  <th>Building Name</th>
                  <th>Bank Amounts</th>
                  <th>Cash Amounts</th>
                  <th>Total Paid</th>
				          <th>Total Balance</th>
                  <th>Total Amount</th>
                </tr>
              </thead>
              <tbody>
                <?php
				
        $query = "SELECT ar.r_name as r_name,ar.final_amount, o.o_name,tb.branch_name
        FROM tbl_add_rent ar 
        LEFT JOIN tbl_add_owner o ON o.ownid = ar.ownid";
        $query .= " INNER JOIN tblbranch tb ON tb.branch_id = ar.r_building";
        $query .= "INNER JOIN tbl_emi_payment emi ar.rid = emi.rid";
        
        // SELECT o.ownid, r.final_amount, o.o_name AS owner_name, b.branch_name AS building_name, COALESCE(SUM(f.amount), 0) AS bank_payments, COALESCE(SUM(p.amount), 0) AS cash_payments FROM tbl_add_rent r LEFT JOIN tblbranch b ON r.r_building = b.branch_id LEFT JOIN tbl_add_owner o ON r.ownid = o.ownid LEFT JOIN tbl_emi_payment e ON r.rid = e.rid LEFT JOIN tbl_full_payments f ON e.id = f.ep_id LEFT JOIN tbl_particle_payments p ON e.id = p.ep_id GROUP BY o.o_name, b.branch_name
        
        // Uncomment and add conditions as needed
        // $query .= " INNER JOIN tbl_add_floor fl ON fl.fid = ar.r_floor_no";
        // $query .= " INNER JOIN tbl_add_unit u ON u.uid = ar.r_unit_no";
        // $query .= " WHERE ar.r_building = '" . (int)$_SESSION['objLogin']['branch_id'] . "'";
        // if(!empty($_GET['fid'])){
        //     $query .= " AND ar.r_floor_no='".$_GET['fid']."'";
        // }
        // if(!empty($_GET['uid'])){
        //     $query .= " AND ar.r_unit_no='".$_GET['uid']."'";
        // }
        // if(!empty($_GET['mid'])){
        //     $query .= " AND f.month_id='".$_GET['mid']."'";
        // }
        // if(!empty($_GET['yid'])){
        //     $query .= " AND f.xyear='".$_GET['yid']."'";
        // }
        // if($_GET['ps'] != ''){
        //     $query .= " AND f.bill_status='".$_GET['ps']."'";
        // }

        $result = mysqli_query($link, $query);
        if (!$result) {
            die('Error: ' . mysqli_error($link));
        }
				while($row = mysqli_fetch_array($result)){
          var_dump($row);
          // $rent_per_month_sub_total +=(float)$row['rent'];
				// $gas_per_month_sub_total +=(float)$row['gas_bill'];
				// $electric_per_month_sub_total +=(float)$row['electric_bill'];
				// $water_per_month_sub_total +=(float)$row['water_bill'];
				// $security_per_month_sub_total +=(float)$row['security_bill'];
				// $utility_per_month_sub_total +=(float)$row['utility_bill'];
				// $other_per_month_sub_total +=(float)$row['other_bill'];
				// $total_per_month_sub_total +=(float)$row['total_rent'];
				?>
                <tr>
                    <td>
                      <!-- <?php echo $row['issue_date']; ?> -->
                    </td>
                    <td><?php echo $row['o_name'];?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['branch_name']; ?></td>
                    <td><?php echo $row['final_amount']; ?></td>
                    
                </tr>
                <?php } mysqli_close($link);$link = NULL; ?>
              </tbody>
              <tfoot>
                <tr>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
				  <th>&nbsp;</th>
                  <!-- <th style="color:red;"><?php echo $ams_helper->currency($localization, $rent_per_month_sub_total); ?></th> -->
				  <!-- <th style="color:red;"><?php echo $ams_helper->currency($localization, $gas_per_month_sub_total); ?></th>
				  <th style="color:red;"><?php echo $ams_helper->currency($localization, $electric_per_month_sub_total); ?></th>
				  <th style="color:red;"><?php echo $ams_helper->currency($localization, $water_per_month_sub_total); ?></th>
				  <th style="color:red;"><?php echo $ams_helper->currency($localization, $security_per_month_sub_total); ?></th>
				  <th style="color:red;"><?php echo $ams_helper->currency($localization, $utility_per_month_sub_total); ?></th>
				  <th style="color:red;"><?php echo $ams_helper->currency($localization, $other_per_month_sub_total); ?></th>
				  <th style="color:red;"><?php echo $ams_helper->currency($localization, $total_per_month_sub_total); ?></th> -->
                </tr>
              </tfoot>
            </table>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div align="center" style="position:fixed;top:0;right:0;margin:10px;"><a title="<?php echo $_data['text_16'];?>" class="btn btn-success btn_save" onClick="javascript:printContent('printable','Fair Collection Report');" href="javascript:void(0);"><i class="fa fa-print"></i> </a></div>
</body>
</html>
