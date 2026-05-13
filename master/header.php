<?php
session_start();
include_once('admin/connect.php');

$s_cate = "SELECT * FROM tbl_category ORDER BY cate_id ASC LIMIT 4";
$q_cate = mysqli_query($connect, $s_cate);

$current_page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Tính số lượng sản phẩm trong giỏ hàng
$cart_count = 0;
if (isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $item) {
    $cart_count += $item['prd_quantity'];
  }
}
?>

<nav class="navbar">
  <a href="index.php" class="nav-logo">
    <div class="logo-icon">🚲</div>
    Kids<span>Bike</span>
  </a>
  <ul class="nav-menu">
    <li><a href="index.php?page=dashboard" class="nav-link <?= ($current_page == 'dashboard') ? 'active' : '' ?>">Trang chủ</a></li>
    <li><a href="index.php?page=about" class="nav-link <?= ($current_page == 'about') ? 'active' : '' ?>">Giới thiệu</a></li>
    <li><a href="index.php?page=products" class="nav-link <?= ($current_page == 'products' || $current_page == 'product-detail') ? 'active' : '' ?>">Sản phẩm</a></li>
    <li><a href="index.php?page=contact" class="nav-link <?= ($current_page == 'contact') ? 'active' : '' ?>">Liên hệ</a></li>
  </ul>
  <div class="nav-actions">
    <a href="index.php?page=search" class="nav-icon-btn <?= ($current_page == 'search') ? 'active' : '' ?>"><i class="fas fa-search"></i></a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="order-history.php" class="nav-icon-btn <?= (basename($_SERVER['PHP_SELF']) == 'order-history.php') ? 'active' : '' ?>" style="background: #3b82f6; color: white; font-weight: bold; padding: 8px 16px; border-radius: 8px;">
        📋 Lịch sử
      </a>
    <?php else: ?>
      <a href="order-search.php" class="nav-icon-btn <?= (basename($_SERVER['PHP_SELF']) == 'order-search.php') ? 'active' : '' ?>"><i class="fas fa-clipboard-list"></i></a>
    <?php endif; ?>
    <a href="index.php?page=cart" class="nav-icon-btn <?= ($current_page == 'cart') ? 'active' : '' ?>">
      <i class="fas fa-shopping-cart"></i>
      <span class="badge cart-badge"><?php echo $cart_count; ?></span>
    </a>
    <?php if (isset($_SESSION['user_id'])): ?>
      <a href="profile.php" class="btn-login">Tài khoản</a>
      <a href="logout.php" class="btn-register">Đăng xuất</a>
    <?php else: ?>
      <a href="login.php" class="btn-login">Đăng nhập</a>
      <a href="login.php" class="btn-register">Đăng ký</a>
    <?php endif; ?>
    <a href="index.php?page=products" class="btn btn-primary">Mua ngay</a>
  </div>
  <button class="nav-hamburger">
    <span></span><span></span><span></span>
  </button>
</nav>

<div class="nav-mobile">
  <a href="index.php" class="nav-link <?= ($current_page == 'index') ? 'active' : '' ?>">🏠 Trang chủ</a>
  <a href="index.php?page=about" class="nav-link <?= ($current_page == 'about') ? 'active' : '' ?>">ℹ️ Giới thiệu</a>
  <a href="index.php?page=products" class="nav-link <?= ($current_page == 'products' || $current_page == 'product-detail') ? 'active' : '' ?>">🛍️ Sản phẩm</a>
  <a href="index.php?page=contact" class="nav-link <?= ($current_page == 'contact') ? 'active' : '' ?>">📞 Liên hệ</a>
  <?php if (isset($_SESSION['user_id'])): ?>
    <a href="order-history.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'order-history.php') ? 'active' : '' ?>" style="background: #3b82f6; color: white; font-weight: bold;">📋 Lịch sử đơn hàng</a>
  <?php else: ?>
    <a href="order-search.php" class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'order-search.php') ? 'active' : '' ?>">📋 Tra cứu đơn hàng</a>
  <?php endif; ?>
  <a href="index.php?page=cart" class="nav-link <?= ($current_page == 'cart') ? 'active' : '' ?>">🛒 Giỏ hàng</a>
</div>