<?php
session_start();
include_once('admin/connect.php');

if (isset($_POST['prd_id'])) {

    $prd_id = (int)$_POST['prd_id'];
    $qty = isset($_POST['prd_quantity']) ? (int)$_POST['prd_quantity'] : 1;

    // Lấy sản phẩm từ database
    $sql = "SELECT * FROM tbl_product WHERE prd_id = $prd_id";
    $query = mysqli_query($connect, $sql);

    if (mysqli_num_rows($query) > 0) {

        $product = mysqli_fetch_assoc($query);

        // Nếu chưa có giỏ hàng
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        $found = false;

        // Kiểm tra sản phẩm đã tồn tại chưa
        foreach ($_SESSION['cart'] as &$item) {

            if ($item['prd_id'] == $prd_id) {

                $item['prd_quantity'] += $qty;
                $found = true;
                break;
            }
        }

        // Nếu chưa tồn tại thì thêm mới
        if (!$found) {

            $_SESSION['cart'][] = [
                'prd_id' => $product['prd_id'],
                'prd_name' => $product['prd_name'],
                'prd_price' => $product['prd_price'],
                'prd_image' => $product['prd_image'],
                'prd_quantity' => $qty
            ];
        }

        $_SESSION['cart_message'] = "Đã thêm sản phẩm vào giỏ hàng!";
    }
}

header("Location: index.php?page=cart");
exit();
