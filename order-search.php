<?php
session_start();
include_once(__DIR__ . "/admin/connect.php");

// Hiển thị thông báo nếu có
$alert_message = '';
if (isset($_GET['message']) && $_GET['message'] == 'login_required') {
    $alert_message = 'Bạn cần đăng nhập để xem lịch sử đơn hàng. Vui lòng đăng nhập hoặc tra cứu đơn hàng bên dưới!';
}

// Xử lý tìm kiếm
$search_result = null;
$search_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['search'])) {
    $search_term = trim($_POST['search_term']);
    
    if (empty($search_term)) {
        $search_error = 'Vui lòng nhập mã đơn hàng hoặc thông tin tìm kiếm!';
    } else {
        // Tìm kiếm theo nhiều tiêu chí
        $search_term = mysqli_real_escape_string($connect, $search_term);
        
        // Kiểm tra xem có phải là mã đơn hàng (số)
        if (is_numeric($search_term)) {
            $order_id = intval($search_term);
            $sql = "SELECT o.*, COUNT(od.detail_id) as total_items 
                    FROM tbl_orders o 
                    LEFT JOIN tbl_order_details od ON o.order_id = od.order_id 
                    WHERE o.order_id = $order_id 
                    GROUP BY o.order_id";
        } else {
            // Tìm kiếm theo tên khách hàng, email, điện thoại
            $sql = "SELECT o.*, COUNT(od.detail_id) as total_items 
                    FROM tbl_orders o 
                    LEFT JOIN tbl_order_details od ON o.order_id = od.order_id 
                    WHERE o.customer_name LIKE '%$search_term%' 
                       OR o.customer_email LIKE '%$search_term%' 
                       OR o.customer_phone LIKE '%$search_term%' 
                    GROUP BY o.order_id 
                    ORDER BY o.created_at DESC";
        }
        
        $result = mysqli_query($connect, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $search_result = [];
            while ($row = mysqli_fetch_array($result)) {
                $search_result[] = $row;
            }
        } else {
            $search_error = 'Không tìm thấy đơn hàng nào phù hợp!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng - KidBike Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/orders.css">
</head>
<body>
    <!-- Header -->
    <?php include_once('master/header.php'); ?>
    
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a><span>/</span>Tra cứu đơn hàng
            </div>
            <h1>Tra cứu <span style="color: var(--primary)">đơn hàng</span> 🔍</h1>
            <p>Tìm kiếm đơn hàng của bạn nhanh chóng</p>
        </div>
    </div>

    <!-- Order Search Content -->
    <section class="section">
        <div class="container">
            <!-- Alert Message -->
            <?php if ($alert_message): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <?= $alert_message ?>
                </div>
            <?php endif; ?>

            <!-- Login Section for registered users -->
            <?php if (!isset($_SESSION['user_id'])): ?>
            <div class="login-prompt">
                <div class="login-card">
                    <h3><i class="fas fa-user"></i> Đã có tài khoản?</h3>
                    <p>Đăng nhập để xem lịch sử mua hàng đầy đủ</p>
                    <div class="login-buttons">
                        <a href="login.php" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                        <a href="login.php?register=1" class="btn btn-outline">
                            <i class="fas fa-user-plus"></i> Đăng ký tài khoản
                        </a>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <!-- Section cho người đã đăng nhập -->
            <div class="logged-in-prompt">
                <div class="logged-in-card">
                    <h3><i class="fas fa-user-check"></i> Chào mừng quay trở lại!</h3>
                    <p>Bạn đã đăng nhập. Xem <a href="order-history.php" style="color: #3b82f6; font-weight: bold;">lịch sử đơn hàng</a> của bạn.</p>
                    <div class="logged-in-actions">
                        <a href="order-history.php" class="btn btn-primary">
                            <i class="fas fa-history"></i> Xem lịch sử
                        </a>
                        <a href="logout.php" class="btn btn-outline">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Search Form -->
            <div class="search-section">
                <div class="search-card">
                    <div class="search-header">
                        <i class="fas fa-search"></i>
                        <h3>Tra cứu đơn hàng</h3>
                    </div>
                    
                    <form method="post" class="search-form">
                        <div class="search-input-group">
                            <div class="search-input-wrapper">
                                <i class="fas fa-hashtag"></i>
                                <input type="text" 
                                       name="search_term" 
                                       placeholder="Nhập mã đơn hàng, tên, email hoặc SĐT..." 
                                       value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>"
                                       required>
                            </div>
                            <button type="submit" name="search" class="btn btn-primary btn-lg">
                                <i class="fas fa-search"></i> Tìm kiếm
                            </button>
                        </div>
                    </form>

                    <!-- Quick Search Options -->
                    <div class="quick-search">
                        <h4>Tìm nhanh:</h4>
                        <div class="quick-options">
                            <a href="#" onclick="quickSearch('pending')" class="quick-option">
                                <i class="fas fa-clock"></i> Đơn hàng chờ xử lý
                            </a>
                            <a href="#" onclick="quickSearch('processing')" class="quick-option">
                                <i class="fas fa-truck"></i> Đơn hàng đang giao
                            </a>
                            <a href="#" onclick="quickSearch('completed')" class="quick-option">
                                <i class="fas fa-check-circle"></i> Đơn hàng hoàn thành
                            </a>
                            <a href="#" onclick="quickSearch('cancelled')" class="quick-option">
                                <i class="fas fa-times-circle"></i> Đơn hàng đã hủy
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Results -->
            <?php if ($search_error): ?>
                <div class="search-error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <?= $search_error ?>
                </div>
            <?php endif; ?>

            <?php if ($search_result !== null): ?>
                <div class="search-results">
                    <div class="results-header">
                        <h3><i class="fas fa-list"></i> Kết quả tìm kiếm</h3>
                        <span class="results-count">Tìm thấy <?= count($search_result) ?> đơn hàng</span>
                    </div>

                    <div class="orders-list">
                        <?php foreach ($search_result as $order): ?>
                            <div class="order-card search-result">
                                <div class="order-header">
                                    <div class="order-info">
                                        <div class="order-id">
                                            <strong>Mã đơn hàng:</strong> #<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?>
                                        </div>
                                        <div class="order-date">
                                            <i class="fas fa-calendar"></i> 
                                            <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                        </div>
                                    </div>
                                    <div class="order-status">
                                        <?php
                                        $status_class = '';
                                        $status_text = '';
                                        switch ($order['order_status']) {
                                            case 'pending':
                                                $status_class = 'status-pending';
                                                $status_text = 'Chờ xử lý';
                                                break;
                                            case 'processing':
                                                $status_class = 'status-processing';
                                                $status_text = 'Đang xử lý';
                                                break;
                                            case 'completed':
                                                $status_class = 'status-completed';
                                                $status_text = 'Hoàn thành';
                                                break;
                                            case 'cancelled':
                                                $status_class = 'status-cancelled';
                                                $status_text = 'Đã hủy';
                                                break;
                                        }
                                        ?>
                                        <span class="status-badge <?= $status_class ?>">
                                            <?= $status_text ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="order-content">
                                    <div class="order-summary">
                                        <div class="order-items-count">
                                            <i class="fas fa-box"></i> 
                                            <?= $order['total_items'] ?> sản phẩm
                                        </div>
                                        <div class="order-total">
                                            <strong>Tổng tiền:</strong> 
                                            <span class="price"><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</span>
                                        </div>
                                    </div>

                                    <div class="order-customer">
                                        <div class="customer-name">
                                            <i class="fas fa-user"></i> <?= htmlspecialchars($order['customer_name']) ?>
                                        </div>
                                        <div class="customer-phone">
                                            <i class="fas fa-phone"></i> <?= htmlspecialchars($order['customer_phone']) ?>
                                        </div>
                                        <div class="customer-email">
                                            <i class="fas fa-envelope"></i> <?= htmlspecialchars($order['customer_email']) ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="order-actions">
                                    <a href="order-detail.php?id=<?= $order['order_id'] ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye"></i> Xem chi tiết
                                    </a>
                                    <button class="btn btn-outline btn-sm" onclick="copyOrderId(<?= $order['order_id'] ?>)">
                                        <i class="fas fa-copy"></i> Sao chép mã
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Help Section -->
            <div class="help-section">
                <div class="help-card">
                    <h3><i class="fas fa-question-circle"></i> Cần giúp đỡ?</h3>
                    <div class="help-content">
                        <div class="help-item">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <h4>Cách tra cứu đơn hàng?</h4>
                                <p>Nhập mã đơn hàng (ví dụ: 000123) hoặc thông tin cá nhân (tên, email, SĐT) vào ô tìm kiếm.</p>
                            </div>
                        </div>
                        <div class="help-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Không tìm thấy đơn hàng?</h4>
                                <p>Kiểm tra lại mã đơn hàng hoặc thông tin đã nhập. Đơn hàng mới có thể mất vài phút để hiển thị.</p>
                            </div>
                        </div>
                        <div class="help-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <h4>Cần hỗ trợ thêm?</h4>
                                <p>Liên hệ hotline: <strong>1900-1234</strong> hoặc email: <strong>support@kidbike.vn</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once('master/footer.php'); ?>

    <script>
        // Quick search
        function quickSearch(status) {
            const form = document.querySelector('.search-form');
            const input = form.querySelector('input[name="search_term"]');
            
            // Set search term based on status
            switch(status) {
                case 'pending':
                    input.value = 'chờ xử lý';
                    break;
                case 'processing':
                    input.value = 'đang giao';
                    break;
                case 'completed':
                    input.value = 'hoàn thành';
                    break;
                case 'cancelled':
                    input.value = 'đã hủy';
                    break;
            }
            
            // Submit form
            form.submit();
        }

        // Copy order ID
        function copyOrderId(orderId) {
            const orderCode = '#' + orderId.toString().padStart(6, '0');
            navigator.clipboard.writeText(orderCode).then(() => {
                // Show toast notification
                showToast('Đã sao chép mã đơn hàng: ' + orderCode);
            });
        }

        // Show toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            `;
            
            document.body.appendChild(toast);
            
            // Show toast
            setTimeout(() => {
                toast.classList.add('show');
            }, 100);
            
            // Hide toast after 3 seconds
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }

        // Auto-focus search input
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="search_term"]').focus();
        });

        // Enter key to search
        document.querySelector('input[name="search_term"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.querySelector('.search-form').submit();
            }
        });
    </script>

    <style>
        /* Toast notification styles */
        .toast-notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #4CAF50;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .toast-notification.show {
            transform: translateY(0);
            opacity: 1;
        }

        .toast-notification i {
            font-size: 18px;
        }
    </style>
</body>
</html>
