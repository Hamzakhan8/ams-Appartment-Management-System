<?php
include('../header.php');
include(ROOT_PATH . 'language/' . $lang_code_global . '/lang_branch_list.php');
if (!isset($_SESSION['objLogin']) || (int)$_SESSION['login_type'] !== 5) {
    header("Location: " . WEB_URL . "logout.php");
    die();
}
if (isset($_GET['id']) && $_GET['id'] != '' && $_GET['id'] > 0) {
    if (branchCount($link)) {
        $sqlx = "DELETE FROM `tblbranch` WHERE branch_id = " . $_GET['id'];
        if(mysqli_query($link, $sqlx)) {
            $delinfo = 'block';
        } else {
            echo "Error: " . mysqli_error($link);
        }
    }
}
if (isset($_GET['m'])) {
    if ($_GET['m'] == 'add') {
        $addinfo = 'block';
        $msg = $_data['text_11'];
    } elseif ($_GET['m'] == 'up') {
        $addinfo = 'block';
        $msg = $_data['text_12'];
    }
}
function branchCount($link)
{
    $sql = mysqli_query($link, "SELECT COUNT(*) AS total_rows FROM tblbranch");
    if ($row = mysqli_fetch_assoc($sql)) {
        return $row['total_rows'] > 1;
    }
    return false;
}
?>

<section class="content">
<section class="content-header">
    <h1><?php echo $_data['text_14']; ?></h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo WEB_URL; ?>/dashboard.php"><i class="fa fa-dashboard"></i> <?php echo $_data['text_19']; ?></a></li>
        <li class="active"><?php echo $_data['text_20']; ?></li>
        <li class="active"><?php echo $_data['text_14']; ?></li>
    </ol>
</section>
    <div class="row">
        <div class="col-xs-12">
            <!-- <div class="alert alert-danger alert-dismissable" style="display:<?php echo $delinfo; ?>"></div>
            <div class="alert alert-success alert-dismissable" style="display:<?php echo $addinfo; ?>"></div> -->
            <div align="right" style="margin-bottom:1%;">
                <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>branch/addbranch.php" data-original-title="<?php echo $_data['text_1']; ?>"><i class="fa fa-plus"></i></a>
                <!-- <a class="btn btn-success" data-toggle="tooltip" href="<?php echo WEB_URL; ?>dashboard.php" data-original-title="<?php echo $_data['text_17']; ?>"><i class="fa fa-dashboard"></i></a> -->
            </div>
            <div class="box box-white box-size">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $_data['text_14']; ?></h3>
                </div>
                <div class="box-body">
                    <table class="table sakotable table-bordered table-striped dt-responsive">
                        <thead>
                            <tr>
                                <th><?php echo $_data['text_4']; ?></th>
                                <th>Owner Name</th>
                                <th><?php echo $_data['text_7']; ?></th>
                                <th><?php echo $_data['text_233']; ?></th>
                                <th><?php echo $_data['action_text']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $result = mysqli_query($link, "SELECT b.*, owner.* FROM tblbranch AS b LEFT JOIN tbl_add_owner AS owner ON b.building_make_year = owner.ownid ORDER BY b.branch_id DESC");
                              while ($row = mysqli_fetch_array($result)) {
                                $image = $row['building_image'] ? (file_exists(ROOT_PATH . '/img/upload/' . $row['building_image']) ? WEB_URL . 'img/upload/' . $row['building_image'] : $image) : $image;
                            ?>
                                <tr>
                                    <td><?php echo $row['branch_name']; ?></td>
                                    <td><?php echo $row['o_name']; ?></td>
                                    <td><?php echo $row['b_address']; ?></td>
                                    <td><?php echo $row['b_status'] ? '<span class="label label-success"><i class="fa fa-check"></i></span>' : '<span class="label label-danger"><i class="fa fa-times"></i></span>'; ?></td>
                                    <td>
                                        <a class="btn btn-success ams_btn_special" data-toggle="tooltip" href="javascript:;" onclick="$('#employee_view_<?php echo $row['branch_id']; ?>').modal('show');" data-original-title="<?php echo $_data['view_text']; ?>"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-warning ams_btn_special" data-toggle="tooltip" href="<?php echo WEB_URL; ?>branch/addbranch.php?id=<?php echo $row['branch_id']; ?>" data-original-title="<?php echo $_data['edit_text']; ?>"><i class="fa fa-pencil"></i></a>
                                        <a class="btn btn-danger ams_btn_special" data-toggle="tooltip" onclick="deleteBranch(<?php echo $row['branch_id']; ?>);" href="javascript:;" data-original-title="<?php echo $_data['delete_text']; ?>"><i class="fa fa-trash-o"></i></a>
                                        <div id="employee_view_<?php echo $row['branch_id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function deleteBranch(Id) {
        var iAnswer = confirm("Are you sure you want to delete this branch ?");
        if (iAnswer) {
            window.location = 'branchlist.php?id=' + Id;
        }
    }
</script>
<?php include('../footer.php'); ?>
