<?php
/**
 * File tạo bảng tbl_orders cho trang checkout
 * Chạy file này 1 lần để tạo bảng
 */

include_once('admin/connect.php');

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

// Thực thi tạo bảng
if (mysqli_query($connect, $sql_create_orders)) {
    echo "✅ Bảng tbl_orders đã được tạo thành công!<br>";
} else {
    echo "❌ Lỗi tạo bảng tbl_orders: " . mysqli_error($connect) . "<br>";
}

if (mysqli_query($connect, $sql_create_order_details)) {
    echo "✅ Bảng tbl_order_details đã được tạo thành công!<br>";
} else {
    echo "❌ Lỗi tạo bảng tbl_order_details: " . mysqli_error($connect) . "<br>";
}

echo "<style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .success { color: #4CAF50; font-weight: bold; }
        .error { color: #f44336; font-weight: bold; }
        .back-link { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; border-radius: 5px; }
        .back-link:hover { background: #45a049; }
    </style>";
echo "<br><a href='index.php?page=cart' class='back-link'>🛒 Về trang giỏ hàng</a>";
?>
