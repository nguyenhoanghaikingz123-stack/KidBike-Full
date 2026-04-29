/* ===================================================
   PRODUCTS PAGE - products.js
=================================================== */

const allProducts = [
  { id:1, name:'Xe Thăng Bằng Bunny', cat:'thang-bang', age:'2-4', price:890000, oldPrice:1200000, rating:4.8, reviews:124, emoji:'🐰🚲', badge:'hot' },
  { id:2, name:'Xe Địa Hình Explorer X', cat:'dia-hinh', age:'6-10', price:2450000, oldPrice:2900000, rating:4.9, reviews:87, emoji:'🌟🚵', badge:'new' },
  { id:3, name:'Xe Bánh Phụ Rainbow', cat:'banh-phu', age:'4-6', price:1350000, oldPrice:null, rating:4.7, reviews:203, emoji:'🌈🚲', badge:'sale' },
  { id:4, name:'Xe Thể Thao SpeedKid', cat:'the-thao', age:'10-14', price:3200000, oldPrice:3800000, rating:5.0, reviews:56, emoji:'⚡🏆', badge:'new' },
  { id:5, name:'Xe Mini StarBike', cat:'thang-bang', age:'2-4', price:750000, oldPrice:null, rating:4.6, reviews:88, emoji:'⭐🏍️', badge:'hot' },
  { id:6, name:'Xe Địa Hình Rocky Pro', cat:'dia-hinh', age:'6-10', price:2100000, oldPrice:2500000, rating:4.8, reviews:110, emoji:'🏔️🚵', badge:'sale' },
  { id:7, name:'Xe Bánh Phụ PinkCute', cat:'banh-phu', age:'4-6', price:980000, oldPrice:null, rating:4.5, reviews:160, emoji:'🌸🚲', badge:'hot' },
  { id:8, name:'Xe Thể Thao TurboX', cat:'the-thao', age:'10-14', price:4100000, oldPrice:4800000, rating:4.9, reviews:42, emoji:'🔥🏆', badge:'new' },
  { id:9, name:'Xe Thăng Bằng Tiger', cat:'thang-bang', age:'2-4', price:820000, oldPrice:1000000, rating:4.7, reviews:95, emoji:'🐯🚲', badge:'sale' },
  { id:10, name:'Xe Bánh Phụ DinoKid', cat:'banh-phu', age:'4-6', price:1200000, oldPrice:null, rating:4.8, reviews:130, emoji:'🦕🚲', badge:'new' },
  { id:11, name:'Xe Địa Hình Thunder', cat:'dia-hinh', age:'6-10', price:2800000, oldPrice:3200000, rating:5.0, reviews:68, emoji:'⛈️🚵', badge:'hot' },
  { id:12, name:'Xe Thể Thao AlphaRide', cat:'the-thao', age:'10-14', price:3600000, oldPrice:4200000, rating:4.7, reviews:38, emoji:'🚀🏆', badge:'sale' },
];

let currentView = 'grid';
let currentPage = 1;
const perPage = 9;

function getFilters() {
  const cats = [...document.querySelectorAll('[name="cat"]:checked')].map(e => e.value);
  const ages = [...document.querySelectorAll('[name="age"]:checked')].map(e => e.value);
  const rating = parseFloat(document.querySelector('[name="rating"]:checked')?.value || 0);
  const maxPrice = parseInt(document.getElementById('priceRange')?.value || 5000000);
  return { cats, ages, rating, maxPrice };
}

function filterProducts() {
  currentPage = 1;
  renderProducts();
}

function sortProducts() {
  renderProducts();
}

function updatePriceLabel(val) {
  document.getElementById('priceLabel').textContent = parseInt(val).toLocaleString('vi-VN') + 'đ';
  renderProducts();
}

function clearFilters() {
  document.querySelectorAll('[name="cat"]')[0].checked = true;
  document.querySelectorAll('[name="cat"]').forEach((el, i) => { if (i > 0) el.checked = false; });
  document.querySelectorAll('[name="age"]').forEach(el => el.checked = false);
  document.querySelectorAll('[name="rating"]')[0].checked = true;
  const range = document.getElementById('priceRange');
  if (range) { range.value = 5000000; updatePriceLabel(5000000); }
  filterProducts();
}

