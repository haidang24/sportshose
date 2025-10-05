<!-- Order History CSS -->
<link rel="stylesheet" href="View/assets/css/order-history.css">

<div class="order-history-container">
<div class="container">
        <!-- Header -->
        <div class="order-header-section">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <a href="index.php" class="back-btn me-3">
                            <i class="fas fa-arrow-left"></i>
                        </a>
                        <div>
                            <h1 class="page-title">Đơn hàng của tôi</h1>
                            <p class="page-subtitle">Quản lý và theo dõi đơn hàng của bạn</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="order-stats">
                        <span class="stat-item">
                            <span class="stat-number" id="total-orders">0</span>
                            <span class="stat-label">Đơn hàng</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-section">
            <div class="filter-tabs-wrapper">
                <div class="filter-tabs">
                    <button class="filter-tab active" data-status="all">
                        <span class="tab-text">Tất cả</span>
                        <span class="tab-count" id="count-all">0</span>
                    </button>
                    <button class="filter-tab" data-status="1">
                        <span class="tab-text">Chờ xử lý</span>
                        <span class="tab-count" id="count-pending">0</span>
                    </button>
                    <button class="filter-tab" data-status="2">
                        <span class="tab-text">Đang giao</span>
                        <span class="tab-count" id="count-shipping">0</span>
                    </button>
                    <button class="filter-tab" data-status="3">
                        <span class="tab-text">Đã giao</span>
                        <span class="tab-count" id="count-delivered">0</span>
                    </button>
                    <button class="filter-tab" data-status="0">
                        <span class="tab-text">Đã hủy</span>
                        <span class="tab-count" id="count-cancelled">0</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Loading State -->
        <div class="loading-container" id="loading-state">
            <div class="loading-content">
                <div class="loading-spinner"></div>
                <p class="loading-text">Đang tải đơn hàng...</p>
            </div>
        </div>

        <!-- Empty State -->
        <div class="empty-container" id="empty-state" style="display: none;">
            <div class="empty-content">
                <div class="empty-icon">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <h3 class="empty-title">Chưa có đơn hàng</h3>
                <p class="empty-subtitle">Bạn chưa có đơn hàng nào. Hãy bắt đầu mua sắm!</p>
                <a href="index.php?action=shop" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-cart me-2"></i>
                    Mua sắm ngay
                </a>
            </div>
        </div>

        <!-- Orders List -->
        <div id="orders-container">
            <input id="user_id" type="hidden" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '' ?>">
        </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Order History Management
class OrderHistory {
    constructor() {
        const userIdElement = document.getElementById('user_id');
        this.userId = userIdElement ? userIdElement.value : null;
        this.orders = [];
        this.filteredOrders = [];
        this.currentFilter = 'all';
        
        console.log('OrderHistory initialized with user_id:', this.userId);
        
        if (!this.userId || this.userId === '') {
            this.showError('Vui lòng đăng nhập để xem lịch sử đơn hàng');
            return;
        }
        
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.loadOrders();
    }

