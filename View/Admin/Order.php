
<!-- Simple Order Management -->
<div class="container-fluid">
  <!-- Simple Header -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex gap-2">
          <span class="badge bg-primary" id="total_orders_count">0 đơn hàng</span>
          <button class="btn btn-outline-primary btn-sm" id="export_orders_btn">
            <i class="fas fa-download"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Simple Stats -->
  <div class="row mb-3">
    <div class="col-md-3">
      <div class="simple-stat-card">
        <div class="stat-number" id="count_order_wating">0</div>
        <div class="stat-label">Chờ xử lý</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="simple-stat-card">
        <div class="stat-number" id="count_order_shipping">0</div>
        <div class="stat-label">Đang giao</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="simple-stat-card">
        <div class="stat-number" id="count_order_delivered">0</div>
        <div class="stat-label">Đã giao</div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="simple-stat-card">
        <div class="stat-number" id="count_order_cancelled">0</div>
        <div class="stat-label">Đã hủy</div>
      </div>
    </div>
  </div>

  <!-- Simple Filter -->
  <div class="row mb-3">
    <div class="col-12">
      <div class="card">
        <div class="card-body py-2">
          <div class="row g-2 align-items-end">
            <div class="col-md-2">
              <label class="form-label small">Trạng thái</label>
              <select id="status_filter" class="form-select form-select-sm">
                <option value="">Tất cả</option>
                <option value="1">Chờ xử lý</option>
                <option value="2">Đang giao</option>
                <option value="3">Đã giao</option>
                <option value="4">Đã hủy</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label small">Thanh toán</label>
              <select id="payment_filter" class="form-select form-select-sm">
                <option value="">Tất cả</option>
                <option value="COD">COD</option>
                <option value="PayPal">PayPal</option>
              </select>
            </div>
            <div class="col-md-2">
              <label class="form-label small">Từ ngày</label>
              <input type="date" id="date_from" class="form-control form-control-sm">
            </div>
            <div class="col-md-2">
              <label class="form-label small">Đến ngày</label>
              <input type="date" id="date_to" class="form-control form-control-sm">
            </div>
            <div class="col-md-3">
              <label class="form-label small">Tìm kiếm</label>
              <input type="text" id="search_orders" class="form-control form-control-sm" placeholder="Mã đơn, tên KH...">
            </div>
            <div class="col-md-1">
              <button id="clear_filter_orders_btn" class="btn btn-outline-secondary btn-sm w-100">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Simple Orders Table -->
   <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body p-0">
          <!-- Loading State -->
          <div id="loading_orders" class="text-center py-4">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Đang tải...</span>
            </div>
            <p class="mt-2 text-muted small">Đang tải...</p>
          </div>

          <!-- Empty State -->
          <div id="empty_orders" class="text-center py-5 d-none">
            <i class="fas fa-shopping-cart fa-2x text-muted mb-3"></i>
            <p class="text-muted">Không có đơn hàng nào</p>
          </div>

          <!-- Table View -->
          <div id="table_orders_view">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th width="5%">
                      <input type="checkbox" id="select_all_orders" class="form-check-input">
                    </th>
                    <th width="10%">Mã đơn</th>
                    <th width="20%">Khách hàng</th>
                    <th width="25%">Địa chỉ</th>
                    <th width="10%">Thanh toán</th>
                    <th width="10%">Tổng tiền</th>
                    <th width="10%">Trạng thái</th>
                    <th width="10%">Thao tác</th>
               </tr>
            </thead>
                <tbody id="table_order">
                  <!-- Orders will be loaded here -->
                </tbody>
         </table>
            </div>
          </div>
        </div>
      </div>
      </div>
   </div>
</div>

