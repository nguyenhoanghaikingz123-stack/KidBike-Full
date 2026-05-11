<?php 
session_start();
ob_start();

$action = $_POST['action'];
$prd_id = $_POST['prd_id'];
$quantity = isset($_POST['prd_quantity']) && is_numeric($_POST['prd_quantity']) ? intval($_POST['prd_quantity']) : 1;
if ($quantity < 1) {
    $quantity = 1;
}

//Khoi tao gio hang
if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];


}
switch($action) {
    case "add":
        
        if(!isset($_SESSION['cart'][$prd_id])){
            $_SESSION['cart'][$prd_id] = $quantity;
        }else {
            $_SESSION['cart'][$prd_id] += $quantity;
        };
        break;




}



?>