<?php
session_start();
include_once('admin/connect.php');

// Lấy dữ liệu từ form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $prd_id = intval($_POST['prd_id']);
    $prd_quantity = intval($_POST['prd_quantity']);

    // Lấy thông tin sản phẩm từ database
    $query = "SELECT * FROM tbl_product WHERE prd_id = $prd_id";
    $result = mysqli_query($connect, $query);

    if ($product = mysqli_fetch_array($result)) {
        // Khởi tạo giỏ hàng trong session nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $product_exists = false;
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['prd_id'] == $prd_id) {
                $item['prd_quantity'] += $prd_quantity;
                $product_exists = true;
                break;
            }
        }

        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
        if (!$product_exists) {
            $_SESSION['cart'][] = array(
                'prd_id' => $product['prd_id'],
                'prd_name' => $product['prd_name'],
                'prd_price' => $product['prd_price'],
                'prd_image' => $product['prd_image'],
                'prd_quantity' => $prd_quantity
            );
        }

        // Chuyển hướng đến trang giỏ hàng
        header('Location: index.php?page=cart');
        exit();
    } else {
        // Nếu không tìm thấy sản phẩm, quay lại trang chủ
        header('Location: index.php');
        exit();
    }
} else {
    // Nếu không phải POST request, quay lại trang chủ
    header('Location: index.php');
    exit();
}
