<?php

/**
 * Setup database tables for orders
 * File này sẽ tạo các bảng cần thiết cho hệ thống đơn hàng
 */

include_once('admin/connect.php');

echo "<h2>🔧 Database Setup - KidBike Shop</h2>";

// Kiểm tra kết nối
if (!$connect) {
    die("<p style='color: red;'>❌ Kết nối database thất bại: " . mysqli_connect_error() . "</p>");
}

echo "<p style='color: green;'>✅ Kết nối database thành công!</p>";

// SQL tạo bảng orders
$sql_create_orders = "
CREATE TABLE IF NOT EXISTS `tbl_orders` (
    `order_id` int(11) NOT NULL AUTO_INCREMENT,
    `customer_name` varchar(255) NOT NULL,
    `customer_email` varchar(255) NOT NULL,
    `customer_phone` varchar(20) DEFAULT NULL,
    `customer_address` text DEFAULT NULL,
    `total_amount` decimal(10,2) NOT NULL,
    `payment_method` varchar(50) DEFAULT 'cod',
    `order_status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
    `order_notes` text DEFAULT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`order_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

// SQL tạo bảng order_details
$sql_create_order_details = "
CREATE TABLE IF NOT EXISTS `tbl_order_details` (
    `detail_id` int(11) NOT NULL AUTO_INCREMENT,
    `order_id` int(11) NOT NULL,
    `product_id` int(11) NOT NULL,
    `product_name` varchar(255) NOT NULL,
    `product_price` decimal(10,2) NOT NULL,
    `quantity` int(11) NOT NULL,
    `subtotal` decimal(10,2) NOT NULL,
    PRIMARY KEY (`detail_id`),
    FOREIGN KEY (`order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE CASCADE,
    FOREIGN KEY (`product_id`) REFERENCES `tbl_product`(`prd_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
";

// Kiểm tra và thêm sample data cho tbl_product nếu cần
$check_products = mysqli_query($connect, "SELECT COUNT(*) as count FROM tbl_product");
$products_count = mysqli_fetch_array($check_products)['count'];

if ($products_count == 0) {
    // Thêm sample products trước
    $sql_sample_products = "
    INSERT INTO `tbl_product` (`prd_name`, `prd_price`, `prd_quantity`, `cate_id`, `prd_image`) VALUES
    ('Xe thăng bằng cho bé 2-4 tuổi', 1500000.00, 50, 1, 'xe1.jpg'),
    ('Xe bánh phụ cho bé 3-5 tuổi', 1000000.00, 30, 2, 'xe2.jpg'),
    ('Xe địa hình cho bé 5-8 tuổi', 1800000.00, 20, 3, 'xe3.jpg'),
    ('Xe điện cho bé 6-10 tuổi', 2000000.00, 15, 4, 'xe4.jpg')
    ";

    if (mysqli_query($connect, $sql_sample_products)) {
        echo "<p style='color: green;'>✅ Đã thêm 4 sản phẩm mẫu!</p>";
    }
}

// Thêm sample data cho orders
$sql_sample_orders = "
INSERT INTO `tbl_orders` (`customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_amount`, `payment_method`, `order_status`) VALUES
('Nguyễn Văn A', 'nguyenvana@email.com', '0901234567', '123 Đường ABC, Quận 1, TP.HCM', 2500000.00, 'cod', 'completed'),
('Trần Thị B', 'tranthib@email.com', '0909876543', '456 Đường XYZ, Quận 3, TP.HCM', 1800000.00, 'cod', 'processing'),
('Lê Văn C', 'levanc@email.com', '0905678901', '789 Đường DEF, Quận 5, TP.HCM', 3200000.00, 'cod', 'pending')
";

$sql_sample_order_details = "
INSERT INTO `tbl_order_details` (`order_id`, `product_id`, `product_name`, `product_price`, `quantity`, `subtotal`) VALUES
(1, 1, 'Xe thăng bằng cho bé 2-4 tuổi', 1500000.00, 1, 1500000.00),
(1, 2, 'Xe bánh phụ cho bé 3-5 tuổi', 1000000.00, 1, 1000000.00),
(2, 3, 'Xe địa hình cho bé 5-8 tuổi', 1800000.00, 1, 1800000.00),
(3, 1, 'Xe thăng bằng cho bé 2-4 tuổi', 1500000.00, 2, 3000000.00),
(3, 4, 'Xe điện cho bé 6-10 tuổi', 2000000.00, 1, 2000000.00)
";

// Thực thi tạo bảng
echo "<h3>📋 Tạo bảng tbl_orders...</h3>";
if (mysqli_query($connect, $sql_create_orders)) {
    echo "<p style='color: green;'>✅ Bảng tbl_orders đã được tạo thành công!</p>";
} else {
    echo "<p style='color: red;'>❌ Lỗi tạo bảng tbl_orders: " . mysqli_error($connect) . "</p>";
}

echo "<h3>📦 Tạo bảng tbl_order_details...</h3>";
if (mysqli_query($connect, $sql_create_order_details)) {
    echo "<p style='color: green;'>✅ Bảng tbl_order_details đã được tạo thành công!</p>";
} else {
    echo "<p style='color: red;'>❌ Lỗi tạo bảng tbl_order_details: " . mysqli_error($connect) . "</p>";
}

// Thêm sample data (chỉ khi bảng rỗng)
echo "<h3>📝 Thêm dữ liệu mẫu...</h3>";
$check_orders = mysqli_query($connect, "SELECT COUNT(*) as count FROM tbl_orders");
$orders_count = mysqli_fetch_array($check_orders)['count'];

if ($orders_count == 0) {
    if (mysqli_query($connect, $sql_sample_orders)) {
        echo "<p style='color: green;'>✅ Đã thêm 3 đơn hàng mẫu!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Lỗi thêm đơn hàng mẫu: " . mysqli_error($connect) . "</p>";
    }

    if (mysqli_query($connect, $sql_sample_order_details)) {
        echo "<p style='color: green;'>✅ Đã thêm chi tiết đơn hàng mẫu!</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ Lỗi thêm chi tiết đơn hàng: " . mysqli_error($connect) . "</p>";
    }
} else {
    echo "<p style='color: blue;'>ℹ️ Bảng đã có dữ liệu, bỏ qua thêm dữ liệu mẫu!</p>";
}

// Kiểm tra lại
echo "<h3>🔍 Kiểm tra lại database...</h3>";
$check_tables = [
    'tbl_orders' => 'Đơn hàng',
    'tbl_order_details' => 'Chi tiết đơn hàng'
];

foreach ($check_tables as $table => $description) {
    $result = mysqli_query($connect, "SHOW TABLES LIKE '$table'");
    if (mysqli_num_rows($result) > 0) {
        echo "<p style='color: green;'>✅ Bảng $table ($description) đã tồn tại!</p>";

        // Đếm số records
        $count_result = mysqli_query($connect, "SELECT COUNT(*) as count FROM $table");
        $count = mysqli_fetch_array($count_result)['count'];
        echo "<p style='color: blue;'>ℹ️ Số records trong $table: $count</p>";
    } else {
        echo "<p style='color: red;'>❌ Bảng $table ($description) không tồn tại!</p>";
    }
}

echo "<hr>";
echo "<h3>🎉 Hoàn tất!</h3>";
echo "<p><strong>Các bước tiếp theo:</strong></p>";
echo "<ol>";
echo "<li><a href='order-search.php' style='color: blue; text-decoration: none;'>🔍 Test trang tra cứu đơn hàng</a></li>";
echo "<li><a href='order-history.php' style='color: blue; text-decoration: none;'>📋 Test trang lịch sử đơn hàng (cần đăng nhập)</a></li>";
echo "<li><a href='index.php?page=products' style='color: blue; text-decoration: none;'>🛍️ Mua sắm để tạo đơn hàng thật</a></li>";
echo "</ol>";

echo "<style>
    body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
    h2 { color: #2563eb; border-bottom: 3px solid #2563eb; padding-bottom: 10px; }
    h3 { color: #1f2937; margin-top: 30px; }
    p { line-height: 1.6; }
    ol { line-height: 2; }
    a:hover { text-decoration: underline; }
</style>";
