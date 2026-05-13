<?php
session_start();
include_once(__DIR__ . "/admin/connect.php");

// Kiểm tra đăng nhập - yêu cầu phải đăng nhập để xem lịch sử
if (!isset($_SESSION['user_id'])) {
    // Nếu chưa đăng nhập, chuyển hướng đến trang tra cứu đơn hàng
    header('Location: order-search.php?message=login_required');
    exit();
}

// Phân trang cho lịch sử đơn hàng
$page = isset($_GET['p']) ? intval($_GET['p']) : 1;
$per_page = 10;
$start = ($page - 1) * $per_page;

// Lấy tổng số đơn hàng của user (hiện tại lấy tất cả, sau này có thể filter theo user_id)
$count_sql = "SELECT COUNT(*) as total FROM tbl_orders";
$count_result = mysqli_query($connect, $count_sql);
$total_row = mysqli_fetch_array($count_result);
$total_orders = $total_row['total'];
$total_pages = ceil($total_orders / $per_page);

// Lấy danh sách đơn hàng
$sql = "SELECT o.*, COUNT(od.detail_id) as total_items 
        FROM tbl_orders o 
        LEFT JOIN tbl_order_details od ON o.order_id = od.order_id 
        GROUP BY o.order_id 
        ORDER BY o.created_at DESC 
        LIMIT $start, $per_page";
