<?php
    session_start();
    include("../config.php");
    if (isset($_SESSION['objLogin'])) {
        if(isset($_POST['token']) && $_POST['token'] == 'getfloorinfo'){
			$html = '<option value="">--Select Floor--</option>';
			if(isset($_POST['building']) && (int)$_POST['building'] > 0){
				$unit_no = '';
				$result = mysqli_query($link,"SELECT * from tbl_add_floor where branch_id = '" . (int)$_POST['building'] . "'");
				while($rows = mysqli_fetch_array($result)){
					$html .= '<option value="'.$rows['fid'].'">'.$rows['floor_no'] . '</option>';
				}
				echo $html;
				die();
			}
			echo '';
			die();
		}
    }

?>