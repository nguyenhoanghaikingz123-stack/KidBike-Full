/* ===================================================
   SEARCH PAGE - search.js
=================================================== */

const searchDatabase = [
  { id:1, name:'Xe Thăng Bằng Bunny', cat:'Xe thăng bằng', price:890000, oldPrice:1200000, rating:4.8, reviews:124, emoji:'🐰🚲', badge:'hot', tags:['thăng bằng','2 tuổi','nhỏ','bé'] },
  { id:2, name:'Xe Địa Hình Explorer X', cat:'Xe địa hình', price:2450000, oldPrice:2900000, rating:4.9, reviews:87, emoji:'🌟🚵', badge:'new', tags:['địa hình','6 tuổi','phiêu lưu'] },
  { id:3, name:'Xe Bánh Phụ Rainbow', cat:'Xe bánh phụ', price:1350000, oldPrice:null, rating:4.7, reviews:203, emoji:'🌈🚲', badge:'sale', tags:['bánh phụ','4 tuổi','màu sắc','cầu vồng'] },
  { id:4, name:'Xe Thể Thao SpeedKid', cat:'Xe thể thao', price:3200000, oldPrice:3800000, rating:5.0, reviews:56, emoji:'⚡🏆', badge:'new', tags:['thể thao','10 tuổi','tốc độ'] },
  { id:5, name:'Xe Mini StarBike', cat:'Xe thăng bằng', price:750000, oldPrice:null, rating:4.6, reviews:88, emoji:'⭐🏍️', badge:'hot', tags:['thăng bằng','2 tuổi','mini','dưới 1 triệu'] },
  { id:6, name:'Xe Địa Hình Rocky Pro', cat:'Xe địa hình', price:2100000, oldPrice:2500000, rating:4.8, reviews:110, emoji:'🏔️🚵', badge:'sale', tags:['địa hình','8 tuổi','địa hình'] },
  { id:7, name:'Xe Bánh Phụ PinkCute', cat:'Xe bánh phụ', price:980000, oldPrice:null, rating:4.5, reviews:160, emoji:'🌸🚲', badge:'hot', tags:['bánh phụ','4 tuổi','hồng','bé gái'] },
  { id:8, name:'Xe Thể Thao TurboX', cat:'Xe thể thao', price:4100000, oldPrice:4800000, rating:4.9, reviews:42, emoji:'🔥🏆', badge:'new', tags:['thể thao','12 tuổi','đua'] },
  { id:9, name:'Xe Thăng Bằng Tiger', cat:'Xe thăng bằng', price:820000, oldPrice:1000000, rating:4.7, reviews:95, emoji:'🐯🚲', badge:'sale', tags:['thăng bằng','3 tuổi','tiger'] },
  { id:10, name:'Xe Bánh Phụ DinoKid', cat:'Xe bánh phụ', price:1200000, oldPrice:null, rating:4.8, reviews:130, emoji:'🦕🚲', badge:'new', tags:['bánh phụ','5 tuổi','khủng long'] },
  { id:11, name:'Xe Địa Hình Thunder', cat:'Xe địa hình', price:2800000, oldPrice:3200000, rating:5.0, reviews:68, emoji:'⛈️🚵', badge:'hot', tags:['địa hình','9 tuổi'] },
  { id:12, name:'Xe Thể Thao AlphaRide', cat:'Xe thể thao', price:3600000, oldPrice:4200000, rating:4.7, reviews:38, emoji:'🚀🏆', badge:'sale', tags:['thể thao','11 tuổi'] },
];

const trending = [
  { id:1, name:'Xe Thăng Bằng Bunny', price:890000, emoji:'🐰🚲', badge:'hot', cat:'Xe thăng bằng', rating:4.8, reviews:124, oldPrice:1200000 },
  { id:4, name:'Xe Thể Thao SpeedKid', price:3200000, emoji:'⚡🏆', badge:'new', cat:'Xe thể thao', rating:5.0, reviews:56, oldPrice:3800000 },
  { id:3, name:'Xe Bánh Phụ Rainbow', price:1350000, emoji:'🌈🚲', badge:'sale', cat:'Xe bánh phụ', rating:4.7, reviews:203, oldPrice:null },
  { id:2, name:'Xe Địa Hình Explorer X', price:2450000, emoji:'🌟🚵', badge:'new', cat:'Xe địa hình', rating:4.9, reviews:87, oldPrice:2900000 },
];

