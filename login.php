<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css"
    rel="stylesheet" />
  <link href="css/login.css" rel="stylesheet" />
  <title>Đăng nhập – KidBike Admin</title>
</head>

<body>
  <!-- LEFT PANEL -->
  <div class="login-left">
    <div class="brand">
      <div class="brand-icon"><i class="bx bx-cycling"></i></div>
      <div class="brand-name">KidBike<span>Customer</span></div>
    </div>
    <i class="bx bx-cycling bike-icon"></i>
    <div class="tagline">
      <h2>Chào mừng bạn đến với HDBike! 👋</h2>
      <p>Nơi khám phá thế giới dành cho bé yêu</p>
    </div>
  </div>

  <!-- RIGHT PANEL -->
  <div class="login-right">
    <!-- LOGIN FORM -->
    <div class="form-panel active" id="login-form">
      <h2>Đăng nhập</h2>
      <p class="subtitle">Nhập thông tin để truy cập</p>

      <form method="POST">
        <div class="form-group">
          <label>Email</label>
          <div class="input-wrap">
            <input type="email" placeholder="nguyenvanA@kidbike.vn" />
            <i class="bx bx-envelope"></i>
          </div>
        </div>
        <div class="form-group">
          <label>Mật khẩu</label>
          <div class="input-wrap">
            <input type="password" placeholder="••••••••" />
            <i class="bx bx-lock-alt"></i>
          </div>
        </div>

        <button class="btn-submit" onclick="window.location.href='index.php'">
          <i class="bx bx-log-in"></i> Đăng nhập
        </button>
        <div class="form-switch">
          Chưa có tài khoản?
          <a onclick="switchForm('register-form')">Đăng ký ngay</a>
        </div>
    </div>
    </form>
    <!-- REGISTER FORM -->
    <div class="form-panel" id="register-form">
      <h2>Đăng ký tài khoản</h2>
      <p class="subtitle">Tạo tài khoản mới</p>

      <div class="form-group">
        <label>Họ và tên</label>
        <div class="input-wrap">
          <input type="text" placeholder="Nguyễn Văn A" />
          <i class="bx bx-user"></i>
        </div>
      </div>
      <div class="form-group">
        <label>Email</label>
        <div class="input-wrap">
          <input type="email" placeholder="email@kidbike.vn" />
          <i class="bx bx-envelope"></i>
        </div>
      </div>
      <div class="form-group">
        <label>Mật khẩu</label>
        <div class="input-wrap">
          <input type="password" placeholder="••••••••" />
          <i class="bx bx-lock-alt"></i>
        </div>
      </div>

      <button class="btn-submit" onclick="window.location.href='index.php'">
        <i class="bx bx-user-plus"></i> Đăng ký
      </button>
      <div class="form-switch">
        Đã có tài khoản? <a onclick="switchForm('login-form')">Đăng nhập</a>
      </div>
    </div>
  </div>

  <script>
    function switchForm(id) {
      document
        .querySelectorAll(".form-panel")
        .forEach((p) => p.classList.remove("active"));
      document.getElementById(id).classList.add("active");
    }
  </script>
</body>

</html>