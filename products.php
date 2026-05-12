<?php
include_once(__DIR__ . "/admin/connect.php");

// Phân trang
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
$per_page = 12; // Số sản phẩm mỗi trang
$start = ($page - 1) * $per_page;

// Đếm tổng số sản phẩm
$count_sql = "SELECT COUNT(*) as total FROM tbl_product";
$count_result = mysqli_query($connect, $count_sql);
$total_row = mysqli_fetch_array($count_result);
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $per_page);

// Xây dựng query SQL với filters
$sql_conditions = [];
$params = [];

// Filter theo danh mục
if (isset($_GET['cat']) && $_GET['cat'] !== 'all') {
    $cat_ids = explode(',', $_GET['cat']);
    $cat_placeholders = implode(',', array_fill(0, count($cat_ids), '?'));
    $sql_conditions[] = "p.cate_id IN (" . implode(',', $cat_ids) . ")";
    $params[] = "cat=" . $_GET['cat'];
}

// Filter theo độ tuổi
if (isset($_GET['age'])) {
    $age_ranges = explode(',', $_GET['age']);
    $age_conditions = [];
    foreach ($age_ranges as $range) {
        switch ($range) {
            case '2-4':
                $age_conditions[] = "(p.prd_price BETWEEN 500000 AND 1500000)";
                break;
            case '4-6':
                $age_conditions[] = "(p.prd_price BETWEEN 800000 AND 2500000)";
                break;
            case '6-10':
                $age_conditions[] = "(p.prd_price BETWEEN 1000000 AND 3500000)";
                break;
            case '10-14':
                $age_conditions[] = "(p.prd_price BETWEEN 2000000 AND 5000000)";
                break;
        }
    }
    if (!empty($age_conditions)) {
        $sql_conditions[] = "(" . implode(' OR ', $age_conditions) . ")";
        $params[] = "age=" . $_GET['age'];
    }
}

// Filter theo tính năng
if (isset($_GET['feature'])) {
    $features = explode(',', $_GET['feature']);
    $feature_conditions = [];
    foreach ($features as $feature) {
        switch ($feature) {
            case 'giam-xe':
                $feature_conditions[] = "p.prd_name LIKE '%giảm xóc%'";
                break;
            case 'phanh-thep':
                $feature_conditions[] = "p.prd_name LIKE '%phanh thép%'";
                break;
            case 'den-hoa':
                $feature_conditions[] = "p.prd_name LIKE '%đèn hoa%'";
                break;
            case 'tui-xe':
                $feature_conditions[] = "p.prd_name LIKE '%túi xe%'";
                break;
        }
    }
    if (!empty($feature_conditions)) {
        $sql_conditions[] = "(" . implode(' OR ', $feature_conditions) . ")";
        $params[] = "feature=" . $_GET['feature'];
    }
}

// Filter theo khoảng giá
if (isset($_GET['priceMin']) || isset($_GET['priceMax'])) {
    $price_conditions = [];
    if (isset($_GET['priceMin']) && is_numeric($_GET['priceMin'])) {
        $price_conditions[] = "p.prd_price >= " . intval($_GET['priceMin']);
        $params[] = "priceMin=" . $_GET['priceMin'];
    }
    if (isset($_GET['priceMax']) && is_numeric($_GET['priceMax'])) {
        $price_conditions[] = "p.prd_price <= " . intval($_GET['priceMax']);
        $params[] = "priceMax=" . $_GET['priceMax'];
    }
    if (!empty($price_conditions)) {
        $sql_conditions[] = "(" . implode(' AND ', $price_conditions) . ")";
    }
}

// Filter theo đánh giá (giả định có cột rating)
if (isset($_GET['rating']) && $_GET['rating'] !== '0') {
    $rating_value = floatval($_GET['rating']);
    $sql_conditions[] = "p.prd_price >= " . ($rating_value * 500000) . " AND p.prd_price <= " . (($rating_value + 1) * 500000);
    $params[] = "rating=" . $_GET['rating'];
}

// Xây dựng query hoàn chỉnh
$where_clause = !empty($sql_conditions) ? " WHERE " . implode(' AND ', $sql_conditions) : "";
$order_by = " ORDER BY prd_id ASC";

