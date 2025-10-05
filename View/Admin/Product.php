<div class="container">
  <div class="row">
    <div class="col-lg-12 mb-3">
      <h1 class="mt-3 mb-3 text-success fw-bolder text-center">DANH SÁCH SẢN PHẨM</h1>
      <div class="d-flex justify-content-center">
        <div class="mx-2">
          <label class="fw-bold">Loại giày: </label>
          <select id="shoes_type_id" style="width: 400px;" class="form-select form-select-sm"
            aria-label="Small select example">
            <?php
            $shoes_type = new Shoes_Type();
            $kq = $shoes_type->getAll_Shoes_Type();
            while ($set = $kq->fetch()):
              ?>
              <option value="<?php echo $set['id'] ?>"><?php echo $set['name'] ?></option>
            <?php endwhile ?>
          </select>
        </div>
        <div class="mx-2">
          <label class="fw-bold">Tên thương hiệu</label>
          <select id="brand_id" style="width: 400px;" class="form-select form-select-sm"
            aria-label="Small select example">
            <?php
            $brand = new Brand();
            $kq = $brand->getAll_Brand();
            while ($set = $kq->fetch()):
              ?>
              <option value="<?php echo $set['id'] ?>"><?php echo $set['name_brand'] ?></option>
            <?php endwhile ?>
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <table class="table table-bordered">
        <thead>
          <tr class="table-danger">
            <th>Tên Sản Phẩm</th>
            <th>Mô Tả</th>
            <th></th>
          </tr>
        </thead>
        <tbody id="table_product"></tbody>
      </table>
    </div>
  </div>
</div>