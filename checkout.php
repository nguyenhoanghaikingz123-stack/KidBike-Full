
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán - KidBike Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
    <!-- Header -->
    <?php include_once('master/header.php'); ?>
    
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a><span>/</span><a href="index.php?page=cart">Giỏ hàng</a><span>/</span>Thanh toán
            </div>
            <h1>Thanh toán <span style="color: var(--primary)">đơn hàng</span> 🛒</h1>
            <p>Hoàn tất thông tin để đặt hàng thành công</p>
        </div>
    </div>

    <!-- Checkout Content -->
    <div class="container">
        <div class="checkout-container">
            <!-- Error Message (Frontend only) -->
            <div class="alert-error" id="errorMessage" style="display: none;">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorText"></span>
            </div>
            
            <div class="checkout-grid">
                <!-- Checkout Form -->
                <div class="checkout-form">
                    <h2><i class="fas fa-user"></i> Thông tin khách hàng</h2>
                    
                    <form method="POST" action="checkout.php" id="checkoutForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="customer_name">Họ tên *</label>
                                <input type="text" id="customer_name" name="customer_name" required
                                       placeholder="Nhập họ tên của bạn">
                            </div>
                            <div class="form-group">
                                <label for="customer_email">Email *</label>
                                <input type="email" id="customer_email" name="customer_email" required
                                       placeholder="email@example.com">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="customer_phone">Số điện thoại *</label>
                            <input type="tel" id="customer_phone" name="customer_phone" required
                                   placeholder="09xxxxxxxx">
                        </div>
                        
                        <div class="form-group">
                            <label for="customer_address">Địa chỉ giao hàng *</label>
                            <textarea id="customer_address" name="customer_address" required rows="3"
                                      placeholder="Nhập địa chỉ giao hàng chi tiết"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Phương thức thanh toán *</label>
                            <option class="payment-methods">
                                <div class="payment-option" data-method="cod">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <div>Thanh toán khi nhận hàng (COD)</div>
                                </div>
                                <div class="payment-option" data-method="banking">
                                    <i class="fas fa-university"></i>
                                    <div>Chuyển khoản ngân hàng</div>
                                </div>
                            </option>
                            <input type="hidden" id="payment_method" name="payment_method" value="">
                        </div>
                        
                        <div class="form-group">
                            <label for="order_notes">Ghi chú (tùy chọn)</label>
                            <textarea id="order_notes" name="order_notes" rows="3"
                                      placeholder="Ghi chú đặc biệt về đơn hàng..."></textarea>
                        </div>
                        
                        <button type="submit" name="checkout_submit" class="checkout-btn">
                            <i class="fas fa-lock"></i> Đặt hàng an toàn
                        </button>
                    </form>
                </div>
                
                <!-- Order Summary -->
                <div class="order-summary">
                    <h3><i class="fas fa-shopping-cart"></i> Tóm tắt đơn hàng</h3>
                    
                    <div class="summary-products">
                        <!-- Sample products for frontend demo -->
                        <div class="checkout-product">
                            <img src="admin/assets/images/xedapbegai.jpg" alt="Xe đạp bé gái">
                            <div class="checkout-product-info">
                                <div class="checkout-product-name">Xe Đạp Bé Gái Pink Princess</div>
                                <div class="checkout-product-price">890.000₫</div>
                                <div class="checkout-product-quantity">Số lượng: 1</div>
                            </div>
                            <div class="checkout-product-total">890.000₫</div>
                        </div>
                        <div class="checkout-product">
                            <img src="admin/assets/images/xedapchobetrai.webp" alt="Xe đạp bé trai">
                            <div class="checkout-product-info">
                                <div class="checkout-product-name">Xe Đạp Bé Trai Super Hero</div>
                                <div class="checkout-product-price">950.000₫</div>
                                <div class="checkout-product-quantity">Số lượng: 2</div>
                            </div>
                            <div class="checkout-product-total">1.900.000₫</div>
                        </div>
                    </div>
                    
                    <div class="summary-item">
                        <span>Tạm tính:</span>
                        <span>2.790.000₫</span>
                    </div>
                    <div class="summary-item">
                        <span>Phí vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div class="summary-item">
                        <span>Tổng cộng:</span>
                        <span>2.790.000₫</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include_once('master/footer.php'); ?>
    
    </body>
</html>
