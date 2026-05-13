<?php
/**
 * Kiểm tra sản phẩm và thêm chi tiết đơn hàng
 */

include_once('admin/connect.php');

echo "<h2>🔍 Kiểm Tra Sản Phẩm</h2>";

// Kiểm tra các sản phẩm hiện có
$check_products = mysqli_query($connect, "SELECT prd_id, prd_name FROM tbl_product LIMIT 10");
echo "<h3>Sản phẩm hiện có:</h3>";
echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
echo "<tr><th>ID</th><th>Tên sản phẩm</th></tr>";

while ($product = mysqli_fetch_array($check_products)) {
    echo "<tr>";
    echo "<td>" . $product['prd_id'] . "</td>";
    echo "<td>" . htmlspecialchars($product['prd_name']) . "</td>";
    echo "</tr>";
}
echo "</table>";

// Thêm sản phẩm mẫu nếu trống
$count = mysqli_num_rows($check_products);
if ($count == 0) {
    echo "<p style='color: orange;'>Không có sản phẩm nào. Đang thêm sản phẩm mẫu...</p>";
    
    // Thêm sản phẩm mẫu
    $sql_add_products = "
    INSERT INTO `tbl_product` (`prd_name`, `prd_price`, `prd_quantity`, `cate_id`, `prd_image`) VALUES
    ('Xe thăng bằng cho bé 2-4 tuổi', 1500000.00, 50, 1, 'xe1.jpg'),
    ('Xe bánh phụ cho bé 3-5 tuổi', 1000000.00, 30, 2, 'xe2.jpg'),
    ('Xe địa hình cho bé 5-8 tuổi', 1800000.00, 20, 3, 'xe3.jpg'),
    ('Xe điện cho bé 6-10 tuổi', 2000000.00, 15, 4, 'xe4.jpg')
    ";
    
    if (mysqli_query($connect, $sql_add_products)) {
        echo "<p style='color: green;'>✅ Đã thêm 4 sản phẩm mẫu!</p>";
    } else {
        echo "<p style='color: red;'>❌ Lỗi thêm sản phẩm: " . mysqli_error($connect) . "</p>";
    }
}

// Bây giờ thêm chi tiết đơn hàng
echo "<h3>📝 Thêm Chi Tiết Đơn Hàng</h3>";

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
echo "<h3>🔍 Kiểm Tra Lại</h3>";
$check_orders = mysqli_query($connect, "SELECT COUNT(*) as count FROM tbl_orders");
$orders_count = mysqli_fetch_array($check_orders)['count'];

$check_details = mysqli_query($connect, "SELECT COUNT(*) as count FROM tbl_order_details");
$details_count = mysqli_fetch_array($check_details)['count'];

echo "<p><strong>Đơn hàng:</strong> $orders_count records</p>";
echo "<p><strong>Chi tiết đơn hàng:</strong> $details_count records</p>";

echo "<hr>";
echo "<p><a href='order-search.php' style='color: blue; text-decoration: none;'>🔍 Test tra cứu đơn hàng ngay!</a></p>";

echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
    h2, h3 { color: #2563eb; }
    table { margin: 20px 0; }
    th, td { padding: 8px; text-align: left; border: 1px solid #ddd; }
    th { background: #f5f5f5; font-weight: bold; }
    p { line-height: 1.6; }
</style>";
?>
