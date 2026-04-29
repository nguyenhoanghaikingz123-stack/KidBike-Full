/* ===================================================
   HOME PAGE - JavaScript (home.js)
=================================================== */

// ===== FEATURED PRODUCTS DATA =====
const featuredProducts = [
  { id: 1, name: 'Xe Thăng Bằng Bunny', category: 'Xe thăng bằng', price: 890000, oldPrice: 1200000, rating: 4.8, reviews: 124, emoji: '🐰🚲', badge: 'hot', age: '2-4 tuổi' },
  { id: 2, name: 'Xe Địa Hình Explorer X', category: 'Xe địa hình', price: 2450000, oldPrice: 2900000, rating: 4.9, reviews: 87, emoji: '🌟🚵', badge: 'new', age: '6-10 tuổi' },
  { id: 3, name: 'Xe Bánh Phụ Rainbow', category: 'Xe bánh phụ', price: 1350000, oldPrice: null, rating: 4.7, reviews: 203, emoji: '🌈🚲', badge: 'sale', age: '4-6 tuổi' },
  { id: 4, name: 'Xe Thể Thao SpeedKid', category: 'Xe thể thao', price: 3200000, oldPrice: 3800000, rating: 5.0, reviews: 56, emoji: '⚡🏆', badge: 'new', age: '10-14 tuổi' },
];



function toggleWishlistBtn(id) {
  const product = featuredProducts.find(p => p.id === id);
  if (product) toggleWishlist(product);
}

function handleNewsletter() {
  const email = document.getElementById('newsletterEmail');
  if (email && email.value && email.value.includes('@')) {
    showToast('🎉 Đăng ký thành công! Cảm ơn bạn.');
    email.value = '';
  } else {
    showToast('⚠️ Vui lòng nhập email hợp lệ.', 'error');
  }
}

// Init
renderFeaturedProducts();

// Re-trigger scroll observer after render
setTimeout(() => {
  document.querySelectorAll('.fade-up').forEach(el => observer.observe(el));
}, 100);
