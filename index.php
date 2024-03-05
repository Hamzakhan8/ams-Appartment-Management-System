<?php
ob_start();
session_start();
define('DIR_APPLICATION', str_replace('\'', '/', realpath(dirname(__FILE__))) . '/');
if(!file_exists("config.php")){
	header("Location: install/index.php");
	die();
}
unset($_SESSION['step']);
unset($_SESSION['domain']);
include(DIR_APPLICATION."config.php");
include(DIR_APPLICATION."library/maxPower.php");
include(DIR_APPLICATION."library/encryption.php");
include(DIR_APPLICATION."library/helper.php");
$converter = new Encryption;
$helper = new ams_helper;
$helper->removeInstallFolder(ROOT_PATH.'install');

//redirect if session already exist
if(isset($_SESSION['objLogin']) && !empty($_SESSION['objLogin'])){
	if($_SESSION['login_type'] == '1' || $_SESSION['login_type'] == '5'){
		header("Location: dashboard.php");
		die();
	}
	else if($_SESSION['login_type'] == '2'){
		header("Location: o_dashboard.php");
		die();
	}
	else if($_SESSION['login_type'] == '3'){
		header("Location: e_dashboard.php");
		die();
	}
	else if($_SESSION['login_type'] == '4'){
		header("Location: t_dashboard.php");
		die();
	}
}
/*****************************************************************************/
/////////////variables/////////////////////////////////////////////////////////
$msg = false;
$sql = '';
$cookie_name = "ams_lang_code";
//////////////////////////////////////////////////////////////////////////////

if(isset($_POST['username']) && $_POST['username'] != '' && isset($_POST['password']) && $_POST['password'] != ''){
	$user_name = trim(make_safe($link, $_POST['username'])); //Escaping Strings
	$password = $converter->encode(trim(make_safe($link, $_POST['password']))); //Escaping Strings
	//admin
	if($_POST['ddlLoginType'] == '1'){
		$sql = mysqli_query($link,"SELECT *,b.* FROM tbl_add_admin aa left join tblbranch b on b.branch_id = aa.branch_id WHERE aa.email = '".$user_name."' and aa.password = '".$password."'");
	}
	//owner
	if($_POST['ddlLoginType'] == '2'){
		$sql = mysqli_query($link, "SELECT *,b.* FROM tbl_add_owner o left join tblbranch b on b.branch_id = o.branch_id WHERE o.o_email = '".$user_name."' and o.o_password = '".$password."'");
	}
	//employee
	if($_POST['ddlLoginType'] == '3'){
		$sql = mysqli_query($link, "SELECT *,b.* FROM tbl_add_employee e left join tblbranch b on b.branch_id = e.branch_id WHERE e.e_email = '".$user_name."' and e.e_password = '".$password."'");
	}
	//renter
	if($_POST['ddlLoginType'] == '4'){
		$sql = mysqli_query($link, "SELECT *,b.* FROM tbl_add_rent ad left join tblbranch b on b.branch_id = ad.branch_id WHERE ad.r_email = '".$user_name."' and ad.r_password = '".$password."'");
	}
	//super admin
	if($_POST['ddlLoginType'] == '5'){
		$sql = mysqli_query($link, "SELECT * FROM tblsuper_admin WHERE email = '".$user_name."' and password = '".$password."'");
	}
	if(!empty($sql)){
		if($row = mysqli_fetch_assoc($sql)){
			if($_POST['ddlLoginType'] == '5'){
				$branch_list = getBuildingDetails($_POST['ddlBranch'], $link);
				$arr = array(
					'user_id'				=> $row['user_id'],
					'name'					=> $row['name'],
					'email'					=> $row['email'],
					'contact'				=> $row['contact'],
					'password'				=> $_POST['password'],
					'added_date'			=> $row['added_date']
				);
				$arr = array_merge($arr, $branch_list);
				$_SESSION['objLogin'] = $arr;
			}
			else{
				$_SESSION['objLogin'] = $row;
			}
			
			mysqli_close($link);
			$link = NULL;
			
			$_SESSION['login_type'] = $_POST['ddlLoginType'];
			if($_POST['ddlLoginType'] == '1' || $_POST['ddlLoginType'] == '5'){
				header("Location: dashboard.php");
				die();
			}
			else if($_POST['ddlLoginType'] == '2'){
				header("Location: o_dashboard.php");
				die();
			}
			else if($_POST['ddlLoginType'] == '3'){
				header("Location: e_dashboard.php");
				die();
			}
			else if($_POST['ddlLoginType'] == '4'){
				header("Location: t_dashboard.php");
				die();
			}	
		} else {
			$msg = true;
		}
	}
	else{
		$msg = true;
	}
}
//
function getBuildingDetails($bid, $link){
	$sql = mysqli_query($link, "SELECT * from tblbranch WHERE branch_id = ".(int)$bid);
	if($row = mysqli_fetch_assoc($sql)){
		return $row;
	}
	return array();
}
function make_safe($con, $variable){
	$variable = mysqli_real_escape_string($con, strip_tags(trim($variable)));
	return $variable; 
}
$query_ams_settings = mysqli_query($link,"SELECT * FROM tbl_settings");
if($row_query_ams_core = mysqli_fetch_array($query_ams_settings)){
	$lang_code_global = $row_query_ams_core['lang_code'];
	$global_currency = $row_query_ams_core['currency'];
	$currency_position = $row_query_ams_core['currency_position'];
	$currency_sep = $row_query_ams_core['currency_seperator'];
}
$lang_code = "English";
if(isset($_COOKIE[$cookie_name]) && !empty($_COOKIE[$cookie_name])) {
	$lang_code = $_COOKIE[$cookie_name];
	$lang_code_global = $_COOKIE[$cookie_name];
}
include(ROOT_PATH.'language/'.$lang_code_global.'/lang_index.php');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title><?php echo $_data['application_title']; ?></title>
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets2/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets2/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link href="assets/css/custom.css" rel="stylesheet" />
  <!-- Theme style -->
  <link rel="stylesheet" href="assets2/dist/css/adminlte.min.css">
