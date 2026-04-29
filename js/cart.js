/* ===================================================
   CART PAGE - cart.js
=================================================== */

const COUPONS = {
  'KIDSBIKE2025': { type: 'percent', value: 10, label: 'Giảm 10%' },
  'FREESHIP': { type: 'ship', value: 0, label: 'Miễn phí ship' },
  'GIAM50K': { type: 'fixed', value: 50000, label: 'Giảm 50,000đ' },
};

let appliedCoupon = null;

function renderCart() {
  const cart = getCart();
  const cartContent = document.getElementById('cartContent');
  const emptyCart = document.getElementById('emptyCart');

  if (cart.length === 0) {
    cartContent.style.display = 'none';
    emptyCart.style.display = 'block';
    return;
  }

  cartContent.style.display = 'grid';
  emptyCart.style.display = 'none';

  const list = document.getElementById('cartItemsList');
  list.innerHTML = cart.map(item => `
    <div class="cart-item fade-up" id="item-${item.id}">
      <div class="cart-item-info">
        <div class="cart-item-emoji">${item.emoji || '🚲'}</div>
        <div>
          <div class="cart-item-name">${item.name}</div>
          <div class="cart-item-meta">Màu: Cam · Cỡ: 16"</div>
        </div>
      </div>
      <div class="cart-item-price">${formatPrice(item.price)}</div>
      <div class="cart-qty">
        <button onclick="changeCartQty(${item.id}, -1)">−</button>
        <input type="number" value="${item.quantity}" min="1" max="10"
               onchange="setCartQty(${item.id}, this.value)" />
        <button onclick="changeCartQty(${item.id}, 1)">+</button>
      </div>
      <div class="cart-item-total">${formatPrice(item.price * item.quantity)}</div>
      <button class="cart-item-remove" onclick="handleRemove(${item.id})" title="Xóa">
        <i class="fas fa-trash-alt"></i>
      </button>
    </div>
  `).join('');

  updateSummary();

  // Animate
  setTimeout(() => list.querySelectorAll('.fade-up').forEach(el => observer.observe(el)), 50);
}

function changeCartQty(id, delta) {
  const cart = getCart();
  const item = cart.find(i => i.id === id);
  if (item) {
    const newQty = Math.max(1, Math.min(10, item.quantity + delta));
    updateQuantity(id, newQty);
    renderCart();
  }
}

function setCartQty(id, val) {
  const qty = Math.max(1, Math.min(10, parseInt(val) || 1));
  updateQuantity(id, qty);
  renderCart();
}

function handleRemove(id) {
  const el = document.getElementById('item-' + id);
  if (el) {
    el.style.opacity = '0';
    el.style.transform = 'translateX(20px)';
    setTimeout(() => {
      removeFromCart(id);
      renderCart();
    }, 300);
  }
}

function clearAllCart() {
  if (confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')) {
    localStorage.removeItem('kidsbike_cart');
    updateCartBadge();
    renderCart();
  }
}

function updateSummary() {
  const cart = getCart();
  const subtotal = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
  const totalItems = cart.reduce((sum, i) => sum + i.quantity, 0);

  document.getElementById('itemCount').textContent = totalItems;
  document.getElementById('subtotal').textContent = formatPrice(subtotal);

  let discount = 0;
  if (appliedCoupon) {
    const c = COUPONS[appliedCoupon];
    if (c.type === 'percent') discount = Math.round(subtotal * c.value / 100);
    else if (c.type === 'fixed') discount = c.value;
    document.getElementById('discountRow').style.display = 'flex';
    document.getElementById('appliedCode').textContent = appliedCoupon;
    document.getElementById('discountAmt').textContent = '-' + formatPrice(discount);
  } else {
    document.getElementById('discountRow').style.display = 'none';
  }

  const shippingFee = subtotal >= 500000 ? 0 : 30000;
  document.getElementById('shipping').textContent = shippingFee === 0 ? 'Miễn phí 🎉' : formatPrice(shippingFee);

  const total = subtotal - discount + shippingFee;
  document.getElementById('totalPrice').textContent = formatPrice(total);
}

function applyCoupon() {
  const code = document.getElementById('couponInput').value.trim().toUpperCase();
  if (!code) { showToast('⚠️ Vui lòng nhập mã giảm giá.', 'error'); return; }
  if (COUPONS[code]) {
    appliedCoupon = code;
    showToast(`🎉 Áp dụng mã "${code}" thành công!`);
    updateSummary();
    document.getElementById('couponInput').value = '';
  } else {
    showToast('❌ Mã giảm giá không hợp lệ.', 'error');
  }
}

function handleCheckout() {
  const cart = getCart();
  if (cart.length === 0) { showToast('⚠️ Giỏ hàng đang trống!', 'error'); return; }
  const code = 'KB' + Date.now().toString().slice(-6);
  document.getElementById('orderCode').textContent = '#' + code;
  document.getElementById('checkoutModal').classList.add('open');
  // Clear cart after order
  setTimeout(() => {
    localStorage.removeItem('kidsbike_cart');
    updateCartBadge();
  }, 500);
}

function closeModal() {
  document.getElementById('checkoutModal').classList.remove('open');
  renderCart();
}

// Close on overlay click
document.getElementById('checkoutModal').addEventListener('click', function(e) {
  if (e.target === this) closeModal();
});

// Init
renderCart();
