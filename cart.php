<?php
/**
 * SHOPEE-STYLE CART PAGE
 * Giỏ hàng với UI hiện đại như Shopee
 * Author: Senior Fullstack Developer
 */

// session_start();
include_once('./admin/connect.php');

// Lấy giỏ hàng từ session
$cart_items = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

// Tính tổng tiền và tổng số lượng
$total_amount = 0;
$total_items = 0;

foreach ($cart_items as $item) {
  $total_amount += $item['prd_price'] * $item['prd_quantity'];
  $total_items += $item['prd_quantity'];
}

// Hiển thị thông báo (nếu có)
$message = '';
if (isset($_SESSION['cart_message'])) {
  $message = $_SESSION['cart_message'];
  unset($_SESSION['cart_message']); // Xóa thông báo sau khi hiển thị
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng - KidBike Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart-shopee.css">
</head>
<body>
    <!-- Header -->
    <?php include_once('master/header.php'); ?>
    
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a><span>/</span>Giỏ hàng
            </div>
            <h1>Giỏ hàng <span style="color: var(--primary)">của bạn</span> 🛒</h1>
            <p>Kiểm tra và hoàn tất đơn hàng của bạn</p>
        </div>
    </div>

    <!-- Cart Content -->
    <div class="container">
        <div class="cart-shopee-container">
            <!-- Cart Header -->
            <div class="cart-shopee-header">
                <div class="cart-shopee-title">
                    <i class="fas fa-shopping-cart"></i>
                    Giỏ hàng của bạn (<?php echo $total_items; ?> sản phẩm)
                </div>
                <div class="cart-shopee-actions">
                    <a href="index.php?page=products" class="btn-shopee btn-shopee-secondary">
                        <i class="fas fa-arrow-left"></i>
                        Tiếp tục mua sắm
                    </a>
                    <button type="button" class="btn-shopee btn-shopee-danger" onclick="if(confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) { window.location.href='cart-action.php?action=clear'; }">
                        <i class="fas fa-trash"></i>
                        Xóa tất cả
                    </button>
                </div>
            </div>

            <!-- Hiển thị thông báo -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>

            <!-- Giỏ hàng trống -->
            <?php if (empty($cart_items)): ?>
                <div class="cart-shopee-empty">
                    <div class="cart-shopee-empty-icon">🛒</div>
                    <h2 class="cart-shopee-empty-title">Giỏ hàng của bạn đang trống</h2>
                    <p class="cart-shopee-empty-message">Hãy thêm những chiếc xe đạp tuyệt vời vào giỏ hàng nhé!</p>
                    <a href="index.php?page=products" class="btn-shopee btn-shopee-primary">
                        <i class="fas fa-bicycle"></i>
                        Mua sắm ngay
                    </a>
                </div>
            <?php endif; ?>

            <!-- Danh sách sản phẩm trong giỏ hàng -->
            <?php if (!empty($cart_items)): ?>
                <form method="post" action="cart-action.php">
                    <div class="cart-shopee-products">
                        <?php foreach ($cart_items as $item): ?>
                            <div class="cart-shopee-item">
                                <!-- Checkbox chọn sản phẩm -->
                                <div class="cart-shopee-checkbox">
                                    <input type="checkbox" name="select_product[<?php echo $item['prd_id']; ?>]" value="<?php echo $item['prd_id']; ?>">
                                </div>

                                <!-- Ảnh sản phẩm -->
                                <div class="cart-shopee-image">
                                    <img src="admin/assets/images/<?php echo htmlspecialchars($item['prd_image']); ?>" 
                                         alt="<?php echo htmlspecialchars($item['prd_name']); ?>">
                                </div>

                                <!-- Thông tin sản phẩm -->
                                <div class="cart-shopee-content">
                                    <div class="cart-shopee-product-name">
                                        <?php echo htmlspecialchars($item['prd_name']); ?>
                                    </div>
                                    <div class="cart-shopee-product-id">
                                        Mã SP: <?php echo $item['prd_id']; ?>
                                    </div>
                                    <div class="cart-shopee-price">
                                        <?php echo number_format($item['prd_price'], 0, ',', '.'); ?>₫
                                        <?php if (isset($item['prd_original_price']) && $item['prd_original_price'] > $item['prd_price']): ?>
                                            <span class="cart-shopee-price-original">
                                                <?php echo number_format($item['prd_original_price'], 0, ',', '.'); ?>₫
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Điều khiển số lượng -->
                                    <div class="cart-shopee-quantity">
                                        <div class="cart-shopee-quantity-label">Số lượng:</div>
                                        <div class="cart-shopee-quantity-controls">
                                            <button type="button" class="cart-shopee-quantity-btn" onclick="updateQuantity(<?php echo $item['prd_id']; ?>, <?php echo $item['prd_quantity']; ?>, -1)">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input type="number" 
                                                   name="quantity[<?php echo $item['prd_id']; ?>]" 
                                                   value="<?php echo $item['prd_quantity']; ?>" 
                                                   min="1" 
                                                   max="99"
                                                   class="cart-shopee-quantity-input"
                                                   id="quantity_<?php echo $item['prd_id']; ?>">
                                            <button type="button" class="cart-shopee-quantity-btn" onclick="updateQuantity(<?php echo $item['prd_id']; ?>, <?php echo $item['prd_quantity']; ?>, 1)">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Nút xóa -->
                                    <div class="cart-shopee-actions">
                                        <button type="button" 
                                                onclick="if(confirm('Bạn có chắc muốn xóa sản phẩm này?')) { 
                                                    window.location.href='cart-action.php?action=remove&product_id=<?php echo $item['prd_id']; ?>'; 
                                                }"
                                                class="cart-shopee-delete">
                                            <i class="fas fa-trash"></i>
                                            Xóa
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Cart Summary -->
                    <div class="cart-shopee-summary">
                        <h3><i class="fas fa-calculator"></i> Tóm tắt đơn hàng</h3>
                        
                        <!-- Voucher section -->
                        <div class="cart-shopee-voucher">
                            <div class="cart-shopee-voucher-input">
                                <input type="text" placeholder="Nhập mã giảm giá" name="voucher_code">
                                <button type="button" class="cart-shopee-voucher-btn">
                                    <i class="fas fa-ticket-alt"></i>
                                    Áp dụng
                                </button>
                            </div>
                        </div>

                        <!-- Summary items -->
                        <div class="cart-shopee-summary-item">
                            <span class="cart-shopee-summary-label">Tạm tính:</span>
                            <span class="cart-shopee-summary-value"><?php echo number_format($total_amount, 0, ',', '.'); ?>₫</span>
                        </div>
                        
                        <div class="cart-shopee-summary-item">
                            <span class="cart-shopee-summary-label">Phí vận chuyển:</span>
                            <span class="cart-shopee-summary-value">Miễn phí</span>
                        </div>
                        
                        <div class="cart-shopee-summary-item">
                            <span class="cart-shopee-summary-label">Giảm giá:</span>
                            <span class="cart-shopee-summary-value">0₫</span>
                        </div>
                        
                        <div class="cart-shopee-summary-item">
                            <span class="cart-shopee-summary-label">Tổng cộng:</span>
                            <span class="cart-shopee-summary-total"><?php echo number_format($total_amount, 0, ',', '.'); ?>₫</span>
                        </div>
                    </div>

                    <!-- Checkout buttons -->
                    <div class="cart-shopee-checkout">
                        <button type="submit" name="action" value="update" class="btn-shopee btn-shopee-secondary">
                            <i class="fas fa-sync-alt"></i>
                            Cập nhật giỏ hàng
                        </button>
                        <a href="checkout.php" class="btn-shopee btn-shopee-primary cart-shopee-checkout-btn">
                            <i class="fas fa-credit-card"></i>
                            Thanh toán ngay
                        </a>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('master/footer.php'); ?>

    <script>
        // Simple JavaScript cho quantity controls
        function updateQuantity(productId, currentQuantity, change) {
            const newQuantity = currentQuantity + change;
            if (newQuantity >= 1 && newQuantity <= 99) {
                document.getElementById('quantity_' + productId).value = newQuantity;
                // Trigger form submit để cập nhật
                document.querySelector('form').submit();
            }
        }

        // Auto-submit form khi quantity thay đổi
        document.querySelectorAll('.cart-shopee-quantity-input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelector('form').submit();
            });
        });
    </script>
</body>
</html>
