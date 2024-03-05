<?php
session_start();
include("../config.php");
if (isset($_SESSION['objLogin']) && isset($_POST['token'], $_POST['data'])) {
    $jsonData = $_POST['data'];
    $formData = json_decode($jsonData, true);
    if ($formData !== null) {
        $paymentBy = $formData['paymentBy'];
        $paymentStatus = $formData['paymentStatus'];
        $paidAmount = $formData['paidAmount'];
        $number = $formData['number'];
        $id = $formData['id'];
        $sql = "UPDATE `tbl_emi_payment` SET `payment_by` = '$paymentBy', `status` = '$paymentStatus' WHERE `id` = '$id'";
        $result = mysqli_query($link, $sql);
        if ($result) {
            $paymentTable = ($paymentStatus == 1) ? "tbl_full_payments" : "tbl_particle_payments";
            $sqlx = "INSERT INTO `$paymentTable` (`ep_id`, `amount`, `date`) VALUES ('$id', '$paidAmount', NOW())";
            $resultx = mysqli_query($link, $sqlx);
            if ($resultx) {
                echo json_encode(array("success" => true, "message" => "Data updated and inserted successfully"));
            } else {
                echo json_encode(array("success" => false, "message" => "Failed to insert payment data"));
            }
        } else {
            echo json_encode(array("success" => false, "message" => "Failed to update rental data"));
        }
    } else {
        echo json_encode(array("success" => false, "message" => "Failed to decode JSON data"));
    }
} else {
    echo json_encode(array("success" => false, "message" => "Invalid token or data or user not logged in"));
}
?>
