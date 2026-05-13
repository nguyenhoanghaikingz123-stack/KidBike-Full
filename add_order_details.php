<?php
/**
 * Thêm sample data cho tbl_order_details
 */

include_once('admin/connect.php');

echo "<h2>📝 Thêm Chi Tiết Đơn Hàng Mẫu</h2>";

// Thêm sample order details
$sql_sample_order_details = "
INSERT INTO `tbl_order_details` (`order_id`, `product_id`, `product_name`, `product_price`, `quantity`, `subtotal`) VALUES
(1, 1, 'Xe thăng bằng cho bé 2-4 tuổi', 1500000.00, 1, 1500000.00),
(1, 2, 'Xe bánh phụ cho bé 3-5 tuổi', 1000000.00, 1, 1000000.00),
(2, 3, 'Xe địa hình cho bé 5-8 tuổi', 1800000.00, 1, 1800000.00),
(3, 1, 'Xe thăng bằng cho bé 2-4 tuổi', 1500000.00, 2, 3000000.00),
(3, 4, 'Xe điện cho bé 6-10 tuổi', 2000000.00, 1, 2000000.00)
";

if (mysqli_query($connect, $sql_sample_order_details)) {
    echo "<p style='color: green;'>✅ Đã thêm chi tiết đơn hàng mẫu thành công!</p>";
} else {
    echo "<p style='color: red;'>❌ Lỗi: " . mysqli_error($connect) . "</p>";
}

// Kiểm tra lại
$check_details = mysqli_query($connect, "SELECT COUNT(*) as count FROM tbl_order_details");
$details_count = mysqli_fetch_array($check_details)['count'];

echo "<p style='color: blue;'>ℹ️ Số chi tiết đơn hàng: $details_count</p>";

echo "<p><a href='order-search.php' style='color: blue; text-decoration: none;'>🔍 Test tra cứu đơn hàng ngay!</a></p>";

echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
    h2 { color: #2563eb; }
    p { line-height: 1.6; }
</style>";
?>
