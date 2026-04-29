<?php
// Lấy prd_id từ URL
if(isset($_GET['prd_id'])){
    $prd_id = intval($_GET['prd_id']);
    $s_product = "SELECT * FROM tbl_product
                  JOIN tbl_category ON tbl_product.cate_id = tbl_category.cate_id
                  WHERE tbl_product.prd_id = $prd_id";
    $q_product = mysqli_query($connect, $s_product);
    $product = mysqli_fetch_array($q_product);

    if(!$product){
        echo "<script>window.location.href='index.php'</script>";
        exit();
    }
} else {
    echo "<script>window.location.href='index.php'</script>";
    exit();
}
?>

<div style="height:72px;"></div>

<section class="section">
  <div class="container">
    <div class="breadcrumb" style="margin-bottom:2rem;">
      <a href="index.html">Trang chủ</a><span>/</span>
      <a href="products.html">Sản phẩm</a><span>/</span>
      <span id="pdBreadcrumb">Chi tiết sản phẩm</span>
    </div>

    <div class="pd-layout">
      <!-- LEFT: GALLERY -->
      <div class="pd-gallery fade-up">
        <div class="pd-main-img" id="pdMainImg">
          <img src="admin/assets/images/<?= $product['prd_image'] ?>" alt="<?= $product['prd_name'] ?>" style="width:100%;height:100%;object-fit:cover;" />
        </div>
        <div class="pd-thumbs">
          <div class="pd-thumb active" onclick="selectThumb(this, 'admin/assets/images/<?= $product['prd_image'] ?>')">
            <img src="admin/assets/images/<?= $product['prd_image'] ?>" alt="<?= $product['prd_name'] ?>" />
          </div>
        </div>
      </div>

      <!-- RIGHT: INFO -->
      <div class="pd-info fade-up fade-up-delay-1">
        <div class="pd-category" id="pdCategory"><?= $product['cate_name'] ?></div>
        <h1 class="pd-title" id="pdTitle"><?= $product['prd_name'] ?></h1>
        <div class="pd-rating">
          <span class="stars">⭐⭐⭐⭐⭐</span>
          <span class="pd-rating-count" id="pdRating">5.0 (0 đánh giá)</span>
          <span class="pd-sold">· Đã bán 0+</span>
        </div>

        <div class="pd-price-block">
          <span class="pd-price-current" id="pdPrice"><?= number_format($product['prd_price'], 0, ',', '.') ?>đ</span>
        </div>

        <div class="pd-colors">
          <h4>Màu sắc:</h4>
          <div class="color-options">
            <button class="color-opt active" style="background:#FF6B35;" title="Cam" onclick="selectColor(this)"></button>
            <button class="color-opt" style="background:#4ECDC4;" title="Xanh ngọc" onclick="selectColor(this)"></button>
            <button class="color-opt" style="background:#C3B1E1;" title="Tím" onclick="selectColor(this)"></button>
            <button class="color-opt" style="background:#FFE66D;" title="Vàng" onclick="selectColor(this)"></button>
            <button class="color-opt" style="background:#FF9AA2;" title="Hồng" onclick="selectColor(this)"></button>
          </div>
        </div>

        <div class="pd-size">
          <h4>Cỡ bánh xe:</h4>
          <div class="size-options">
            <button class="size-opt active" onclick="selectSize(this)">12"</button>
            <button class="size-opt" onclick="selectSize(this)">14"</button>
            <button class="size-opt" onclick="selectSize(this)">16"</button>
            <button class="size-opt" onclick="selectSize(this)">20"</button>
          </div>
        </div>

        <div class="pd-qty">
          <h4>Số lượng:</h4>
          <div class="qty-control">
            <button onclick="changeQty(-1)">−</button>
            <input type="number" value="1" min="1" max="10" id="qtyInput" />
            <button onclick="changeQty(1)">+</button>
          </div>
          <span class="stock-info">✅ Còn hàng</span>
        </div>

        <div class="pd-actions">
          <button class="btn btn-primary btn-lg" onclick="handleAddToCart()">
            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
          </button>
          <button class="btn btn-secondary btn-lg" onclick="handleBuyNow()">
            <i class="fas fa-bolt"></i> Mua ngay
          </button>
          <button class="btn-wish" id="wishBtn" onclick="handleWish()">
            <i class="fas fa-heart"></i>
          </button>
        </div>

        <div class="pd-guarantees">
          <div class="guarantee-item"><i class="fas fa-shield-alt"></i> Bảo hành 24 tháng</div>
          <div class="guarantee-item"><i class="fas fa-truck"></i> Miễn phí giao hàng</div>
          <div class="guarantee-item"><i class="fas fa-undo"></i> Đổi trả 30 ngày</div>
          <div class="guarantee-item"><i class="fas fa-phone"></i> Hỗ trợ 24/7</div>
        </div>
      </div>
    </div>

    <!-- TABS -->
    <div class="pd-tabs" style="margin-top:3rem;">
      <div class="tabs-nav">
        <button class="tab-btn active" onclick="switchTab(this, 'desc')">Mô tả sản phẩm</button>
        <button class="tab-btn" onclick="switchTab(this, 'specs')">Thông số kỹ thuật</button>
        <button class="tab-btn" onclick="switchTab(this, 'reviews')">Đánh giá (87)</button>
      </div>

      <div class="tab-content active" id="tab-desc">
        <h3><?= $product['prd_name'] ?> - Người bạn đồng hành lý tưởng của bé</h3>
        <p><?= $product['prd_description'] ?? 'Sản phẩm chất lượng cao, phù hợp cho bé yêu của bạn.' ?></p>
      </div>

      <div class="tab-content" id="tab-specs">
        <table class="specs-table">
          <tr><th>Trọng lượng xe</th><td>8.5 kg</td></tr>
          <tr><th>Tải trọng tối đa</th><td>60 kg</td></tr>
          <tr><th>Cỡ bánh</th><td>12" / 14" / 16" / 20"</td></tr>
          <tr><th>Chất liệu khung</th><td>Hợp kim nhôm 6061</td></tr>
          <tr><th>Hệ thống phanh</th><td>Phanh đĩa cơ học</td></tr>
          <tr><th>Số cấp tốc độ</th><td>7 cấp (Shimano)</td></tr>
          <tr><th>Chiều cao yên</th><td>55 – 75 cm (điều chỉnh)</td></tr>
          <tr><th>Màu sắc có sẵn</th><td>Cam, Xanh ngọc, Tím, Vàng, Hồng</td></tr>
          <tr><th>Xuất xứ</th><td>Đài Loan</td></tr>
          <tr><th>Bảo hành</th><td>24 tháng</td></tr>
        </table>
      </div>

      <div class="tab-content" id="tab-reviews">
        <div class="reviews-summary">
          <div class="reviews-score">
            <strong>4.9</strong>
            <span>⭐⭐⭐⭐⭐</span>
            <small>87 đánh giá</small>
          </div>
          <div class="reviews-bars">
            <div class="review-bar"><span>5 ⭐</span><div class="bar"><div style="width:82%"></div></div><span>82%</span></div>
            <div class="review-bar"><span>4 ⭐</span><div class="bar"><div style="width:12%"></div></div><span>12%</span></div>
            <div class="review-bar"><span>3 ⭐</span><div class="bar"><div style="width:4%"></div></div><span>4%</span></div>
            <div class="review-bar"><span>2 ⭐</span><div class="bar"><div style="width:1%"></div></div><span>1%</span></div>
            <div class="review-bar"><span>1 ⭐</span><div class="bar"><div style="width:1%"></div></div><span>1%</span></div>
          </div>
        </div>
        <div class="reviews-list">
          <div class="review-item">
            <div class="review-header">
              <div class="reviewer">👩 <strong>Nguyễn Thị Mai</strong></div>
              <span>⭐⭐⭐⭐⭐</span>
            </div>
            <p>Con trai 8 tuổi của tôi mê chiếc xe này lắm! Đạp trên đường đất rất ổn định, phanh nhạy. Giao hàng nhanh, đóng gói cẩn thận.</p>
            <small>20/03/2025</small>
          </div>
          <div class="review-item">
            <div class="review-header">
              <div class="reviewer">👨 <strong>Trần Văn Hùng</strong></div>
              <span>⭐⭐⭐⭐⭐</span>
            </div>
            <p>Chất lượng tốt, xe chắc chắn. Bé 7 tuổi nhà mình học đạp rất nhanh. Màu cam đẹp như hình. Rất hài lòng!</p>
            <small>15/02/2025</small>
          </div>
        </div>
      </div>
    </div>

    <!-- RELATED PRODUCTS -->
    <div style="margin-top:4rem;">
      <h2 class="section-title fade-up">Sản phẩm <span>liên quan</span></h2>
      <div class="products-grid" id="relatedProducts" style="margin-top:1.5rem;"></div>
    </div>
  </div>
</section>



<script src="js/common.js"></script>
<script src="js/product-detail.js"></script>
</body>

