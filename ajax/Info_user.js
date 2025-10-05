$(document).ready(() => {
   // Hiển thị modal thêm user
   $(document).on('click', '#add_address_user', function () {
      $('#address_user').modal('show')
   })

   // Hiển thị modal cập nhật user
   $(document).on('click', '#update_address_user', function () {
      $('#modal_update_address_user').modal('show')
   })

   // Đổ dữ liệu những địa chỉ theo user_id
   function get_address_user() {
      user_id = $('#user_id').val()
      $.ajax({
         url: 'Controller/info_user.php?act=get_info_user',
         method: 'POST',
         data: { user_id },
         dataType: 'json',
         success: (res) => {
            // console.log(res);
            $('#table_address_user').empty();
            res.forEach(user => {
               const isSelected = user.role == 1 ? 'selected' : '';
               const row = `
                  <div class="address-item ${isSelected}">
                     <div class="address-header-item">
                        <div>
                           <h4 class="address-name">${user.fullname}</h4>
                           <p class="address-phone">(+84) ${user.number_phone}</p>
                        </div>
                        <div class="address-actions">
                           <button class="address-btn address-select" value="${user.id}" id="chose_address">
                              <i class="fas fa-check"></i>
                              Chọn
                           </button>
                           <button class="address-btn address-delete" data-user_address_id="${user.id}" id="delete_address_user">
                              <i class="fas fa-trash"></i>
                              Xóa
                           </button>
                        </div>
                     </div>
                     <div class="address-details">
                        <p><strong>Địa chỉ:</strong> ${user.address}</p>
                        <p><strong>Khu vực:</strong> ${user.wards}, ${user.district}, ${user.province}</p>
                     </div>
                  </div>`;
               $('#table_address_user').append(row);
            });
         }
      })
   }
   get_address_user();

   // Xóa địa chỉ giao hàng theo id
   $(document).on('click', '#delete_address_user', function () {
      user_address_id = $(this).data('user_address_id');
      $.ajax({
         url: 'Controller/info_user.php?act=delete_user_address',
         method: "POST",
         data: { user_address_id },
         dataType: 'json',
         success: (res) => {
            if (res.status == 200) {
               get_address_user();
            }
         }
      })
   })

   //Chọn địa chỉ giao hàng cho user
   $(document).on('click', '#chose_address', function () {
      user_address_id = $(this).val();
      user_id = $('#user_id').val();
      $.ajax({
         url: 'Controller/info_user.php?act=chose_address',
         method: "POST",
         data: { user_address_id, user_id },
         dataType: 'json',
         success: (res) => {
            if (res.status == 200) {
               get_address_user();
            }
         }
      })
   })
   // Cập nhật thêm thông tin user
   $(document).on('submit', '#form_user_details', function (event) {
      event.preventDefault();
      flag = false;
      user_id = $('#user_id').val();
      firstname = $('#firstname').val();
      lastname = $('#lastname').val();
      number_phone = $('#number_phone').val();
      email = $('#email').val();
      gender = $('input[name="btnradio"]:checked').val();
      day = $('#day').val();
      month = $('#month').val();
      year = $('#year').val();

      result_firstname = check_name('#firstname')
      result_lastname = check_name('#lastname')
      result_number_phone = check_number_phone('#number_phone')

      if (gender == undefined) {
         flag = true
         $('#gender_error').text('Bạn chưa điền thông tin này')
      }

      if (result_firstname == false && result_lastname == false && result_number_phone == false && flag == false) {
         // alert(`${user_id} ${firstname} ${number_phone} ${email} ${gender} ${day} ${month} ${year}`);return;
         $.ajax({
            url: 'Controller/info_user.php?act=update_info_user',
            method: 'POST',
            data: { user_id, firstname, lastname, number_phone, email, gender, day, month, year },
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
               } else {
                  Swal.fire({
                     icon: "Lỗi!",
                     text: res.message,
                  });
               }
            }
         })
      }

   })

   // Thêm địa chỉ giao hàng cho user
   $(document).on('submit', '#form_info_user1', function (event) {
      event.preventDefault();
      // Kiểm tra trường hợp trống
      result_address = check_empty('#address');
      result_province = check_empty('#province');
      result_district = check_empty('#district');
      result_wards = check_empty('#wards');
      // Kiểm tra tên hợp lệ
      result_name = check_name('#fullname')

      // Kiểm tra sđt hợp lệ
      result_number_phone = check_number_phone('#numberphone');

      if (result_wards == false && result_district == false && result_province == false && result_address == false && result_name == false && result_number_phone == false) {
         form_info_user = new FormData(this);
         $.ajax({
            url: 'Controller/info_user.php?act=add_user_address',
            method: 'post',
            data: form_info_user,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  $('#address_user').modal('hide');
                  $('#fullname').val('');
                  $('#numberphone').val('');
                  $('#address').val('');
                  $('#wards').val('');
                  // $('#wards').text('Chọn phường/xã');
                  $('#district').val('');
                  // $('#district').text('Chọn quận/huyện');
                  $('#province').val('');
                  get_address_user();
               } else if (res.status == 404) {
                  Swal.fire({
                     icon: "error",
                     text: res.message,
                  });
               } else {
                  Swal.fire({
                     icon: "error",
                     text: res.message,
                  });
               }
            }
         })
      }
   })

   // Lưu hình ảnh vào cơ sở dữ liệu
   $(document).on('submit', '#save_avatar', function (e) {
      e.preventDefault();
      const formData = new FormData(this);


      const avatar = formData.get('avatar');
      if (!avatar || avatar.size === 0) {
         Swal.fire("Hãy chọn tệp!");
         return;
      }

      $.ajax({
         url: 'Controller/info_user.php?act=save_avatar',
         method: 'POST',
         data: formData,
         dataType: 'json',
         processData: false,
         contentType: false,
         success: (res) => {
            if (res.status == 200) {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: res.message,
                  showConfirmButton: false,
                  timer: 1500
               });
               avatar = $('#avatar').val('');
            } else if (res.status == 404) {
               Swal.fire(res.message);
            }
         }
      })
   })
})