// Kiểm tra trường hợp trống
// ...args nhận bao nhiêu tham số vào cũng được

// Lỗi 
// VD: 1 2 3 
// true true false
// thì nó sẽ trả false
function check_empty(...args) {
   var flag = false;
   args.forEach(selector => {
      var check = $(selector).val();
      if (check == '') {
         $(selector + '_error').text('Bạn chưa nhập thông tin này!');
         flag = true;
      } else {
         $(selector + '_error').text('');
         flag = false;   
      }
   });
   return flag;
}

function check_email(...args) {
   var flag = false;
   args.forEach(selector => {
      var emailValue = $(selector).val(); // Lấy giá trị email từ trường input
      if (!/^[^\s@]+@gmail\.com$/.test(emailValue)) {
         $(selector + '_error').text('Email không hợp lệ'); // Thêm thông báo lỗi cho trường email tương ứng
         flag = true;
      } else {
         $(selector + '_error').text(''); // Xóa thông báo lỗi nếu email hợp lệ
      }
   });
   return flag;
}

// Kiểm tra họ tên có ký tự đặc biệt hoặc số 
function check_name(...args) {
   var digitPattern = /\d/; // Biểu thức chính quy để kiểm tra xem chuỗi có chứa ít nhất một số không
   var specialCharPattern = /[~!@#$%^&*()_+`\-={}[\]:;"'<>,.?/\\|]/; // Biểu thức chính quy để kiểm tra xem chuỗi có chứa ký tự đặc biệt hay không
   var flag = false;
   args.forEach(selector => {
      var value = $(selector).val();
      if (digitPattern.test(value)) {
         $(selector + '_error').text('Họ tên không được chứa số');
         flag = true;
      } else if (specialCharPattern.test(value)) {
         $(selector + '_error').text('Họ tên không chứa ký tự đặc biệt');
         flag = true;
      } else if(value.trim() == '') {
         $(selector + '_error').text('Bạn chưa nhập thông tin này!');
      } 
      else {
         $(selector + '_error').text('');
      }
   })
   return flag;
}

// Kiểm tra mật khẩu giống nhau
function check_password(password, confirm_password) {
   var flag = false;
   if ($(password).val() !== $(confirm_password).val()) {
      flag = true;
      $(password + '_error').text('Mật khẩu không giống nhau');
   } else {
      $(password + '_error').text('');
   }
   return flag; // Trả về giá trị flag sau khi kiểm tra
}

// Kiểm tra mật khẩu trên 6 ký tự
function check_password_length(...args) {
   var flag = false;
   args.forEach(selector => {
      var check = $(selector).val();
      if (check.length > 6) {
         $(selector+ "_error").text('Mật khẩu phải trên 6 ký tự')
         flag = true;
      } else {
         $(selector+ "_error").text('')
      }
   });
   return flag;
}

// Xử lý số điện thoại
function check_number_phone(selector) {
   var flag = false;
   check = $(selector).val();
   if (!/^(0\d{9,10})$/.test(check)) {
      $(selector + "_error").text('Số điện thoại không hợp lệ');
      flag = true;
   }else {
      $(selector + "_error").text('');
   }
   return flag;
} 

// Định dạng tiền việt nam
function formatCurrency(number) {
   const formatter = new Intl.NumberFormat('vi-VI', {
       numberStyle: 'decimal',
       maximumFractionDigits: 2,
   });      
   return formatter.format(parseFloat(number));
}