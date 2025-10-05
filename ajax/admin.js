//get_all
function get_all_admin() {
   // set mặc định khi thêm thì nó tự tích vào xem sản phẩm
   $('input[name="feature[]"][value="Xem sản phẩm"]').prop('checked', true).prop('disabled', true);

   $.ajax({
      url: 'Controller/Admin/admin.php?act=get_all_admin',
      method: 'GET',
      dataType: 'json',
      success: (res) => {
         $('#table_admin').empty();
         res.forEach(user => {
            const row = `
            <tr height="60" style="line-height: 40px;">
               <td>${user.fullname}</td>
               <td>${user.start_date}</td>
               <td>${user.username}</td>
               <td>${user.password}</td>
               <td>0${user.number_phone}</td>

               <td>${user.position}</td>
               <td>
                  <div class="d-flex justify-content-around">
                     <button data-admin_id=${user.admin_id} id="edit_admin" data-bs-toggle="modal" data-bs-target="#modal_edit_admin" class="btn btn-outline-dark">
                        <i class="bi bi-pencil-square"></i>
                     </button>
                     <button id="delete_admin" data-admin_id="${user.admin_id}" class="btn btn-outline-danger">
                        <i class="bi bi-trash"></i>
                     </button>
                  </div>
               </td>
            </tr>`;
            $('#table_admin').append(row);
         });
      }
   })
}
$(document).ready(() => {
   get_all_admin();

   // Đổ dữ liệu để edit
   $(document).on('click', '#edit_admin', function () {
      admin_id = $(this).data('admin_id');
      $.ajax({
         url: 'Controller/Admin/admin.php?act=get_admin_id',
         method: 'post',
         data: { admin_id },
         dataType: 'json',
         success: (res) => {
            // console.log(res.admin_id);
            $('#emp_name1').val(res.fullname);
            $('#datepicker1').val(res.start_date);
            $('#emp_username1').val(res.username);
            $('#emp_password1').val(res.password);
            $('#emp_phone1').val('0' + res.number_phone);
            $('#emp_position1').val(res.position);
            $('#emp_admin_id').val(res.admin_id);
            // Chuyển đổi chuỗi feature thành mảng
            let featuresArray = res.feature.split('-');

            // Đặt trạng thái cho các checkbox
            $('input[name="feature[]"]').each(function () {
               if (featuresArray.includes($(this).val())) {
                  $(this).prop('checked', true);
               } else {
                  $(this).prop('checked', false);
               }
            });
         }, error: (error) => console.log(error)
      })
   })

   // edit
   $(document).on('submit', '#form_edit_admin', function (event) {
      event.preventDefault();
      // validate
      result_name = check_name('#emp_name1')
      result_start_date = check_empty('#datepicker1')
      result_username = check_empty('#emp_username1')
      result_password = check_empty('#emp_password1')
      result_phone = check_number_phone('#emp_phone1')
      result_position = check_empty('#emp_position1')

      var form_edit_admin = new FormData(this);
      // Thu thập tất cả các checkbox đã chọn
      $('input[name="feature[]"]:checked').each(function () {
         form_add_admin.append('feature[]', this.value);
      });

      // console.log(Array.from(form_edit_admin));
      // form_edit_admin.forEach((i) => {
      //    console.log(i);
      // });return;


      if (result_name == false && result_start_date == false && result_username == false && result_password == false
         && result_phone == false && result_position == false) {
         $.ajax({
            url: 'Controller/Admin/admin.php?act=edit_admin',
            method: 'post',
            data: form_edit_admin,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: (res) => {
               console.log(res);
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  // Vừa tắt modal vừa reset lại 
                  $('#modal_edit_admin').modal('hide').on('hidden.bs.modal', function () {
                     $('#form_edit_admin')[0].reset();
                  });
                  get_all_admin();
               } else if (res.status == 404) {
                  Swal.fire({
                     icon: "error",
                     text: res.message,
                  });
               }
            }, error: (error) => {
               Swal.fire({
                  icon: "error",
                  text: 'Bạn hãy điền ít nhất 1 chức năng',
               });
            }
         })
      }
   })

   // Đặt lại trạng thái của các checkbox khi modal bị đóng
   $('#modal_edit_admin').on('hidden.bs.modal', function () {
      $('input[name="feature[]"]').prop('checked', false);
      $('#form_add_admin')[0].reset(); // Đặt lại các trường input khác nếu cần
   });

   // add 
   $(document).on('submit', '#form_add_admin', function (event) {
      event.preventDefault();

      // validate
      result_name = check_name('#emp_name')
      result_start_date = check_empty('#datepicker')
      result_username = check_empty('#emp_username')
      result_password = check_empty('#emp_password')
      result_phone = check_number_phone('#emp_phone')
      result_position = check_empty('#emp_position')
      var form_add_admin = new FormData(this);
      // Thu thập tất cả các checkbox đã chọn
      $('input[name="feature[]"]:checked').each(function () {
         form_add_admin.append('feature[]', this.value);
      });

      if (result_name == false && result_start_date == false && result_username == false && result_password == false
         && result_phone == false && result_position == false) {
         $.ajax({
            url: 'Controller/Admin/admin.php?act=add_admin',
            method: 'post',
            data: form_add_admin,
            dataType: 'json',
            processData: false,
            contentType: false,
            success: (res) => {
               console.log(res);
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  });
                  // Vừa tắt modal vừa reset lại 
                  $('#modal_add_admin').modal('hide').on('hidden.bs.modal', function () {
                     $('#form_add_admin')[0].reset();
                  });
                  get_all_admin();
               }
            }, error: (error) => {
               Swal.fire({
                  icon: "error",
                  text: 'Bạn hãy điền ít nhất 1 chức năng',
               });
            }
         })
      }
   })

   // delete 
   $(document).on('click', '#delete_admin', function () {
      admin_id = $(this).data('admin_id');
      Swal.fire({
         title: "Bạn có chắc chắn xóa không?",
         icon: "warning",
         showCancelButton: true,
         confirmButtonColor: "#3085d6",
         cancelButtonColor: "#d33",
         confirmButtonText: "Xóa!",
         cancelButtonText: "Hủy!",
      }).then((result) => {
         if (result.isConfirmed) {
            $.ajax({
               url: 'Controller/Admin/admin.php?act=delete_admin',
               method: 'POST',
               data: { admin_id },
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
                     get_all_admin();
                  }
               }
            })
         }
      });
   })

   // Hiển thị thông tin admin
   $(document).on('click', '.info-admin', function () {
      admin_id = $(this).data('admin_id')
      $.ajax({
         url: 'Controller/Admin/admin.php?act=get_admin_id',
         method: 'POST',
         data: { admin_id },
         dataType: 'json',
         success: (res) => {
            console.log(res);
            $('#fullname').val(res.fullname)
            $('#number_phone_admin').val('0' + res.number_phone)
            $('#start_date').val(res.start_date)

            // Kiểm tra nếu updated = 1 thì sẽ ẩn input cập nhật
            if (res.updated == 1) {
               $('#email_admin').val(res.email).prop('disabled', true).addClass('bg-success-subtle');
               $('#dob').val(res.date_of_birth).prop('disabled', true).addClass('bg-success-subtle');
               $('input[name="gender"]').prop('disabled', true).addClass('bg-success');
               $('input[name="gender"][value="' + res.gender + '"]').prop('checked', true).addClass('bg-success');
               $('#address_admin').val(res.address).prop('disabled', true).addClass('bg-success-subtle');
            }

            $('#preview_avatar_admin').attr('src', res.profile_picture !== null ? `./View/assets/img/avatar/${res.profile_picture}` : `./View/assets/img/upload/avatar-trang-4.jpg`);

         }
      })
   })

   // Cập nhật thông tin 
   $(document).on('click', '#update_info_admin', function () {
      result_avatar = check_empty('#file-input');
      result_email = check_email('#email_admin');
      // result_gender = check_empty(gender);
      result_gender = $('input[name="gender"]:checked').val() === undefined;
      if (result_gender === undefined) {
         $('#gender_error').text('Hãy điền giới tính của bạn')
      } else {
         $('#gender_error').text('')

      }
      result_address = check_empty('#address_admin');
      result_date_of_birth = check_empty('#dob');

      if (!result_gender && result_avatar == false && result_email == false && result_address == false && result_date_of_birth == false) {
         avatar = $('#file-input').val().slice(12);
         email = $('#email_admin').val();
         gender = $('input[name="gender"]:checked').val();
         address = $('#address_admin').val();
         date_of_birth = $('#dob').val();
         admin_id = $('#admin_id').val();
         $.ajax({
            url: 'Controller/Admin/admin.php?act=update_info_admin',
            method: 'POST',
            data: { avatar, email, gender, address, date_of_birth, admin_id },
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
                     icon: "error",
                     text: res.message,
                  });
               }
            }
         })
      }
   })
})