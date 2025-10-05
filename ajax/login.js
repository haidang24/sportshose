$(document).ready(function (){
   // Đăng nhập
   $(document).on('submit','#formLogin',function(event) {
       event.preventDefault();
       var username = $('#username').val();
       var password = $('#password').val();
       if(username.trim() == '' || password.trim() == '') {
           Swal.fire("Hãy điền tài khoản và mật khẩu");return;
       } 

       $.ajax({
         url: "Controller/Admin/login.php?act=login_action",
         method: 'POST',
         data: {username, password},
         dataType: "json",
         success: (res) => {
            if(res.status == 200) {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: "Đăng nhập thành công",
                  showConfirmButton: false,
                  timer: 1500
               });
               setTimeout(() => {
                  window.location.href = 'admin.php?action=product';
               }, 1500)
            }else {
               Swal.fire({
                  icon: "error",
                  text: "Đăng nhập không thành công",
               });
            }
         }
       })
   })

   // Đăng xuất
   $(document).on('click', '#log_out', function() {
      $.ajax({
         url: 'Controller/Admin/login.php?act=log_out',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            console.log(res);
            if(res.status == 200) {
               window.location.href = "admin.php?action=login";
            }
         }
      })
   })
});