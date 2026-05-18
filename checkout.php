<?php
include_once('./admin/connect.php');
// 1. Kiểm tra nếu giỏ hàng có đồ thì mới xử lý, không sẽ bị lỗi SQL
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    $arr_id = []; // Khởi tạo mảng để chứa ID
    foreach ($_SESSION['cart'] as $id_san_pham => $so_luong) {
        $arr_id[] = $id_san_pham; // Nhét từng ID vào mảng
    }

    // 2. Biến mảng [1, 2, 3] thành chuỗi "1, 2, 3" để nhét vào câu SQL
    $ids = implode(', ', $arr_id);

    // 3. Lấy tất cả sản phẩm có ID nằm trong danh sách trên
    $sql = "SELECT * FROM tbl_product WHERE prd_id IN ($ids)";
    $query = mysqli_query($connect, $sql);

    // 4. Đổ dữ liệu từ SQL vào mảng $products
    $products = [];
    while ($row = mysqli_fetch_assoc($query)) {
        // Lấy số lượng từ Session dựa theo ID của sản phẩm đang lặp
        $row['quantity'] = $_SESSION['cart'][$row['prd_id']];

        // Cất con xe này vào mảng $products
        $products[] = $row;
    }
}





?>

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
                        <div class="payment-methods">
                            <div class="payment-option" data-method="cod">
                                <i class="fas fa-money-bill-wave"></i>
                                <div>Thanh toán khi nhận hàng (COD)</div>
                            </div>
                            <div class="payment-option" data-method="banking">
                                <i class="fas fa-university"></i>
                                <div>Chuyển khoản ngân hàng</div>
                            </div>
                        </div>
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
                    <?php
                    $grand_total = 0;
                    if (!empty($products)) {
                        foreach ($products as $item) {
                            // SỬA LỖI 1: Dùng $item['quantity'] thay vì prd_quantity
                            $total = $item['prd_price'] * $item['quantity'];
                            $grand_total += $total;
                    ?>
                            <div class="checkout-product">
                                <img src="admin/assets/images/<?= $item['prd_image']; ?>">
                                <div class="checkout-product-info">
                                    <div class="checkout-product-name"><?= $item['prd_name']; ?></div>
                                    <div class="checkout-product-price"><?= number_format($item['prd_price'], 0, ',', '.'); ?>đ</div>
                                    <div class="checkout-product-quantity">SL: <?= $item['quantity']; ?></div>
                                </div>
                                <div class="checkout-product-total"><?= number_format($total, 0, ',', '.'); ?>đ</div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="summary-item">
                    <span>Tạm tính:</span>
                    <span><?= number_format($grand_total, 0, ',', '.'); ?>đ</span>
                </div>
                <div class="summary-item">
                    <span>Phí vận chuyển:</span>
                    <span>Miễn phí</span>
                </div>
                <div class="summary-item" style="font-weight: bold; font-size: 1.2rem; color: var(--primary);">
                    <span>Tổng cộng:</span>
                    <span><?= number_format($grand_total, 0, ',', '.'); ?>đ</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include_once('master/footer.php'); ?>

</body>

</html>