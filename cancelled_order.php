<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng đã huỷ</title>

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/cancelled_order.css" />
</head>

<body>
    <div class="cancelled-order-page">
        <!-- HERO -->

        <section class="hero">

            <div class="container">

                <i class="fas fa-times-circle"></i>

                <h1>Đơn hàng đã huỷ</h1>

                <p>
                    Danh sách các đơn hàng đã bị huỷ
                </p>

            </div>

        </section>

        <!-- CONTENT -->

        <section class="section">

            <div class="container">

                <div class="top-bar">

                    <h2>
                        <i class="fas fa-ban"></i>
                        Lịch sử huỷ đơn
                    </h2>

                    <div class="btn-group">

                        <a href="index.php" class="btn btn-outline">
                            <i class="fas fa-house"></i>
                            Trang chủ
                        </a>

                        <a href="order-history.php" class="btn btn-outline">
                            <i class="fas fa-clock-rotate-left"></i>
                            Tất cả đơn
                        </a>

                        <a href="checkout_success.php" class="btn btn-outline">
                            <i class="fas fa-check-circle"></i>
                            Hoàn thành
                        </a>

                    </div>

                </div>

                <div class="orders">

                    <div class="order-card">

                        <div class="order-top">

                            <div>

                                <div class="order-code">
                                    #000321
                                </div>

                                <div class="order-date">
                                    <i class="fas fa-calendar"></i>
                                    13/05/2026 - 14:30
                                </div>

                            </div>

                            <div class="status">
                                Đã huỷ
                            </div>

                        </div>

                        <div class="order-body">

                            <div class="customer-grid">

                                <div class="info-box">

                                    <h3>
                                        <i class="fas fa-user"></i>
                                        Khách hàng
                                    </h3>

                                    <div class="info-item">
                                        <span>Họ tên</span>
                                        Nguyễn Văn A
                                    </div>

                                    <div class="info-item">
                                        <span>Số điện thoại</span>
                                        0987654321
                                    </div>

                                    <div class="info-item">
                                        <span>Địa chỉ</span>
                                        Hồ Chí Minh
                                    </div>

                                </div>

                                <div class="info-box">

                                    <h3>
                                        <i class="fas fa-box"></i>
                                        Sản phẩm
                                    </h3>

                                    <div class="product-item">

                                        <div>
                                            <div class="product-name">
                                                Xe đạp trẻ em
                                            </div>
                                            <small>Số lượng: 1</small>
                                        </div>

                                        <div class="product-price">
                                            4.500.000₫
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="order-footer">

                            <div class="total">
                                4.500.000₫
                            </div>

                            <div class="btn-group">

                                <a href="#" class="btn btn-primary">
                                    <i class="fas fa-eye"></i>
                                    Xem chi tiết
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>
    </div>
</body>

</html>