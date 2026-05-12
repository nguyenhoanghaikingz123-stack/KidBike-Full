<?php


/*explode(chuỗi, ký_hiệu_tách);
implode(chuỗi_đã_tách, ký_hiệu_nối);
$str_key = */
include_once('../KidBike-Full/admin/connect.php');



$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

// Câu lệnh SQL (đã sửa lỗi cú pháp)
$sql_search = "SELECT * FROM tbl_product p 
               JOIN tbl_category c ON p.cate_id = c.cate_id 
               WHERE p.prd_name LIKE '%$keyword%'
               ORDER BY p.prd_id DESC";

$query_search = mysqli_query($connect, $sql_search);
$count_results = mysqli_num_rows($query_search)

?>

<!-- SEARCH HERO -->
<div class="search-hero">
  <div class="container">
    <h1>Tìm kiếm <span>sản phẩm</span> 🔍</h1>
    <p>Nhập tên xe, danh mục hoặc từ khóa bạn muốn tìm</p>

    <!-- Đã sửa div thành form để gửi dữ liệu bằng PHP -->
    <form class="search-box-wrap" action="index.php" method="GET">
      <div class="search-input-wrap">
        <i class="fas fa-search"></i>
        <!-- Giữ lại page=search để index.php biết load file này -->
        <input type="hidden" name="page" value="search">
        <input
          type="text"
          id="searchInput"
          name="keyword"
          value="<?= htmlspecialchars($keyword) ?>"
          placeholder="Tìm kiếm xe đạp trẻ em..."
          autofocus>
        <!-- Nút xóa nhanh từ khóa (dùng JS nhỏ gọn) -->

        <a href="index.php?page=search" class="search-clear" style="display:flex;">
          <i class="fas fa-times"></i>
        </a>

      </div>
      <button type="submit" class="btn btn-primary search-submit-btn" name="sbm">
        <i class="fas fa-search"></i> Tìm kiếm
      </button>
    </form>

    <!-- QUICK TAGS: Chuyển thành link GET thay vì dùng JS -->
    <div class="search-tags">
      <span>Tìm nhanh:</span>
      <a href="index.php?page=search&keyword=xe+thăng+bằng" class="search-tag" style="text-decoration:none;">Xe thăng bằng</a>
      <a href="index.php?page=search&keyword=xe+địa+hình" class="search-tag" style="text-decoration:none;">Xe địa hình</a>
      <a href="index.php?page=search&keyword=2+tuổi" class="search-tag" style="text-decoration:none;">Cho bé 2 tuổi</a>
      <a href="index.php?page=search&keyword=thể+thao" class="search-tag" style="text-decoration:none;">Xe thể thao</a>
    </div>
  </div>
</div>

<!-- SEARCH RESULTS -->
<section class="section">
  <div class="container">

    <?php if (empty($keyword)): ?>

      <div class="search-initial" id="searchInitial">
        <
          <div style="text-align:center; margin-bottom:3rem;">
          <div class="section-tag center" style="display:inline-flex;">🔥 Gợi ý cho bạn</div>
      </div>

      <div style="margin-top:4rem;">
        <h3 class="section-title fade-up">Danh mục <span>nổi bật</span></h3>
        <div class="cat-quick-grid" style="margin-top:1.5rem;">
          <a href="index.php?page=search&keyword=thăng+bằng" class="cat-quick-item fade-up">🏍️<span>Xe thăng bằng</span></a>
          <a href="index.php?page=search&keyword=bánh+phụ" class="cat-quick-item fade-up fade-up-delay-1">🚲<span>Xe bánh phụ</span></a>
          <a href="index.php?page=search&keyword=địa+hình" class="cat-quick-item fade-up fade-up-delay-2">🚵<span>Xe địa hình</span></a>
          <a href="index.php?page=search&keyword=thể+thao" class="cat-quick-item fade-up fade-up-delay-3">🏆<span>Xe thể thao</span></a>
        </div>
      </div>
  </div>

<?php else: ?>
  <!-- 2. TRẠNG THÁI KẾT QUẢ TÌM KIẾM -->
  <div id="searchResults">
    <?php if ($count_results > 0): ?>
      <div class="results-header fade-up">
        <span id="resultInfo">Tìm thấy <strong><?= $count_results ?></strong> kết quả cho "<strong><?= htmlspecialchars($keyword) ?></strong>"</span>
      </div>

      <!-- Lặp dữ liệu thực tế từ CSDL -->
      <div class="products-grid" id="resultGrid">
        <?php while ($row = mysqli_fetch_array($query_search)) { ?>
          <div class="product-card fade-up">
            <div class="product-card-img">
              <!-- Hiển thị ảnh thật -->
              <img src="admin/assets/images/<?= $row['prd_image'] ?>" alt="<?= $row['prd_name'] ?>" style="width:100%; height:auto; object-fit:cover; aspect-ratio:1/1;" onerror="this.src='assets/images/no-image.png'">
              <div class="product-card-actions">
                <!-- Đổi link trỏ đến trang chi tiết thực tế của bạn -->
                <a href="index.php?page=product_detail&id=<?= $row['prd_id'] ?>" class="card-action-btn"><i class="fas fa-eye"></i></a>
              </div>
            </div>
            <div class="product-card-body">
              <div class="product-card-category"><?= $row['cate_name'] ?></div>
              <a href="index.php?page=product_detail&id=<?= $row['prd_id'] ?>" style="text-decoration:none; color:inherit;">
                <div class="product-card-name"><?= $row['prd_name'] ?></div>
              </a>
              <div class="product-card-footer">
                <div class="product-price">
                  <span class="price-current"><?= number_format($row['prd_price'], 0, ',', '.') ?>₫</span>
                </div>
                <!-- Nếu bạn có chức năng giỏ hàng, cập nhật lại ID và Giá thực tế ở đây -->
                <button class="add-cart-btn" onclick="addToCart({id:<?= $row['prd_id'] ?>, name:'<?= $row['prd_name'] ?>', price:<?= $row['prd_price'] ?>})">
                  <i class="fas fa-shopping-cart"></i>
                </button>
              </div>
            </div>
          </div>
        <?php }; ?>
      </div>

    <?php else: ?>
      <!-- KHÔNG TÌM THẤY KẾT QUẢ -->
      <div class="no-results" id="noResults">
        <div class="no-results-icon">😕</div>
        <h2>Không tìm thấy kết quả</h2>
        <p>Không có sản phẩm nào khớp với từ khóa "<strong><?= htmlspecialchars($keyword) ?></strong>"</p>
        <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; margin-top:1.5rem;">
          <a href="index.php?page=products" class="btn btn-primary">Xem tất cả sản phẩm</a>
          <a href="index.php?page=search" class="btn btn-outline">Tìm kiếm lại</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

</div>
</section>