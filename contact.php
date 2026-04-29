

<div class="page-hero">
  <div class="container">
    <div class="breadcrumb"><a href="index.html">Trang chủ</a><span>/</span>Liên hệ</div>
    <h1>Liên hệ <span style="color:var(--primary)">với chúng tôi</span> 📞</h1>
    <p>Chúng tôi luôn sẵn sàng lắng nghe và hỗ trợ bạn 24/7</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <!-- CONTACT INFO CARDS -->
    <div class="contact-cards fade-up">
      <div class="contact-card">
        <div class="contact-card-icon" style="background:linear-gradient(135deg,#FF6B35,#FF8F65)">📞</div>
        <h3>Điện thoại</h3>
        <p>1800 1234 (Miễn phí)</p>
        <p>028 3821 4567</p>
        <span>T2–CN: 8:00–21:00</span>
      </div>
      <div class="contact-card">
        <div class="contact-card-icon" style="background:linear-gradient(135deg,#4ECDC4,#7EDDD6)">✉️</div>
        <h3>Email</h3>
        <p>hello@kidsbike.vn</p>
        <p>support@kidsbike.vn</p>
        <span>Phản hồi trong 2 giờ</span>
      </div>
      <div class="contact-card">
        <div class="contact-card-icon" style="background:linear-gradient(135deg,#C3B1E1,#DDD0F5)">📍</div>
        <h3>Địa chỉ</h3>
        <p>123 Nguyễn Văn Cừ, Q.5</p>
        <p>TP. Hồ Chí Minh</p>
        <span>T2–CN: 8:00–20:00</span>
      </div>
      <div class="contact-card">
        <div class="contact-card-icon" style="background:linear-gradient(135deg,#FFE66D,#FFF0A0)">💬</div>
        <h3>Live Chat</h3>
        <p>Chat trực tiếp</p>
        <p>Facebook & Zalo</p>
        <span>Phản hồi ngay lập tức</span>
      </div>
    </div>

    <!-- FORM + MAP -->
    <div class="contact-layout">
      <!-- FORM -->
      <div class="contact-form-wrap fade-up">
        <h2>Gửi <span>tin nhắn</span> cho chúng tôi</h2>
        <p>Điền thông tin bên dưới, chúng tôi sẽ liên hệ lại sớm nhất có thể.</p>

        <form class="contact-form" id="contactForm" onsubmit="handleSubmit(event)">
          <div class="form-row">
            <div class="form-group">
              <label>Họ và tên <span>*</span></label>
              <input type="text" placeholder="Nguyễn Văn A" required id="formName" />
            </div>
            <div class="form-group">
              <label>Số điện thoại <span>*</span></label>
              <input type="tel" placeholder="0912 345 678" required id="formPhone" />
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="email" placeholder="email@example.com" id="formEmail" />
          </div>
          <div class="form-group">
            <label>Chủ đề <span>*</span></label>
            <select required id="formSubject">
              <option value="">Chọn chủ đề...</option>
              <option>Tư vấn chọn xe</option>
              <option>Đặt hàng / Thanh toán</option>
              <option>Đổi trả hàng hóa</option>
              <option>Bảo hành sản phẩm</option>
              <option>Hợp tác kinh doanh</option>
              <option>Khác</option>
            </select>
          </div>
          <div class="form-group">
            <label>Nội dung <span>*</span></label>
            <textarea rows="5" placeholder="Nhập nội dung tin nhắn của bạn..." required id="formMessage"></textarea>
          </div>
          <div class="form-group">
            <label class="checkbox-label">
              <input type="checkbox" required />
              <span>Tôi đồng ý với <a href="#">Chính sách bảo mật</a> của KidsBike</span>
            </label>
          </div>
          <button type="submit" class="btn btn-primary btn-submit">
            <i class="fas fa-paper-plane"></i> Gửi tin nhắn
          </button>
        </form>
      </div>

      <!-- MAP & EXTRA INFO -->
      <div class="contact-extra fade-up fade-up-delay-1">
        <!-- Fake Map -->
        <div class="map-placeholder">
          <div class="map-pin">📍</div>
          <div class="map-label">
            <strong>KidsBike Store</strong>
            <span>123 Nguyễn Văn Cừ, Q.5, TP.HCM</span>
          </div>
        </div>

        <!-- Working Hours -->
        <div class="working-hours">
          <h4><i class="fas fa-clock"></i> Giờ làm việc</h4>
          <div class="hour-row">
            <span>Thứ 2 – Thứ 6</span>
            <strong>8:00 – 21:00</strong>
          </div>
          <div class="hour-row">
            <span>Thứ 7 – Chủ nhật</span>
            <strong>9:00 – 20:00</strong>
          </div>
          <div class="hour-row" style="color:var(--primary);">
            <span>Hotline (24/7)</span>
            <strong>1800 1234</strong>
          </div>
        </div>

        <!-- Social Links -->
        <div class="contact-social">
          <h4>Kết nối với chúng tôi</h4>
          <div class="social-links">
            <a href="#" class="social-link fb"><i class="fab fa-facebook-f"></i> Facebook</a>
            <a href="#" class="social-link zalo"><span style="font-weight:900;font-size:0.9rem;">Z</span> Zalo</a>
            <a href="#" class="social-link ig"><i class="fab fa-instagram"></i> Instagram</a>
            <a href="#" class="social-link tiktok"><i class="fab fa-tiktok"></i> TikTok</a>
          </div>
        </div>
      </div>
    </div>

    <!-- FAQ -->
    <div class="faq-section fade-up" style="margin-top:4rem;">
      <div class="section-header center">
        <div class="section-tag">❓ FAQ</div>
        <h2 class="section-title">Câu hỏi <span>thường gặp</span></h2>
      </div>
      <div class="faq-list" id="faqList"></div>
    </div>
  </div>
</section>



<script src="js/common.js"></script>
<script src="js/contact.js"></script>
</body>

