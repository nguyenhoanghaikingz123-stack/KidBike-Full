<?php

$s_prd = "SELECT * FROM tbl_product 
            JOIN tbl_category ON tbl_product.cate_id = tbl_category.cate_id
            ORDER BY prd_id ASC LIMIT 12";
$q_prd = mysqli_query($connect, $s_prd);
?>

<div class="page-hero">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.html">Trang chủ</a><span>/</span>Sản phẩm
    </div>
    <h1>Tất cả <span style="color: var(--primary)">sản phẩm</span> 🚲</h1>
    <p>
      Khám phá hơn 500 mẫu xe đạp trẻ em chất lượng cao, phù hợp mọi lứa
      tuổi
    </p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="products-layout">
      <!-- SIDEBAR FILTER -->
      <aside class="filter-sidebar fade-up">
        <div class="filter-header">
          <h3><i class="fas fa-sliders-h"></i> Bộ lọc</h3>
          <button class="btn-clear" onclick="clearFilters()">
            Xóa tất cả
          </button>
        </div>

        <div class="filter-group">
          <h4>Danh mục</h4>
          <label class="filter-check"><input
              type="checkbox"
              value="all"
              checked
              onchange="filterProducts()"
              name="cat" />
            Tất cả</label>
          <label class="filter-check"><input
              type="checkbox"
              value="thang-bang"
              onchange="filterProducts()"
              name="cat" />
            🏍️ Xe thăng bằng</label>
          <label class="filter-check"><input
              type="checkbox"
              value="banh-phu"
              onchange="filterProducts()"
              name="cat" />
            🚲 Xe bánh phụ</label>
          <label class="filter-check"><input
              type="checkbox"
              value="dia-hinh"
              onchange="filterProducts()"
              name="cat" />
            🚵 Xe địa hình</label>
          <label class="filter-check"><input
              type="checkbox"
              value="the-thao"
              onchange="filterProducts()"
              name="cat" />
            🏆 Xe thể thao</label>
        </div>

        <div class="filter-group">
          <h4>Độ tuổi</h4>
          <label class="filter-check"><input
              type="checkbox"
              value="2-4"
              onchange="filterProducts()"
              name="age" />
            2 – 4 tuổi</label>
          <label class="filter-check"><input
              type="checkbox"
              value="4-6"
              onchange="filterProducts()"
              name="age" />
            4 – 6 tuổi</label>
          <label class="filter-check"><input
              type="checkbox"
              value="6-10"
              onchange="filterProducts()"
              name="age" />
            6 – 10 tuổi</label>
          <label class="filter-check"><input
              type="checkbox"
              value="10-14"
              onchange="filterProducts()"
              name="age" />
            10 – 14 tuổi</label>
        </div>

        <div class="filter-group">
          <h4>Khoảng giá</h4>
          <input
            type="range"
            min="500000"
            max="5000000"
            step="100000"
            value="5000000"
            id="priceRange"
            oninput="updatePriceLabel(this.value)" />
          <div class="price-range-label">
            Đến: <strong id="priceLabel">5,000,000đ</strong>
          </div>
        </div>

        <div class="filter-group">
          <h4>Đánh giá</h4>
          <label class="filter-check"><input
              type="radio"
              name="rating"
              value="0"
              checked
              onchange="filterProducts()" />
            Tất cả</label>
          <label class="filter-check"><input
              type="radio"
              name="rating"
              value="4"
              onchange="filterProducts()" />
            ⭐ 4+ sao</label>
          <label class="filter-check"><input
              type="radio"
              name="rating"
              value="4.5"
              onchange="filterProducts()" />
            ⭐ 4.5+ sao</label>
        </div>
      </aside>

      <!-- PRODUCTS MAIN -->
      <class="products-main">
        <div class="products-toolbar fade-up">
          <span id="resultCount">Hiển thị 12 sản phẩm</span>
          <div class="toolbar-right">
            <select id="sortSelect" onchange="sortProducts()">
              <option value="default">Mặc định</option>
              <option value="price-asc">Giá tăng dần</option>
              <option value="price-desc">Giá giảm dần</option>
              <option value="rating">Đánh giá cao nhất</option>
              <option value="newest">Mới nhất</option>
            </select>
            <div class="view-toggle">
              <button
                class="view-btn active"
                id="gridViewBtn"
                onclick="setView('grid')">
                <i class="fas fa-th"></i>
              </button>
              <button
                class="view-btn"
                id="listViewBtn"
                onclick="setView('list')">
                <i class="fas fa-list"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Add Product -->
        <div class="products-grid">
          <?php
          // Duyệt dữ liệu từ CSDL
          while ($row = mysqli_fetch_array($q_prd)) {
          ?>
            <a href="index.php?page=product-detail&prd_id=<?= $row['prd_id'] ?>" class="product-card" style="text-decoration: none; color: inherit; display: block;">
              <img src="admin/assets/images/<?= $row['prd_image'] ?>" alt="<?= $row['prd_name'] ?>" />

              <h3><?= $row['prd_name'] ?></h3>

              <p><?= $row['cate_name'] ?></p>

              <div class="price">
                <span class="current"><?= number_format($row['prd_price'], 0, ',', '.') ?>đ</span>
              </div>

              <button class="btn btn-primary">Mua ngay</button>
            </a>
          <?php } ?>
        </div>
        <!-- End Add Product -->

        <div class="pagination" id="pagination"></div>
    </div>
  </div>
  </div>
</section>


<script src="js/common.js"></script>
<script src="js/products.js"></script>
</body>