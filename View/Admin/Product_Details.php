<div class="container mt-5">
   <h1 class="text-success fw-bold text-center">CHI TIẾT SẢN PHẨM</h1>
   <div class="row mb-3">
      <div class="col-lg-12">
         <div class="d-flex justify-content-between">
            <?php
            $Product = new Product();
            if (isset($_GET['id'])) {
               $id = $_GET['id'];
            }
            $kq = $Product->get_ProductByID($id);
            ?>
            <span>Tên món hàng: <b class="text-danger"><?php echo $kq['name'] ?></b></span>
            <span>Loại giày: <b class="text-danger"><?php echo $kq['shoes_type_name'] ?></b></span>
            <span>Thương hiệu: <b class="text-danger"><?php echo strtoupper($kq['brand_name']) ?></span>
            <button id="add_product_details" class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i></button>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-lg-12">
         <table class="table table-bordered">
            <thead class="text-center">
               <tr class="table-primary">
                  <th>Hình ảnh</th>
                  <th>Đơn giá</th>
                  <th>Giá giảm</th>
                  <th>Size</th>
                  <th>Số lượng tồn</th>
                  <th></th>
               </tr>
            </thead>
            <tbody>
               <?php
               $Product = new Product();
               $stt = 0;
               // if (isset($_GET['id'])) {
               //    $id = $_GET['id'];
               // }
               $id = $_GET['id'];
               $kq = $Product->get_ProductDetailsByID($id);

               while ($set = $kq->fetch()):
                  $stt++
                     ?>
                  <tr>
                     <td>
                        <div class="d-flex justify-content-around">
                           <img style="width: 80px; height: 80px; border-radius: 10px;"
                              src="View/assets/img/upload/<?php echo $set['img1'] ?>" alt="">
                           <img style="width: 80px; height: 80px; border-radius: 10px;"
                              src="View/assets/img/upload/<?php echo $set['img2'] ?>" alt="">
                           <img style="width: 80px; height: 80px; border-radius: 10px;"
                              src="View/assets/img/upload/<?php echo $set['img3'] ?>" alt="">
                        </div>
                     </td>
                     <td class="text-center pt-4"><span
                           class="text-secondary fs-6"><?php echo number_format($set['price']) ?>đ</span></td>
                     <td class="text-center pt-4"><span
                           class="text-secondary fs-6"><?php echo number_format($set['discount']) ?>đ</span></td>
                     <td class="text-center pt-4"><span class="text-secondary fs-6"><?php echo $set['size'] ?></span></td>
                     <td class="text-center pt-4"><span class="text-secondary fs-6"><?php echo $set['quantity'] ?></span>
                     </td>
                     <td>
                        <div class="d-flex justify-content-around pt-2">
                           <a href="admin.php?action=product&act=update_product_details&idct=<?php echo $set['id'] ?>"
                              class="btn btn-outline-warning repo-link"><i class="bi bi-pencil"></i></a> <br>
                           <a id="delete_product_details" data-product_details_id="<?php echo $set['id'] ?>"
                              class="btn btn-outline-danger bi bi-trash3-fill"></a>
                        </div>
                     </td>
                  </tr>
               <?php endwhile ?>
            </tbody>
         </table>
      </div>
   </div>
</div>

<!-- Modal Thêm Chi Tiết Sản Phẩm -->
<div class="modal fade" id="modal_add_product_details" tabindex="-1">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title text-success fw-bold" id="exampleModalLabel">Thêm Chi Tiết Sản Phẩm</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">

            <?php
            if (isset($_GET['id'])) {
               $id = $_GET['id'];
            }
            ?>
            <form id="add_product_details" enctype="multipart/form-data">
               <input type="hidden" name="product_id" id="product_id"
                  value="<?php echo isset($_GET['id']) ? $id : '' ?>">
               <div>
                  <div class="d-flex justify-content-between mb-3">
                     <div>
                        <label class="form-label">Đơn giá</label>
                        <input id="price" type="text" name="price" placeholder="Nhập đơn giá" style="width: 370px"
                           class="form-control">
                     </div>
                     <div>
                        <label class="form-label">Giảm giá</label>
                        <input id="discount" type="text" name="discount" style="width: 370px" class="form-control"
                           value="0">
                        <small id="discount_error" class="text-danger"></small>
                     </div>
                  </div>

                  <div class="d-flex justify-content-between">
                     <div class="form-group">
                        <label class="form-label">Số lượng tồn</label>
                        <input type="number" name="quantity" min="1" value="1" style="width: 370px"
                           placeholder="Nhập số lượng tồn" class="form-control">
                     </div>
                     <div>
                        <label class="form-label">Size</label>
                        <select name="size_id" style="width: 370px" class="form-select"
                           aria-label="Large select example">
                           <?php
                           $size = new size();
                           $kichthuoc = $size->getAll_size();
                           while ($set = $kichthuoc->fetch()):
                              ?>
                              <option value="<?php echo $set['id'] ?>">Size: <?php echo $set['size'] ?>
                              </option>
                           <?php endwhile ?>
                        </select>
                        <small id="size_error" class="text-danger"></small>
                     </div>
                  </div>


                  <div class="d-flex justify-content-between mb-3">
                     <div class="form-group mb-3">
                        <label class="form-label">Hình 1</label>
                        <input accept=".jpg, .webp, .jpeg, .png" style="width: 250px" type="file" id="img1" name="img1"
                           class="form-control">
                        <img id="preview_img1" class="d-none" alt="Preview Image"
                           style="max-width: 100px; max-height: 100px;border-radius: 10px;">
                        <small id="img1_error" class="text-danger"></small>
                     </div>
                     <div class="form-group mb-3">
                        <label class="form-label">Hình 2</label>
                        <input accept=".jpg, .webp, .jpeg, .png" style="width: 250px" type="file" id="img2" name="img2"
                           class="form-control">
                        <img id="preview_img2" class="d-none" alt="Preview Image"
                           style="max-width: 100px; max-height: 100px;border-radius: 10px;">
                        <small id="img2_error" class="text-danger"></small>
                     </div>
                     <div class="form-group mb-3">
                        <label class="form-label">Hình 3</label>
                        <input accept=".jpg, .webp, .jpeg, .png" style="width: 250px" type="file" name="img3" id="img3"
                           class="form-control">
                        <img id="preview_img3" class="d-none" alt="Preview Image"
                           style="max-width: 100px; max-height: 100px;border-radius: 10px;">
                        <small id="img3_error" class="text-danger"></small>
                     </div>
                  </div>
                  <div class="d-flex justify-content-end">
                     <button type="submit" class="btn btn-outline-success">Thêm</button>
                  </div>
            </form>

            <script>
               //Vừa nhập vừa định dạng cho đơn giá và giảm giá
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
         </div>
      </div>
   </div>

   <style>
      .form-label {
         color: black;
      }
   </style>