<div class="container mt-5">
  <div class="row">
    <!-- Thêm sản phẩm -->
    <div class="col-lg-7 offset-md-3">
      <div class="card">
        <div class="card-header text-center bg-success">
          <h3 style="line-height: 50px;" class="text-dark fw-bolder">THÊM SẢN PHẨM</h3>
        </div>
        <div class="card-body bg-success-subtle">
          <form id="form_add_product">
            <div class="form-group mb-4">
              <label class="form-label">Tên sản phẩm</label>
              <input placeholder="Nhập tên sản phẩm" name="name_product" id="name_product" type="text" value=""
                class="form-control">
              <small class="text-danger" id="name_product_error"></small>
            </div>

            <div class="d-flex justify-content-between mb-3">
              <div>
                <label class="form-label">Tên loại giày</label>
                <select name="shoes_type_id" style="width: 290px" class="form-select form-select-sm mb-3"
                  aria-label="Large select example">
                  <?php

                  $shoes_type = new Shoes_Type();
                  $kq = $shoes_type->getAll_Shoes_Type();
                  while ($set = $kq->fetch()):
                    ?>
                    <option value="<?php echo $set['id'] ?>">
                      <?php echo $set['name'] ?>
                    </option>
                  <?php endwhile ?>

                </select>
              </div>
              <div>
                <label class="form-label">Tên thương hiệu</label>
                <select name="brand_id" style="width: 290px" class="form-select form-select-sm mb-3"
                  aria-label="Large select example">
                  <?php
                  $brand = new Brand();
                  $kq = $brand->getAll_Brand();
                  while ($set = $kq->fetch()):
                    ?>
                    <option value="<?php echo $set['id'] ?>">
                      <?php echo $set['name_brand'] ?>
                    </option>

                  <?php endwhile ?>
                </select>
              </div>
            </div>

            <div class="form-group mb-3">
              <label class="form-label">Mô tả</label>
              <textarea placeholder="Nhập mô tả" class="form-control" name="descriptions" id="descriptions" cols="30"
                rows="5"></textarea>
              <small id="descriptions_error" class="text-danger"></small>
            </div>

            <div class="form-group mb-3">
              <label class="form-label">Hình ảnh</label>
              <input type="file" name="img" id="img" class="form-control" value="">
              <img accept="image/webp, image/jpg, image/jpeg, image/png" class="d-none"
                style="width: 200px; height: 200px;" id="preview_img" src="" alt="">
              <small id="img_error" class="text-danger"></small>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-outline-success">Thêm</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- Phần thêm sản phẩm -->