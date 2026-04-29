/* ===================================================
   PRODUCT DETAIL - product-detail.js
=================================================== */

const productData = {
  2: {
    id: 2,
    name: "Xe Địa Hình Explorer X",
    cat: "Xe địa hình · 6-10 tuổi",
    price: 2450000,
    oldPrice: 2900000,
    rating: 4.9,
    reviews: 87,
    emoji: "🌟🚵",
    badge: "new",
  },
  1: {
    id: 1,
    name: "Xe Thăng Bằng Bunny",
    cat: "Xe thăng bằng · 2-4 tuổi",
    price: 890000,
    oldPrice: 1200000,
    rating: 4.8,
    reviews: 124,
    emoji: "🐰🚲",
    badge: "hot",
  },
  3: {
    id: 3,
    name: "Xe Bánh Phụ Rainbow",
    cat: "Xe bánh phụ · 4-6 tuổi",
    price: 1350000,
    oldPrice: null,
    rating: 4.7,
    reviews: 203,
    emoji: "🌈🚲",
    badge: "sale",
  },
  4: {
    id: 4,
    name: "Xe Thể Thao SpeedKid",
    cat: "Xe thể thao · 10-14 tuổi",
    price: 3200000,
    oldPrice: 3800000,
    rating: 5.0,
    reviews: 56,
    emoji: "⚡🏆",
    badge: "new",
  },
};

const relatedList = [
  {
    id: 5,
    name: "Xe Mini StarBike",
    cat: "Xe thăng bằng",
    price: 750000,
    oldPrice: null,
    rating: 4.6,
    reviews: 88,
    emoji: "⭐🏍️",
    badge: "hot",
  },
  {
    id: 6,
    name: "Xe Rocky Pro",
    cat: "Xe địa hình",
    price: 2100000,
    oldPrice: 2500000,
    rating: 4.8,
    reviews: 110,
    emoji: "🏔️🚵",
    badge: "sale",
  },
  {
    id: 7,
    name: "Xe Bánh Phụ PinkCute",
    cat: "Xe bánh phụ",
    price: 980000,
    oldPrice: null,
    rating: 4.5,
    reviews: 160,
    emoji: "🌸🚲",
    badge: "hot",
  },
  {
    id: 8,
    name: "Xe TurboX",
    cat: "Xe thể thao",
    price: 4100000,
    oldPrice: 4800000,
    rating: 4.9,
    reviews: 42,
    emoji: "🔥🏆",
    badge: "new",
  },
];

// Load product from URL param
function loadProduct() {
  const params = new URLSearchParams(window.location.search);
  const id = parseInt(params.get("id")) || 2;
  const p = productData[id] || productData[2];

  document.getElementById("pdBreadcrumb").textContent = p.name;
  document.getElementById("pdCategory").textContent = p.cat;
  document.getElementById("pdTitle").textContent = p.name;
  document.getElementById(
    "pdRating"
  ).textContent = `${p.rating} (${p.reviews} đánh giá)`;
  document.getElementById("pdPrice").textContent = formatPrice(p.price);
  document.getElementById("pdMainImg").textContent = p.emoji;
  document.title = p.name + " - KidsBike";

  const oldEl = document.getElementById("pdOldPrice");
  if (p.oldPrice) {
    oldEl.textContent = formatPrice(p.oldPrice);
    const disc = Math.round((1 - p.price / p.oldPrice) * 100);
    document.querySelector(".pd-discount").textContent = `-${disc}%`;
  } else {
    oldEl.style.display = "none";
    document.querySelector(".pd-discount").style.display = "none";
  }

  // Store for cart use
  window.currentProduct = p;
}

// Thumbnail
function selectThumb(el, emoji) {
  document
    .querySelectorAll(".pd-thumb")
    .forEach((t) => t.classList.remove("active"));
  el.classList.add("active");
  const main = document.getElementById("pdMainImg");
  main.style.opacity = "0";
  setTimeout(() => {
    main.textContent = emoji;
    main.style.opacity = "1";
  }, 200);
}

// Color
function selectColor(el) {
  document
    .querySelectorAll(".color-opt")
    .forEach((c) => c.classList.remove("active"));
  el.classList.add("active");
}

// Size
function selectSize(el) {
  document
    .querySelectorAll(".size-opt")
    .forEach((s) => s.classList.remove("active"));
  el.classList.add("active");
}

// Quantity
function changeQty(delta) {
  const input = document.getElementById("qtyInput");
  let val = parseInt(input.value) + delta;
  val = Math.max(1, Math.min(10, val));
  input.value = val;
}

// Cart
function handleAddToCart() {
  const qty = parseInt(document.getElementById("qtyInput").value);
  const p = window.currentProduct;
  for (let i = 0; i < qty; i++)
    addToCart({ id: p.id, name: p.name, price: p.price, emoji: p.emoji });
}

function handleBuyNow() {
  handleAddToCart();
  setTimeout(() => (window.location.href = "cart.html"), 600);
}

// Wishlist
function handleWish() {
  const p = window.currentProduct;
  toggleWishlist(p);
  document.getElementById("wishBtn").classList.toggle("wished");
}

// Tabs
function switchTab(btn, id) {
  document
    .querySelectorAll(".tab-btn")
    .forEach((b) => b.classList.remove("active"));
  document
    .querySelectorAll(".tab-content")
    .forEach((t) => t.classList.remove("active"));
  btn.classList.add("active");
  document.getElementById("tab-" + id).classList.add("active");
}

// Related products
function renderRelated() {
  const grid = document.getElementById("relatedProducts");
  if (!grid) return;
  grid.innerHTML = relatedList
    .map(
      (p) => `
    <div class="product-card fade-up">
      <div class="product-card-img">
        <span class="product-card-badge badge-${p.badge}">${
        p.badge === "hot" ? "🔥 Hot" : p.badge === "new" ? "✨ Mới" : "🏷️ Sale"
      }</span>
        <div style="font-size:5.5rem;">${p.emoji}</div>
        <div class="product-card-actions">
          <a href="product-detail.html?id=${
            p.id
          }" class="card-action-btn"><i class="fas fa-eye"></i></a>
        </div>
      </div>
      <div class="product-card-body">
        <div class="product-card-category">${p.cat}</div>
        <a href="product-detail.html?id=${
          p.id
        }"><div class="product-card-name">${p.name}</div></a>
        <div class="product-card-rating">
          <div class="stars">${"⭐".repeat(Math.round(p.rating))}</div>
          <span class="rating-count">(${p.reviews})</span>
        </div>
        <div class="product-card-footer">
          <div class="product-price">
            <span class="price-current">${formatPrice(p.price)}</span>
            ${
              p.oldPrice
                ? `<span class="price-old">${formatPrice(p.oldPrice)}</span>`
                : ""
            }
          </div>
          <button class="add-cart-btn" onclick="addToCart({id:${p.id},name:'${
        p.name
      }',price:${p.price},emoji:'${p.emoji}'})">
            <i class="fas fa-shopping-cart"></i>
          </button>
        </div>
      </div>
    </div>
  `
    )
    .join("");
  setTimeout(
    () =>
      grid.querySelectorAll(".fade-up").forEach((el) => observer.observe(el)),
    50
  );
}

// Init
loadProduct();
renderRelated();
