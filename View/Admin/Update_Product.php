<div class="container mt-5">
   <div class="row">
      <!-- Chỉnh sửa sản phẩm -->
      <div class="col-lg-8 offset-md-2">
         <div class="card">
            <div class="card-header text-center">
               <h3 class="text-dark fw-bolder">
                  <i class="fas fa-edit text-primary"></i>
                  CHỈNH SỬA SẢN PHẨM
               </h3>
            </div>
            <div class="card-body">
               <form id="form_Product">
                  <input type="hidden" id="id_product">
                  <div class="form-group mb-3">
                     <label class="form-label">Tên sản phẩm</label>
                     <input id="name_product" type="text" class="form-control">
                     <small id="name_product_error" class="text-danger"></small>
                  </div>

                  <div class="d-flex justify-content-between">
                     <div class="form-group">
                        <label class="form-label">Tên loại giày</label>
                        <select id="shoes_type" style="width: 330px" class="form-select mb-3"
                           aria-label="Large select example">
                           <?php 
                              $shoes_type_id = new Shoes_Type();
                              $kq = $shoes_type_id->getAll_Shoes_Type();
                              while($set = $kq->fetch()):
                           ?>
                           <option value="<?php echo $set['id']?>"><?php echo $set['name']?></option>
                           <?php endwhile?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label class="form-label">Tên thương hiệu</label>
                        <select id="brand" style="width: 330px" class="form-select mb-3"
                           aria-label="Large select example">
                           <?php 
                              $brand = new Brand();
                              $kq = $brand->getAll_Brand();
                              while($set = $kq->fetch()):
                           ?>
                           <option value="<?php echo $set['id']?>" ><?php echo $set['name_brand']?></option>
                           <?php endwhile?>
                        </select>
                     </div>
                  </div>

                  <div class="form-group mb-3">
                     <label class="form-label">Mô tả</label>
                     <textarea id="descriptions_product" class="form-control" name="" id="" cols="30" rows="5"></textarea>
                     <small id="descriptions_product_error" class="text-danger"></small>
                  </div>

                  <div class="form-group mb-3">
                     <label class="form-label">Hình ảnh</label>
                     <input class="form-control" accept=".jpeg, .png, .jpg, .webp" type="file" id="img">
                     <div class="mt-2">
                        <label class="form-label">Hình ảnh hiện tại:</label>
                        <img style="width: 200px; height: 200px; border-radius: 8px; border: 2px solid #e2e8f0;" id="current_image" src="" alt="Hình ảnh hiện tại" class="d-none">
                        <p id="no_image" class="text-muted">Chưa có hình ảnh</p>
                     </div>
                     <div class="mt-2">
                        <label class="form-label">Hình ảnh mới (nếu thay đổi):</label>
                        <img style="width: 200px; height: 200px; border-radius: 8px; border: 2px solid #e2e8f0;" id="preview_img" src="" alt="Hình ảnh mới" class="d-none">
                     </div>
                  </div>

                  <div class="d-flex justify-content-between">
                     <a href="admin.php?action=product" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Quay lại
                     </a>
                     <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật sản phẩm
                     </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
// Preview hình ảnh mới khi chọn file
$(document).ready(function() {
   $('#img').change(function() {
      const file = this.files[0];
      if (file) {
         const reader = new FileReader();
         reader.onload = function(e) {
            $('#preview_img').attr('src', e.target.result).removeClass('d-none');
         };
         reader.readAsDataURL(file);
      } else {
         $('#preview_img').addClass('d-none');
      }
   });
});
</script>