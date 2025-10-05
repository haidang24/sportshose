feature = [];
// function đổ chức năng ra đem đi so sánh string
function checkFeature(string, callback) {
   admin_id = $('#admin_id').val();
   $.ajax({
      url: 'Controller/Admin/feature.php?act=get_feature_id',
      method: 'POST',
      data: { admin_id },
      dataType: 'json',
      success: (res) => {
         res.forEach(i => {
            feature = i.feature;
         });

         // Kiểm tra nếu feature chứa chuỗi string
         if (feature.includes(string)) {
            // trả callback về true
            callback(true);
         } else {
            // trả callback về false
            callback(false);
         }
      },
      error: (err) => {
         console.error('Đã xảy ra lỗi:', err);
         callback(false);
      }
   });
}