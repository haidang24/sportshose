$(document).ready(() => {
   // Đếm tổng số đơn chờ xử lý 
   function count_order_waiting() {
      $.ajax({
         url: 'Controller/Admin/order.php?act=count_order_wating',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            kind = res;
            $('#count_order_wating').text(res);
            $('#count_order_wating1').text(res);
         }
      })
   }
   count_order_waiting()


   // Lấy đơn hàng chờ xử lý và đang giao 
   function get_order_delivery() {
      $.ajax({
         url: 'Controller/Admin/order.php?act=get_order_delivery',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#table_order').empty();
            res.forEach(order => {
               const selectedStatus = (status) => status == order.status ? 'selected' : '';
               const row = `
               <tr height="60px" class="text-center">
                  <td>
                     <span class="fw-bolder text-secondary">${order.fullname}</span> <br>
                     <span class="text-danger">0${order.number_phone}</span> 
                  </td>
                  <td class="pt-2">${order.address}, ${order.wards}, ${order.district}, ${order.province}</td>
                  <td class="pt-2">${order.create_at}</td>
                  <td class="pt-2">${(order.delivery_time == null) ? '' : order.delivery_time}</td>
                  <td>
                     <select data-order_id="${order.order_id}" id="status_id" style="width: 110px;cursor: pointer;" class="form-control" id="">
                        <option ${selectedStatus(1)} disabled value="1">Chờ xử lý</option>
                        <option ${selectedStatus(2)} value="2">Đang giao</option>
                        <option value="3">Đã giao</option>
                        <option value="4">Hủy đơn</option>
                     </select>
                  </td>
                  <td><button data-order_id="${order.order_id}" data-bs-toggle="modal" data-bs-target="#modal_order_details" class="order_details btn btn-outline-info"><i class="bi bi-eye"></i></button></td>
               </tr>`;
               $('#table_order').append(row);
            });
         }
      })
   }
   get_order_delivery();
   
   // Chuyển đổi trạng thái cho đơn hàng
   $(document).on('change', '#status_id', function () {
      status_id = $(this).val();
      order_id = $(this).data('order_id');
      if (checkFeature('Cập nhật tình trạng đơn hàng', (result) => {
         if (result) {
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
                     get_order_delivery();
                     count_order_waiting()
                  }
               }, error: (error) => console.log(error)
            })
         } else {
            Swal.fire("Bạn không thể sử dụng chức năng này!").then(function() {
               window.location.reload();
            });
         }
      }));
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
      order_id = $(this).data('order_id')
      // $('#order_id').val($(this).data('order_id'))
      $.ajax({
         url: 'Controller/Admin/order.php?act=get_order_id',
         method: 'POST',
         data: { order_id },
         dataType: 'json',
         success: (res) => {
            console.log(res);
            $('#table_order_details').empty()
            res.forEach(item => {
               const row = `
                  <div class="d-flex">
                     <img style="width: 90px; height: 90px; border-radius: 30px;" src="./View/assets/img/upload/${item.img}" alt="">
                     <div class="mx-4">
                        <span id="name_product" class="fw-bolder">${item.name_product}</span>
                        <div class="d-flex mt-1">
                           <span id="price">Giá: ${formatCurrency(item.price)}</span>
                           <span class="mx-5" id="quantity">x${item.quantity}</span>
                        </div>
                        <span>Size: ${item.size}</span>
                        <p class="text-danger fw-bolder text-end" id="total_price">Tổng: ${formatCurrency(item.total_price)}</p>
                     </div>
                  </div>
               `
               $('#table_order_details').append(row)
            })
         }
      })

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
                  get_all_order(user_id);
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