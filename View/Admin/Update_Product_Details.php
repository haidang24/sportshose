<div class="container mt-5">
   <div class="row">
      <div class="col-lg-10 offset-md-1">
         <div class="card">
            <div class="card-header bg-success">
               <h3 class="text-center fw-bolder text-dark">CHỈNH SỬA CHI TIẾT SẢN PHẨM</h3>
            </div>
            <div class="card-body bg-success-subtle">
               <form id="formProduct_Details" enctype="multipart/form-data">
                  <div>
                     <input type="hidden" id="id" value="">
                     <div class="d-flex justify-content-between mb-3">
                        <div>
                           <label class="form-label">Đơn giá</label>
                           <input id="price" type="text" name="price" placeholder="Nhập đơn giá" style="width: 430px"
                              class="form-control">
                           <small id="price_error" class="text-danger"></small>
                        </div>
                        <div>
                           <label class="form-label">Giảm giá</label>
                           <input id="discount" type="text" class="form-control" style="width: 430px">
                           <small id="discount_error" class="text-danger"></small>
                        </div>
                     </div>

                     <div class="d-flex justify-content-between mb-3">
                        <div>
                           <label class="form-label">Số lượng tồn</label>
                           <input value="1" min="1" type="number" id="quantity" placeholder="Nhập đơn giá"
                              style="width: 430px" class="form-control">
                           <small id="quantity_error" class="text-danger"></small>
                        </div>
                        <div>
                           <label class="form-label">Size</label>
                           <input disabled id="size" type="text" class="form-control" style="width: 430px">
                        </div>
                     </div>


                     <div class="d-flex justify-content-between mb-3">
                        <div class="form-group mb-3">
                           <label class="form-label">Hình 1</label>
                           <input accept=".jpg, .webp, .jpeg, .png" style="width: 280px" type="file" id="img1"
                              class="form-control">
                           <img id="preview_img1" value="" alt="Preview Image"
                              style="max-width: 100px; max-height: 100px;">
                           <small id="img_error" class="text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                           <label class="form-label">Hình 2</label>
                           <input accept=".jpg, .webp, .jpeg, .png" style="width: 280px" type="file" id="img2"
                              class="form-control">
                           <img id="preview_img2" value="" alt="Preview Image"
                              style="max-width: 100px; max-height: 100px;">
                           <small id="img_error2" class="text-danger"></small>
                        </div>
                        <div class="form-group mb-3">
                           <label class="form-label">Hình 3</label>
                           <input accept=".jpg, .webp, .jpeg, .png" style="width: 280px" type="file" id="img3" class="form-control">
                           <img id="preview_img3" value="" alt="Preview Image"
                              style="max-width: 100px; max-height: 100px;">
                           <small id="img_error3" class="text-danger"></small>
                        </div>
                     </div>
                     <div class="d-flex justify-content-end">
                        <button name="detailsPro_submit" type="submit" class="btn btn-outline-success"><i class="bi bi-floppy"></i></button>
                     </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Đổ dữ liệu theo ID -->
<?php
if (isset($_GET['idct'])) {
   $idct = $_GET['idct'];
}
$product = new Product();
$kq = $product->get_ProductDetailsBySize($idct);
?>

<script>
   $(document).ready(() => {
      productDetails = <?php echo json_encode($kq) ?>;
      $('#id').val(productDetails.id);
      $('#price').val(productDetails.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
      $('#discount').val(productDetails.discount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
      $('#quantity').val(productDetails.quantity);
      $('#size').val(productDetails.size);
      $('#preview_img1').attr('src', "./View/assets/img/upload/" + productDetails.img1);
      $('#preview_img2').attr('src', "./View/assets/img/upload/" + productDetails.img2);
      $('#preview_img3').attr('src', "./View/assets/img/upload/" + productDetails.img3);
      $('#preview_img1').val(productDetails.img1);
      $('#preview_img2').val(productDetails.img2);
      $('#preview_img3').val(productDetails.img3);
   })

   //Vừa nhập vừa định dạng
   let value = ['#price', '#discount'];
   for (let i = 0; i < value.length; i++) {
      $(document).on('input', value[i], function () {
         let number_input = $(this).val().replace(/[^0-9]/g, ""); // Lấy giá trị hiện tại của ô input và loại bỏ các ký tự không phải số
         const formattedNumber = new Intl.NumberFormat('vi-VI', {
            numberStyle: 'decimal',
            maximumFractionDigits: 2,
         }).format(parseFloat(number_input)); // Định dạng giá trị theo chuẩn VND

         // Cập nhật giá trị ô input với giá trị đã định dạng
         $(this).val(formattedNumber);
      });
   }

</script>