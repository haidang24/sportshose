<?php
// Modern Admin Dashboard
$statistical = new Statistical();
$product = new Product();
$user = new User();
$order = new Order();

// Get statistics
$total_products = $product->count_products();
$total_users = $user->count_users();
$total_orders = $order->count_orders();
$total_revenue = $statistical->get_total_revenue();
?>

<!-- Dashboard Stats -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon primary">
            <i class="fas fa-box"></i>
        </div>
        <h3 class="stat-value"><?php echo $total_products['dem'] ?? 0; ?></h3>
        <p class="stat-label">Tổng sản phẩm</p>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+12% so với tháng trước</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon success">
            <i class="fas fa-users"></i>
        </div>
        <h3 class="stat-value"><?php echo $total_users['dem'] ?? 0; ?></h3>
        <p class="stat-label">Khách hàng</p>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+8% so với tháng trước</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon warning">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <h3 class="stat-value"><?php echo $total_orders['dem'] ?? 0; ?></h3>
        <p class="stat-label">Đơn hàng</p>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+15% so với tháng trước</span>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon danger">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <h3 class="stat-value"><?php echo number_format($total_revenue['total'] ?? 0); ?>đ</h3>
        <p class="stat-label">Doanh thu</p>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>+22% so với tháng trước</span>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-chart-line"></i>
                Biểu đồ doanh thu 7 ngày qua
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-clock"></i>
                Hoạt động gần đây
            </div>
            <div class="card-body">
                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text">Sản phẩm mới được thêm</p>
                        <small class="activity-time">2 phút trước</small>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon primary">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text">Đơn hàng mới #1234</p>
                        <small class="activity-time">15 phút trước</small>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon warning">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text">Khách hàng mới đăng ký</p>
                        <small class="activity-time">1 giờ trước</small>
                    </div>
                </div>
                
                <div class="activity-item">
                    <div class="activity-icon info">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="activity-content">
                        <p class="activity-text">Tin nhắn liên hệ mới</p>
                        <small class="activity-time">2 giờ trước</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-bolt"></i>
                Thao tác nhanh
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="admin.php?action=product&act=add_product" class="btn btn-primary w-100">
                            <i class="fas fa-plus"></i>
                            Thêm sản phẩm
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="admin.php?action=order" class="btn btn-success w-100">
                            <i class="fas fa-shopping-cart"></i>
                            Xem đơn hàng
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="admin.php?action=user" class="btn btn-warning w-100">
                            <i class="fas fa-users"></i>
                            Quản lý khách hàng
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="admin.php?action=statistical" class="btn btn-danger w-100">
                            <i class="fas fa-chart-bar"></i>
                            Xem thống kê
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Activity Items */
.activity-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem 0;
    border-bottom: 1px solid var(--admin-border-light);
}

.activity-item:last-child {
    border-bottom: none;
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.9rem;
}

.activity-icon.success {
    background: var(--admin-success);
}

.activity-icon.primary {
    background: var(--admin-primary);
}

.activity-icon.warning {
    background: var(--admin-warning);
}

.activity-icon.info {
    background: var(--admin-info);
}

.activity-content {
    flex: 1;
}

.activity-text {
    margin: 0 0 0.25rem 0;
    font-weight: 500;
    color: var(--admin-text-primary);
}

.activity-time {
    color: var(--admin-text-muted);
    font-size: 0.8rem;
}
</style>

<script>
// Revenue Chart
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    
    // Sample data for the last 7 days
    const revenueData = {
        labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
        datasets: [{
            label: 'Doanh thu (VNĐ)',
            data: [1200000, 1900000, 3000000, 5000000, 2000000, 3000000, 4500000],
            borderColor: 'rgb(102, 126, 234)',
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4
        }]
    };
    
    const config = {
        type: 'line',
        data: revenueData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString('vi-VN') + 'đ';
                        }
                    }
                }
            },
            elements: {
                point: {
                    radius: 6,
                    hoverRadius: 8,
                    backgroundColor: 'rgb(102, 126, 234)',
                    borderColor: 'white',
                    borderWidth: 2
                }
            }
        }
    };
    
    new Chart(ctx, config);
});
</script>
