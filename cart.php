<?php
//$ids = '';
foreach ($_SESSION['cart'] as $item => $quantity){
  //$ids .= $item . ", ";
  $arr_id[] = $item;
}
$ids = implode(', ', $arr_id);
$sql = "SELECT * FROM tbl_product WHERE `prd_id` IN($ids)";
$query = mysqli_query($connect, $sql);


?>

<div class="page-hero">
  <div class="container">
    <div class="breadcrumb"><a href="index.html">Trang chủ</a><span>/</span>Giỏ hàng</div>
    <h1>Giỏ hàng <span style="color:var(--primary)">của bạn</span> 🛒</h1>
    <p>Kiểm tra và hoàn tất đơn hàng của bạn</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- EMPTY CART -->
    <div class="empty-cart" id="emptyCart" style="display:none;">
      <div class="empty-icon">🛒</div>
      <h2>Giỏ hàng của bạn đang trống</h2>
      <p>Hãy thêm những chiếc xe đạp tuyệt vời vào giỏ hàng nhé!</p>
      <a href="index.php?page=products" class="btn btn-primary"><i class="fas fa-bicycle"></i> Mua sắm ngay</a>
    </div>

    <!-- CART CONTENT -->
    <div class="cart-layout" id="cartContent">
      <!-- CART ITEMS -->
      <div class="cart-items-wrap">
        <div class="cart-header-row">
          <span>Sản phẩm</span>
          <span>Đơn giá</span>
          <span>Số lượng</span>
          <span>Thành tiền</span>
          <span></span>
        </div>
        <div id="cartItemsList">
<?php
if (!empty($products)) {
    foreach ($products as $product) {
        $quantity = $product['quantity'];
        $total = $product['prd_price'] * $quantity;
        ?>
        <div class="cart-item fade-up" id="item-<?php echo $product['prd_id']; ?>">
            <div class="cart-item-info">
                <div class="cart-item-emoji">🚲</div>
                <div>
                    <div class="cart-item-name"><?php echo htmlspecialchars($product['prd_name']); ?></div>
                    <div class="cart-item-meta">Màu: <?php echo htmlspecialchars($product['prd_color'] ?? 'Cam'); ?> · Cỡ: <?php echo htmlspecialchars($product['prd_size'] ?? '16"'); ?></div>
                </div>
            </div>
            <div class="cart-item-price"><?php echo number_format($product['prd_price'],0,',','.'); ?>đ</div>
            <div class="cart-qty">
                <button onclick="changeCartQty(<?php echo $product['prd_id']; ?>, -1)">−</button>
                <input type="number" value="<?php echo $quantity; ?>" min="1" max="10" onchange="setCartQty(<?php echo $product['prd_id']; ?>, this.value)" />
                <button onclick="changeCartQty(<?php echo $product['prd_id']; ?>, 1)">+</button>
            </div>
            <div class="cart-item-total"><?php echo number_format($total,0,',','.'); ?>đ</div>
            <button class="cart-item-remove" onclick="handleRemove(<?php echo $product['prd_id']; ?>)" title="Xóa"><i class="fas fa-trash-alt"></i></button>
        </div>
        <?php
    }
}
?>
</div>

        <div class="cart-footer-actions">
          <a href="index.php?page=products" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Tiếp tục mua</a>
          <button class="btn btn-outline" onclick="clearAllCart()" style="color:var(--gray); border-color:var(--gray);">
            <i class="fas fa-trash"></i> Xóa tất cả
          </button>
        </div>
      </div>

      <!-- ORDER SUMMARY -->
      <div class="order-summary">
        <h3>Tóm tắt đơn hàng</h3>

        <div class="summary-rows">
          <div class="summary-row">
            <span>Tạm tính (<span id="itemCount">0</span> sản phẩm)</span>
            <span id="subtotal">0đ</span>
          </div>
          <div class="summary-row">
            <span>Phí vận chuyển</span>
            <span id="shipping">Miễn phí</span>
          </div>
          <div class="summary-row discount-row" id="discountRow" style="display:none;">
            <span>Giảm giá (mã: <strong id="appliedCode"></strong>)</span>
            <span id="discountAmt" style="color:var(--primary);">-0đ</span>
          </div>
        </div>

        <div class="summary-total">
          <span>Tổng cộng</span>
          <span id="totalPrice">0đ</span>
        </div>

        <!-- COUPON -->
        <div class="coupon-section">
          <h4>Mã giảm giá</h4>
          <div class="coupon-input">
            <input type="text" placeholder="Nhập mã..." id="couponInput" />
            <button onclick="applyCoupon()">Áp dụng</button>
          </div>
          <small>Thử: <strong>KIDSBIKE2025</strong> (giảm 10%) hoặc <strong>FREESHIP</strong></small>
        </div>

        <button class="btn btn-primary btn-block" onclick="handleCheckout()">
          <i class="fas fa-credit-card"></i> Tiến hành thanh toán
        </button>

        <div class="payment-icons">
          <span>💳</span><span>🏦</span><span>📱</span><span>💰</span>
        </div>
        <p class="secure-note"><i class="fas fa-lock"></i> Thanh toán an toàn & bảo mật</p>
      </div>
    </div>
  </div>
</section>

<!-- CHECKOUT MODAL -->
<div class="modal-overlay" id="checkoutModal">
  <div class="modal">
    <button class="modal-close" onclick="closeModal()"><i class="fas fa-times"></i></button>
    <div class="modal-icon">🎉</div>
    <h2>Đặt hàng thành công!</h2>
    <p>Cảm ơn bạn đã mua hàng tại KidsBike! Đơn hàng của bạn đang được xử lý.</p>
    <p>Mã đơn hàng: <strong id="orderCode"></strong></p>
    <p style="font-size:0.88rem; color:var(--gray);">Chúng tôi sẽ liên hệ xác nhận trong vòng 30 phút.</p>
    <div style="display:flex; gap:10px; justify-content:center; margin-top:1.5rem;">
      <a href="index.html" class="btn btn-primary">Về trang chủ</a>
      <a href="products.html" class="btn btn-outline">Mua thêm</a>
    </div>
  </div>
</div>



<script src="js/common.js"></script>

</body>

