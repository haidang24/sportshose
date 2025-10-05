<div class="container mt-5">
   <div class="row">
      <!-- Thêm sản phẩm -->
      <div class="col-lg-8 offset-md-2">
         <div class="card">
            <div class="card-header text-center bg-success">
               <h3 class="text-dark fw-bolder">CHỈNH SỬA SẢN PHẨM</h3>
            </div>
            <div class="card-body bg-success-subtle">
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
                     <img style="width: 200px; height: 200px;" id="preview_img" src="" alt="">
                  </div>

                  <div class="d-flex justify-content-end">
                     <button class="btn btn-outline-success"><i class="bi bi-floppy"></i></button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php 
   if(isset($_GET['id'])) {
      $id = $_GET['id'];
   }
   $product = new Product();
   $result = $product->getByID_Product($id);
?>

<script>
   $(document).ready(() => {
      product = <?php echo json_encode($result)?>;
      $('#id_product').val(product.id);
      $('#name_product').val(product.name);
      $('#descriptions_product').val(product.descriptions);
      $('#shoes_type').val(product.shoes_type_id);
      $('#brand').val(product.brand_id);
      $('#img_old').val("./View/assets/img/upload/" + product.img); 
      $('#preview_img').attr('src', "./View/assets/img/upload/" + product.img); 
   })
</script>