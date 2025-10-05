<link rel="stylesheet" href="View/assets/css/ecommerce.css">

<div class="ecommerce-container">
   <div class="cart-wrapper">
      <div class="cart-header">
         <h1 class="cart-title">
            <i class="fas fa-shopping-cart"></i>
            Giỏ Hàng Của Bạn
         </h1>
         <p class="cart-subtitle">Kiểm tra và chỉnh sửa các sản phẩm trước khi thanh toán</p>
      </div>

      <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
         <div class="premium-cart-table">
            <div class="cart-table-header">
               <h2 class="cart-table-title">
                  <i class="fas fa-box"></i>
                  Danh Sách Sản Phẩm
               </h2>
            </div>
            
            <table class="cart-table">
            <thead>
               <tr>
                  <th class="cart-col-product">Sản phẩm</th>
                  <th class="cart-col-price">Đơn giá</th>
                  <th class="cart-col-qty">Số lượng</th>
                  <th class="cart-col-total">Thành tiền</th>
               </tr>
            </thead>
            <tbody>
                  <?php foreach ($_SESSION['cart'] as $cart): ?>
                     <tr class="cart-item-row">
                        <td>
                           <div class="cart-item">
                              <img class="cart-product-image"
                                 src="View/assets/img/upload/<?php echo $cart['img'] ?>" 
                                 alt="<?php echo htmlspecialchars($cart['name']) ?>">
                              <div class="cart-product-info">
                                 <div class="cart-product-name"><?php echo $cart['name'] ?></div>
                                 <div class="cart-product-details"><?php echo $cart['shoes_type'] . " - " . $cart['brand'] ?></div>
                                 <div class="cart-product-size">Size: <?php echo $cart['size'] ?></div>
                                 <div class="cart-stock-info">
                                    <span data-name="<?php echo htmlspecialchars($cart['name']); ?>" data-size="<?php echo $cart['size']; ?>" class="stock-badge repo_cart">Kho:</span>
                                    <small class="stock-count"></small>
                                 </div>
                                 <button id="drop_ItemCart" value="<?php echo $cart['idsp'] ?>" class="cart-remove-btn">
                                    <i class="fas fa-trash"></i>
                                    Xóa sản phẩm
                                 </button>
                              </div>
                           </div>
                        </td>
                        <td class="cart-price">
                           <?php if (isset($cart['discount']) && $cart['discount'] > 0): ?>
                              <span class="current-price"><?php echo number_format($cart['discount']) ?>đ</span>
                              <span class="original-price"><?php echo number_format($cart['price']) ?>đ</span>
                           <?php else: ?>
                              <span class="current-price"><?php echo number_format($cart['price']) ?>đ</span>
                           <?php endif; ?>
                        </td>
                        <td class="cart-quantity">
                           <div class="quantity-controls">
                              <button class="quantity-btn decrease_cart" data-id="<?php echo $cart['idsp'] ?>">
                                 <i class="fas fa-minus"></i>
                              </button>
                              <span class="quantity_cart"><?php echo $cart['quantity'] ?></span>
                              <button class="quantity-btn increase_cart" data-id="<?php echo $cart['idsp'] ?>">
                                 <i class="fas fa-plus"></i>
                              </button>
                           </div>
                        </td>
                        <td class="cart-line-total">
                           <span><?php echo number_format(((isset($cart['discount']) && $cart['discount'] > 0) ? $cart['discount'] : $cart['price']) * $cart['quantity']) ?>đ</span>
                        </td>
                     </tr>
                  <?php endforeach; ?>
            </tbody>
         </table>

            <div class="cart-actions">
               <a href="index.php" class="continue-shopping-btn">
                  <i class="fas fa-arrow-left"></i>
                  Tiếp tục mua sắm
               </a>
               <button class="update-cart-btn" onclick="window.location.reload()">
                  <i class="fas fa-sync-alt"></i>
                  Cập nhật giỏ hàng
               </button>
            </div>
         </div>

         <!-- Checkout Section -->
         <div class="checkout-section">
            <div class="checkout-summary">
               <h3 class="summary-title">
                  <i class="fas fa-receipt"></i>
                  Tóm Tắt Đơn Hàng
               </h3>
               
               <div class="summary-details">
                  <div class="summary-row">
                     <span class="summary-label">Tạm tính:</span>
                     <span class="summary-value" id="cart-subtotal">0đ</span>
                  </div>
                  <div class="summary-row">
                     <span class="summary-label">Phí vận chuyển:</span>
                     <span class="summary-value">Miễn phí</span>
                     </div>
                  <div class="summary-row">
                     <span class="summary-label">Giảm giá:</span>
                     <span class="summary-value">0đ</span>
                  </div>
                  <div class="summary-divider"></div>
                  <div class="summary-row total-row">
                     <span class="summary-label">Tổng cộng:</span>
                     <span class="summary-value total-amount" id="cart-total">0đ</span>
                           </div>
                        </div>

               <div class="checkout-actions">
                  <button class="checkout-btn" id="btn_show_modal">
                     <i class="fas fa-credit-card"></i>
                     Tiến Hành Thanh Toán
                  </button>
               </div>

               <div class="security-notice">
                  <i class="fas fa-shield-alt"></i>
                  <span>Thanh toán an toàn & bảo mật</span>
               </div>
                           </div>
                        </div>

      <?php } else { ?>
         <!-- Empty Cart -->
         <div class="empty-cart">
            <div class="empty-cart-icon">
               <i class="fas fa-shopping-cart"></i>
            </div>
            <h2 class="empty-cart-title">Giỏ hàng trống</h2>
            <p class="empty-cart-subtitle">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
            <a href="index.php" class="start-shopping-btn">
               <i class="fas fa-shopping-bag"></i>
               Bắt đầu mua sắm
            </a>
         </div>
      <?php } ?>

      <!-- Checkout Modal -->
      <div class="modal fade" id="modal_pay" tabindex="-1" aria-labelledby="modal_payLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg">
            <div class="modal-content checkout-modal-content">
               <div class="modal-header checkout-modal-header">
                  <h5 class="modal-title checkout-modal-title" id="modal_payLabel">
                     <i class="fas fa-credit-card"></i>
                     Thanh Toán Đơn Hàng
                  </h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               
               <div class="modal-body checkout-modal-body">
                  <div class="checkout-content">
                     <div class="row">
                        <!-- Left Column: Address & Payment -->
                        <div class="col-lg-7">
                           <!-- Address Selection -->
                           <div class="checkout-section">
                              <div class="section-header">
                                 <h6 class="section-title">
                                    <i class="fas fa-map-marker-alt"></i>
                                    Địa Chỉ Giao Hàng
                                 </h6>
                              </div>
                              <div class="address-selection">
                                 <div id="profile-addresses-container">
                                    <!-- Profile addresses will be loaded here -->
                                 </div>
                                 
                                 <div id="fallback-address-form" class="fallback-address-form" style="display: none;">
                                    <div class="form-group">
                                       <label>Họ và tên</label>
                                       <input type="text" class="form-control" name="fullname" value="<?php echo $_SESSION['fullname'] ?? '' ?>">
                                    </div>
                                    <div class="form-group">
                                       <label>Số điện thoại</label>
                                       <input type="text" class="form-control" name="number_phone" value="<?php echo $_SESSION['number_phone'] ?? '' ?>">
                                    </div>
                           <div class="form-group">
                                       <label>Địa chỉ</label>
                                       <input type="text" class="form-control" name="address" value="<?php echo $_SESSION['address'] ?? '' ?>">
                                    </div>
                           </div>
                        </div>
                           </div>

                           <!-- Payment Method -->
                           <div class="checkout-section">
                              <div class="section-header">
                                 <h6 class="section-title">
                                    <i class="fas fa-credit-card"></i>
                                    Phương Thức Thanh Toán
                                 </h6>
                              </div>
                              <div class="payment-methods">
                                 <div class="payment-method-card" data-payment="cod">
                                    <div class="payment-method-header">
                                       <input type="radio" name="payment_method" value="cod" id="payment_cod">
                                       <label for="payment_cod" class="payment-label">
                                          <div class="payment-icon">
                                             <i class="fas fa-money-bill-wave"></i>
                                          </div>
                                          <div class="payment-info">
                                             <span class="payment-name">Thanh toán khi nhận hàng (COD)</span>
                                             <span class="payment-desc">Thanh toán bằng tiền mặt khi nhận được hàng</span>
                                          </div>
                                       </label>
                                    </div>
                                 </div>

                                 <div class="payment-method-card" data-payment="paypal">
                                    <div class="payment-method-header">
                                       <input type="radio" name="payment_method" value="paypal" id="payment_paypal">
                                       <label for="payment_paypal" class="payment-label">
                                          <div class="payment-icon">
                                             <i class="fab fa-paypal"></i>
                                          </div>
                                          <div class="payment-info">
                                             <span class="payment-name">PayPal</span>
                                             <span class="payment-desc">Thanh toán nhanh và an toàn qua PayPal</span>
                                          </div>
                                       </label>
                                    </div>
                                    <div class="payment-notice" id="paypal-notice" style="display: none;">
                                       <div class="alert alert-warning mb-0">
                                          <i class="fas fa-exclamation-triangle me-2"></i>
                                          <strong>Lưu ý:</strong> Đơn hàng thanh toán bằng PayPal không thể hủy sau khi đặt hàng thành công.
                                       </div>
                                    </div>
                                 </div>

                                 <div class="payment-method-card" data-payment="vnpay">
                                    <div class="payment-method-header">
                                       <input type="radio" name="payment_method" value="vnpay" id="payment_vnpay">
                                       <label for="payment_vnpay" class="payment-label">
                                          <div class="payment-icon">
                                             <i class="fas fa-mobile-alt"></i>
                                          </div>
                                          <div class="payment-info">
                                             <span class="payment-name">VNPay</span>
                                             <span class="payment-desc">Thanh toán qua ví điện tử VNPay</span>
                                          </div>
                                       </label>
                                    </div>
                           </div>
                        </div>
                           </div>
                        </div>

                        <!-- Right Column: Order Summary -->
                        <div class="col-lg-5">
                           <div class="checkout-summary">
                              <div class="summary-header">
                                 <h6 class="summary-title">
                                    <i class="fas fa-receipt"></i>
                                    Tóm Tắt Đơn Hàng
                                 </h6>
                              </div>
                              
                              <div class="order-items-summary">
                                 <div id="checkout-order-items">
                                    <!-- Order items will be loaded here -->
                           </div>
                        </div>

                              <div class="order-summary-details">
                                 <div class="summary-row">
                                    <span class="summary-label">Tạm tính</span>
                                    <span class="summary-value" id="checkout-subtotal">0đ</span>
                                 </div>
                                 <div class="summary-row">
                                    <span class="summary-label">Phí vận chuyển</span>
                                    <span class="summary-value">Miễn phí</span>
                        </div>
                                 <div class="summary-row">
                                    <span class="summary-label">Giảm giá</span>
                                    <span class="summary-value">0đ</span>
                        </div>
                                 <div class="summary-divider"></div>
                                 <div class="summary-row total-row">
                                    <span class="summary-label">Tổng cộng</span>
                                    <span class="summary-value total-amount" id="checkout-total">0đ</span>
                        </div>
                     </div>

                              <div class="security-notice">
                                 <i class="fas fa-shield-alt"></i>
                                 <span>Thông tin thanh toán được mã hóa và bảo mật</span>
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               
               <div class="modal-footer checkout-modal-footer">
                  <div class="checkout-actions">
                     <button type="button" class="checkout-cancel-btn" data-bs-dismiss="modal">
                        <i class="fas fa-arrow-left"></i>
                        Quay lại giỏ hàng
                     </button>
                     <button type="button" class="checkout-confirm-btn" id="checkout-confirm-btn">
                        <i class="fas fa-credit-card"></i>
                        Đặt hàng
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Hidden input for user ID -->
<input type="hidden" id="user_id" value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '' ?>">

<script>
// Make user data available to JavaScript
window.userFullname = '<?php echo addslashes($_SESSION['fullname'] ?? '') ?>';
window.userPhone = '<?php echo addslashes($_SESSION['number_phone'] ?? '') ?>';
window.userAddress = '<?php echo addslashes($_SESSION['address'] ?? '') ?>';
window.userProvince = <?php echo $_SESSION['province_id'] ?? 0 ?>;
window.userDistrict = <?php echo $_SESSION['district_id'] ?? 0 ?>;
window.userWards = <?php echo $_SESSION['wards_id'] ?? 0 ?>;
</script>

<!-- Cart JavaScript -->
<script src="ajax/Cart.js"></script>
<script src="ajax/Checkout.js"></script>