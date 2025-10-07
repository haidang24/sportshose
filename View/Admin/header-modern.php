<?php
// Modern Admin Header
$admin_name = $_SESSION['admin_fullname'] ?? 'Admin';
$admin_role = $_SESSION['admin_position'] ?? 'Quản trị viên';
$admin_initial = strtoupper(substr($admin_name, 0, 1));
?>

<!-- Modern Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="admin.php" class="sidebar-brand">
            <i class="fas fa-shoe-prints"></i>
            <span class="nav-text">ShoeShop Admin</span>
        </a>
    </div>
    
    <nav class="sidebar-nav">
        <!-- Dashboard -->
        <div class="nav-item">
            <a href="admin.php" class="nav-link <?php echo (!isset($_GET['action']) || $_GET['action'] == '') ? 'active' : ''; ?>">
                <i class="fas fa-tachometer-alt"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </div>
        
        <!-- User Management -->
        <div class="nav-item">
            <a href="#" class="nav-link <?php echo (isset($_GET['action']) && in_array($_GET['action'], ['user', 'admin', 'contact'])) ? 'active' : ''; ?>" 
               data-bs-toggle="collapse" data-bs-target="#userMenu" aria-expanded="false">
                <i class="fas fa-users"></i>
                <span class="nav-text">Quản lý người dùng</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="userMenu">
                <div class="nav-item">
                    <a href="admin.php?action=admin" class="nav-link">
                        <i class="fas fa-user-tie"></i>
                        <span class="nav-text">Nhân viên</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="admin.php?action=user" class="nav-link">
                        <i class="fas fa-user-friends"></i>
                        <span class="nav-text">Khách hàng</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="admin.php?action=contact" class="nav-link">
                        <i class="fas fa-envelope"></i>
                        <span class="nav-text">Liên hệ</span>
                        <?php
                        $contact = new Contact();
                        $sum_contact = $contact->count_contact();
                        if ($sum_contact['dem'] > 0):
                        ?>
                        <span class="badge badge-danger ms-auto"><?php echo $sum_contact['dem']; ?></span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="admin.php?action=user&act=khoiphuc" class="nav-link">
                        <i class="fas fa-undo"></i>
                        <span class="nav-text">Khôi phục</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Product Management -->
        <div class="nav-item">
            <a href="#" class="nav-link <?php echo (isset($_GET['action']) && $_GET['action'] == 'product') ? 'active' : ''; ?>" 
               data-bs-toggle="collapse" data-bs-target="#productMenu" aria-expanded="false">
                <i class="fas fa-box"></i>
                <span class="nav-text">Quản lý sản phẩm</span>
                <i class="fas fa-chevron-down ms-auto"></i>
            </a>
            <div class="collapse" id="productMenu">
                <div class="nav-item">
                    <a href="admin.php?action=product" class="nav-link">
                        <i class="fas fa-list"></i>
                        <span class="nav-text">Danh sách sản phẩm</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="admin.php?action=product&act=add_product" class="nav-link">
                        <i class="fas fa-plus"></i>
                        <span class="nav-text">Thêm sản phẩm</span>
                    </a>
                </div>
                <div class="nav-item">
                    <a href="admin.php?action=product&act=product_detailss" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span class="nav-text">Thêm chi tiết</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Order Management -->
        <div class="nav-item">
            <a href="admin.php?action=order" class="nav-link <?php echo (isset($_GET['action']) && in_array($_GET['action'], ['order', 'order_deliveried', 'order_cancel'])) ? 'active' : ''; ?>">
                <i class="fas fa-shopping-cart"></i>
                <span class="nav-text">Quản lý đơn hàng</span>
            </a>
        </div>
    </nav>
</div>

