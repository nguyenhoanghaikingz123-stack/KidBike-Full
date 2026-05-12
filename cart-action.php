<?php
/**
 * File xử lý các action của giỏ hàng
 * - Cập nhật số lượng sản phẩm
 * - Xóa sản phẩm
 * - Xóa toàn bộ giỏ hàng
 */

// Khởi động session
session_start();

// Include file kết nối database
include_once('admin/connect.php');

// Xử lý các action khác nhau
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

switch ($action) {
    case 'update':
        // Cập nhật số lượng sản phẩm (POST request)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            // Kiểm tra nếu giỏ hàng tồn tại
            if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                
                // Lấy dữ liệu từ form
                $product_ids = isset($_POST['product_id']) ? $_POST['product_id'] : array();
                $quantities = isset($_POST['quantity']) ? $_POST['quantity'] : array();
                
                // Mảng mới để lưu giỏ hàng sau khi cập nhật
                $updated_cart = array();
                
                // Duyệt qua từng sản phẩm trong giỏ hàng hiện tại
                foreach ($_SESSION['cart'] as $item) {
                    $prd_id = $item['prd_id'];
                    
                    // Kiểm tra xem sản phẩm này có trong dữ liệu POST không
                    if (isset($product_ids[$prd_id]) && isset($quantities[$prd_id])) {
                        
                        // Lấy số lượng mới từ form
                        $new_quantity = intval($quantities[$prd_id]);
                        
                        // Chỉ giữ sản phẩm nếu số lượng > 0
                        if ($new_quantity > 0) {
                            // Cập nhật số lượng mới
                            $item['prd_quantity'] = $new_quantity;
                            $updated_cart[] = $item;
                        }
                        // Nếu số lượng <= 0 thì không thêm vào mảng mới (tức là xóa)
                    } else {
                        // Nếu không có dữ liệu cho sản phẩm này, giữ nguyên
                        $updated_cart[] = $item;
                    }
                }
                
                // Cập nhật lại giỏ hàng trong session
                $_SESSION['cart'] = $updated_cart;
                
                // Thông báo thành công
                $_SESSION['cart_message'] = "Giỏ hàng đã được cập nhật thành công!";
                
            } else {
                $_SESSION['cart_message'] = "Giỏ hàng của bạn đang trống!";
            }
        }
        break;
        
    case 'remove':
        // Xóa một sản phẩm (GET request)
        $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
        
        if ($product_id > 0 && isset($_SESSION['cart'])) {
            // Lọc sản phẩm cần xóa
            $_SESSION['cart'] = array_filter($_SESSION['cart'], function($item) use ($product_id) {
                return $item['prd_id'] != $product_id;
            });
            
            // Re-index array
            $_SESSION['cart'] = array_values($_SESSION['cart']);
            
            $_SESSION['cart_message'] = "Sản phẩm đã được xóa khỏi giỏ hàng!";
        }
        break;
        
    case 'clear':
        // Xóa toàn bộ giỏ hàng (GET request)
        unset($_SESSION['cart']);
        $_SESSION['cart_message'] = "Giỏ hàng đã được xóa toàn bộ!";
        break;
        
    default:
        $_SESSION['cart_message'] = "Hành động không hợp lệ!";
        break;
}

// Chuyển hướng về trang giỏ hàng
header('Location: index.php?page=cart');
exit();
?>
