$(document).ready(() => {
   let currentView = 'list'; // Default view
   let allOrders = []; // Store all orders
   
   // Load order statistics
   function loadOrderStats() {
      // Count waiting orders
      $.ajax({
         url: 'Controller/Admin/order.php?act=count_order_wating',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#count_order_wating').text(res);
         },
         error: function(xhr, status, error) {
            console.error('Error loading waiting orders count:', error);
         }
      });
      
      // Count other statuses
      $.ajax({
         url: 'Controller/Admin/order.php?act=count_shipping_orders',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#count_order_shipping').text(res);
         },
         error: function(xhr, status, error) {
            console.error('Error loading shipping orders count:', error);
         }
      });
      
      $.ajax({
         url: 'Controller/Admin/order.php?act=count_delivered_orders',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#count_order_delivered').text(res);
         },
         error: function(xhr, status, error) {
            console.error('Error loading delivered orders count:', error);
         }
      });
      
      $.ajax({
         url: 'Controller/Admin/order.php?act=count_cancelled_orders',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#count_order_cancelled').text(res);
         },
         error: function(xhr, status, error) {
            console.error('Error loading cancelled orders count:', error);
         }
      });
   }
   
   // Load all orders
   function loadOrders() {
      $('#loading_orders').show();
      $('#empty_orders').addClass('d-none');
      $('#table_orders_view').hide();
      
      $.ajax({
         url: 'Controller/Admin/order.php?act=get_order_delivery',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            allOrders = res;
            $('#loading_orders').hide();
            
            if (res.length === 0) {
               $('#empty_orders').removeClass('d-none');
            } else {
               displayOrders(res);
               updateOrderCount(res.length);
            }
         },
         error: function(xhr, status, error) {
            console.error('Error loading orders:', error);
            $('#loading_orders').hide();
            $('#empty_orders').removeClass('d-none');
         }
      });
   }
   
   // Display orders based on current view
   function displayOrders(orders) {
      displayOrdersTable(orders);
      $('#table_orders_view').show();
   }
   
   // Display orders in table format
   function displayOrdersTable(orders) {
            $('#table_order').empty();
      orders.forEach(order => {
               const selectedStatus = (status) => status == order.status ? 'selected' : '';
               const row = `
         <tr>
            <td>
               <input type="checkbox" class="form-check-input order-checkbox" value="${order.order_id}">
            </td>
            <td>
               <span class="fw-bold">#${order.order_id}</span>
            </td>
            <td>
               <div>
                  <div class="fw-bold">${order.fullname}</div>
                  <small class="text-muted">0${order.number_phone}</small>
               </div>
            </td>
            <td>
               <div class="small">
                  ${order.address}, ${order.wards}, ${order.district}, ${order.province}
               </div>
            </td>
            <td>
               <span class="payment-method ${order.payment_method === 'PayPal' ? 'paypal' : 'cod'}">
                  ${order.payment_method || 'COD'}
               </span>
            </td>
            <td>
               <span class="fw-bold">${formatCurrency(order.total_amount || 0)}</span>
            </td>
            <td>
               <span class="status-badge ${getStatusClass(order.status)}">
                  ${getStatusText(order.status)}
               </span>
                  </td>
            <td>
               <div class="btn-group" role="group">
                  <button data-order_id="${order.order_id}" data-bs-toggle="modal" data-bs-target="#modal_order_details" class="btn btn-outline-primary btn-sm order_details" title="Xem chi tiết">
                     <i class="fas fa-eye"></i>
                  </button>
                  <select data-order_id="${order.order_id}" data-current-status="${order.status}" data-payment-method="${order.payment_method || 'COD'}" class="form-select form-select-sm status-select" style="width: 100px;">
                        ${getStatusOptions(order.status, order.payment_method || 'COD')}
                  </select>
               </div>
                  </td>
               </tr>`;
               $('#table_order').append(row);
            });
         }
   
   // Display orders in cards format
   function displayOrdersCards(orders) {
      $('#orders_cards').empty();
      orders.forEach(order => {
         const card = `
         <div class="col-lg-4 col-md-6 mb-3">
            <div class="order-card">
               <div class="order-header">
                  <div>
                     <div class="order-id">#${order.order_id}</div>
                     <div class="order-date">${order.create_at}</div>
                  </div>
                  <span class="status-badge ${getStatusClass(order.status)}">
                     ${getStatusText(order.status)}
                  </span>
               </div>
               <div class="customer-name">${order.fullname}</div>
               <div class="customer-phone">0${order.number_phone}</div>
               <div class="shipping-address mb-2">${order.address}, ${order.wards}, ${order.district}, ${order.province}</div>
               <div class="d-flex justify-content-between align-items-center mb-2">
                  <span class="payment-method ${order.payment_method === 'PayPal' ? 'paypal' : 'cod'}">
                     ${order.payment_method || 'COD'}
                  </span>
                  <span class="order-total">${formatCurrency(order.total_amount || 0)}</span>
               </div>
               <div class="btn-group w-100" role="group">
                  <button data-order_id="${order.order_id}" data-bs-toggle="modal" data-bs-target="#modal_order_details" class="btn btn-outline-primary btn-sm order_details">
                     <i class="fas fa-eye"></i> Chi tiết
                  </button>
                  <select data-order_id="${order.order_id}" data-current-status="${order.status}" data-payment-method="${order.payment_method || 'COD'}" class="form-select form-select-sm status-select">
                     ${getStatusOptions(order.status, order.payment_method || 'COD')}
                  </select>
               </div>
            </div>
         </div>`;
         $('#orders_cards').append(card);
      });
   }
   
   // Helper functions
   function getStatusText(status) {
      const statusTexts = {
         1: 'Chờ xử lý',
         2: 'Đang giao',
         3: 'Đã giao',
         4: 'Đã hủy'
      };
      return statusTexts[status] || 'Không xác định';
   }
   
   function getStatusClass(status) {
      const statusClasses = {
         1: 'pending',
         2: 'shipping',
         3: 'delivered',
         4: 'cancelled'
      };
      return statusClasses[status] || 'pending';
   }

   // Tạo options cho dropdown status theo quy trình
   function getStatusOptions(currentStatus, paymentMethod = 'COD') {
      let options = '';
      
      // Luôn hiển thị trạng thái hiện tại
      options += `<option value="${currentStatus}" selected>${getStatusText(currentStatus)}</option>`;
      
      // Quy trình: Chờ xử lý (1) → Đang giao (2) → Đã giao (3)
      // Quy trình: Chờ xử lý (1) → Đã hủy (4) - CHỈ KHI THANH TOÁN COD
      switch(parseInt(currentStatus)) {
         case 1: // Chờ xử lý
            options += `<option value="2">Đang giao</option>`;
            // Chỉ cho phép hủy nếu thanh toán COD
            if (paymentMethod === 'COD') {
               options += `<option value="4">Hủy đơn</option>`;
            }
            break;
         case 2: // Đang giao
            options += `<option value="3">Đã giao</option>`;
            break;
         case 3: // Đã giao - không thể thay đổi
            options = `<option value="3" selected disabled>Đã giao</option>`;
            break;
         case 4: // Đã hủy - không thể thay đổi
            options = `<option value="4" selected disabled>Đã hủy</option>`;
            break;
      }
      
      return options;
   }

   // Kiểm tra quy trình chuyển đổi trạng thái có hợp lệ không
   function isValidStatusTransition(currentStatus, newStatus, paymentMethod = 'COD') {
      const current = parseInt(currentStatus);
      const next = parseInt(newStatus);
      
      // Không thể chuyển sang cùng trạng thái
      if (current === next) return false;
      
      // Quy trình hợp lệ:
      // 1 (Chờ xử lý) → 2 (Đang giao) hoặc 4 (Đã hủy) - CHỈ KHI COD
      // 2 (Đang giao) → 3 (Đã giao)
      // 3 (Đã giao) → không thể chuyển
      // 4 (Đã hủy) → không thể chuyển
      
      switch(current) {
         case 1: // Chờ xử lý
            if (next === 2) return true; // Luôn có thể chuyển sang "Đang giao"
            if (next === 4) return paymentMethod === 'COD'; // Chỉ hủy được khi COD
            return false;
         case 2: // Đang giao
            return next === 3;
         case 3: // Đã giao
            return false; // Không thể chuyển từ đã giao
         case 4: // Đã hủy
            return false; // Không thể chuyển từ đã hủy
         default:
            return false;
      }
   }
   
   function formatCurrency(amount) {
      return new Intl.NumberFormat('vi-VN', {
         style: 'currency',
         currency: 'VND'
      }).format(amount);
   }
   
   function updateOrderCount(count) {
      $('#total_orders_count').text(`${count} đơn hàng`);
   }
   
   function formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleDateString('vi-VN', {
         day: '2-digit',
         month: '2-digit',
         year: 'numeric'
      });
   }
   
   function updateSelectedCount() {
      const selectedCount = $('.order-checkbox:checked').length;
      $('#selected_orders_count').text(`${selectedCount} đã chọn`);
      
      // Enable/disable bulk action buttons
      const bulkButtons = ['#bulk_approve_btn', '#bulk_ship_btn', '#bulk_cancel_btn'];
      bulkButtons.forEach(btn => {
         $(btn).prop('disabled', selectedCount === 0);
      });
   }
   
   function generatePagination(currentPage, totalPages) {
      let pagination = '';
      
      // Previous button
      pagination += `<li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
         <a class="page-link" href="#" data-page="${currentPage - 1}">
            <i class="fas fa-chevron-left"></i>
         </a>
      </li>`;
      
      // Page numbers
      for (let i = Math.max(1, currentPage - 2); i <= Math.min(totalPages, currentPage + 2); i++) {
         pagination += `<li class="page-item ${i === currentPage ? 'active' : ''}">
            <a class="page-link" href="#" data-page="${i}">${i}</a>
         </li>`;
      }
      
      // Next button
      pagination += `<li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
         <a class="page-link" href="#" data-page="${currentPage + 1}">
            <i class="fas fa-chevron-right"></i>
         </a>
      </li>`;
      
      $('#orders_pagination').html(pagination);
   }
   
   // Initialize
   loadOrderStats();
   loadOrders();
   
   // Simple view - only table view
   currentView = 'list';
   
   // Filter function
   function applyFilters() {
      const status = $('#status_filter').val();
      const payment = $('#payment_filter').val();
      const dateFrom = $('#date_from').val();
      const dateTo = $('#date_to').val();
      const search = $('#search_orders').val().toLowerCase();
      
      let filteredOrders = allOrders;
      
      // Filter by status
      if (status) {
         filteredOrders = filteredOrders.filter(order => {
            const orderStatus = String(order.status);
            const filterStatus = String(status);
            return orderStatus === filterStatus;
         });
      }
      
      // Filter by payment method
      if (payment) {
         filteredOrders = filteredOrders.filter(order => 
            (order.payment_method || 'COD').toLowerCase() === payment.toLowerCase()
         );
      }
      
      // Filter by date range
      if (dateFrom) {
         filteredOrders = filteredOrders.filter(order => new Date(order.create_at) >= new Date(dateFrom));
      }
      
      if (dateTo) {
         filteredOrders = filteredOrders.filter(order => new Date(order.create_at) <= new Date(dateTo));
      }
      
      // Filter by search term
      if (search) {
         filteredOrders = filteredOrders.filter(order => 
            order.order_id.toString().includes(search) ||
            order.fullname.toLowerCase().includes(search) ||
            order.number_phone.includes(search)
         );
      }
      
      displayOrders(filteredOrders);
      updateOrderCount(filteredOrders.length);
   }
   
   $('#clear_filter_orders_btn').on('click', function() {
      $('#status_filter').val('');
      $('#payment_filter').val('');
      $('#date_from').val('');
      $('#date_to').val('');
      $('#search_orders').val('');
      displayOrders(allOrders);
      updateOrderCount(allOrders.length);
   });
   
   // Auto-filter when filter values change
   $('#status_filter, #payment_filter, #date_from, #date_to').on('change', function() {
      applyFilters();
   });
   
   // Auto-filter for search with debounce
   let searchTimeout;
   $('#search_orders').on('input', function() {
      clearTimeout(searchTimeout);
      searchTimeout = setTimeout(() => {
         applyFilters();
      }, 500);
   });
   
   // Select all orders checkbox
   $('#select_all_orders').on('change', function() {
      $('.order-checkbox').prop('checked', this.checked);
      updateSelectedCount();
   });
   
   // Individual order checkbox
   $(document).on('change', '.order-checkbox', function() {
      updateSelectedCount();
   });
   
   // Export orders
   $('#export_orders_btn').on('click', function() {
      console.log('Export orders to Excel');
   });
   
   // Chuyển đổi trạng thái cho đơn hàng
   $(document).on('change', '.status-select', function () {
      const status_id = $(this).val();
      const order_id = $(this).data('order_id');
      const currentStatus = $(this).data('current-status') || $(this).find('option:selected').data('original-status');
      const paymentMethod = $(this).data('payment-method') || 'COD';
      
      // Kiểm tra quy trình hợp lệ
      if (!isValidStatusTransition(currentStatus, status_id, paymentMethod)) {
         let errorMessage = "Quy trình xử lý đơn hàng không cho phép chuyển từ trạng thái này sang trạng thái khác";
         
         // Thông báo cụ thể cho trường hợp PayPal
         if (paymentMethod === 'PayPal' && status_id == 4) {
            errorMessage = "Đơn hàng thanh toán bằng PayPal không thể hủy. Chỉ có thể chuyển sang 'Đang giao' hoặc 'Đã giao'.";
         }
         
         Swal.fire({
            position: "top-center",
            icon: "error",
            title: "Không thể thay đổi trạng thái",
            text: errorMessage,
            showConfirmButton: false,
            timer: 3000
         });
         // Reset về trạng thái cũ
         $(this).val(currentStatus);
         return;
      }
      
      // Confirm status change
      let confirmMessage = '';
      switch(status_id) {
         case '2': confirmMessage = 'Bạn có chắc chắn muốn chuyển đơn hàng sang trạng thái "Đang giao"?'; break;
         case '3': confirmMessage = 'Bạn có chắc chắn muốn chuyển đơn hàng sang trạng thái "Đã giao"?'; break;
         case '4': confirmMessage = 'Bạn có chắc chắn muốn hủy đơn hàng?'; break;
         default: confirmMessage = 'Bạn có chắc chắn muốn thay đổi trạng thái đơn hàng?';
      }
      
      Swal.fire({
         text: confirmMessage,
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Có",
         cancelButtonText: "Không"
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: 'Controller/Admin/order.php?act=delivery_status',
               method: 'POST',
               data: { order_id, status_id },
               dataType: 'json',
               success: (res) => {
                  if (res.status == 200) {
                     Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                     });
                     // Reload orders and statistics
                     loadOrders();
                     loadOrderStats();
                  } else if (res.status == 400) {
                     Swal.fire({
                        position: "top-center",
                        icon: "error",
                        title: "Lỗi quy trình",
                        text: res.message,
                        showConfirmButton: false,
                        timer: 2000
                     });
                     // Reset dropdown to original value
                     const originalStatus = $(this).data('current-status');
                     $(this).val(originalStatus);
                  }
               }, 
               error: (error) => {
                  console.error('Error updating order status:', error);
                  Swal.fire({
                     position: "top-center",
                     icon: "error",
                     title: "Lỗi khi cập nhật trạng thái đơn hàng",
                     showConfirmButton: false,
                     timer: 1500
                  });
               }
            });
         } else {
            // Reset dropdown to original value
            const originalStatus = $(this).data('current-status') || $(this).find('option:first').val();
            $(this).val(originalStatus);
         }
      });
   })

   // Lấy đơn hàng đã hủy
   function get_order_cancel() {
      $.ajax({
         url: 'Controller/Admin/order_cancel.php?act=get_order_cancel',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#table_order_cancel').empty();
            res.forEach(order => {
               const row = `
               <tr height="60px" class="text-center">
                  <td>
                     <span class="fw-bolder text-secondary">${order.fullname}</span> <br>
                     <span class="text-danger">0${order.number_phone}</span> 
                  </td>
                  <td class="pt-2">${order.address}, ${order.wards}, ${order.district}, ${order.province}</td>
                  <td class="pt-2">${order.create_at}</td>
                  <td class="pt-2">${order.deleted_at}</td>
                  <td><button data-order_id="${order.order_id}" data-bs-toggle="modal" data-bs-target="#modal_order_details" class="order_details btn btn-outline-info"><i class="bi bi-eye"></i></button></td>
               </tr>`;
               $('#table_order_cancel').append(row);
            });
         }
      })
   }
   get_order_cancel();

   // Lấy đơn hàng đã giao
   function get_order_deliveried(start) {
      $.ajax({
         url: 'Controller/Admin/order_deliveried.php?act=get_order_deliveried',
         method: 'POST',
         data: { start },
         dataType: 'json',
         success: (res) => {
            $('#table_order_deliveried').empty();
            res.forEach(order => {
               const row = `
            <tr height="60px" class="text-center">
               <td>
                  <span class="fw-bolder text-secondary">${order.fullname}</span> <br>
                  <span class="text-danger">0${order.number_phone}</span> 
               </td>
               <td class="pt-2">${order.address}, ${order.wards}, ${order.district}, ${order.province}</td>
               <td class="pt-2">${order.create_at}</td>
               <td class="pt-2">${order.delivered_time}</td>
               <td><button data-order_id="${order.order_id}" class="order_details btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modal_order_details"><i class="bi bi-eye"></i></button></td>
            </tr>`;
               $('#table_order_deliveried').append(row);
            });
         }
      })
   }
   get_order_deliveried(0);

   // Paginate cho trang đã giao
   $(document).on('click', '.page-link', function () {
      page_id = $(this).data('page_id');
      per_page = (page - 1) * 10;
      get_order_deliveried(per_page);
   })

   // Sử dụng class thay vì ID để tránh trùng lặp
   $(document).on('click', '.order_details', function () {
      const order_id = $(this).data('order_id');
      
      // Load order details
      $.ajax({
         url: 'Controller/Admin/order.php?act=get_order_id',
         method: 'POST',
         data: { order_id },
         dataType: 'json',
         success: (res) => {
            console.log('Order items:', res);
            $('#table_order_details').empty();
            
            if (res && res.length > 0) {
            res.forEach(item => {
               const row = `
                     <div class="d-flex mb-3 p-3 border rounded">
                        <img style="width: 90px; height: 90px; border-radius: 10px; object-fit: cover;" 
                             src="./View/assets/img/upload/${item.img || 'placeholder.jpg'}" alt="${item.name_product}">
                        <div class="mx-4 flex-grow-1">
                           <h6 class="mb-2">${item.name_product}</h6>
                           <div class="row">
                              <div class="col-md-3">
                                 <small class="text-muted">Giá:</small><br>
                                 <span class="fw-bold">${formatCurrency(item.price)}</span>
                              </div>
                              <div class="col-md-3">
                                 <small class="text-muted">Số lượng:</small><br>
                                 <span class="fw-bold">${item.quantity}</span>
                              </div>
                              <div class="col-md-3">
                                 <small class="text-muted">Size:</small><br>
                                 <span class="fw-bold">${item.size}</span>
                              </div>
                              <div class="col-md-3">
                                 <small class="text-muted">Thành tiền:</small><br>
                                 <span class="text-danger fw-bold">${formatCurrency(item.total_price)}</span>
                              </div>
                           </div>
                        </div>
                     </div>
                  `;
                  $('#table_order_details').append(row);
               });
            } else {
               $('#table_order_details').append(`
                  <div class="text-center text-muted py-4">
                     <i class="fas fa-shopping-cart fa-2x mb-2"></i>
                     <br>Không có sản phẩm nào trong đơn hàng
                  </div>
               `);
            }
         },
         error: function(xhr, status, error) {
            console.error('Error loading order details:', error);
            $('#table_order_details').append(`
               <div class="text-center text-danger py-4">
                  <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                  <br>Lỗi khi tải chi tiết đơn hàng
               </div>
            `);
         }
      });

      // Load customer info
      const order = allOrders.find(o => o.order_id === order_id);
      if (order) {
         $('#customer_info').html(`
            <div class="row g-3">
               <div class="col-12">
                  <label class="form-label fw-bold">Họ tên:</label>
                  <p class="mb-0">${order.fullname}</p>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Số điện thoại:</label>
                  <p class="mb-0">${order.number_phone}</p>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Email:</label>
                  <p class="mb-0">${order.email || 'N/A'}</p>
               </div>
            </div>
         `);

         $('#shipping_address').html(`
            <div class="row g-3">
               <div class="col-12">
                  <label class="form-label fw-bold">Địa chỉ:</label>
                  <p class="mb-0">${order.address}</p>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Tỉnh/Thành phố:</label>
                  <p class="mb-0">${order.province}</p>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Quận/Huyện:</label>
                  <p class="mb-0">${order.district}</p>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Phường/Xã:</label>
                  <p class="mb-0">${order.wards}</p>
               </div>
            </div>
         `);

         $('#order_summary').html(`
            <div class="row g-3">
               <div class="col-12">
                  <label class="form-label fw-bold">Mã đơn hàng:</label>
                  <p class="mb-0">${order.order_id}</p>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Ngày đặt:</label>
                  <p class="mb-0">${formatDate(order.create_at)}</p>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Trạng thái:</label>
                  <span class="badge bg-${getStatusClass(order.status)}">${getStatusText(order.status)}</span>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Tổng tiền:</label>
                  <p class="mb-0 text-primary fw-bold">${formatCurrency(order.total_amount || 0)}</p>
               </div>
            </div>
         `);

         $('#payment_info').html(`
            <div class="row g-3">
               <div class="col-12">
                  <label class="form-label fw-bold">Phương thức:</label>
                  <span class="badge bg-${(order.payment_method || 'COD') === 'COD' ? 'success' : 'primary'}">
                     ${order.payment_method || 'COD'}
                  </span>
               </div>
               <div class="col-12">
                  <label class="form-label fw-bold">Trạng thái thanh toán:</label>
                  <span class="badge bg-success">Đã thanh toán</span>
               </div>
            </div>
         `);
      }
   });

   // Xác nhận đơn hàng trang User
   $('#form_Order').on('click', function () {
      user_id = $('#user_id').val();
      fullname = $('#fullname').val();
      size = $('#size').val();
      number_phone = $('#number_phone').val();
      address = $('#address').val();
      province = $('#province').val();
      district = $('#district').val();
      wards = $('#wards').val();
      // console.log(`${fullname} - ${number_phone} - ${address} - ${province} - ${district} - ${wards}`);

      // Xử lý tên
      result_name = check_name('#fullname');

      // Xử lý số điện thoại 
      result_phone = check_number_phone('#number_phone');

      // Kiểm tra trống
      result_address = check_empty('#address');
      result_province = check_empty('#province');
      result_district = check_empty('#district');
      result_wards = check_empty('#wards');

      if (result_name == false && result_phone == false && result_address == false && result_province == false && result_district == false && result_wards == false) {
         // Truyền thông tin vào đơn hàng
         $.ajax({
            url: 'Controller/order.php?act=order',
            method: 'POST',
            data: {
               user_id: user_id,
               fullname: fullname,
               size: size,
               number_phone: number_phone,
               address: address,
               province: province,
               district: district,
               wards: wards,
            },
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: "Bạn đã đặt hàng thành công",
                     showConfirmButton: false,
                     timer: 1500
                  });
                  setTimeout(() => {
                     window.location.reload();
                  }, 1500);
               }
            }
         })

         // Truyền thông tin vào tài khoản
         $.ajax({
            url: 'Controller/info_user.php?act=info_user_action',
            method: 'POST',
            data: {
               user_id: user_id,
               fullname: fullname,
               number_phone: number_phone,
               address: address,
               province: province,
               district: district,
               wards: wards,
            },
            dataType: 'json',
            success: () => { }
         })
      }
   })

   // $(document).on('change', '#select_option', function () {
   //    order_id = $(this).data('orderid');
   //    status_id = $(this).val();
   //    $.ajax({
   //       url: 'Controller/Admin/order.php?act=delivery_status',
   //       method: 'post',
   //       data: {
   //          order_id: order_id,
   //          status_id: status_id,
   //       },
   //       dataType: 'json',
   //       success: (res) => {
   //          if (res.status == 200) {
   //             Swal.fire({
   //                position: "top-center",
   //                icon: "success",
   //                title: res.message,
   //                showConfirmButton: false,
   //                timer: 1500
   //             });

   //             setTimeout(() => {
   //                window.location.reload();
   //             }, 1500);
   //          }
   //       }
   //    })
   // })


   // Đưa đơn hàng mua ngay vào bảng đơn hàng và bảng chi tiết đơn hàng
   $(document).on('click', '#order_buy_now', function () {
      // Thông tin sản phẩm
      product_img = $('#product_img').attr('src')
      // Sử dụng phương thức split để tách chuỗi dựa trên dấu '/'
      var img = product_img.split('/').pop();
      product_name = $('#product_name').text();
      product_price = $('#product_price').text().replace(/[^0-9]/g, "");
      product_quantity = $('#product_quantity').text();
      product_sum = $('#product_sum').text().replace(/[^0-9]/g, "");
      size = $('#product_size').text();

      // Thông tin khách hàng
      user_id = $('#user_id').val();
      fullname = $('#fullname').val();
      number_phone = $('#number_phone').val();
      address = $('#address').val();
      province = $('#province').val();
      district = $('#district').val();
      wards = $('#wards').val();
      // alert(`${user_id} - ${size} - ${number_phone} - ${address} - ${province} - ${district} - ${wards}`);
      // alert(`${img} - ${product_name} - ${product_price} - ${product_quantity} - ${product_sum}`)

      // Xử lý tên
      result_name = check_name('#fullname');

      // Xử lý số điện thoại 
      result_phone = check_number_phone('#number_phone');

      // Kiểm tra trống
      result_address = check_empty('#address');
      result_province = check_empty('#province');
      result_district = check_empty('#district');
      result_wards = check_empty('#wards');


      if (result_name == false && result_address == false && result_phone == false && result_district == false && result_wards == false && result_province == false) {
         $.ajax({
            url: 'Controller/order.php?act=order_buy_now',
            method: 'POST',
            data: {
               img, product_name, product_price, product_quantity, product_sum, size,
               user_id, fullname, number_phone, address, province, district, wards
            },
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  setTimeout(() => {
                     window.location.reload();
                  }, 1500);
               }
            }
         })

         // Truyền thông tin vào tài khoản
         $.ajax({
            url: 'Controller/info_user.php?act=info_user_action',
            method: 'POST',
            data: {
               user_id: user_id,
               fullname: fullname,
               number_phone: number_phone,
               address: address,
               province: province,
               district: district,
               wards: wards,
            },
            dataType: 'json',
            success: () => { }
         })
      }
   })
   var user_id = $('#user_id').val()
   // Hủy đơn hàng
   $(document).on('click', '#delete_order', function () {
      order_id = $(this).data('order_id');
      status_id = 4
      Swal.fire({
         text: "Bạn có chắc chắn muốn hủy đơn hàng?",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Có",
         cancelButtonText: "Không"
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: 'Controller/Admin/order.php?act=delivery_status',
               method: 'post',
               data: { order_id, status_id },
               dataType: 'json',
               success: (res) => {
                  // Reload orders and statistics
                  loadOrders();
                  loadOrderStats();
                  if (res.status == 200) {
                     Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: "Bạn đã hủy đơn hàng thành công",
                        showConfirmButton: false,
                        timer: 1500
                     });
                  }
               }
            })
         }
      });
   })

   // Đổ dữ liệu bảng order cho lịch sử đơn hàng
   function get_all_order(user_id) {
      $.ajax({
         url: 'Controller/order_history.php?act=get_all_order',
         method: 'POST',
         data: { user_id },
         dataType: 'json',
         success: (res) => {
            // console.log(res);
            $('#table_order_history').empty();
            res.forEach(order => {
               const row = `
               <div class="col-lg-12">
                  <div style="border-radius: 20px;" class="shadow p-3 mb-5 bg-light">
                     <h5 class="fw-bold text-success">Đơn hàng #${order.order_id}</h5>
                     <div class="d-flex justify-content-between">
                        <div>
                           <span class="text-dark badge">Tên: ${order.fullname}</span> <br>
                           <span class="text-dark badge">Số điện thoại: 0${order.number_phone}</span> <br>
                           <span class="text-dark badge">Địa chỉ: ${order.address}, ${order.wards}, ${order.district}, ${order.province}</span> <br>
                        </div>
                        <div>
                           ${(order.status == 1 && !order.deleted_at) ? '<span class="text-dark badge">Trạng thái: <b class="text-danger">Chờ xử lý</b></span> <br>' : ''}
                           ${(order.status == 2 && !order.deleted_at) ? '<span class="text-dark badge">Trạng thái: <b class="text-warning">Đang giao</b></span> <br>' : ''}
                           ${(order.status == 3 && !order.deleted_at) ? '<span class="text-dark badge">Trạng thái: <b class="text-success">Đã giao</b></span> <br>' : ''}
                           ${(order.deleted_at) ? '<span class="text-dark badge">Trạng thái: <b class="text-secondary">Đã hủy</b></span> <br>' : ''}
                           <span class="text-dark badge">Ngày đặt hàng: ${order.create_at}</span> <br>
                           ${(order.status == 3 && !order.deleted_at) ? `<span class="text-dark badge">Ngày giao hàng: ${order.delivered_time}</span> <br>` : ''}
                           ${(order.deleted_at) ? `<span class="text-dark badge">Ngày hủy hàng: ${order.deleted_at}</span> <br>` : ''}
                     </div>
                        <div>
                           <span data-order_id="${order.order_id}" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#modal_order_details" style="border-radius: 20px;" class="order_details badge text-bg-primary">Chi tiết</span> <br>
                           ${(order.status == 1 && !order.deleted_at) ? `<span data-order_id="${order.order_id}" id="delete_order" style="cursor: pointer; border-radius: 20px;" class="badge text-bg-danger">Hủy đơn</span> <br>` : ''}
                        </div>
                     </div>
                  </div>
               </div>`;

               $('#table_order_history').append(row);
            });
         }
      })
   }
   get_all_order(user_id);

   $(document).on('click', '.order_details', function () {
      order_id = $(this).data('order_id');
      $.ajax({
         url: 'Controller/order_history.php?act=get_order_details',
         method: 'POST',
         data: { order_id },
         dataType: 'json',
         success: (res) => {
            $('.table_order_details1').empty();
            sum = 0;
            $('#sum_price_order').empty();
            res.forEach(i => {
               const row = `
               <div class="d-flex mt-2 mb-2">
                  <img src="./View/assets/img/upload/${i.img}" class="me-3" alt="Product Image" style="width: 100px; height: 100px;border-radius: 20px;">
                  <div class="mx-4">
                     <h6>${i.name_product}</h6>
                     <div class="d-flex justify-content-between">
                        <span class="badge text-secondary">Đơn giá: ${formatCurrency(i.price)}</span><br>
                        <span class="badge text-secondary">x${i.quantity}</span><br>
                     </div>
                     <span class="badge text-secondary">Size: ${i.size}</span><br>
                  </div>
               </div>`;
               sum += i.price * i.quantity;
               $('.table_order_details1').append(row);
            });
            $('#sum_price_order').append(formatCurrency(sum));
         }
      })
   })

})