<!-- Modal Order Details -->
<div class="modal fade" id="modal_order_details" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fw-bold" id="orderDetailsModalLabel">
               <i class="fas fa-receipt text-primary"></i>
               Chi tiết đơn hàng
            </h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <!-- Order Info -->
            <div class="row mb-4">
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-header">
                        <h6 class="mb-0">
                           <i class="fas fa-user text-primary"></i>
                           Thông tin khách hàng
                        </h6>
                     </div>
                     <div class="card-body" id="customer_info">
                        <!-- Customer info will be loaded here -->
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-header">
                        <h6 class="mb-0">
                           <i class="fas fa-map-marker-alt text-primary"></i>
                           Địa chỉ giao hàng
                        </h6>
                     </div>
                     <div class="card-body" id="shipping_address">
                        <!-- Shipping address will be loaded here -->
                     </div>
                  </div>
               </div>
            </div>

            <!-- Order Summary -->
            <div class="row mb-4">
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-header">
                        <h6 class="mb-0">
                           <i class="fas fa-info-circle text-primary"></i>
                           Thông tin đơn hàng
                        </h6>
                     </div>
                     <div class="card-body" id="order_summary">
                        <!-- Order summary will be loaded here -->
                     </div>
                  </div>
               </div>
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-header">
                        <h6 class="mb-0">
                           <i class="fas fa-credit-card text-primary"></i>
                           Phương thức thanh toán
                        </h6>
                     </div>
                     <div class="card-body" id="payment_info">
                        <!-- Payment info will be loaded here -->
                     </div>
                  </div>
               </div>
            </div>

            <!-- Order Items -->
            <div class="card">
               <div class="card-header">
                  <h6 class="mb-0">
                     <i class="fas fa-shopping-bag text-primary"></i>
                     Sản phẩm trong đơn hàng
                  </h6>
               </div>
               <div class="card-body p-0">
                  <div class="table-responsive">
                     <table class="table table-hover mb-0">
                        <thead class="table-light">
                           <tr>
                              <th>Hình ảnh</th>
                              <th>Tên sản phẩm</th>
                              <th>Size</th>
                              <th>Giá</th>
                              <th>Số lượng</th>
                              <th>Thành tiền</th>
                           </tr>
                        </thead>
                        <tbody id="order_items_table">
                           <!-- Order items will be loaded here -->
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>

            <!-- Order Total -->
            <div class="row mt-4">
               <div class="col-md-6"></div>
               <div class="col-md-6">
                  <div class="card">
                     <div class="card-body" id="order_total">
                        <!-- Order total will be loaded here -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
               <i class="fas fa-times"></i> Đóng
            </button>
            <button type="button" class="btn btn-primary" id="print_order_btn">
               <i class="fas fa-print"></i> In đơn hàng
            </button>
         </div>
      </div>
   </div>
</div>

<!-- Simple Clean Styles -->
<style>
/* Simple Stat Cards */
.simple-stat-card {
   background: white;
   border-radius: 8px;
   padding: 1rem;
   text-align: center;
   border: 1px solid #e9ecef;
   transition: all 0.2s ease;
}

.simple-stat-card:hover {
   box-shadow: 0 2px 8px rgba(0,0,0,0.1);
   transform: translateY(-1px);
}

.stat-number {
   font-size: 2rem;
   font-weight: 700;
   color: #495057;
   margin-bottom: 0.25rem;
}

.stat-label {
   color: #6c757d;
   font-size: 0.9rem;
   font-weight: 500;
}

/* Status Badges */
.status-badge {
   padding: 0.25rem 0.75rem;
   border-radius: 12px;
   font-size: 0.75rem;
   font-weight: 600;
   text-transform: uppercase;
}

.status-badge.pending {
   background: #fff3cd;
   color: #856404;
}

.status-badge.shipping {
   background: #d1ecf1;
   color: #0c5460;
}

.status-badge.delivered {
   background: #d4edda;
   color: #155724;
}

.status-badge.cancelled {
   background: #f8d7da;
   color: #721c24;
}

/* Payment Method Badges */
.payment-method {
   padding: 0.25rem 0.5rem;
   border-radius: 8px;
   font-size: 0.75rem;
   font-weight: 600;
}

.payment-method.cod {
   background: #fff3cd;
   color: #856404;
}

.payment-method.paypal {
   background: #d1ecf1;
   color: #0c5460;
}

/* Table Styles */
.table tbody tr:hover {
   background-color: #f8f9fa;
}

.table tbody td {
   padding: 0.75rem;
   vertical-align: middle;
   border-top: 1px solid #dee2e6;
}

/* Simple Button Styles */
.btn-sm {
   padding: 0.25rem 0.5rem;
   font-size: 0.875rem;
}

/* Responsive */
@media (max-width: 768px) {
   .simple-stat-card {
      padding: 0.75rem;
   }
   
   .stat-number {
      font-size: 1.5rem;
   }
   
   .table-responsive {
      font-size: 0.875rem;
   }
}
</style>

<!-- Include Order JavaScript -->
<script src="ajax/Order.js"></script>