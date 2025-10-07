<!-- Modern Product Management Page -->
<div class="container-fluid">
  <!-- Quick Actions -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="d-flex justify-content-end">
        <a href="admin.php?action=product&act=add_product" class="btn btn-primary">
          <i class="fas fa-plus"></i> Thêm sản phẩm mới
        </a>
      </div>
    </div>
  </div>

  <!-- Filter Section -->
  <div class="row mb-4">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">
            <i class="fas fa-filter text-primary"></i>
            Bộ lọc sản phẩm
          </h5>
        </div>
        <div class="card-body">
          <div class="row g-3">
            <div class="col-md-4">
              <label class="form-label fw-bold">
                <i class="fas fa-shoe-prints text-secondary"></i>
                Loại giày
              </label>
              <select id="shoes_type_id" class="form-select">
                <option value="">-- Chọn loại giày --</option>
                <?php
                $shoes_type = new Shoes_Type();
                $kq = $shoes_type->getAll_Shoes_Type();
                while ($set = $kq->fetch()):
                  ?>
                  <option value="<?php echo $set['id'] ?>"><?php echo $set['name'] ?></option>
                <?php endwhile ?>
              </select>
            </div>
            <div class="col-md-4">
              <label class="form-label fw-bold">
                <i class="fas fa-tags text-secondary"></i>
                Thương hiệu
              </label>
              <select id="brand_id" class="form-select">
                <option value="">-- Chọn thương hiệu --</option>
                <?php
                $brand = new Brand();
                $kq = $brand->getAll_Brand();
                while ($set = $kq->fetch()):
                  ?>
                  <option value="<?php echo $set['id'] ?>"><?php echo $set['name_brand'] ?></option>
                <?php endwhile ?>
              </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
              <button id="filter_btn" class="btn btn-outline-primary me-2">
                <i class="fas fa-search"></i> Lọc
              </button>
              <button id="clear_filter_btn" class="btn btn-outline-secondary">
                <i class="fas fa-times"></i> Xóa lọc
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Products Table -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">
            <i class="fas fa-list text-primary"></i>
            Danh sách sản phẩm
          </h5>
          <div class="d-flex align-items-center">
            <span class="badge badge-primary me-2" id="product_count">0 sản phẩm</span>
            <div class="btn-group" role="group">
              <button type="button" class="btn btn-outline-primary btn-sm" id="view_grid">
                <i class="fas fa-th"></i>
              </button>
              <button type="button" class="btn btn-outline-primary btn-sm active" id="view_list">
                <i class="fas fa-list"></i>
              </button>
            </div>
          </div>
        </div>
        <div class="card-body p-0">
          <!-- Loading State -->
          <div id="loading_state" class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Đang tải...</span>
            </div>
            <p class="mt-3 text-muted">Đang tải danh sách sản phẩm...</p>
          </div>

          <!-- Empty State -->
          <div id="empty_state" class="text-center py-5 d-none">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Không có sản phẩm nào</h5>
            <p class="text-muted">Hãy thêm sản phẩm mới hoặc thay đổi bộ lọc</p>
            <a href="admin.php?action=product&act=add_product" class="btn btn-primary">
              <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>
          </div>

          <!-- Table View -->
          <div id="table_view">
            <div class="table-responsive">
              <table class="table table-hover mb-0">
                <thead class="table-light">
                  <tr>
                    <th width="5%">
                      <input type="checkbox" id="select_all" class="form-check-input">
                    </th>
                    <th width="15%">Hình ảnh</th>
                    <th width="25%">Tên sản phẩm</th>
                    <th width="30%">Mô tả</th>
                    <th width="15%">Loại & Thương hiệu</th>
                    <th width="10%">Trạng thái</th>
                    <th width="10%">Thao tác</th>
                  </tr>
                </thead>
                <tbody id="table_product">
                  <!-- Products will be loaded here -->
                </tbody>
              </table>
            </div>
          </div>

          <!-- Grid View -->
          <div id="grid_view" class="d-none p-3">
            <div class="row" id="grid_products">
              <!-- Grid products will be loaded here -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Custom Styles -->
