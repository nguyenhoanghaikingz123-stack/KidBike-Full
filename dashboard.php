<?php
include_once('./admin/connect.php');
// Lấy 4 sản phẩm mới nhất / nổi bật nhất từ CSDL
$s_featured = "SELECT * FROM tbl_product 
                 JOIN tbl_category ON tbl_product.cate_id = tbl_category.cate_id
                 ORDER BY prd_id DESC LIMIT 4";
$q_featured = mysqli_query($connect, $s_featured);

$product_count_sql = "SELECT * FROM tbl_product";
$product_count_query = mysqli_query($connect, $product_count_sql);

?>


<section class="hero">
  <div class="hero-bg-decor">
    <div class="decor-circle c1"></div>
    <div class="decor-circle c2"></div>
    <div class="decor-circle c3"></div>
    <div class="decor-dots"></div>
  </div>
  <div class="container hero-inner">
    <div class="hero-content fade-up">
      <div class="hero-tag"><span>🎉</span> Bộ sưu tập 2025 đã ra mắt!</div>
      <h1 class="hero-title">
        Khám phá thế giới <span>xe đạp</span> dành cho bé yêu
      </h1>
      <p class="hero-subtitle">
        Hàng trăm mẫu xe đạp trẻ em chất lượng cao, an toàn tuyệt đối. Thiết
        kế đầy màu sắc, phù hợp mọi lứa tuổi từ 2–14 tuổi.
      </p>
      <div class="hero-actions">
        <a href="index.php?page=products" class="btn btn-primary">
          <i class="fas fa-bicycle"></i> Xem sản phẩm
        </a>
        <a href="index.php?page=about" class="btn btn-outline"> Tìm hiểu thêm </a>
      </div>
      <div class="hero-stats">
        <div class="stat">
          <strong><?= mysqli_num_rows($product_count_query); ?></strong>
          <span>Sản phẩm</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat">
          <strong>50K+</strong>
          <span>Khách hàng</span>
        </div>
        <div class="stat-divider"></div>
        <div class="stat">
          <strong>99%</strong>
          <span>Hài lòng</span>
        </div>
      </div>
    </div>
    <div class="hero-visual fade-up fade-up-delay-2">
      <div class="hero-bike-wrap">
        <div class="hero-bike-bg"></div>
        <div class="hero-bike">🚲</div>
        <div class="floating-badge b1">⭐ Bestseller</div>
        <div class="floating-badge b2">🔒 An toàn tuyệt đối</div>
        <div class="floating-badge b3">🎁 Free ship</div>
      </div>
    </div>
  </div>
</section>

<!-- ===== FEATURES ===== -->
<section class="features section">
  <div class="container">
    <div class="features-grid">
      <div class="feature-card fade-up">
        <div class="feature-icon">🛡️</div>
        <h3>An Toàn Tuyệt Đối</h3>
        <p>
          Tất cả sản phẩm đạt chuẩn an toàn quốc tế, được kiểm định nghiêm
          ngặt trước khi đến tay bé.
        </p>
      </div>
      <div class="feature-card fade-up fade-up-delay-1">
        <div class="feature-icon">🚚</div>
        <h3>Giao Hàng Toàn Quốc</h3>
        <p>
          Giao hàng nhanh 2–4 ngày, miễn phí vận chuyển cho đơn hàng từ
          500.000đ trên toàn quốc.
        </p>
      </div>
      <div class="feature-card fade-up fade-up-delay-2">
        <div class="feature-icon">🔄</div>
        <h3>Đổi Trả 30 Ngày</h3>
        <p>
          Không vừa ý? Đổi trả miễn phí trong vòng 30 ngày kể từ ngày mua
          hàng, không cần lý do.
        </p>
      </div>
      <div class="feature-card fade-up fade-up-delay-3">
        <div class="feature-icon">💬</div>
        <h3>Tư Vấn 24/7</h3>
        <p>
          Đội ngũ chuyên gia sẵn sàng tư vấn, hỗ trợ bạn chọn xe phù hợp
          nhất cho con yêu.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ===== CATEGORIES ===== -->
<section
  class="categories section"
  style="background: linear-gradient(135deg, #fff5f0 0%, #f0fffe 100%)">
  <div class="container">
    <div class="section-header center fade-up">
      <div class="section-tag">📂 Danh mục</div>
      <h2 class="section-title">Chọn xe theo <span>độ tuổi</span></h2>
      <p class="section-subtitle">
        Từng loại xe được thiết kế tối ưu cho từng giai đoạn phát triển của
        bé
      </p>
    </div>
    <div class="category-grid">
      <a
        href="index.php?page=products"
        class="category-card fade-up"
        style="--cat-color: #ff6b35">
        <div class="cat-icon">🏍️</div>
        <div class="cat-info">
          <h3>Xe Thăng Bằng</h3>
          <p>2 – 4 tuổi</p>
          <span class="cat-count">48 sản phẩm</span>
        </div>
        <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>
      <a
        href="index.php?page=products"
        class="category-card fade-up fade-up-delay-1"
        style="--cat-color: #4ecdc4">
        <div class="cat-icon">🚲</div>
        <div class="cat-info">
          <h3>Xe Bánh Phụ</h3>
          <p>4 – 6 tuổi</p>
          <span class="cat-count">62 sản phẩm</span>
        </div>
        <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>
      <a
        href="index.php?page=products"
        class="category-card fade-up fade-up-delay-2"
        style="--cat-color: #c3b1e1">
        <div class="cat-icon">🚵</div>
        <div class="cat-info">
          <h3>Xe Địa Hình</h3>
          <p>6 – 10 tuổi</p>
          <span class="cat-count">75 sản phẩm</span>
        </div>
        <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>
      <a
        href="index.php?page=products"
        class="category-card fade-up fade-up-delay-3"
        style="--cat-color: #ffe66d">
        <div class="cat-icon">🏆</div>
        <div class="cat-info">
          <h3>Xe Thể Thao</h3>
          <p>10 – 14 tuổi</p>
          <span class="cat-count">38 sản phẩm</span>
        </div>
        <div class="cat-arrow"><i class="fas fa-arrow-right"></i></div>
      </a>
    </div>
  </div>
