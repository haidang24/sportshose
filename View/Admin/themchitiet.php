<div class="container mt-5">
   <div class="row">
      <!-- Phần thương hiệu -->
      <div class="col-lg-4">
         <form id="form_Brand">
            <div class="mb-3">
               <label class="form-label">Thêm thương hiệu</label>
               <input type="text" id="name_brand" class="form-control bg-light">
               <small id="name_brand_error" class="text-danger"></small>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
         </form>

         <!-- Bảng chi tiết thương hiệu -->
         <table class="table mt-4">
            <thead>
               <tr>
                  <th>STT</th>
                  <th>Tên thương hiệu</th>
                  <th></th>
               </tr>
            </thead>
            <!-- Đổ dữ liệu ở ajax -->
            <tbody id="table_brand"></tbody>
         </table>
      </div>

      <!-- Phần thêm loại giày -->
      <div class="col-lg-4">
         <form id="form_shoes_type">
            <div class="mb-3">
               <label class="form-label">Thêm loại giày</label>
               <input type="text" id="name_shoes_type" class="form-control bg-light">
               <small id="name_shoes_type_error" class="text-danger"></small>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
         </form>

         <!-- Bảng chi tiết thương hiệu -->
         <table class="table mt-4">
            <thead>
               <tr>
                  <th>STT</th>
                  <th>Tên loại giày</th>
                  <th></th>
               </tr>
            </thead>
            <tbody id="table_shoes_type"></tbody>
         </table>
      </div>

      <!-- Phần thêm size -->
      <div class="col-lg-4">
         <form id="form_Size">
            <div class="mb-3">
               <label class="form-label">Thêm size</label>
               <input type="text" id="size" class="form-control bg-light">
               <small id="size_error" class="text-danger"></small>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i></button>
         </form>

         <!-- Bảng chi tiết thương hiệu -->
         <table class="table mt-4">
            <thead>
               <tr>
                  <th>STT</th>
                  <th class="text-center">Kích thước</th>
                  <th></th>
               </tr>
            </thead>
            <tbody id="table_size"></tbody>
         </table>
      </div>
   </div>
</div>