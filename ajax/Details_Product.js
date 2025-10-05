$(document).ready(function () {
   // Lấy ra tổng số lượng giỏ hàng
   function get_totalCart() {
      $.ajax({
         url: 'Controller/cart.php?act=get_totalCart',
         method: 'GET',
         dataType: 'json',
         success: (res) => {
            $('#totalCart').text(res)
         }
      })
   }
   // Xử lí thay đổi hình ảnh 
   // Lắng nghe sự kiện click trên các hình ảnh thumbnail
   $('.thumb-item').click(function () {
      // Lấy đường dẫn của hình ảnh được click
      var imgSrc = $(this).attr('data-src');
      // Cập nhật đường dẫn hình ảnh trong card
      $('#product-detail').attr('src', './View/assets/img/upload/' + imgSrc);
      
      // Remove active class from all thumbnails
      $('.thumb-item').removeClass('active');
      // Add active class to clicked thumbnail
      $(this).addClass('active');
   });
   flag = false;
   // Lấy sản phẩm bỏ vào giỏ hàng
   // Cắm cờ để xác định người ta đã chọn size chưa 
   $('.btn-size').click(function () {
      // Nếu người ta click vào nút thì lấy ra tên và size
      size_id = $(this).data('size_id');
      size_value = $(this).text().trim(); // Get the actual size value (42)
      name_product = $('#name_product').text().trim();
      
      console.log('Size button clicked:', {
         size_id: size_id,
         size_value: size_value,
         name_product: name_product,
         element: $(this)
      });
      
      // Truyền vào ajax 
      $.ajax({
         url: 'Controller/cart.php?act=getDetailsProduct_NameSizeID',
         method: 'POST',
         data: {
            size_id: size_id,
            name_product: name_product,
         },
         dataType: 'json',
         success: (res) => {
            if (res.status == 200) {
               $('#discount').text(numeral(res.discount).format('0,0[.]00') + "đ");
               $('#price').text(numeral(res.price).format('0,0[.]00') + "đ");
               $('#discount').attr('data-value', res.discount);
               $('#price').attr('data-value', res.price);
               
               // Load stock quantity
               loadStockQuantity(size_value, name_product);
            }
         }
      })

      // Xóa lớp "active" khỏi tất cả các nút kích thước
      $('.btn-size').removeClass('active');
      // Thêm lớp "active" vào nút kích thước được click
      $(this).addClass('active');
      flag = true;
   })

   // Thêm vào giỏ hàng
   $('#addCart').click(function () {
      if (flag == false) {
         Swal.fire({
            icon: "error",
            text: "Vui lòng chọn kích thước!",
         });
         return; // Dừng lại nếu kích thước chưa được chọn
      }
      var id_product = $('#idsp').val();
      var name_product = $('#name_product').text();
      var img = $('#product-detail').attr('data-src');
      var shoes_type = $('#shoes_type').text();
      var brand = $('#brand').text();
      var quantity = $('#product-quanity').val();
      var price = $('#discount').data('value') == 0 ? $('#price').data('value') : $('#discount').data('value');
      var size = $('.btn-size.active').text();
      // console.log(`${img} - ${shoes_type} - ${brand} - ${price} - ${size} - ${quantity} - ${id_product}`);return;
      $.ajax({
         url: 'Controller/details_product.php?act=addCart',
         method: 'post',
         data: { id_product, name_product, img, shoes_type, brand, quantity, price, size },
         dataType: 'json', // Muốn nhận giữ liệu từ PHP phải thêm này
         success: (res) => {
            if (res.status == 200) {
               Swal.fire({
                  position: "top-center",
                  icon: "success",
                  title: "Đã thêm vào giỏ",
                  showConfirmButton: false,
                  timer: 1000
               });
               get_totalCart();
               
               // Reload stock quantity after adding to cart
               setTimeout(function() {
                  const activeSize = $('.btn-size.active');
                  if (activeSize.length > 0) {
                     const size_value = activeSize.text().trim();
                     const name_product = $('#name_product').text().trim();
                     loadStockQuantity(size_value, name_product);
                  }
               }, 300);
               
            } else if (res.status == 201) {
               Swal.fire({
                  icon: "error",
                  text: "Sản phẩm không đủ hàng",
               });
            }

         }
      })
   })


   // Click vào buy_now để lấy size và id sản phẩm
   $(document).on('click', '#buy_now', function () {
      flag1 = true;
      var size = $('.btn-size.active').data('size_id');
      var quantity = $('#product-quanity').val();
      var product_id = $('#product_id').val();

      if (!size) {
         Swal.fire({
            icon: "error",
            text: "Vui lòng chọn kích thước!",
         });
         return; // Dừng lại nếu kích thước chưa được chọn
      }

      $.ajax({
         url: 'Controller/details_product.php?act=get_quantity_product',
         method: 'post',
         data: { product_id, size },
         dataType: 'json',
         success: (res) => {
            // console.log(parseInt(res.message));
            if (res.status == 200) {
               if (parseInt(res.message) < quantity) {
                  flag1 = false;
                  Swal.fire({
                     icon: "error",
                     text: "Sản phẩm không đủ hàng",
                  });
               } else {
                  // Nếu số lượng đủ, hiển thị modal và gán giá trị vào modal
                  $('#ModalBuy_Now').modal('show');
                  $.ajax({
                     url: 'Controller/details_product.php?act=get_product_sizeid',
                     method: 'POST',
                     data: { product_id, size },
                     dataType: 'json',
                     success: (res) => {
                        // console.log(res);
                        if (res.status == 200) {
                           var product_price = (res.message.discount == 0) ? res.message.price : res.message.discount

                           $('#product_img').attr('src', `./View/assets/img/upload/${res.message.img}`);
                           $('#product_name').text(res.message.name)
                           $('#product_price').text(formatCurrency(product_price))
                           $('#product_quantity').text($('#product-quanity').val())
                           $('#product_sum').text(formatCurrency(product_price * $('#product-quanity').val()))
                           $('#product_size').text($('.btn-size.active').text())
                        }
                     }
                  })
               }
            } else {
               // Xử lý trường hợp res.status không phải là 200
               Swal.fire({
                  icon: "error",
                  text: "Có lỗi xảy ra, vui lòng thử lại.",
               });
            }
         },
         error: (xhr, status, error) => {
            // Xử lý lỗi AJAX nếu cần
            Swal.fire({
               icon: "error",
               text: "Có lỗi xảy ra, vui lòng thử lại.",
            });
         }
      });
   });

   // Load stock quantity function
   function loadStockQuantity(size_id, name_product) {
      console.log('Loading stock for product:', {
         size_id: size_id,
         name_product: name_product
      });
      
      $.ajax({
         url: 'Controller/cart.php?act=get_stock_by_size',
         method: 'POST',
         data: {
            size_id: size_id,
            name_product: name_product
         },
         dataType: 'json',
         success: function(response) {
            console.log('Stock API response:', response);
            
            if (response && response.available !== undefined) {
               let stockText = 'Kho: ' + response.available;
               if (response.in_cart > 0) {
                  stockText += ' (Đã có ' + response.in_cart + ' trong giỏ)';
               }
               if (response.warning) {
                  stockText += ' ⚠️';
               }
               console.log('Setting stock text:', stockText);
               $('#repository').text(stockText);
               
               // Update stock color based on availability
               if (response.warning) {
                  $('#repository').css('color', '#dc3545'); // Red for warning
               } else if (response.available > 10) {
                  $('#repository').css('color', '#28a745'); // Green for good stock
               } else if (response.available > 0) {
                  $('#repository').css('color', '#ffc107'); // Yellow for low stock
               } else {
                  $('#repository').css('color', '#dc3545'); // Red for no stock
               }
            } else {
               console.warn('Invalid stock response:', response);
               $('#repository').text('Kho: Đang tải...').css('color', '#6c757d');
            }
         },
         error: function(xhr, status, error) {
            console.error('Stock API error:', error, xhr.responseText);
            $('#repository').text('Kho: N/A').css('color', '#dc3545');
         }
      });
   }

   // Load stock quantity for first size on page load
   $(document).ready(function() {
      // Auto-select first size and load stock
      setTimeout(function() {
         const firstSize = $('.btn-size').first();
         if (firstSize.length > 0) {
            firstSize.click();
         }
      }, 500);
   });

   // Reload stock quantity when quantity changes
   $(document).on('click', '#btn-plus, #btn-minus', function() {
      setTimeout(function() {
         const activeSize = $('.btn-size.active');
         if (activeSize.length > 0) {
            const size_value = activeSize.text().trim();
            const name_product = $('#name_product').text().trim();
            loadStockQuantity(size_value, name_product);
         }
      }, 100);
   });

   // Reload stock quantity when quantity input changes
   $(document).on('change', '#product-quanity', function() {
      setTimeout(function() {
         const activeSize = $('.btn-size.active');
         if (activeSize.length > 0) {
            const size_value = activeSize.text().trim();
            const name_product = $('#name_product').text().trim();
            loadStockQuantity(size_value, name_product);
         }
      }, 100);
   });

});