

<!-- SEARCH HERO -->
<div class="search-hero">
  <div class="container">
    <h1>Tìm kiếm <span>sản phẩm</span> 🔍</h1>
    <p>Nhập tên xe, danh mục hoặc từ khóa bạn muốn tìm</p>

    <div class="search-box-wrap">
      <div class="search-input-wrap">
        <i class="fas fa-search"></i>
        <input
          type="text"
          id="searchInput"
          placeholder="Tìm kiếm xe đạp trẻ em..."
          oninput="handleSearch()"
          onkeydown="if(event.key==='Enter') handleSearch()"
          autofocus
        />
        <button class="search-clear" id="clearBtn" onclick="clearSearch()" style="display:none;">
          <i class="fas fa-times"></i>
        </button>
      </div>
      <button class="btn btn-primary search-submit-btn" onclick="handleSearch()">
        <i class="fas fa-search"></i> Tìm kiếm
      </button>
    </div>

    <!-- QUICK TAGS -->
    <div class="search-tags">
      <span>Tìm nhanh:</span>
      <button class="search-tag" onclick="quickSearch('xe thăng bằng')">Xe thăng bằng</button>
      <button class="search-tag" onclick="quickSearch('xe địa hình')">Xe địa hình</button>
      <button class="search-tag" onclick="quickSearch('2 tuổi')">Cho bé 2 tuổi</button>
      <button class="search-tag" onclick="quickSearch('dưới 1 triệu')">Dưới 1 triệu</button>
      <button class="search-tag" onclick="quickSearch('xe thể thao')">Xe thể thao</button>
    </div>
  </div>
</div>

<!-- SEARCH RESULTS -->
<section class="section">
  <div class="container">
    <!-- INITIAL STATE -->
    <div class="search-initial" id="searchInitial">
      <div style="text-align:center; margin-bottom:3rem;">
        <div class="section-tag center" style="display:inline-flex;">🔥 Xu hướng tìm kiếm</div>
      </div>
      <div class="trending-grid" id="trendingGrid"></div>

      <div style="margin-top:4rem;">
        <h3 class="section-title fade-up">Danh mục <span>nổi bật</span></h3>
        <div class="cat-quick-grid" style="margin-top:1.5rem;">
          <a href="products.html?cat=thang-bang" class="cat-quick-item fade-up">🏍️<span>Xe thăng bằng</span></a>
          <a href="products.html?cat=banh-phu" class="cat-quick-item fade-up fade-up-delay-1">🚲<span>Xe bánh phụ</span></a>
          <a href="products.html?cat=dia-hinh" class="cat-quick-item fade-up fade-up-delay-2">🚵<span>Xe địa hình</span></a>
          <a href="products.html?cat=the-thao" class="cat-quick-item fade-up fade-up-delay-3">🏆<span>Xe thể thao</span></a>
        </div>
      </div>
    </div>

    <!-- RESULTS -->
    <div id="searchResults" style="display:none;">
      <div class="results-header fade-up">
        <span id="resultInfo"></span>
        <div class="sort-result">
          <label>Sắp xếp:</label>
          <select onchange="handleSearch()">
            <option>Phù hợp nhất</option>
            <option>Giá tăng dần</option>
            <option>Giá giảm dần</option>
            <option>Đánh giá cao nhất</option>
          </select>
        </div>
      </div>
      <div class="products-grid" id="resultGrid"></div>
    </div>

    <!-- NO RESULTS -->
    <div class="no-results" id="noResults" style="display:none;">
      <div class="no-results-icon">😕</div>
      <h2>Không tìm thấy kết quả</h2>
      <p>Thử tìm với từ khóa khác hoặc xem tất cả sản phẩm của chúng tôi</p>
      <div style="display:flex; gap:1rem; justify-content:center; flex-wrap:wrap; margin-top:1.5rem;">
        <a href="products.php" class="btn btn-primary">Xem tất cả sản phẩm</a>
        <button class="btn btn-outline" onclick="clearSearch()">Tìm kiếm lại</button>
      </div>
    </div>
  </div>
</section>



<script src="js/common.js"></script>
<script src="js/search.js"></script>
</body>