$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch sử mua hàng - KidBike Shop</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/orders.css">
</head>
<body>
    <!-- Header -->
    <?php include_once('master/header.php'); ?>
    
    <!-- Page Hero -->
    <div class="page-hero">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.php">Trang chủ</a><span>/</span>Lịch sử mua hàng
            </div>
            <h1>Lịch sử <span style="color: var(--primary)">mua hàng</span> 📦</h1>
            <p>Xem lại tất cả đơn hàng của bạn</p>
        </div>
    </div>

    <!-- Order History Content -->
    <section class="section">
        <div class="container">
            <!-- Order Tabs -->
            <div class="order-tabs">
                <div class="order-tab active" onclick="filterOrders('all')">
                    <i class="fas fa-list"></i> Tất cả đơn hàng
                </div>
                <div class="order-tab" onclick="filterOrders('pending')">
                    <i class="fas fa-clock"></i> Chờ xử lý
                </div>
                <div class="order-tab" onclick="filterOrders('processing')">
                    <i class="fas fa-truck"></i> Đang giao
                </div>
                <div class="order-tab" onclick="filterOrders('completed')">
                    <i class="fas fa-check-circle"></i> Hoàn thành
                </div>
                <div class="order-tab" onclick="filterOrders('cancelled')">
                    <i class="fas fa-times-circle"></i> Đã hủy
                </div>
            </div>

            <!-- Search Bar -->
            <div class="order-search">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Tìm kiếm theo mã đơn hàng, tên sản phẩm...">
                    <button onclick="searchOrders()">Tìm kiếm</button>
                </div>
                <a href="order-search.php" class="btn btn-outline">
                    <i class="fas fa-search"></i> Tra cứu đơn hàng
                </a>
            </div>

            <!-- Orders List -->
            <div class="orders-container">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($order = mysqli_fetch_array($result)): ?>
                        <div class="order-card" data-status="<?= $order['order_status'] ?>">
                            <div class="order-header">
                                <div class="order-info">
                                    <div class="order-id">
                                        <strong>Mã đơn hàng:</strong> #<?= str_pad($order['order_id'], 6, '0', STR_PAD_LEFT) ?>
                                    </div>
                                    <div class="order-date">
                                        <i class="fas fa-calendar"></i> 
                                        <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
                                    </div>
                                </div>
                                <div class="order-status">
                                    <?php
                                    $status_class = '';
                                    $status_text = '';
                                    switch ($order['order_status']) {
                                        case 'pending':
                                            $status_class = 'status-pending';
                                            $status_text = 'Chờ xử lý';
                                            break;
                                        case 'processing':
                                            $status_class = 'status-processing';
                                            $status_text = 'Đang xử lý';
                                            break;
                                        case 'completed':
                                            $status_class = 'status-completed';
                                            $status_text = 'Hoàn thành';
                                            break;
                                        case 'cancelled':
                                            $status_class = 'status-cancelled';
                                            $status_text = 'Đã hủy';
                                            break;
                                    }
                                    ?>
                                    <span class="status-badge <?= $status_class ?>">
                                        <?= $status_text ?>
                                    </span>
                                </div>
                            </div>

                            <div class="order-content">
                                <div class="order-summary">
                                    <div class="order-items-count">
                                        <i class="fas fa-box"></i> 
                                        <?= $order['total_items'] ?> sản phẩm
                                    </div>
                                    <div class="order-total">
                                        <strong>Tổng tiền:</strong> 
                                        <span class="price"><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</span>
                                    </div>
                                </div>

                                <div class="order-customer">
                                    <div class="customer-name">
                                        <i class="fas fa-user"></i> <?= htmlspecialchars($order['customer_name']) ?>
                                    </div>
                                    <div class="customer-phone">
                                        <i class="fas fa-phone"></i> <?= htmlspecialchars($order['customer_phone']) ?>
                                    </div>
                                </div>
                            </div>

                            <div class="order-actions">
                                <a href="order-detail.php?id=<?= $order['order_id'] ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-eye"></i> Xem chi tiết
                                </a>
                                <?php if ($order['order_status'] == 'pending'): ?>
                                    <button class="btn btn-danger btn-sm" onclick="cancelOrder(<?= $order['order_id'] ?>)">
                                        <i class="fas fa-times"></i> Hủy đơn
                                    </button>
                                <?php endif; ?>
                                <?php if ($order['order_status'] == 'completed'): ?>
                                    <button class="btn btn-success btn-sm" onclick="reorder(<?= $order['order_id'] ?>)">
                                        <i class="fas fa-redo"></i> Đặt lại
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-orders">
                        <div class="empty-icon">📦</div>
                        <h3>Chưa có đơn hàng nào</h3>
                        <p>Bạn chưa có đơn hàng nào. Hãy mua sắm ngay!</p>
                        <a href="index.php?page=products" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i> Mua sắm ngay
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="pagination-wrapper">
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?p=<?= $page - 1 ?>" class="page-link prev">
                                <i class="fas fa-chevron-left"></i> Trang trước
                            </a>
                        <?php endif; ?>
                        
                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $active_class = ($i == $page) ? 'active' : '';
                            echo '<a href="?p=' . $i . '" class="page-link ' . $active_class . '">' . $i . '</a>';
                        }
                        ?>
                        
                        <?php if ($page < $total_pages): ?>
                            <a href="?p=<?= $page + 1 ?>" class="page-link next">
                                Trang sau <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include_once('master/footer.php'); ?>

    <script>
        // Filter orders by status
        function filterOrders(status) {
            // Remove active class from all tabs
            document.querySelectorAll('.order-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Add active class to clicked tab
            event.target.closest('.order-tab').classList.add('active');
            
            // Filter order cards
            document.querySelectorAll('.order-card').forEach(card => {
                if (status === 'all' || card.dataset.status === status) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Search orders
        function searchOrders() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            
            document.querySelectorAll('.order-card').forEach(card => {
                const text = card.textContent.toLowerCase();
                if (text.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Real-time search
        document.getElementById('searchInput').addEventListener('input', searchOrders);

        // Cancel order
        function cancelOrder(orderId) {
            if (confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
                window.location.href = 'order-action.php?action=cancel&id=' + orderId;
            }
        }

        // Reorder
        function reorder(orderId) {
            if (confirm('Bạn có muốn đặt lại các sản phẩm trong đơn hàng này?')) {
                window.location.href = 'order-action.php?action=reorder&id=' + orderId;
            }
        }
    </script>
</body>
</html>
