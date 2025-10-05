$(document).ready(() => {
   // Hiện thị mật khẩu
   $(document).on('click', '#show_password', function () {
      $('#password').val();
      $('#confirm_password').val();
      var inputType1 = $('#password').attr('type');
      var inputType2 = $('#confirm_password').attr('type');
      (inputType1 === 'password') ? $('#password').attr('type', 'text') : $('#password').attr('type', 'password');
      (inputType2 === 'password') ? $('#confirm_password').attr('type', 'text') : $('#confirm_password').attr('type', 'password');
   })

   // Register Nguời dùng
   $(document).on('submit', '#register', (event) => {
      event.preventDefault(); // Ngăn chặn mặc định của thẻ form
      // Xử lý tên không được nhập số và ký tự đặc biệt
      result_name = check_name('#firstname', '#lastname');

      // Xử lý email hợp lệ
      result_email = check_email('#email');

      flag = false;
      // Xử lý mật khẩu phải trùng nhau
      if ($('#password').val().trim() === '') {
         $('#password_error').text('Mật khẩu không được để trống')
         flag = true;
      } else {
         result_password = check_password('#password', '#confirm_password')
      }

      // Nếu hợp lệ thì xử lý
      if (flag == false && result_email == false && result_name == false && result_password == false) {
         var firstname = $('#firstname').val();
         var lastname = $('#lastname').val();
         var email = $('#email').val();
         var password = $('#password').val();
         $.ajax({
            url: "Controller/User.php?act=register_action",
            method: 'POST',
            data: {
               firstname,
               lastname,
               email,
               password
            },
            dataType: 'json', // Muốn nhận giữ liệu từ PHP phải thêm này
            success: (res) => {
               if (res.status == 422) {
                  $('#email_error').html(res.message);
               } else if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: "Bạn đã tạo tài khoản thành công",
                     showConfirmButton: false,
                     timer: 1500
                  })

                  setTimeout(function () {
                     window.location.href = 'index.php?action=User&act=login';
                  }, 1500); // Chờ 1.5 giây trước khi chuyển hướng
               }
            },
         })
      }
   })

   $(document).on('click', '#revise_password', async function () {
      checkFeature('Chỉnh sửa mật khẩu', function (result) {
         if (result) {
            $('#modal_revise_password').modal('show');
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      });
   });


   // Sửa mật khẩu khách hàng
   $(document).on('click', '#update_action', function (event) {
      event.preventDefault();
      var flag = false;
      let id = $(this).val();
      let newpass = $('#newpass').val();
      if (newpass.length == 0) {
         $('#password_error').text('Mật khẩu không được để trống')
         flag = true;
      } else if (newpass.length < 6) {
         flag = true;
         $('#password_error').text('Mật khẩu không được dưới 6 kí tự')
      }

      if (flag == false) {
         $.ajax({
            url: "Controller/admin/user.php?act=update_action",
            method: 'POST',
            data: { id, newpass },
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: "Cập nhật khách hàng thành công",
                     showConfirmButton: false,
                     timer: 1500
                  });
                  setTimeout(function () {
                     window.location.href = "admin.php?action=User";
                  }, 1500);
               }
            }
         })
      }
   });

   // Đổ dữ liệu trang khôi phục khách hàng
   function get_restore_user() {
      $.ajax({
         url: 'Controller/Admin/user.php?act=get_restore_user',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#table_restore_user').empty();
            res.forEach(user => {
               const row = `
                  <tr class="text-center" height="70x;">
                     <td style="line-height: 50px;">${user.id}</td>
                     <td style="line-height: 50px;">${user.firstname} ${user.lastname}</td>
                     <td style="line-height: 50px;">${user.email}</td>
                     <td style="line-height: 50px;"><span>${user.password}</span></td>
                     <td style="line-height: 50px;">${(user.gender == null) ? '' : user.gender}</td>
                     <td style="line-height: 50px;">${(user.birthday == null) ? '' : user.birthday}</td>
                     <td style="line-height: 50px;">${(user.number_phone == null) ? '' : '0' + user.number_phone}</td>
                     <td style="line-height: 50px;">
                        <button id="restore_user" data-user_id="${user.id}" class="btn btn-outline-primary"><i class="bi bi-arrow-clockwise"></i></button>
                        <button id="clear_user" data-user_id="${user.id}" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                     </td>
                  </tr>`
               $('#table_restore_user').append(row);
            });

         },
         error: (error) => console.log(error)
      })
   }
   get_restore_user()

   // Khôi phục khách hàng
   $(document).on('click', '#restore_user', function () {
      let user_id = $(this).data('user_id');
      if (checkFeature('Khôi phục khách hàng', (result) => {
         if (result) {
            $.ajax({
               url: "Controller/Admin/user.php?act=restore_user",
               method: 'POST',
               data: {
                  user_id
               },
               dataType: 'json',
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
                     get_restore_user();
                  }
               }
            })
         } else {
            Swal.fire("Bạn không có quyền sử dụng chức năng này!");
         }
      }));
   })

   // Xóa khách hàng vĩnh viễn
   $(document).on('click', '#clear_user', function () {
      let user_id = $(this).data("user_id");

      if (checkFeature('Xóa khách hàng', (result) => {
         if (result) {
            Swal.fire({
               title: "Bạn có chắc chắn?",
               text: "Dữ liệu sẽ không thể khôi phục!",
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Xóa!",
               cancelButtonText: "Hủy!"
            }).then((result) => {
               if (result.isConfirmed) {
                  $.ajax({
                     url: "Controller/Admin/user.php?act=clear_user",
                     method: 'POST',
                     data: { user_id },
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
                           get_restore_user();
                        }
                     }
                  })
               }
            });
         } else {
            Swal.fire("Bạn không có quyền sử dụng chức năng này!");
         }
      }));
   })

   // Đăng nhập người dùng
   $('#formLogin_User').on('submit', function (e) {
      e.preventDefault();
      result_email = check_email('#email');
      email = $('#email').val();
      password = $('#password').val();
      if (result_email == false) {
         $.ajax({
            url: 'Controller/User.php?act=login_action',
            method: 'post',
            data: {
               email: email,
               password: password,
            },
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: "Đăng nhập thành công",
                     showConfirmButton: false,
                     timer: 1500
                  });
                  setTimeout(() => {
                     window.location.href = 'index.php?action=home';
                  }, 1500);
               } else {
                  Swal.fire({
                     position: "top-center",
                     icon: "error",
                     title: "Đăng nhập thất bại",
                     showConfirmButton: false,
                     timer: 1500
                  });
               }
            }
         })
      }
   })

   let userList = [];
   // Đổ dữ liệu vào khách hàng trang admin
   function get_all_user() {
      $.ajax({
         url: 'Controller/Admin/user.php?act=getAll_User',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            userList = res; // Lưu lại danh sách khách hàng ban đầu
         },
         error: (error) => console.log(error)
      })
   }
   get_all_user();

   // Đổ dữ liệu theo LIMIT
   function get_user_limit(start) {
      $.ajax({
         url: 'Controller/Admin/user.php?act=get_user_limit',
         method: 'POST',
         data: { start },
         dataType: 'json',
         success: (res) => {
            // console.log(res);
            $('#table_user').empty();
            res.forEach(user => {
               const row = `
                  <tr class="text-center" height="70x;">
                     <td style="line-height: 50px;">${user.id}</td>
                     <td style="line-height: 50px;">${user.firstname} ${user.lastname}</td>
                     <td style="line-height: 50px;">${user.email}</td>
                     <td class="d-flex justify-content-between" style="line-height: 50px;">
                        <span>${user.password}</span> 
                        <button id="revise_password" data-user_id="${user.id}" class="btn btn-outline-success"><i class="bi bi-pencil-square"></i></button>
                     </td>
                     <td style="line-height: 50px;">${(user.gender == null) ? '' : user.gender}</td>
                     <td style="line-height: 50px;">${(user.birthday == null) ? '' : user.birthday}</td>
                     <td style="line-height: 50px;">${(user.number_phone == null) ? '' : '0' + user.number_phone}</td>
                     <td style="line-height: 50px;">
                        <button id="delete_user" data-user_id="${user.id}" class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
                     </td>
                  </tr>
               `

               $('#table_user').append(row);
            });

         },
         error: (error) => console.log(error)
      })
   }
   get_user_limit(0)

   // Đổ dữ liệu khi bấm chỉnh 
   $(document).on('click', '#revise_password', function () {
      user_id = $(this).data('user_id');
      $.ajax({
         url: 'Controller/Admin/user.php?act=revise_password',
         method: 'POST',
         data: { user_id },
         dataType: 'json',
         success: (res) => {
            $('#user_id').val(res.id);
            $('#revise_email').val(res.email);
            $('#revise_password1').val(res.password);
         }
      })
   })

   // Update revise password
   $(document).on('click', '#revise_password_action', function () {
      user_id = $('#user_id').val();

      result_empty = check_empty('#revise_password1')

      pass_new = $('#revise_password1').val();

      if (result_empty == false) {
         $.ajax({
            url: 'Controller/Admin/user.php?act=revise_password_action',
            method: 'POST',
            data: { user_id, pass_new },
            dataType: 'json',
            success: (res) => {
               if (res.status == 200) {
                  Swal.fire({
                     position: "top-center",
                     icon: "success",
                     title: res.message,
                     showConfirmButton: false,
                     timer: 1500
                  }).then(() => {
                     window.location.reload();
                  });
                  $('#modal_revise_password').modal('hide')
               }
            }
         })
      }
   })

   // Đưa khách hàng vào thùng rác
   $(document).on('click', '#delete_user', function () {
      let user_id = $(this).data('user_id');
      // alert(user_id)
      checkFeature('Ẩn khách hàng', function (result) {
         if (result) {
            $.ajax({
               url: "Controller/Admin/user.php?act=delete_user",
               method: 'POST',
               data: {
                  user_id
               },
               dataType: 'json',
               success: (res) => {
                  console.log(res);
                  if (res.status == 200) {
                     Swal.fire({
                        position: "top-center",
                        icon: "success",
                        title: res.message,
                        showConfirmButton: false,
                        timer: 1500
                     }).then(() => {
                        window.location.reload();
                     });
                  }
               }
            })
         } else {
            Swal.fire("Bạn không có quyền sử dụng tính năng này");
         }
      });
   })

   // Chức năng paginate user trang admin 
   $(document).on('click', '.page-link', function () {
      // Xóa lớp 'active' khỏi tất cả các phần tử
      $('.pagination .page-item').removeClass('active');
      // Kích hoạt phần tử đã được nhấp vào
      $(this).parent().addClass('active');

      page = $(this).data('page_id')
      per_page = (page - 1) * 10;
      get_user_limit(per_page);
   });


   // Chức năng tìm kiếm user theo email trang admin
   function search_user(search_text) {
      search_text = search_text.trim().toLowerCase();
      let result = userList.filter(user => {
         return user.email.toLowerCase().includes(search_text);
      });
      return result;
   }

   $(document).on('input', '#search_user', function () {
      // get_all_user();
      const search_text = $(this).val().trim().toLowerCase();

      if (search_text.length == 0) {
         get_user_limit(0)
         return;
      }

      let result = search_user(search_text);
      $('#table_user').empty();
      result.forEach(user => {
         const row = `
            <tr class="text-center" height="70x;">
               <td style="line-height: 50px;">${user.id}</td>
               <td style="line-height: 50px;">${user.firstname} ${user.lastname}</td>
               <td style="line-height: 50px;">${user.email}</td>
               <td class="d-flex justify-content-around" style="line-height: 50px;">
                  <span>${user.password}</span> 
                  <button id="show_modal_revise" class="btn btn-outline-primary"><i class="bi bi-pencil-square"></i></button>
               </td>
               <td style="line-height: 50px;">${(user.gender == null) ? '' : user.gender}</td>
               <td style="line-height: 50px;">${(user.birthday == null) ? '' : user.birthday}</td>
               <td style="line-height: 50px;">${(user.number_phone == null) ? '' : user.number_phone}</td>
               <td style="line-height: 50px;">
                  <button class="btn btn-outline-danger"><i class="bi bi-trash"></i></button>
               </td>
            </tr>
         `
         $('#table_user').append(row);
      });
   });
   ////////////////////////////////
})