if (isset($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price-asc':
            $order_by = " ORDER BY p.prd_price ASC";
            break;
        case 'price-desc':
            $order_by = " ORDER BY p.prd_price DESC";
            break;
        case 'rating':
            $order_by = " ORDER BY p.prd_price DESC";
            break;
        case 'newest':
            $order_by = " ORDER BY p.prd_id DESC";
            break;
        default:
            $order_by = " ORDER BY prd_id ASC";
    }
    $params[] = "sort=" . $_GET['sort'];
}

// Query cuối cùng
$s_prd = "SELECT p.*, c.cate_name FROM tbl_product p 
          JOIN tbl_category c ON p.cate_id = c.cate_id" . 
          $where_clause . 
          $order_by . 
          " LIMIT $start, $per_page";
$q_prd = mysqli_query($connect, $s_prd);
?>

<div class="page-hero">
  <div class="container">
    <div class="breadcrumb">
      <a href="index.php">Trang chủ</a><span>/</span>Sản phẩm
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
          <h3><i class="fas fa-sliders-h"></i> Bộ lọc sản phẩm</h3>
          <button class="btn-clear" onclick="clearFilters()">
            <i class="fas fa-redo"></i> Đặt lại
          </button>
        </div>

        <div class="filter-group">
          <h4><i class="fas fa-tags"></i> Danh mục</h4>
          <div class="filter-options">
            <label class="filter-check">
              <input type="checkbox" value="all" checked onchange="filterProducts()" name="cat">
              <span>Tất cả</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="1" onchange="filterProducts()" name="cat">
              <span>🏍️ Xe thăng bằng</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="2" onchange="filterProducts()" name="cat">
              <span>🚲 Xe bánh phụ</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="3" onchange="filterProducts()" name="cat">
              <span>🚵 Xe địa hình</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="4" onchange="filterProducts()" name="cat">
              <span>🏆 Xe thể thao</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="5" onchange="filterProducts()" name="cat">
              <span>⚡ Xe điện</span>
            </label>
          </div>
        </div>

        <div class="filter-group">
          <h4><i class="fas fa-child"></i> Độ tuổi</h4>
          <div class="filter-options">
            <label class="filter-check">
              <input type="checkbox" value="2-4" onchange="filterProducts()" name="age">
              <span>2 – 4 tuổi</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="4-6" onchange="filterProducts()" name="age">
              <span>4 – 6 tuổi</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="6-10" onchange="filterProducts()" name="age">
              <span>6 – 10 tuổi</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="10-14" onchange="filterProducts()" name="age">
              <span>10 – 14 tuổi</span>
            </label>
          </div>
        </div>

        <div class="filter-group">
          <h4><i class="fas fa-dollar-sign"></i> Khoảng giá</h4>
          <div class="price-filter">
            <div class="price-inputs">
              <input type="number" placeholder="Giá từ" min="500000" max="5000000" step="100000" id="priceMin" onchange="filterProducts()">
              <span>đến</span>
              <input type="number" placeholder="Giá đến" min="500000" max="5000000" step="100000" id="priceMax" onchange="filterProducts()">
            </div>
            <div class="price-presets">
              <button type="button" class="price-preset" onclick="setPriceRange(0, 1000000)">
                Dưới 1 triệu
              </button>
              <button type="button" class="price-preset" onclick="setPriceRange(1000000, 3000000)">
                1-3 triệu
              </button>
              <button type="button" class="price-preset" onclick="setPriceRange(3000000, 5000000)">
                3-5 triệu
              </button>
              <button type="button" class="price-preset" onclick="setPriceRange(5000000, 10000000)">
                5-10 triệu
              </button>
            </div>
          </div>
        </div>

        <div class="filter-group">
          <h4><i class="fas fa-star"></i> Đánh giá</h4>
          <div class="filter-options">
            <label class="filter-check">
              <input type="radio" name="rating" value="0" checked onchange="filterProducts()">
              <span>Tất cả</span>
            </label>
            <label class="filter-check">
              <input type="radio" name="rating" value="4" onchange="filterProducts()">
              <span>⭐⭐⭐⭐ 4+ sao</span>
            </label>
            <label class="filter-check">
              <input type="radio" name="rating" value="4.5" onchange="filterProducts()">
              <span>⭐⭐⭐⭐⭐ 4.5+ sao</span>
            </label>
          </div>
        </div>

        <div class="filter-group">
          <h4><i class="fas fa-bolt"></i> Tính năng</h4>
          <div class="filter-options">
            <label class="filter-check">
              <input type="checkbox" value="giam-xe" onchange="filterProducts()" name="feature">
              <span>🛑 Giảm xóc</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="phanh-thep" onchange="filterProducts()" name="feature">
              <span>🛡️ Phanh đĩa</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="den-hoa" onchange="filterProducts()" name="feature">
              <span>🌸 Đèn hoa</span>
            </label>
            <label class="filter-check">
              <input type="checkbox" value="tui-xe" onchange="filterProducts()" name="feature">
              <span>🎒 Túi xe</span>
            </label>
          </div>
        </div>

        <div class="filter-actions">
          <button type="button" class="btn-apply" onclick="filterProducts()">
            <i class="fas fa-search"></i> Áp dụng bộ lọc
          </button>
        </div>
      </aside>

      <!-- PRODUCTS MAIN -->
      <div class="products-main">
        <div class="products-toolbar fade-up">
          <span id="resultCount">Hiển thị <?php echo min($per_page, $total_products - ($page - 1) * $per_page); ?> sản phẩm (trang <?php echo $page; ?>/<?php echo $total_pages; ?>)</span>
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
        
        <!-- Products Grid -->
        <div class="products-grid">
          <?php
          // Kiểm tra có sản phẩm không
          if (mysqli_num_rows($q_prd) > 0) {
              // Duyệt dữ liệu từ CSDL
              while ($row = mysqli_fetch_array($q_prd)) {
                  // Xây dựng đường dẫn ảnh
                  $image_path = "admin/assets/images/products/" . $row['prd_image'];
          ?>
            <div class="product-card fade-up">
              <!-- Link đến chi tiết sản phẩm -->
              <a href="index.php?page=product-detail&prd_id=<?= $row['prd_id'] ?>" class="product-link">
                
                <!-- Ảnh sản phẩm -->
                <div class="product-image">
                  <img src="<?= $image_path ?>" 
                       alt="<?= htmlspecialchars($row['prd_name']) ?>" 
                       onerror="this.src='admin/assets/images/xe9.jpg';">
                </div>
                
                <!-- Thông tin sản phẩm -->
                <div class="product-info">
                  <div class="product-category"><?= htmlspecialchars($row['cate_name']) ?></div>
                  <h3 class="product-name"><?= htmlspecialchars($row['prd_name']) ?></h3>
                  
                  <div class="product-price">
                    <span class="current-price"><?= number_format($row['prd_price'], 0, ',', '.') ?>đ</span>
                  </div>
                </div>
              </a>
              
              <!-- Nút thêm vào giỏ hàng -->
              <div class="product-actions">
                <form method="post" action="add_cart.php">
                  <input type="hidden" name="action" value="add">
                  <input type="hidden" name="prd_id" value="<?= $row['prd_id'] ?>">
                  <input type="hidden" name="prd_quantity" value="1">
                  <button type="submit" class="btn btn-primary btn-sm">
                    <i class="fas fa-shopping-cart"></i> Mua ngay
                  </button>
                </form>
              </div>
            </div>
          <?php 
              }
          } else {
              echo '<div class="no-products">Không tìm thấy sản phẩm nào.</div>';
          }
          ?>
        </div>

        <!-- Phân trang -->
        <?php if ($total_pages > 1): ?>
        <div class="pagination-wrapper">
          <div class="pagination">
            <?php if ($page > 1): ?>
              <a href="?p=<?php echo $page - 1; ?>" class="page-link prev">
                <i class="fas fa-chevron-left"></i> Trang trước
              </a>
            <?php endif; ?>
            
            <?php
            // Hiển thị số trang
            $start_page = max(1, $page - 2);
            $end_page = min($total_pages, $page + 2);
            
            for ($i = $start_page; $i <= $end_page; $i++) {
                $active_class = ($i == $page) ? 'active' : '';
                echo '<a href="?p=' . $i . '" class="page-link ' . $active_class . '">' . $i . '</a>';
            }
            ?>
            
            <?php if ($page < $total_pages): ?>
              <a href="?p=<?php echo $page + 1; ?>" class="page-link next">
                Trang sau <i class="fas fa-chevron-right"></i>
              </a>
            <?php endif; ?>
          </div>
        </div>
        <?php endif; ?>
    </div>
  </div>
  </div>
</section>

<script src="js/common.js"></script>
<script src="js/products.js"></script>
</body>
</html>