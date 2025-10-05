$(document).ready(() => {
   // Lấy value sxếp
   $('#arrange_select').on('change', function() {
      arrange_select = $(this).val();
      if(arrange_select == 0) {
         // Hiển thị 10 sản phẩm giảm giá nhiều nhất
         window.location.href = 'index.php?action=home';
      }else if(arrange_select == 1) {
         window.location.href = 'index.php?action=home&act=futsal';
      }else if(arrange_select == 2) {
         window.location.href = 'index.php?action=home&act=football';
      }else if(arrange_select == 3) {
         window.location.href = 'index.php?action=home&act=decrease';
      }else if(arrange_select == 4) {
         window.location.href = 'index.php?action=home&act=ascending';
      }
   });

   // Xử lý filter tabs
   $('.filter-btn').on('click', function() {
      const filter = $(this).data('filter');
      
      // Remove active class from all buttons
      $('.filter-btn').removeClass('active');
      // Add active class to clicked button
      $(this).addClass('active');
      
      // Redirect based on filter
      if (filter === 'all') {
         window.location.href = 'index.php?action=home';
      } else if (filter === 'futsal') {
         window.location.href = 'index.php?action=home&act=futsal';
      } else if (filter === 'football') {
         window.location.href = 'index.php?action=home&act=football';
      }
   });
})