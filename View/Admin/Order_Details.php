<?php
// Get order details from session or parameter
$order_details = isset($_SESSION['order_details']) ? $_SESSION['order_details'] : null;
$order_items = isset($_SESSION['order_items']) ? $_SESSION['order_items'] : [];

if (!$order_details) {
    echo "<div class='alert alert-warning'>Không tìm thấy thông tin đơn hàng</div>";
    return;
}
?>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-file-invoice text-primary"></i>
                    Chi tiết đơn hàng
                </h4>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary" onclick="closeOrderDetails()">
                        <i class="fas fa-times"></i> Đóng
                    </button>
                    <button class="btn btn-primary" onclick="printOrder()">
                        <i class="fas fa-print"></i> In đơn hàng
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Details Cards -->
    <div class="row g-4">
        <!-- Customer Information -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-user"></i>
                        Thông tin khách hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Họ tên:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['fullname'] ?? ''); ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Số điện thoại:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['number_phone'] ?? ''); ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Email:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['email'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-map-marker-alt"></i>
                        Địa chỉ giao hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Địa chỉ:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['address'] ?? ''); ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Tỉnh/Thành phố:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['province'] ?? ''); ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Quận/Huyện:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['district'] ?? ''); ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Phường/Xã:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['wards'] ?? ''); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Information -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle"></i>
                        Thông tin đơn hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Mã đơn hàng:</label>
                            <p class="mb-0"><?php echo htmlspecialchars($order_details['order_id'] ?? ''); ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Ngày đặt:</label>
                            <p class="mb-0"><?php echo isset($order_details['create_at']) ? date('d/m/Y H:i:s', strtotime($order_details['create_at'])) : ''; ?></p>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Trạng thái:</label>
                            <span class="badge bg-<?php 
                                $status = $order_details['status'] ?? 1;
                                switch($status) {
                                    case 1: echo 'warning'; break;
                                    case 2: echo 'info'; break;
                                    case 3: echo 'success'; break;
                                    case 4: echo 'danger'; break;
                                    default: echo 'secondary';
                                }
                            ?>">
                                <?php 
                                switch($status) {
                                    case 1: echo 'Chờ xử lý'; break;
                                    case 2: echo 'Đang giao'; break;
                                    case 3: echo 'Đã giao'; break;
                                    case 4: echo 'Đã hủy'; break;
                                    default: echo 'Không xác định';
                                }
                                ?>
                            </span>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Tổng tiền:</label>
                            <p class="mb-0 text-primary fw-bold"><?php echo isset($order_details['total_amount']) ? number_format($order_details['total_amount']) . ' VNĐ' : '0 VNĐ'; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-credit-card"></i>
                        Phương thức thanh toán
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold">Phương thức:</label>
                            <span class="badge bg-<?php echo ($order_details['payment_method'] ?? 'COD') === 'COD' ? 'success' : 'primary'; ?>">
                                <?php echo ($order_details['payment_method'] ?? 'COD') === 'COD' ? 'COD' : 'PayPal'; ?>
                            </span>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold">Trạng thái thanh toán:</label>
                            <span class="badge bg-success">Đã thanh toán</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-shopping-bag"></i>
                        Sản phẩm trong đơn hàng
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="10%">HÌNH ẢNH</th>
                                    <th width="30%">TÊN SẢN PHẨM</th>
                                    <th width="15%">SIZE</th>
                                    <th width="15%">GIÁ</th>
                                    <th width="15%">SỐ LƯỢNG</th>
                                    <th width="15%">THÀNH TIỀN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($order_items)): ?>
                                    <?php foreach ($order_items as $item): ?>
                                        <tr>
                                            <td>
                                                <img src="<?php echo htmlspecialchars($item['image'] ?? 'assets/img/placeholder.jpg'); ?>" 
                                                     alt="<?php echo htmlspecialchars($item['product_name'] ?? ''); ?>" 
                                                     class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($item['product_name'] ?? ''); ?></strong>
                                            </td>
                                            <td><?php echo htmlspecialchars($item['size'] ?? ''); ?></td>
                                            <td><?php echo isset($item['price']) ? number_format($item['price']) . ' VNĐ' : '0 VNĐ'; ?></td>
                                            <td><?php echo htmlspecialchars($item['quantity'] ?? '0'); ?></td>
                                            <td class="text-primary fw-bold">
                                                <?php echo isset($item['total_price']) ? number_format($item['total_price']) . ' VNĐ' : '0 VNĐ'; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                                            <br>Không có sản phẩm nào trong đơn hàng
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function closeOrderDetails() {
    // Close the modal or redirect back to order list
    window.location.href = 'admin.php?action=order';
}

function printOrder() {
    // Print the order details
    window.print();
}
</script>