    setupEventListeners() {
        // Filter tabs
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.addEventListener('click', (e) => {
                const status = e.currentTarget.getAttribute('data-status');
                this.filterOrders(status);
                this.updateActiveTab(e.currentTarget);
            });
        });

        // Orders container click handler
        document.getElementById('orders-container').addEventListener('click', (e) => {
            const btn = e.target.closest('[data-action]');
            if (!btn) return;

            const action = btn.getAttribute('data-action');
            const orderId = btn.getAttribute('data-order');

            switch(action) {
                case 'view-details':
                    this.resetModal();
                    this.viewOrderDetails(orderId);
                    break;
                case 'cancel-order':
                    this.cancelOrder(orderId);
                    break;
            }
        });
    }

    async loadOrders() {
        try {
            this.showLoading();
            
            console.log('Loading orders for user_id:', this.userId);
            
            const response = await fetch('Controller/order_history.php?act=get_all_order', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'user_id=' + encodeURIComponent(this.userId)
            });

            console.log('Response status:', response.status);
            console.log('Response ok:', response.ok);

            if (!response.ok) {
                const errorText = await response.text();
                console.error('Response error:', errorText);
                throw new Error(`Network response was not ok: ${response.status} - ${errorText}`);
            }

            const responseText = await response.text();
            console.log('Raw response:', responseText);
            
            let orders;
            try {
                orders = JSON.parse(responseText);
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                throw new Error('Invalid JSON response: ' + responseText);
            }
            
            console.log('Parsed orders:', orders);

            if (!Array.isArray(orders)) {
                console.error('Orders is not an array:', typeof orders, orders);
                throw new Error('Invalid response format - expected array');
            }

            this.orders = orders;
            console.log('Orders loaded successfully, count:', orders.length);
            this.filterOrders(this.currentFilter);
            
        } catch (error) {
            console.error('Error loading orders:', error);
            this.showError('Không thể tải lịch sử đơn hàng: ' + error.message);
        }
    }

    filterOrders(status) {
        this.currentFilter = status;
        
        if (status === 'all') {
            this.filteredOrders = [...this.orders];
        } else {
            this.filteredOrders = this.orders.filter(order => 
                order.status == status
            );
        }

        this.renderOrders();
    }

    updateActiveTab(activeTab) {
        document.querySelectorAll('.filter-tab').forEach(tab => {
            tab.classList.remove('active');
        });
        activeTab.classList.add('active');
    }

    updateOrderCounts() {
        const counts = {
            all: this.orders.length,
            pending: this.orders.filter(order => order.status == 1).length,
            shipping: this.orders.filter(order => order.status == 2).length,
            delivered: this.orders.filter(order => order.status == 3).length,
            cancelled: this.orders.filter(order => order.status == 0).length
        };

        // Update count badges
        document.getElementById('count-all').textContent = counts.all;
        document.getElementById('count-pending').textContent = counts.pending;
        document.getElementById('count-shipping').textContent = counts.shipping;
        document.getElementById('count-delivered').textContent = counts.delivered;
        document.getElementById('count-cancelled').textContent = counts.cancelled;

        // Update total orders stat
        document.getElementById('total-orders').textContent = counts.all;
    }

    renderOrders() {
        const container = document.getElementById('orders-container');
        const loadingState = document.getElementById('loading-state');
        const emptyState = document.getElementById('empty-state');

        // Hide loading state
        loadingState.style.display = 'none';

        // Update order counts
        this.updateOrderCounts();

        if (this.filteredOrders.length === 0) {
            emptyState.style.display = 'block';
            container.innerHTML = '';
          return;
        }

        emptyState.style.display = 'none';
        
        
        const ordersHtml = this.filteredOrders.map(order => this.createOrderCard(order)).join('');
        container.innerHTML = ordersHtml;
    }

    createOrderCard(order) {
        const statusInfo = this.getStatusInfo(order.status);
        const formatDate = (dateString) => {
            if (!dateString) return 'N/A';
            return new Date(dateString).toLocaleDateString('vi-VN', {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit'
            });
        };

        const canCancel = order.status == 1 && order.payment_method !== 'PayPal'; // Only pending orders can be cancelled, except PayPal
        const formatPrice = (price) => {
            // Handle null, undefined, or non-numeric values
            if (price === null || price === undefined || price === '' || isNaN(price)) {
                return '0đ';
            }
            // Convert to number and format
            const numPrice = parseFloat(price);
            if (isNaN(numPrice)) {
                return '0đ';
            }
            return new Intl.NumberFormat('vi-VN').format(numPrice) + 'đ';
        };

        // Get first few items for preview
        const items = order.items || [];
        const previewItems = items.slice(0, 3);
        const remainingItems = items.length - 3;

        return `
            <div class="order-card">
                <div class="order-card-header">
                    <div class="order-info">
                        <h3 class="order-id">Đơn hàng #${order.order_id}</h3>
                        <p class="order-date">${formatDate(order.create_at)}</p>
                        <p class="order-payment-method">
                            <i class="fas fa-credit-card me-1"></i>
                            Thanh toán: <strong>${order.payment_method || 'COD'}</strong>
                            ${order.payment_method === 'PayPal' ? '<span class="badge bg-info ms-1">Đã thanh toán</span>' : ''}
                        </p>
                    </div>
                    <div class="order-status ${statusInfo.class}">
                        ${statusInfo.text}
                    </div>
                </div>
                
                <div class="order-card-body">
                    ${items.length > 0 ? `
                        <div class="order-items">
                            ${previewItems.map(item => `
                                <div class="order-item">
                                    <img src="${item.image || 'View/assets/img/placeholder.jpg'}" 
                                         alt="${item.product_name}" 
                                         class="order-item-image"
                                         onerror="this.src='View/assets/img/placeholder.jpg'">
                                    <div class="order-item-info">
                                        <div class="order-item-name">${item.product_name}</div>
                                        <div class="order-item-details">
                                            ${item.size ? `Size: ${item.size}` : ''} 
                                            ${item.size && item.quantity ? ' | ' : ''}
                                            ${item.quantity ? `Số lượng: ${item.quantity}` : ''}
                                        </div>
                                    </div>
                                    <div class="order-item-price">
                                        ${formatPrice(item.price * item.quantity)}
                                    </div>
                                </div>
                            `).join('')}
                            
                            ${remainingItems > 0 ? `
                                <div class="order-more-items">
                                    <i class="fas fa-ellipsis-h"></i>
                                    <span>và ${remainingItems} sản phẩm khác</span>
                                </div>
                            ` : ''}
                        </div>
                    ` : `
                        <div class="order-items">
                            <div class="order-item">
                                <div class="order-item-info">
                                    <div class="order-item-name">Đơn hàng đã được xử lý</div>
                                    <div class="order-item-details">Chi tiết sản phẩm sẽ được hiển thị trong modal</div>
                                </div>
                            </div>
                        </div>
                    `}
                    
                    <div class="order-summary">
                        <div class="order-total">
                            <span class="order-total-label">Tổng tiền:</span>
                            <span class="order-total-value">${formatPrice(order.total_amount || order.total_price || order.total || 0)}</span>
                        </div>
                        <div class="order-actions">
                            <button class="btn btn-outline-primary btn-sm" 
                                    data-action="view-details" 
                                    data-order="${order.order_id}" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modal_order_details">
                                <i class="fas fa-eye me-1"></i>
                                Chi tiết
                            </button>
                            ${canCancel ? `
                                <button class="btn btn-outline-danger btn-sm" 
                                        data-action="cancel-order" 
                                        data-order="${order.order_id}">
                                    <i class="fas fa-times me-1"></i>
                                    Hủy đơn
                                </button>
                            ` : ''}
                        </div>
                    </div>
                </div>
              </div>
        `;
    }

    getStatusInfo(status) {
        const statusMap = {
            '0': { text: 'Đã hủy', class: 'cancelled', icon: 'fas fa-times-circle' },
            '1': { text: 'Chờ xử lý', class: 'pending', icon: 'fas fa-clock' },
            '2': { text: 'Đang giao', class: 'shipping', icon: 'fas fa-shipping-fast' },
            '3': { text: 'Đã giao', class: 'delivered', icon: 'fas fa-check-circle' }
        };
        
        return statusMap[status] || { text: 'Không xác định', class: 'pending', icon: 'fas fa-question-circle' };
    }

    async viewOrderDetails(orderId) {
        try {
            // Get order details (products)
            const detailsResponse = await fetch('Controller/order_history.php?act=get_order_details', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'order_id=' + encodeURIComponent(orderId)
            });

            const details = await detailsResponse.json();
            
            // Get order info from current orders list
            const orderInfo = this.orders.find(order => order.order_id === orderId);
            
            if (!orderInfo) {
                this.showModalError('Không tìm thấy thông tin đơn hàng.');
                return;
              }
            
            this.renderOrderDetails(details, orderInfo);
            
        } catch (error) {
            console.error('Error loading order details:', error);
            Swal.fire('Lỗi', 'Không thể tải chi tiết đơn hàng', 'error');
        }
    }

    renderOrderDetails(details, orderInfo) {
        // Hide loading and show content
        document.getElementById('modal-loading').style.display = 'none';
        document.getElementById('modal-content-details').style.display = 'block';
        
        const footerSum = document.getElementById('sum_price_order');
        
        if (!Array.isArray(details) || details.length === 0) {
            this.showModalError('Không có chi tiết đơn hàng.');
            footerSum.textContent = '0đ';
            return;
        }

        const orderId = orderInfo.order_id;
        const statusInfo = this.getStatusInfo(orderInfo.status);
        
        // Update modal header
        document.getElementById('modal-order-id').textContent = `Đơn hàng #${orderId}`;
        const statusBadge = document.querySelector('#modal-order-status .status-badge');
        statusBadge.textContent = statusInfo.text;
        statusBadge.className = `status-badge ${statusInfo.class}`;

        // Populate customer info
        const customerInfo = document.getElementById('customer-info');
        customerInfo.innerHTML = `
            <div class="info-item">
                <span class="info-label">Họ và tên</span>
                <span class="info-value">${orderInfo.fullname || 'N/A'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Số điện thoại</span>
                <span class="info-value">${orderInfo.number_phone || 'N/A'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Mã đơn hàng</span>
                <span class="info-value">${orderInfo.order_id || 'N/A'}</span>
            </div>
        `;

        // Populate shipping info
        const shippingInfo = document.getElementById('shipping-info');
        const fullAddress = [orderInfo.address, orderInfo.wards, orderInfo.district, orderInfo.province]
            .filter(part => part && part.trim())
            .join(', ');
            
        shippingInfo.innerHTML = `
            <div class="info-item">
                <span class="info-label">Địa chỉ giao hàng</span>
                <span class="info-value">${fullAddress || 'N/A'}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Ngày đặt</span>
                <span class="info-value">${this.formatDateTime(orderInfo.create_at)}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Trạng thái đơn hàng</span>
                <span class="info-value">${statusInfo.text}</span>
            </div>
        `;

        // Populate order items
        let total = 0;
        const itemsHtml = details.map(item => {
            const itemTotal = Number(item.total_price || 0);
            total += itemTotal;
            
            return `
                <div class="order-item-detail">
                    <img src="View/assets/img/upload/${item.img}" 
                         alt="${item.name_product}" 
                         class="order-item-detail-image"
                         onerror="this.src='View/assets/img/placeholder.jpg'">
                    <div class="order-item-detail-info">
                        <div class="order-item-detail-name">${item.name_product}</div>
                        <div class="order-item-detail-specs">
                            Size: ${item.size}
                        </div>
                        <div class="order-item-detail-price">
                            ${Number(item.price || 0).toLocaleString('vi-VN')}đ
                        </div>
                    </div>
                    <div class="order-item-detail-quantity">
                        ${item.quantity}
                    </div>
                    <div class="order-item-detail-total">
                        ${itemTotal.toLocaleString('vi-VN')}đ
                    </div>
                </div>
            `;
        }).join('');

        document.getElementById('order-items-detail').innerHTML = itemsHtml;

        // Populate summary
        const summaryHtml = `
            <div class="summary-row">
                <span class="summary-label">Tạm tính:</span>
                <span class="summary-value">${total.toLocaleString('vi-VN')}đ</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Phí vận chuyển:</span>
                <span class="summary-value">Miễn phí</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Giảm giá:</span>
                <span class="summary-value">0đ</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Tổng cộng:</span>
                <span class="summary-value">${total.toLocaleString('vi-VN')}đ</span>
            </div>
        `;
        
        document.getElementById('order-summary-details').innerHTML = summaryHtml;
        footerSum.textContent = total.toLocaleString('vi-VN') + 'đ';
    }

    formatDateTime(dateString) {
        if (!dateString || dateString === 'null' || dateString === '') {
            return 'N/A';
        }
        
        try {
            const date = new Date(dateString);
            if (isNaN(date.getTime())) {
                return 'N/A';
            }
            
            return date.toLocaleDateString('vi-VN', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (error) {
            console.error('Error formatting date:', error);
            return 'N/A';
        }
    }

    resetModal() {
        // Show loading state
        document.getElementById('modal-loading').style.display = 'block';
        document.getElementById('modal-content-details').style.display = 'none';
        
        // Reset header
        document.getElementById('modal-order-id').textContent = 'Đang tải...';
        const statusBadge = document.querySelector('#modal-order-status .status-badge');
        statusBadge.textContent = 'Đang tải...';
        statusBadge.className = 'status-badge';
        
        // Reset footer
        document.getElementById('sum_price_order').textContent = '0đ';
    }

    showModalError(message) {
        document.getElementById('modal-loading').style.display = 'none';
        document.getElementById('modal-content-details').innerHTML = `
            <div class="text-center py-5">
                <i class="fas fa-exclamation-triangle text-warning" style="font-size: 48px;"></i>
                <h4 class="mt-3 text-muted">${message}</h4>
            </div>
        `;
        document.getElementById('modal-content-details').style.display = 'block';
    }

    async cancelOrder(orderId) {
        const result = await Swal.fire({
            title: 'Xác nhận hủy đơn hàng',
            text: 'Bạn có chắc chắn muốn hủy đơn hàng này? Hành động này không thể hoàn tác.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Có, hủy đơn!',
            cancelButtonText: 'Không'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch('Controller/order_history.php?act=cancel_order', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'order_id=' + encodeURIComponent(orderId)
                });

                const data = await response.json();
                
                if (data.status === 'success') {
                    await Swal.fire({
                        title: 'Thành công!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    
                    // Reload orders to reflect changes
                    this.loadOrders();
                } else {
                    await Swal.fire({
                        title: 'Lỗi!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
                
            } catch (error) {
                console.error('Error cancelling order:', error);
                await Swal.fire({
                    title: 'Lỗi!',
                    text: 'Không thể hủy đơn hàng. Vui lòng thử lại.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    }

    showLoading() {
        document.getElementById('loading-state').style.display = 'block';
        document.getElementById('empty-state').style.display = 'none';
        document.getElementById('orders-container').innerHTML = '';
    }

    showError(message) {
        document.getElementById('loading-state').style.display = 'none';
        document.getElementById('empty-state').style.display = 'none';
        document.getElementById('orders-container').innerHTML = `
            <div class="alert alert-danger text-center">
                <i class="fas fa-exclamation-triangle"></i> ${message}
            </div>
        `;
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new OrderHistory();
});
</script>

<!-- Modal Order Details -->
<div class="modal fade order-details-modal" id="modal_order_details" tabindex="-1" aria-labelledby="modal_order_details" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <div class="modal-header-content">
               <div class="modal-title-section">
                  <h4 class="modal-title">
                     <i class="fas fa-receipt me-2"></i>
                     Chi tiết đơn hàng
                  </h4>
                  <p class="modal-subtitle" id="modal-order-id">Đang tải...</p>
               </div>
               <div class="modal-status" id="modal-order-status">
                  <span class="status-badge">Đang tải...</span>
               </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         
         <div class="modal-body">
            <div class="order-details-container">
               <!-- Loading State -->
               <div class="modal-loading" id="modal-loading">
                  <div class="loading-spinner"></div>
                  <p class="loading-text">Đang tải chi tiết đơn hàng...</p>
               </div>
               
               <!-- Order Details Content -->
               <div class="modal-content-details" id="modal-content-details" style="display: none;">
                  <!-- Customer Info -->
                  <div class="order-info-section">
                     <h5 class="section-title">
                        <i class="fas fa-user me-2"></i>
                        Thông tin khách hàng
                     </h5>
                     <div class="info-grid" id="customer-info">
                        <!-- Customer info will be populated here -->
                     </div>
                  </div>
                  
                  <!-- Shipping Info -->
                  <div class="order-info-section">
                     <h5 class="section-title">
                        <i class="fas fa-shipping-fast me-2"></i>
                        Thông tin giao hàng
                     </h5>
                     <div class="info-grid" id="shipping-info">
                        <!-- Shipping info will be populated here -->
                     </div>
                  </div>
                  
                  <!-- Order Items -->
                  <div class="order-info-section">
                     <h5 class="section-title">
                        <i class="fas fa-box me-2"></i>
                        Sản phẩm đã đặt
                     </h5>
                     <div class="order-items-detail" id="order-items-detail">
                        <!-- Order items will be populated here -->
                     </div>
                  </div>
                  
                  <!-- Order Summary -->
                  <div class="order-summary-section">
                     <h5 class="section-title">
                        <i class="fas fa-calculator me-2"></i>
                        Tổng kết đơn hàng
                     </h5>
                     <div class="summary-details" id="order-summary-details">
                        <!-- Summary will be populated here -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
         <div class="modal-footer">
            <div class="footer-content">
               <div class="order-total-display">
                  <span class="total-label">Tổng cộng:</span>
                  <span class="total-amount" id="sum_price_order">0đ</span>
               </div>
               <div class="footer-actions">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                     <i class="fas fa-times me-1"></i>
                     Đóng
                  </button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>