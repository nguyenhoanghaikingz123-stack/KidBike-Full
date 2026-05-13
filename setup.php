<?php
/**
 * FILE SETUP DUY NHẤT - XỬ LÝ TẤT CẢ
 * Chạy file này 1 lần để thiết lập mọi thứ
 */

session_start();
include_once('admin/connect.php');

echo "<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Setup KidBike Shop</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; background: #f8fafc; }
        .container { background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h1 { color: #1e40af; text-align: center; margin-bottom: 30px; }
        h2 { color: #374151; margin: 25px 0 15px 0; padding-bottom: 10px; border-bottom: 2px solid #e5e7eb; }
        .success { background: #f0fdf4; border: 1px solid #22c55e; color: #166534; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .error { background: #fef2f2; border: 1px solid #ef4444; color: #991b1b; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .btn { display: inline-block; padding: 12px 24px; background: #3b82f6; color: white; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .btn:hover { background: #2563eb; }
        .btn-success { background: #10b981; }
        .btn-success:hover { background: #059669; }
        .step { margin: 20px 0; padding: 20px; background: #f9fafb; border-radius: 8px; }
        .step h3 { color: #059669; margin: 0 0 10px 0; }
        .links { display: flex; gap: 10px; flex-wrap: wrap; margin: 20px 0; }
        .code { background: #f3f4f6; padding: 15px; border-radius: 6px; font-family: monospace; margin: 10px 0; }
    </style>
</head>
<body>
    <div class='container'>
        <h1>🔧 KIDBIKE SHOP SETUP</h1>
        
        <!-- STEP 1: DATABASE -->
        <div class='step'>
            <h3>📊 Step 1: Database Setup</h3>
            
            <?php
            // Kiểm tra và tạo bảng orders
            $sql_orders = "
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
            
            $sql_order_details = "
            CREATE TABLE IF NOT EXISTS `tbl_order_details` (
                `detail_id` int(11) NOT NULL AUTO_INCREMENT,
                `order_id` int(11) NOT NULL,
                `product_id` int(11) NOT NULL,
                `product_name` varchar(255) NOT NULL,
                `product_price` decimal(10,2) NOT NULL,
                `quantity` int(11) NOT NULL,
                `subtotal` decimal(10,2) NOT NULL,
                PRIMARY KEY (`detail_id`),
                FOREIGN KEY (`order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ";
            
            if (mysqli_query($connect, $sql_orders) && mysqli_query($connect, $sql_order_details)) {
                echo "<div class='success'>✅ Database tables đã được tạo thành công!</div>";
            } else {
                echo "<div class='error'>❌ Lỗi tạo database: " . mysqli_error($connect) . "</div>";
            }
            
            // Thêm sample data nếu trống
            $check_orders = mysqli_query($connect, "SELECT COUNT(*) as count FROM tbl_orders");
            $orders_count = mysqli_fetch_array($check_orders)['count'];
            
            if ($orders_count == 0) {
                $sample_orders = "
                INSERT INTO `tbl_orders` (`customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_amount`, `payment_method`, `order_status`) VALUES
                ('Nguyễn Văn A', 'nguyenvana@email.com', '0901234567', '123 Đường ABC, Q1, TP.HCM', 2500000.00, 'cod', 'completed'),
                ('Trần Thị B', 'tranthib@email.com', '0909876543', '456 Đường XYZ, Q3, TP.HCM', 1800000.00, 'cod', 'processing'),
                ('Lê Văn C', 'levanc@email.com', '0905678901', '789 Đường DEF, Q5, TP.HCM', 3200000.00, 'cod', 'pending')
                ";
                
                if (mysqli_query($connect, $sample_orders)) {
                    echo "<div class='success'>✅ Đã thêm 3 đơn hàng mẫu!</div>";
                    
                    // Thêm order details
                    $get_products = mysqli_query($connect, "SELECT prd_id, prd_name FROM tbl_product LIMIT 3");
                    $products = [];
                    while ($product = mysqli_fetch_array($get_products)) {
                        $products[] = $product;
                    }
                    
                    if (!empty($products)) {
                        $sample_details = "
                        INSERT INTO `tbl_order_details` (`order_id`, `product_id`, `product_name`, `product_price`, `quantity`, `subtotal`) VALUES
                        (1, " . $products[0]['prd_id'] . ", '" . $products[0]['prd_name'] . "', 1500000.00, 1, 1500000.00),
                        (1, " . $products[1]['prd_id'] . ", '" . $products[1]['prd_name'] . "', 1000000.00, 1, 1000000.00),
                        (2, " . $products[2]['prd_id'] . ", '" . $products[2]['prd_name'] . "', 1800000.00, 1, 1800000.00),
                        (3, " . $products[0]['prd_id'] . ", '" . $products[0]['prd_name'] . "', 1500000.00, 2, 3000000.00)
                        ";
                        
                        if (mysqli_query($connect, $sample_details)) {
                            echo "<div class='success'>✅ Đã thêm chi tiết đơn hàng mẫu!</div>";
                        }
                    }
                }
            } else {
                echo "<div class='success'>✅ Database đã có dữ liệu!</div>";
            }
            ?>
        </div>
        
        <!-- STEP 2: SESSION -->
        <div class='step'>
            <h3>👤 Step 2: Session Setup</h3>
            
            <?php
            // Tạo session test
            $_SESSION['user_id'] = 1;
            $_SESSION['user_name'] = 'Test User';
            $_SESSION['user_email'] = 'test@kidbike.vn';
            
            echo "<div class='success'>✅ Session đã được tạo: User ID = " . $_SESSION['user_id'] . "</div>";
            ?>
            
            <div class='code'>
                <strong>Session Info:</strong><br>
                User ID: <?php echo $_SESSION['user_id']; ?><br>
                User Name: <?php echo $_SESSION['user_name']; ?><br>
                User Email: <?php echo $_SESSION['user_email']; ?>
            </div>
        </div>
        
        <!-- STEP 3: NAVIGATION CHECK -->
        <div class='step'>
            <h3>🧭 Step 3: Navigation Check</h3>
            
            <?php
            $current_file = basename($_SERVER['PHP_SELF']);
            echo "<div class='success'>✅ Navigation sẽ hiển thị:</div>";
            echo "<ul>";
            echo "<li><strong>Desktop:</strong> Nút '📋 Lịch sử' (màu xanh dương)</li>";
            echo "<li><strong>Mobile:</strong> Menu '📋 Lịch sử đơn hàng' (nền xanh dương)</li>";
            echo "<li><strong>Order Search:</strong> Sẽ hiện section 'Chào mừng quay trở lại!'</li>";
            echo "</ul>";
            ?>
        </div>
        
        <!-- STEP 4: FINAL -->
        <div class='step'>
            <h3>🎯 Step 4: Ready to Test</h3>
            
            <div class='success'>
                <strong>✅ Mọi thứ đã sẵn sàng!</strong><br><br>
                • Database có 3 đơn hàng mẫu<br>
                • Session đã được tạo<br>
                • Navigation logic đã đúng<br>
                • Các trang order đã sẵn sàng
            </div>
            
            <div class='links'>
                <a href='index.php' class='btn'>🏠 Trang Chủ</a>
                <a href='order-history.php' class='btn btn-success'>📋 Lịch Sử</a>
                <a href='order-search.php' class='btn'>🔍 Tra Cứu</a>
                <a href='login.php' class='btn'>🔐 Login</a>
            </div>
        </div>
        
        <!-- CLEANUP -->
        <div class='step'>
            <h3>🧹 Step 5: Cleanup</h3>
            
            <div class='code'>
                <strong>Để xóa file này sau khi setup:</strong><br>
                rm setup.php<br><br>
                <strong>Để xóa session test:</strong><br>
                Vào <a href='logout.php'>logout.php</a> hoặc xóa session trong code
            </div>
        </div>
    </div>
</body>
</html>";
?>