<!-- Main Content -->
<div class="main-content" id="mainContent">
    <!-- Top Navigation -->
    <nav class="top-navbar">
        <div class="navbar-content">
            <div class="navbar-left">
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="admin.php">
                                <i class="fas fa-home"></i> Dashboard
                            </a>
                        </li>
                        <?php if (isset($_GET['action']) && $_GET['action'] != ''): ?>
                        <li class="breadcrumb-item active">
                            <?php
                            $action_names = [
                                'user' => 'Khách hàng',
                                'admin' => 'Nhân viên',
                                'contact' => 'Liên hệ',
                                'product' => 'Sản phẩm',
                                'order' => 'Đơn hàng',
                                'order_deliveried' => 'Đơn hàng đã giao',
                                'order_cancel' => 'Đơn hàng đã hủy'
                            ];
                            echo $action_names[$_GET['action']] ?? ucfirst($_GET['action']);
                            ?>
                        </li>
                        <?php endif; ?>
                    </ol>
                </nav>
            </div>
            
            <div class="navbar-right">
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn btn-outline" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge badge-danger">3</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Thông báo</h6>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-shopping-cart text-primary"></i>
                            Đơn hàng mới #1234
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user text-success"></i>
                            Khách hàng mới đăng ký
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-envelope text-warning"></i>
                            Tin nhắn liên hệ mới
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-center" href="#">Xem tất cả</a>
                    </div>
                </div>
                
                <!-- User Menu -->
                <div class="dropdown">
                    <button class="user-info" type="button" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <?php echo $admin_initial; ?>
                        </div>
                        <div class="user-details">
                            <div class="user-name"><?php echo $admin_name; ?></div>
                            <div class="user-role"><?php echo $admin_role; ?></div>
                        </div>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <h6 class="dropdown-header">Tài khoản</h6>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-user"></i> Hồ sơ
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-cog"></i> Cài đặt
                        </a>
                        <a class="dropdown-item" href="#">
                            <i class="fas fa-key"></i> Đổi mật khẩu
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="index.php">
                            <i class="fas fa-external-link-alt"></i> Xem website
                        </a>
                        <a class="dropdown-item text-danger" href="admin.php?action=logout">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <?php
                $page_icons = [
                    'user' => 'fas fa-user-friends',
                    'admin' => 'fas fa-user-tie',
                    'contact' => 'fas fa-envelope',
                    'product' => 'fas fa-box',
                    'order' => 'fas fa-shopping-cart',
                    'order_deliveried' => 'fas fa-check-circle',
                    'order_cancel' => 'fas fa-times-circle'
                ];
                $current_action = $_GET['action'] ?? '';
                $page_icon = $page_icons[$current_action] ?? 'fas fa-tachometer-alt';
                ?>
                <i class="<?php echo $page_icon; ?>"></i>
                <?php
                $page_titles = [
                    'user' => 'Quản lý khách hàng',
                    'admin' => 'Quản lý nhân viên',
                    'contact' => 'Quản lý liên hệ',
                    'product' => 'Quản lý sản phẩm',
                    'order' => 'Quản lý đơn hàng',
                    'order_deliveried' => 'Đơn hàng đã giao',
                    'order_cancel' => 'Đơn hàng đã hủy'
                ];
                echo $page_titles[$current_action] ?? 'Dashboard';
                ?>
            </h1>
            <p class="page-subtitle">
                <?php
                $page_subtitles = [
                    'user' => 'Quản lý thông tin và trạng thái khách hàng',
                    'admin' => 'Quản lý tài khoản và quyền hạn nhân viên',
                    'contact' => 'Xem và phản hồi tin nhắn từ khách hàng',
                    'product' => 'Quản lý danh mục sản phẩm và thông tin chi tiết',
                    'order' => 'Theo dõi và xử lý đơn hàng',
                    'order_deliveried' => 'Xem các đơn hàng đã được giao thành công',
                    'order_cancel' => 'Xem các đơn hàng đã bị hủy'
                ];
                echo $page_subtitles[$current_action] ?? 'Tổng quan hệ thống quản trị';
                ?>
            </p>
        </div>

<script>
// Sidebar Toggle Functionality
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    // Toggle sidebar
    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('collapsed');
        mainContent.classList.toggle('expanded');
        
        // Save state to localStorage
        const isCollapsed = sidebar.classList.contains('collapsed');
        localStorage.setItem('sidebarCollapsed', isCollapsed);
    });
    
    // Restore sidebar state
    const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (isCollapsed) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
    }
    
    // Mobile sidebar toggle
    if (window.innerWidth <= 768) {
        sidebar.classList.add('collapsed');
        mainContent.classList.add('expanded');
    }
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        } else {
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            if (!isCollapsed) {
                sidebar.classList.remove('collapsed');
                mainContent.classList.remove('expanded');
            }
        }
    });
    
    // Auto-collapse submenus on mobile
    if (window.innerWidth <= 768) {
        const collapseElements = document.querySelectorAll('.collapse');
        collapseElements.forEach(collapse => {
            collapse.classList.remove('show');
        });
    }
});
</script>
