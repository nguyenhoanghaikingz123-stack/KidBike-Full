/* ===================================================
   KIDSBIKE - JavaScript Chung (common.js)
=================================================== */

// ===== NAVBAR SCROLL EFFECT =====
const navbar = document.querySelector('.navbar');
window.addEventListener('scroll', () => {
  if (window.scrollY > 30) {
    navbar.classList.add('scrolled');
  } else {
    navbar.classList.remove('scrolled');
  }
});

// ===== MOBILE MENU TOGGLE =====
const hamburger = document.querySelector('.nav-hamburger');
const mobileNav = document.querySelector('.nav-mobile');

if (hamburger && mobileNav) {
  hamburger.addEventListener('click', () => {
    mobileNav.classList.toggle('open');
    const spans = hamburger.querySelectorAll('span');
    hamburger.classList.toggle('active');
    if (hamburger.classList.contains('active')) {
      spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
      spans[1].style.opacity = '0';
      spans[2].style.transform = 'rotate(-45deg) translate(5px, -5px)';
    } else {
      spans[0].style.transform = '';
      spans[1].style.opacity = '';
      spans[2].style.transform = '';
    }
  });

  // Close mobile nav on link click
  mobileNav.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
      mobileNav.classList.remove('open');
      hamburger.classList.remove('active');
    });
  });
}

// ===== SCROLL ANIMATIONS =====
const observerOptions = {
  threshold: 0.1,
  rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, observerOptions);

document.querySelectorAll('.fade-up').forEach(el => {
  observer.observe(el);
});

// ===== CART SYSTEM =====
const CART_KEY = 'kidsbike_cart';

function getCart() {
  return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
}

function saveCart(cart) {
  localStorage.setItem(CART_KEY, JSON.stringify(cart));
  updateCartBadge();
}

function addToCart(product) {
  const cart = getCart();
  const existing = cart.find(item => item.id === product.id);
  if (existing) {
    existing.quantity += 1;
  } else {
    cart.push({ ...product, quantity: 1 });
  }
  saveCart(cart);
  showToast(`🛒 Đã thêm "${product.name}" vào giỏ!`);
}

function removeFromCart(productId) {
  let cart = getCart();
  cart = cart.filter(item => item.id !== productId);
  saveCart(cart);
}

function updateQuantity(productId, qty) {
  const cart = getCart();
  const item = cart.find(i => i.id === productId);
  if (item) {
    item.quantity = Math.max(1, qty);
    saveCart(cart);
  }
}

function updateCartBadge() {
  const cart = getCart();
  const total = cart.reduce((sum, i) => sum + i.quantity, 0);
  const badge = document.querySelector('.cart-badge');
  if (badge) {
    badge.textContent = total;
    badge.style.display = total > 0 ? 'flex' : 'none';
  }
}

// Init badge on load
updateCartBadge();

// ===== TOAST NOTIFICATION =====
function showToast(message, type = 'success') {
  let toast = document.querySelector('.toast');
  if (!toast) {
    toast = document.createElement('div');
    toast.className = 'toast';
    document.body.appendChild(toast);
  }
  const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : 'ℹ️';
  toast.innerHTML = `<span>${icon}</span><span>${message}</span>`;
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 3000);
}

// ===== WISHLIST =====
const WISH_KEY = 'kidsbike_wish';

function getWishlist() {
  return JSON.parse(localStorage.getItem(WISH_KEY) || '[]');
}

function toggleWishlist(product) {
  const wish = getWishlist();
  const idx = wish.findIndex(i => i.id === product.id);
  if (idx >= 0) {
    wish.splice(idx, 1);
    showToast(`❤️ Đã bỏ yêu thích "${product.name}"`, 'info');
  } else {
    wish.push(product);
    showToast(`❤️ Đã thêm "${product.name}" vào yêu thích!`);
  }
  localStorage.setItem(WISH_KEY, JSON.stringify(wish));
}

function isWishlisted(productId) {
  return getWishlist().some(i => i.id === productId);
}

// ===== FORMAT CURRENCY =====
function formatPrice(price) {
  return price.toLocaleString('vi-VN') + 'đ';
}

// ===== ACTIVE NAV LINK =====
const currentPage = window.location.pathname.split('/').pop() || 'index.html';
document.querySelectorAll('.nav-link').forEach(link => {
  const href = link.getAttribute('href');
  if (href === currentPage) {
    link.classList.add('active');
  }
});