let lastQuery = '';

function handleSearch() {
  const query = document.getElementById('searchInput').value.trim().toLowerCase();
  const clearBtn = document.getElementById('clearBtn');
  clearBtn.style.display = query ? 'flex' : 'none';

  if (!query) {
    showInitial();
    return;
  }

  lastQuery = query;
  const results = searchDatabase.filter(p => {
    const searchStr = [p.name, p.cat, ...p.tags].join(' ').toLowerCase();
    return query.split(' ').every(word => searchStr.includes(word));
  });

  renderResults(results, query);
}

function quickSearch(term) {
  document.getElementById('searchInput').value = term;
  document.getElementById('clearBtn').style.display = 'flex';
  handleSearch();
}

function clearSearch() {
  document.getElementById('searchInput').value = '';
  document.getElementById('clearBtn').style.display = 'none';
  showInitial();
  document.getElementById('searchInput').focus();
}

function showInitial() {
  document.getElementById('searchInitial').style.display = 'block';
  document.getElementById('searchResults').style.display = 'none';
  document.getElementById('noResults').style.display = 'none';
  renderTrending();
}

function renderResults(results, query) {
  document.getElementById('searchInitial').style.display = 'none';
  document.getElementById('noResults').style.display = 'none';

  if (results.length === 0) {
    document.getElementById('searchResults').style.display = 'none';
    document.getElementById('noResults').style.display = 'block';
    return;
  }

  document.getElementById('searchResults').style.display = 'block';
  document.getElementById('resultInfo').textContent = `Tìm thấy ${results.length} kết quả cho "${query}"`;

  const grid = document.getElementById('resultGrid');
  grid.innerHTML = results.map(p => `
    <div class="product-card fade-up">
      <div class="product-card-img">
        <span class="product-card-badge badge-${p.badge}">${p.badge === 'hot' ? '🔥 Hot' : p.badge === 'new' ? '✨ Mới' : '🏷️ Sale'}</span>
        <div style="font-size:6rem;">${p.emoji}</div>
        <div class="product-card-actions">
          <a href="product-detail.html?id=${p.id}" class="card-action-btn"><i class="fas fa-eye"></i></a>
        </div>
      </div>
      <div class="product-card-body">
        <div class="product-card-category">${p.cat}</div>
        <a href="product-detail.html?id=${p.id}">
          <div class="product-card-name">${highlightText(p.name, query)}</div>
        </a>
        <div class="product-card-rating">
          <div class="stars">${'⭐'.repeat(Math.round(p.rating))}</div>
          <span class="rating-count">(${p.reviews})</span>
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

  setTimeout(() => grid.querySelectorAll('.fade-up').forEach(el => observer.observe(el)), 50);
}

function highlightText(text, query) {
  const regex = new RegExp(`(${query.split(' ').join('|')})`, 'gi');
  return text.replace(regex, '<mark class="highlight">$1</mark>');
}

function renderTrending() {
  const grid = document.getElementById('trendingGrid');
  if (!grid) return;
  grid.innerHTML = trending.map(p => `
    <div class="product-card fade-up">
      <div class="product-card-img">
        <span class="product-card-badge badge-${p.badge}">${p.badge === 'hot' ? '🔥 Hot' : p.badge === 'new' ? '✨ Mới' : '🏷️ Sale'}</span>
        <div style="font-size:5.5rem;">${p.emoji}</div>
        <div class="product-card-actions">
          <a href="product-detail.html?id=${p.id}" class="card-action-btn"><i class="fas fa-eye"></i></a>
        </div>
      </div>
      <div class="product-card-body">
        <div class="product-card-category">${p.cat}</div>
        <a href="product-detail.html?id=${p.id}"><div class="product-card-name">${p.name}</div></a>
        <div class="product-card-rating">
          <div class="stars">${'⭐'.repeat(Math.round(p.rating))}</div>
          <span class="rating-count">(${p.reviews})</span>
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
  setTimeout(() => grid.querySelectorAll('.fade-up').forEach(el => observer.observe(el)), 50);
}

// Check URL param
const urlParams = new URLSearchParams(window.location.search);
const q = urlParams.get('q');
if (q) {
  document.getElementById('searchInput').value = q;
  document.getElementById('clearBtn').style.display = 'flex';
  handleSearch();
} else {
  showInitial();
}
