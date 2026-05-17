<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tra cứu đơn hàng - KidBike Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/orders.css">
    <link rel="stylesheet" href="css/orders_search.css">
</head>

<body>
    <!-- Header -->
    <?php include_once('master/header.php'); ?>

    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a><span>/</span>Tra cứu đơn hàng
            </div>
            <h1>Tra cứu <span style="color: var(--primary)">đơn hàng</span> 🔍</h1>
            <p>Tìm kiếm đơn hàng của bạn nhanh chóng</p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="search-section">
        <div class="search-card">
            <div class="search-header">
                <i class="fas fa-search"></i>
                <h3>Tra cứu đơn hàng</h3>
            </div>

            <form method="post" class="search-form">
                <div class="search-input-group">
                    <div class="search-input-wrapper">
                        <i class="fas fa-hashtag"></i>
                        <input type="text"
                            name="search_term"
                            placeholder="Nhập mã đơn hàng, tên, email hoặc SĐT..."
                            value="<?= isset($_POST['search_term']) ? htmlspecialchars($_POST['search_term']) : '' ?>"
                            required>
                    </div>
                    <button type="submit" name="search" class="btn btn-primary btn-lg">
                        <i class="fas fa-search"></i> Tìm kiếm
                    </button>
                </div>
            </form>

            <!-- Quick Search Options -->
            <div class="quick-search">
                <h4>Tìm nhanh:</h4>
                <div class="quick-options">
                    <a href="pending_order.php" class="quick-option">
                        <i class="fas fa-clock"></i> Đơn hàng chờ xử lý
                    </a>
                    <a href="delivery_order.php" class="quick-option">
                        <i class="fas fa-truck"></i> Đơn hàng đang giao
                    </a>
                    <a href="checkout_success.php" class="quick-option">
                        <i class="fas fa-check-circle"></i> Đơn hàng hoàn thành
                    </a>
                    <a href="cancelled_order.php" class="quick-option">
                        <i class="fas fa-times-circle"></i> Đơn hàng đã hủy
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ORDER RESULTS -->
    <div class="orders-section">
        <div class="container">

            <div class="orders-header">
                <h2>
                    <i class="fas fa-box"></i>
                    Trạng thái đơn hàng
                </h2>
                <span>2 đơn hàng</span>
            </div>

            <!-- ORDER CARD -->
            <div class="order-card">

                <!-- TOP -->
                <div class="order-top">
                    <div>
                        <div class="order-id">#KB2026001</div>
                        <div class="order-date">13/05/2026 - 16:30</div>
                    </div>
                    <div class="order-status pending">Chờ xử lý</div>
                </div>

                <!-- BODY: 2 cột - trái sản phẩm, phải thông tin người nhận -->
                <div class="order-body">

                    <!-- CỘT TRÁI: Sản phẩm -->
                    <div class="order-product">

                        <div class="product-left">
                            <img src="admin/assets/images/1778596326_xe8.jpg" alt="Xe đạp trẻ em SPORT">
                            <div class="product-info">
                                <h3>Xe đạp trẻ em SPORT</h3>
                                <p>Phân loại: Màu cam, Size 16</p>
                                <div class="product-price">
                                    <span class="old-price">5.200.000₫</span>
                                    <span class="new-price">4.500.000₫</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- CỘT PHẢI: Thông tin người nhận + tổng tiền -->
                    <div class="order-side">

                        <div class="buyer-info">
                            <div><strong>Người nhận:</strong> Nguyễn Văn A</div>
                            <div><strong>SĐT:</strong> 0987654321</div>
                            <div><strong>Địa chỉ:</strong> Hồ Chí Minh</div>
                        </div>

                        <div class="order-bottom">
                            <div class="total-price">
                                Tổng: <strong>4.650.000₫</strong>
                            </div>
                            <div class="order-actions">
                                <a href="delivery_order.php" class="btn-track">
                                    <i class="fas fa-map-marker-alt"></i> Theo dõi đơn
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
                <!-- END ORDER BODY -->

            </div>
            <!-- END ORDER CARD -->

            <!-- Help Section -->
            <div class="help-section">
                <div class="help-card">
                    <h3><i class="fas fa-question-circle"></i> Cần giúp đỡ?</h3>
                    <div class="help-content">
                        <div class="help-item">
                            <i class="fas fa-info-circle"></i>
                            <div>
                                <h4>Cách tra cứu đơn hàng?</h4>
                                <p>Nhập mã đơn hàng (ví dụ: 000123) hoặc thông tin cá nhân (tên, email, SĐT) vào ô tìm kiếm.</p>
                            </div>
                        </div>
                        <div class="help-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <div>
                                <h4>Không tìm thấy đơn hàng?</h4>
                                <p>Kiểm tra lại mã đơn hàng hoặc thông tin đã nhập. Đơn hàng mới có thể mất vài phút để hiển thị.</p>
                            </div>
                        </div>
                        <div class="help-item">
                            <i class="fas fa-phone-alt"></i>
                            <div>
                                <h4>Cần hỗ trợ thêm?</h4>
                                <p>Liên hệ hotline: <strong>1900-1234</strong> hoặc email: <strong>support@kidbike.vn</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- END ORDERS SECTION -->

    <!-- Footer -->
    <?php include_once('master/footer.php'); ?>

    <style>
        /* ===== ORDERS SECTION ===== */
        .orders-section {
            padding: 2rem 0;
        }

        .orders-section .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        /* Header đơn hàng */
        .orders-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .orders-header h2 {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            text-transform: none;
            letter-spacing: 0;
        }

        .orders-header h2 i {
            font-size: 16px;
            color: #f97316;
        }

        .orders-header span {
            font-size: 13px;
            color: #666;
            background: #f5f5f5;
            border: 1px solid #e5e5e5;
            border-radius: 20px;
            padding: 3px 12px;
        }

        /* ===== ORDER CARD ===== */
        .order-card {
            background: #fff;
            border: 1px solid #e8e8e8;
            border-radius: 12px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        /* TOP: mã đơn + trạng thái */
        .order-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.875rem;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-id {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .order-date {
            font-size: 12px;
            color: #888;
            margin-top: 2px;
        }

        /* Badge trạng thái */
        .order-status {
            font-size: 12px;
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .order-status.pending {
            background: #fff7ed;
            color: #c2410c;
            border: 1px solid #fed7aa;
        }

        .order-status.processing {
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
        }

        .order-status.completed {
            background: #f0fdf4;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }

        .order-status.cancelled {
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
        }

        /* ===== BODY: 2 cột ===== */
        .order-body {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 1.25rem;
            align-items: start;
        }

        /* Cột trái: sản phẩm */
        .order-product {
            min-width: 0;
        }

        .product-left {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .product-left img {
            width: 72px;
            height: 72px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #f0f0f0;
            flex-shrink: 0;
        }

        .product-info h3 {
            font-size: 14px;
            font-weight: 600;
            color: #1a1a1a;
            margin: 0 0 4px;
        }

        .product-info p {
            font-size: 12px;
            color: #888;
            margin: 0 0 6px;
        }

        .product-price {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .product-price .old-price {
            font-size: 12px;
            color: #aaa;
            text-decoration: line-through;
        }

        .product-price .new-price {
            font-size: 14px;
            font-weight: 600;
            color: #f97316;
        }

        /* Cột phải: thông tin người nhận */
        .order-side {
            min-width: 200px;
            max-width: 220px;
            display: flex;
            flex-direction: column;
            gap: 0.875rem;
        }

        .buyer-info {
            font-size: 13px;
            color: #555;
            line-height: 1.9;
            background: #fafafa;
            border-radius: 8px;
            padding: 0.625rem 0.875rem;
        }

        .buyer-info strong {
            color: #1a1a1a;
            font-weight: 500;
        }

        /* Bottom: tổng tiền + nút */
        .order-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding-top: 0.75rem;
            border-top: 1px solid #f0f0f0;
        }

        .total-price {
            font-size: 13px;
            color: #666;
        }

        .total-price strong {
            font-size: 15px;
            font-weight: 700;
            color: #1a1a1a;
        }

        .btn-track {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            padding: 6px 14px;
            border-radius: 8px;
            background: #fff;
            border: 1px solid #e0e0e0;
            color: #333;
            text-decoration: none;
            white-space: nowrap;
            transition: background 0.15s, border-color 0.15s;
        }

        .btn-track:hover {
            background: #f5f5f5;
            border-color: #ccc;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 600px) {
            .order-body {
                grid-template-columns: 1fr;
            }

            .order-side {
                min-width: unset;
                max-width: unset;
                padding-top: 0.875rem;
                border-top: 1px solid #f0f0f0;
            }

            .order-bottom {
                flex-wrap: wrap;
            }
        }
    </style>

    <script>
        function quickSearch(status) {
            const form = document.querySelector('.search-form');
            const input = form.querySelector('input[name="search_term"]');
            switch (status) {
                case 'pending':
                    input.value = 'chờ xử lý';
                    break;
                case 'processing':
                    input.value = 'đang giao';
                    break;
                case 'completed':
                    input.value = 'hoàn thành';
                    break;
                case 'cancelled':
                    input.value = 'đã hủy';
                    break;
            }
            form.submit();
        }

        function copyOrderId(orderId) {
            const orderCode = '#' + orderId.toString().padStart(6, '0');
            navigator.clipboard.writeText(orderCode).then(() => {
                showToast('Đã sao chép mã đơn hàng: ' + orderCode);
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'toast-notification';
            toast.innerHTML = `<i class="fas fa-check-circle"></i><span>${message}</span>`;
            document.body.appendChild(toast);
            setTimeout(() => toast.classList.add('show'), 100);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => document.body.removeChild(toast), 300);
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('input[name="search_term"]').focus();
        });

        document.querySelector('input[name="search_term"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') document.querySelector('.search-form').submit();
        });
    </script>

</body>

</html>