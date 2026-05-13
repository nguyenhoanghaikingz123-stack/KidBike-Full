<?php
session_start();
include_once(__DIR__ . "/admin/connect.php");

$action = isset($_GET['action']) ? $_GET['action'] : '';
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id <= 0) {
    header('Location: order-history.php');
    exit();
}

switch ($action) {
    case 'cancel':
        cancelOrder($order_id);
        break;
    case 'reorder':
        reorderItems($order_id);
        break;
    default:
        header('Location: order-history.php');
        exit();
}

/**
 * Hủy đơn hàng
 */
function cancelOrder($order_id) {
    global $connect;
    
    // Kiểm tra đơn hàng có tồn tại và có thể hủy không
    $sql = "SELECT * FROM tbl_orders WHERE order_id = $order_id AND order_status = 'pending'";
    $result = mysqli_query($connect, $sql);
    $order = mysqli_fetch_array($result);
    
    if (!$order) {
        $_SESSION['message'] = 'Đơn hàng không tồn tại hoặc không thể hủy!';
        header('Location: order-detail.php?id=' . $order_id);
        exit();
    }
    
    // Cập nhật trạng thái đơn hàng
    $update_sql = "UPDATE tbl_orders SET order_status = 'cancelled', updated_at = NOW() WHERE order_id = $order_id";
    
    if (mysqli_query($connect, $update_sql)) {
        $_SESSION['message'] = 'Đơn hàng #' . str_pad($order_id, 6, '0', STR_PAD_LEFT) . ' đã được hủy thành công!';
    } else {
        $_SESSION['message'] = 'Có lỗi xảy ra khi hủy đơn hàng. Vui lòng thử lại!';
    }
    
    header('Location: order-detail.php?id=' . $order_id);
    exit();
}

/**
 * Đặt lại các sản phẩm trong đơn hàng
 */
function reorderItems($order_id) {
    global $connect;
    
    // Lấy chi tiết đơn hàng
    $sql = "SELECT * FROM tbl_order_details WHERE order_id = $order_id";
    $result = mysqli_query($connect, $sql);
    
    if (mysqli_num_rows($result) == 0) {
        $_SESSION['message'] = 'Không tìm thấy sản phẩm trong đơn hàng!';
        header('Location: order-detail.php?id=' . $order_id);
        exit();
    }
    
    // Khởi tạo giỏ hàng nếu chưa có
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Thêm các sản phẩm vào giỏ hàng
    $added_count = 0;
    while ($item = mysqli_fetch_array($result)) {
        // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
        $product_exists = false;
        foreach ($_SESSION['cart'] as &$cart_item) {
            if ($cart_item['prd_id'] == $item['product_id']) {
                $cart_item['prd_quantity'] += $item['quantity'];
                $product_exists = true;
                break;
            }
        }
        
        // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
        if (!$product_exists) {
            $_SESSION['cart'][] = [
                'prd_id' => $item['product_id'],
                'prd_name' => $item['product_name'],
                'prd_price' => $item['product_price'],
                'prd_quantity' => $item['quantity'],
                'prd_image' => 'default-product.jpg' // Có thể lấy từ database
            ];
        }
        
        $added_count++;
    }
    
    $_SESSION['message'] = "Đã thêm $added_count sản phẩm vào giỏ hàng!";
    header('Location: cart.php');
    exit();
}
?>