function setView(v) {
  currentView = v;
  const grid = document.getElementById('productsGrid');
  document.getElementById('gridViewBtn').classList.toggle('active', v === 'grid');
  document.getElementById('listViewBtn').classList.toggle('active', v === 'list');
  if (v === 'list') grid.classList.add('list-view');
  else grid.classList.remove('list-view');
}

function renderProducts() {
  const { cats, ages, rating, maxPrice } = getFilters();
  const sortVal = document.getElementById('sortSelect')?.value || 'default';

  let filtered = allProducts.filter(p => {
    const catOk = cats.includes('all') || cats.length === 0 || cats.includes(p.cat);
    const ageOk = ages.length === 0 || ages.includes(p.age);
    const ratingOk = p.rating >= rating;
    const priceOk = p.price <= maxPrice;
    return catOk && ageOk && ratingOk && priceOk;
  });

  if (sortVal === 'price-asc') filtered.sort((a, b) => a.price - b.price);
  else if (sortVal === 'price-desc') filtered.sort((a, b) => b.price - a.price);
  else if (sortVal === 'rating') filtered.sort((a, b) => b.rating - a.rating);

  const totalPages = Math.ceil(filtered.length / perPage);
  const paginated = filtered.slice((currentPage - 1) * perPage, currentPage * perPage);

  const grid = document.getElementById('productsGrid');
  const resultCount = document.getElementById('resultCount');
  if (resultCount) resultCount.textContent = `Hiển thị ${paginated.length} / ${filtered.length} sản phẩm`;

  grid.innerHTML = paginated.map(p => `
    <div class="product-card fade-up">
      <div class="product-card-img">
        <span class="product-card-badge badge-${p.badge}">${p.badge === 'hot' ? '🔥 Hot' : p.badge === 'new' ? '✨ Mới' : '🏷️ Sale'}</span>
        <div style="font-size:6rem;">${p.emoji}</div>
        <div class="product-card-actions">
          <button class="card-action-btn" onclick="toggleWishlist({id:${p.id},name:'${p.name}',price:${p.price}})" title="Yêu thích"><i class="fas fa-heart"></i></button>
          <a href="product-detail.html?id=${p.id}" class="card-action-btn" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
        </div>
      </div>
      <div class="product-card-body">
        <div class="product-card-category">${catLabel(p.cat)} · ${p.age} tuổi</div>
        <a href="product-detail.html?id=${p.id}"><div class="product-card-name">${p.name}</div></a>
        <div class="product-card-rating">
          <div class="stars">${'⭐'.repeat(Math.round(p.rating))}</div>
          <span class="rating-count">${p.rating} (${p.reviews})</span>
        </div>
        <div class="product-card-footer">
          <div class="product-price">
            <span class="price-current">${formatPrice(p.price)}</span>
            ${p.oldPrice ? `<span class="price-old">${formatPrice(p.oldPrice)}</span>` : ''}
          </div>
          <button class="add-cart-btn" onclick="addToCart({id:${p.id},name:'${p.name}',price:${p.price},emoji:'${p.emoji}'})">
            <i class="fas fa-shopping-cart"></i>
          </button>
        </div>
      </div>
    </div>
  `).join('');

  // Pagination
  const pag = document.getElementById('pagination');
  if (pag && totalPages > 1) {
    pag.innerHTML = Array.from({length: totalPages}, (_, i) => i + 1)
      .map(n => `<button class="page-btn ${n === currentPage ? 'active' : ''}" onclick="goPage(${n})">${n}</button>`)
      .join('');
  } else if (pag) pag.innerHTML = '';

  // Animate
  setTimeout(() => {
    grid.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
  }, 50);
}

function goPage(n) {
  currentPage = n;
  renderProducts();
  window.scrollTo({ top: 300, behavior: 'smooth' });
}

function catLabel(cat) {
  const map = { 'thang-bang': 'Xe thăng bằng', 'banh-phu': 'Xe bánh phụ', 'dia-hinh': 'Xe địa hình', 'the-thao': 'Xe thể thao' };
  return map[cat] || cat;
}

// Init
renderProducts();
