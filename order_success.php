
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - KidBike Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/order-success.css">
</head>
<body>
    <!-- Header -->
    <?php include_once('master/header.php'); ?>
    
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a><span>/</span><a href="index.php?page=cart">Giỏ hàng</a><span>/</span>Đặt hàng thành công
            </div>
            <h1>Đặt hàng <span style="color: var(--primary)">thành công</span> 🎉</h1>
            <p>Cảm ơn bạn đã tin tưởng và mua hàng</p>
        </div>
    </div>

    <!-- Success Content -->
    <div class="container">
        <div class="success-container">
            <div class="success-icon">
                <i class="fas fa-check"></i>
            </div>
            
            <h2 class="success-title">Đặt hàng thành công!</h2>
            
            <p class="success-message">
                Cảm ơn <strong><?= htmlspecialchars($order_info['customer_name']) ?></strong> đã đặt hàng tại KidBike Shop.<br>
                Chúng tôi sẽ liên hệ với bạn qua email <strong><?= htmlspecialchars($order_info['customer_email']) ?></strong> để xác nhận đơn hàng.
            </p>
            
            <div class="order-info">
                <div class="order-info-item">
                    <span class="order-info-label">Mã đơn hàng:</span>
                    <span class="order-info-value">#<?= str_pad($order_info['order_id'], 6, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Tổng tiền:</span>
                    <span class="order-info-value"><?= number_format($order_info['total_amount'], 0, ',', '.') ?>₫</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Trạng thái:</span>
                    <span class="order-info-value" style="color: #4CAF50;">Đang chờ xử lý</span>
                </div>
                <div class="order-info-item">
                    <span class="order-info-label">Thời gian đặt:</span>
                    <span class="order-info-value"><?= date('H:i - d/m/Y') ?></span>
                </div>
            </div>
            
            <div class="action-buttons">
                <a href="index.php" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Về trang chủ
                </a>
                <a href="index.php?page=products" class="btn btn-secondary">
                    <i class="fas fa-shopping-bag"></i>
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('master/footer.php'); ?>
</body>
</html>
