<?php
session_start();
include_once(__DIR__ . "/admin/connect.php");

// Lấy order_id từ URL
$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($order_id <= 0) {
    header('Location: order-history.php');
    exit();
}

// Lấy thông tin đơn hàng
$order_sql = "SELECT * FROM tbl_orders WHERE order_id = $order_id";
$order_result = mysqli_query($connect, $order_sql);
$order = mysqli_fetch_array($order_result);

if (!$order) {
    echo "<script>alert('Đơn hàng không tồn tại!'); window.location.href='order-history.php';</script>";
    exit();
}

// Lấy chi tiết sản phẩm trong đơn hàng
$details_sql = "SELECT od.*, p.prd_image 
                FROM tbl_order_details od 
                LEFT JOIN tbl_product p ON od.product_id = p.prd_id 
                WHERE od.order_id = $order_id";
$details_result = mysqli_query($connect, $details_sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng #<?= str_pad($order_id, 6, '0', STR_PAD_LEFT) ?> - KidBike Shop</title>
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
                <a href="index.php">Trang chủ</a><span>/</span>
                <a href="order-history.php">Lịch sử mua hàng</a><span>/</span>
                Chi tiết đơn hàng
            </div>
            <h1>Chi tiết đơn hàng <span style="color: var(--primary)">#<?= str_pad($order_id, 6, '0', STR_PAD_LEFT) ?></span> 📋</h1>
            <p>Xem thông tin chi tiết đơn hàng của bạn</p>
        </div>
    </div>

    <!-- Order Detail Content -->
    <section class="section">
        <div class="container">
            <!-- Order Status Timeline -->
            <div class="order-timeline">
                <div class="timeline-item <?= $order['order_status'] == 'pending' ? 'active' : '' ?> <?= in_array($order['order_status'], ['processing', 'completed']) ? 'completed' : '' ?>">
                    <div class="timeline-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Đặt hàng thành công</h4>
                        <p><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                    </div>
                </div>

                <div class="timeline-item <?= $order['order_status'] == 'processing' ? 'active' : '' ?> <?= $order['order_status'] == 'completed' ? 'completed' : '' ?>">
                    <div class="timeline-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Đang xử lý</h4>
                        <p>Đơn hàng đang được chuẩn bị</p>
                    </div>
                </div>

                <div class="timeline-item <?= $order['order_status'] == 'completed' ? 'active' : '' ?>">
                    <div class="timeline-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="timeline-content">
                        <h4>Giao hàng thành công</h4>
                        <p>Đơn hàng đã được giao thành công</p>
                    </div>
                </div>

                <?php if ($order['order_status'] == 'cancelled'): ?>
                    <div class="timeline-item cancelled">
                        <div class="timeline-icon">
                            <i class="fas fa-times-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <h4>Đơn hàng đã hủy</h4>
                            <p>Đơn hàng đã bị hủy</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="order-detail-grid">
                <!-- Order Info -->
                <div class="order-info-card">
                    <div class="card-header">
                        <h3><i class="fas fa-info-circle"></i> Thông tin đơn hàng</h3>
                        <div class="order-status-badge">
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
                            <span class="status-badge <?= $status_class ?>"><?= $status_text ?></span>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="info-row">
                            <label><i class="fas fa-hashtag"></i> Mã đơn hàng:</label>
                            <span>#<?= str_pad($order_id, 6, '0', STR_PAD_LEFT) ?></span>
                        </div>
                        <div class="info-row">
                            <label><i class="fas fa-calendar"></i> Ngày đặt:</label>
                            <span><?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></span>
                        </div>
                        <div class="info-row">
                            <label><i class="fas fa-credit-card"></i> Phương thức thanh toán:</label>
                            <span><?= ucfirst($order['payment_method']) ?></span>
                        </div>
                        <?php if ($order['order_notes']): ?>
                        <div class="info-row">
                            <label><i class="fas fa-sticky-note"></i> Ghi chú:</label>
                            <span><?= htmlspecialchars($order['order_notes']) ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Customer Info -->
                <div class="customer-info-card">
                    <div class="card-header">
                        <h3><i class="fas fa-user"></i> Thông tin khách hàng</h3>
                    </div>
                    
                    <div class="card-body">
                        <div class="info-row">
                            <label><i class="fas fa-user"></i> Họ tên:</label>
                            <span><?= htmlspecialchars($order['customer_name']) ?></span>
                        </div>
                        <div class="info-row">
                            <label><i class="fas fa-envelope"></i> Email:</label>
                            <span><?= htmlspecialchars($order['customer_email']) ?></span>
                        </div>
                        <div class="info-row">
                            <label><i class="fas fa-phone"></i> Số điện thoại:</label>
                            <span><?= htmlspecialchars($order['customer_phone']) ?></span>
                        </div>
                        <div class="info-row">
                            <label><i class="fas fa-map-marker-alt"></i> Địa chỉ giao hàng:</label>
                            <span><?= htmlspecialchars($order['customer_address']) ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="order-items-card">
                <div class="card-header">
                    <h3><i class="fas fa-box"></i> Sản phẩm trong đơn hàng</h3>
                </div>
                
                <div class="card-body">
                    <div class="order-items-list">
                        <?php if (mysqli_num_rows($details_result) > 0): ?>
                            <?php while ($item = mysqli_fetch_array($details_result)): ?>
                                <div class="order-item">
                                    <div class="item-image">
                                        <img src="admin/assets/images/<?= htmlspecialchars($item['prd_image'] ?? 'default-product.jpg') ?>" 
                                             alt="<?= htmlspecialchars($item['product_name']) ?>">
                                    </div>
                                    
                                    <div class="item-info">
                                        <h4 class="item-name"><?= htmlspecialchars($item['product_name']) ?></h4>
                                        <div class="item-details">
                                            <span class="item-price"><?= number_format($item['product_price'], 0, ',', '.') ?>₫</span>
                                            <span class="item-quantity">× <?= $item['quantity'] ?></span>
                                        </div>
                                    </div>
                                    
                                    <div class="item-total">
                                        <strong><?= number_format($item['subtotal'], 0, ',', '.') ?>₫</strong>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="no-items">Không có sản phẩm nào trong đơn hàng</div>
                        <?php endif; ?>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <div class="summary-row">
                            <label>Tạm tính:</label>
                            <span><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</span>
                        </div>
                        <div class="summary-row">
                            <label>Phí vận chuyển:</label>
                            <span>Miễn phí</span>
                        </div>
                        <div class="summary-row discount">
                            <label>Giảm giá:</label>
                            <span>0₫</span>
                        </div>
                        <div class="summary-row total">
                            <label><strong>Tổng cộng:</strong></label>
                            <span><strong><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Actions -->
            <div class="order-actions-card">
                <div class="card-body">
                    <div class="action-buttons">
                        <a href="order-history.php" class="btn btn-outline">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        
                        <?php if ($order['order_status'] == 'pending'): ?>
                            <button class="btn btn-danger" onclick="cancelOrder(<?= $order_id ?>)">
                                <i class="fas fa-times"></i> Hủy đơn hàng
                            </button>
                        <?php endif; ?>
                        
                        <?php if ($order['order_status'] == 'completed'): ?>
                            <button class="btn btn-success" onclick="reorder(<?= $order_id ?>)">
                                <i class="fas fa-redo"></i> Đặt lại đơn hàng
                            </button>
                        <?php endif; ?>
                        
                        <button class="btn btn-primary" onclick="printOrder()">
                            <i class="fas fa-print"></i> In đơn hàng
                        </button>
                        
                        <button class="btn btn-secondary" onclick="shareOrder()">
                            <i class="fas fa-share"></i> Chia sẻ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once('master/footer.php'); ?>

    <script>
        // Cancel order
        function cancelOrder(orderId) {
            if (confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
                window.location.href = 'order-action.php?action=cancel&id=' + orderId;
            }
        }

        // Reorder
        function reorder(orderId) {
            if (confirm('Bạn có muốn đặt lại các sản phẩm trong đơn hàng này?')) {
                window.location.href = 'order-action.php?action=reorder&id=' + orderId;
            }
        }

        // Print order
        function printOrder() {
            window.print();
        }

        // Share order
        function shareOrder() {
            const orderUrl = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: 'Chi tiết đơn hàng #' + <?= $order_id ?>,
                    text: 'Xem chi tiết đơn hàng của tôi tại KidBike Shop',
                    url: orderUrl
                });
            } else {
                // Fallback: copy to clipboard
                navigator.clipboard.writeText(orderUrl).then(() => {
                    alert('Đã sao chép link đơn hàng!');
                });
            }
        }

        // Auto-refresh order status every 30 seconds for pending/processing orders
        <?php if (in_array($order['order_status'], ['pending', 'processing'])): ?>
        setInterval(() => {
            window.location.reload();
        }, 30000);
        <?php endif; ?>
    </script>
</body>
</html>