</section>

<!-- ===== FEATURED PRODUCTS ===== -->
<section class="section" id="featured">
  <div class="container">
    <div
      class="section-header fade-up"
      style="
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 1rem;
          ">
      <div>
        <div class="section-tag">🔥 Nổi bật</div>
        <h2 class="section-title">Sản phẩm <span>bán chạy</span></h2>
      </div>
      <a href="index.php?page=products" class="btn btn-outline">Xem tất cả <i class="fas fa-arrow-right"></i></a>
    </div>
    <div class="products-grid" id="featuredProducts">
      <?php
      // Kiểm tra xem có sản phẩm nào không
      if (mysqli_num_rows($q_featured) > 0) {
        while ($row = mysqli_fetch_array($q_featured)) {
      ?>
          <div class="product-card" onclick="window.location.href='index.php?page=product-detail&prd_id=<?= $row['prd_id'] ?>'" style="cursor: pointer;">
            <span class="badge">🔥 Bán chạy</span>
            <img src="admin/assets/images/<?= $row['prd_image'] ?>" alt="<?= $row['prd_name'] ?>" />

            <h3><?= $row['prd_name'] ?></h3>
            <p><?= $row['cate_name'] ?></p>

            <div class="price">
              <span class="current"><?= number_format($row['prd_price'], 0, ',', '.') ?>đ</span>
            </div>

            <button class="btn btn-primary">Mua ngay</button>
          </div>
      <?php
        }
      } else {
        echo "<p>Chưa có sản phẩm nào.</p>";
      }
      ?>
    </div>


  </div>
  </div>
</section>

<!-- ===== BANNER PROMO ===== -->
<section class="promo-banner fade-up">
  <div class="container">
    <div class="promo-inner">
      <div class="promo-content">
        <div
          class="section-tag"
          style="background: rgba(255, 255, 255, 0.2); color: white">
          🎉 Ưu đãi đặc biệt
        </div>
        <h2>Giảm đến <span>40%</span> cho đơn đầu tiên!</h2>
        <p>
          Nhập mã <strong>KIDSBIKE2025</strong> khi thanh toán để nhận ưu
          đãi độc quyền
        </p>
        <a href="index.php?page=products" class="btn btn-white">Mua ngay <i class="fas fa-tag"></i></a>
      </div>
      <div class="promo-visual">🎁🚲🎉</div>
    </div>
  </div>
</section>

<!-- ===== TESTIMONIALS ===== -->
<section class="section testimonials">
  <div class="container">
    <div class="section-header center fade-up">
      <div class="section-tag">💬 Đánh giá</div>
      <h2 class="section-title">
        Phụ huynh <span>nói gì</span> về chúng tôi
      </h2>
    </div>
    <div class="testimonials-grid">
      <div class="testimonial-card fade-up">
        <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
        <p>
          "Con tôi mê chiếc xe địa hình này lắm! Chất lượng cực tốt, bé đạp
          từ sáng đến tối không chán. Giao hàng nhanh, đóng gói cẩn thận."
        </p>
        <div class="testimonial-author">
          <div class="author-avatar">👩</div>
          <div>
            <strong>Nguyễn Thị Mai</strong>
            <span>Hà Nội · Mẹ bé 7 tuổi</span>
          </div>
        </div>
      </div>
      <div class="testimonial-card fade-up fade-up-delay-1">
        <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
        <p>
          "Shop tư vấn nhiệt tình, giúp tôi chọn được xe phù hợp với con. Bé
          học đạp rất nhanh nhờ xe thăng bằng. Sẽ quay lại mua!"
        </p>
        <div class="testimonial-author">
          <div class="author-avatar">👨</div>
          <div>
            <strong>Trần Văn Hùng</strong>
            <span>TP.HCM · Ba bé 3 tuổi</span>
          </div>
        </div>
      </div>
      <div class="testimonial-card fade-up fade-up-delay-2">
        <div class="testimonial-stars">⭐⭐⭐⭐⭐</div>
        <p>
          "Giá cả hợp lý, chất lượng vượt mong đợi. Xe rất bền, sau 1 năm
          vẫn chạy tốt. Đã giới thiệu cho nhiều bạn bè mua rồi!"
        </p>
        <div class="testimonial-author">
          <div class="author-avatar">👩</div>
          <div>
            <strong>Lê Thị Hoa</strong>
            <span>Đà Nẵng · Mẹ bé 9 tuổi</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>