</head>
<!-- BOOTSTRAP SCRIPTS -->
<!-- jQuery -->
<script src="assets2/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets2/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets2/dist/js/adminlte.min.js"></script>

</head>


<body class="hold-transition login-page">

<div class="login-box">

  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
	<div class="row text-center ">
    <div class="col-md-12 p-2"><br/>
      <span style="font-size:20px;font-weight:bold;color:black;"><?php echo $_data['application_heading_2']; ?></span></div>
  </div>
  

      <form onSubmit="return validationForm();" role="form" id="form" method="post">
        <div class="input-group mb-3">
          <input type="email" name="username" id="username" class="form-control" placeholder="<?php echo $_data['your_email']; ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
		<input type="password" name="password" id="password" class="form-control"  placeholder="<?php echo $_data['your_password']; ?>" />

          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <input type="hidden" name="ddlLoginType" value="5">
          <input type="hidden" name="ddlBranch" value="7">
          <input type="hidden" name="ddlLanguage" value="English">
          <!-- /.col -->
          <div class="col-12" align="center">
            <button type="submit" id="login"  class="btn  btn-success"><i class="fa fa-key"  ></i>&nbsp;<?php echo $_data['_login'];?></button>
          </div>
          <!-- /.col -->
        </div>

		<p class="login-box-msg p-2">Sign in to start your session</p>
      </form>
	  
	  <script type="text/javascript">
function validationForm(){
	if($("#username").val() == ''){
		alert("<?php echo $_data['v1'];?>");
		$("#username").focus();
		return false;
	}
	else if($("#password").val() == ''){
		alert("<?php echo $_data['v3'];?>");
		$("#password").focus();
		return false;
	}
	else if($("#ddlLoginType").val() == ''){
		alert("<?php echo $_data['v4'];?>");
		return false;
	}
	else if(!validateEmail($("#username").val())){
		alert("<?php echo $_data['v2'];?>");
		$("#username").focus();
		return false;
	}
	else{
		return true;
	}
}
function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function mewhat(val){
	if(val != ''){
		if(val == '5'){
			$("#x_branch").show();
		}
		else{
			$("#x_branch").hide();
		}
	}
	else{
		$("#x_branch").hide();
	}
}
</script>

<!-- /.login-box -->

<!-- jQuery -->

</body>
</html>
