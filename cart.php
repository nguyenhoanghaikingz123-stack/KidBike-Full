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
    <div class="page-hero">
      <div class="container">
        <div class="breadcrumb"><a href="index.html">Trang chủ</a><span>/</span>Giỏ hàng</div>
        <h1>Giỏ hàng <span style="color:var(--primary)">của bạn</span> 🛒</h1>
        <p>Kiểm tra và hoàn tất đơn hàng của bạn</p>
      </div>
    </div>

    <!-- Cart Content -->
    <section class="section">
      <div class="container">
        <div class="cart-shopee-container">
          <!-- Cart Header -->
          <div class="cart-shopee-header">
            <div class="cart-shopee-title">
              <i class="fas fa-shopping-cart"></i>
              Giỏ hàng của bạn (<?php echo isset($total_items) ? $total_items : 0; ?> sản phẩm)
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
          <!-- EMPTY CART -->
          <div class="empty-cart" id="emptyCart" style="display:none;">
            <div class="empty-icon">🛒</div>
            <h2>Giỏ hàng của bạn đang trống</h2>
            <p>Hãy thêm những chiếc xe đạp tuyệt vời vào giỏ hàng nhé!</p>
            <a href="index.php?page=products" class="btn btn-primary"><i class="fas fa-bicycle"></i> Mua sắm ngay</a>
          </div>

          <!-- Hiển thị thông báo -->
          <?php if (!empty($message)): ?>
            <div class="alert alert-success">
              <?php echo htmlspecialchars($message); ?>
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
                            <div id="cartItemsList">
                              <?php
                              $grand_total = 0;
                              $grand_quantity = 0;
                              if (!empty($products)) {
                                foreach ($products as $product) {
                                  $quantity = $product['quantity'];
                                  $total = $product['prd_price'] * $quantity;
                                  $grand_total += $total;
                                  $grand_quantity += $quantity;
                              ?>
                                  <div class="cart-item fade-up" id="item-<?php echo $product['prd_id']; ?>">
                                    <div class="cart-item-info">
                                      <div class="cart-item-emoji">🚲</div>
                                      <div>
                                        <div class="cart-item-name"><?php echo htmlspecialchars($product['prd_name']); ?></div>
                                        <!-- <div class="cart-item-meta">Màu: <?php //echo htmlspecialchars($product['prd_color'] ?? 'Cam'); 
                                                                              ?> · Cỡ: <?php //echo htmlspecialchars($product['prd_size'] ?? '16"'); 
                                                                                        ?></div> -->
                                      </div>
                                    </div>
                                    <div class="cart-item-price"><?php echo number_format($product['prd_price'], 0, ',', '.'); ?>đ</div>
                                    <div class="cart-qty">

                                      <input type="number" value="<?php echo $quantity; ?>" min="1" max="<?= $product['prd_quantity']; ?>" onchange="setCartQty(<?php echo $product['prd_id']; ?>, this.value)" />

                                      <!-- Ảnh sản phẩm -->
                                      <div class="cart-shopee-image">
                                        <img src="admin/assets/images/<?php echo htmlspecialchars($item['prd_image']); ?>"
                                          alt="<?php echo htmlspecialchars($item['prd_name']); ?>">
                                      </div>
                                      <div class="cart-item-total"><?php echo number_format($total, 0, ',', '.'); ?>đ</div>
                                      <a href="del_cart.php?id=<?= $product['prd_id'];  ?>"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                <?php
                                }
                              }
                                ?>
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
                                    <div class="cart-footer-actions">
                                      <a href="index.php?page=products" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Tiếp tục mua</a>

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
                        <!-- ORDER SUMMARY -->
                        <div class="order-summary">
                          <h3>Tóm tắt đơn hàng</h3>

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
                              <?php
                              $total_amount = 0; // Initialize total_amount
                              if (!empty($cart_items)) {
                                foreach ($cart_items as $item) {
                                  $total_amount += $item['prd_price'] * $item['prd_quantity']; // Calculate total_amount based on cart items
                                }
                              }
                              ?>
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
                            <div class="summary-rows">
                              <div class="summary-row">
                                <span>Tạm tính (<span id="itemCount"><?= $grand_quantity ?></span> sản phẩm)</span>
                                <span id="subtotal"><?= $grand_total ?></span>
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
                              <div class="summary-total">
                                <span>Tổng cộng</span>
                                <span id="totalPrice"><?= $grand_total ?></span>
                              </div>

                              <!-- COUPON -->
                              <!-- <div class="coupon-section">
          <h4>Mã giảm giá</h4>
          <div class="coupon-input">
            <input type="text" placeholder="Nhập mã..." id="couponInput" />
            <button onclick="applyCoupon()">Áp dụng</button>
          </div>
        </form>
      <?php endif; ?>
          <small>Thử: <strong>KIDSBIKE2025</strong> (giảm 10%) hoặc <strong>FREESHIP</strong></small>
        </div> -->

                              <a class="btn btn-primary btn-block" href="index.php?page=checkout">
                                <i class="fas fa-credit-card"></i> Tiến hành thanh toán
                              </a>
                              <p class="secure-note"><i class="fas fa-lock"></i> Thanh toán an toàn & bảo mật</p>
                            </div>
                          </div>
                        </div>
    </section>
    <script src="js/common.js"></script>

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
</body>