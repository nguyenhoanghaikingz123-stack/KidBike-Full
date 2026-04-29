/* ===================================================
   CONTACT PAGE - contact.js
=================================================== */

// FORM SUBMIT
function handleSubmit(e) {
  e.preventDefault();
  const btn = e.target.querySelector('.btn-submit');
  btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang gửi...';
  btn.disabled = true;
  setTimeout(() => {
    showToast('✅ Tin nhắn đã được gửi! Chúng tôi sẽ liên hệ sớm.');
    e.target.reset();
    btn.innerHTML = '<i class="fas fa-paper-plane"></i> Gửi tin nhắn';
    btn.disabled = false;
  }, 1800);
}

// FAQ DATA
const faqs = [
  { q: 'Làm sao để chọn đúng cỡ xe cho bé?', a: 'Bạn nên chọn xe dựa theo chiều cao của bé chứ không phải độ tuổi. Bé 90-105cm phù hợp bánh 12", 105-120cm phù hợp bánh 14", 120-135cm phù hợp bánh 16". Đội ngũ tư vấn KidsBike luôn sẵn sàng hỗ trợ bạn chọn đúng nhất.' },
  { q: 'Chính sách đổi trả như thế nào?', a: 'KidsBike hỗ trợ đổi trả miễn phí trong vòng 30 ngày kể từ ngày mua hàng nếu sản phẩm còn nguyên vẹn, đầy đủ phụ kiện và hóa đơn. Liên hệ hotline 1800 1234 để được hỗ trợ nhanh nhất.' },
  { q: 'Xe đạp có được bảo hành không?', a: 'Tất cả sản phẩm tại KidsBike đều được bảo hành chính hãng từ 12 đến 24 tháng tùy từng loại xe. Bảo hành bao gồm lỗi kỹ thuật, khung xe, hệ thống phanh và truyền động.' },
  { q: 'Thời gian giao hàng mất bao lâu?', a: 'Nội thành TP.HCM và Hà Nội: 1-2 ngày làm việc. Các tỉnh thành khác: 2-4 ngày làm việc. Đơn hàng đặt trước 15:00 sẽ được xử lý trong ngày. Miễn phí giao hàng cho đơn từ 500.000đ.' },
  { q: 'Có thể xem và thử xe trực tiếp không?', a: 'Có! Bạn có thể đến showroom tại 123 Nguyễn Văn Cừ, Q.5, TP.HCM để xem và thử xe trực tiếp. Chúng tôi mở cửa từ 8:00-20:00 tất cả các ngày trong tuần.' },
];

function renderFAQ() {
  const list = document.getElementById('faqList');
  if (!list) return;
  list.innerHTML = faqs.map((f, i) => `
    <div class="faq-item fade-up" style="transition-delay:${i * 0.08}s;">
      <div class="faq-question" onclick="toggleFAQ(this)">
        <span>${f.q}</span>
        <div class="faq-icon"><i class="fas fa-plus"></i></div>
      </div>
      <div class="faq-answer">${f.a}</div>
    </div>
  `).join('');
  setTimeout(() => list.querySelectorAll('.fade-up').forEach(el => observer.observe(el)), 50);
}

function toggleFAQ(el) {
  const item = el.closest('.faq-item');
  const isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
  if (!isOpen) item.classList.add('open');
}

renderFAQ();