<style>
.page-title {
  font-size: 2rem;
  font-weight: 700;
  color: var(--admin-text-primary);
  margin: 0;
}

.page-subtitle {
  color: var(--admin-text-muted);
  font-size: 1rem;
  margin: 0;
}

.card {
  border: 1px solid var(--admin-border);
  border-radius: var(--admin-radius-lg);
  box-shadow: var(--admin-shadow);
  transition: var(--admin-transition);
}

.card:hover {
  box-shadow: var(--admin-shadow-lg);
}

.card-header {
  background: var(--admin-bg-secondary);
  border-bottom: 1px solid var(--admin-border);
  padding: 1.5rem;
}

.card-body {
  padding: 1.5rem;
}

.form-select {
  border: 2px solid var(--admin-border);
  border-radius: var(--admin-radius);
  padding: 0.75rem 1rem;
  transition: var(--admin-transition);
}

.form-select:focus {
  border-color: var(--admin-primary);
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.table th {
  background: var(--admin-bg-secondary);
  border-bottom: 2px solid var(--admin-border);
  font-weight: 600;
  color: var(--admin-text-primary);
  padding: 1rem;
  font-size: 0.9rem;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.table td {
  padding: 1rem;
  border-bottom: 1px solid var(--admin-border-light);
  vertical-align: middle;
}

.table tbody tr:hover {
  background: var(--admin-bg-secondary);
}

.product-image {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: var(--admin-radius);
  border: 2px solid var(--admin-border);
}

.product-info {
  display: flex;
  flex-direction: column;
}

.product-name {
  font-weight: 600;
  color: var(--admin-text-primary);
  margin-bottom: 0.25rem;
}

.product-id {
  font-size: 0.8rem;
  color: var(--admin-text-muted);
}

.product-description {
  color: var(--admin-text-secondary);
  font-size: 0.9rem;
  line-height: 1.4;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.product-category {
  font-size: 0.8rem;
  color: var(--admin-text-muted);
}

.badge {
  padding: 0.5rem 1rem;
  border-radius: var(--admin-radius);
  font-size: 0.8rem;
  font-weight: 600;
}

.badge-success {
  background: var(--admin-success);
  color: white;
}

.badge-warning {
  background: var(--admin-warning);
  color: white;
}

.btn-group .btn {
  border-radius: var(--admin-radius);
}

.btn-group .btn.active {
  background: var(--admin-primary);
  border-color: var(--admin-primary);
  color: white;
}

/* Grid View Styles */
.grid-product-card {
  border: 1px solid var(--admin-border);
  border-radius: var(--admin-radius-lg);
  padding: 1rem;
  margin-bottom: 1rem;
  transition: var(--admin-transition);
  background: var(--admin-bg-primary);
}

.grid-product-card:hover {
  box-shadow: var(--admin-shadow-lg);
  transform: translateY(-2px);
}

.grid-product-image {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: var(--admin-radius);
  margin-bottom: 1rem;
}

.grid-product-name {
  font-weight: 600;
  color: var(--admin-text-primary);
  margin-bottom: 0.5rem;
  font-size: 1.1rem;
}

.grid-product-description {
  color: var(--admin-text-secondary);
  font-size: 0.9rem;
  line-height: 1.4;
  margin-bottom: 1rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

/* Responsive */
@media (max-width: 768px) {
  .page-title {
    font-size: 1.5rem;
  }
  
  .card-header {
    padding: 1rem;
  }
  
  .card-body {
    padding: 1rem;
  }
  
  .table-responsive {
    font-size: 0.9rem;
  }
  
  .product-image {
    width: 40px;
    height: 40px;
  }
}
</style>