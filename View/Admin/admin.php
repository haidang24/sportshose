<h1 class="mt-3 mb-3 text-success fw-bolder text-center">Thông Tin Nhân Viên</h1>
<div class="col-lg-12">
   <div class="d-flex justify-content-end">
      <button data-bs-toggle="modal" data-bs-target="#modal_add_admin" class="btn btn-outline-info mb-2"><i
            class="bi bi-plus-circle"></i></button>
   </div>
   <table class="table table-bordered">
      <thead class="table-info">
         <tr class="text-center">
            <th>Họ Tên</th>
            <th>Ngày làm việc</th>
            <th>Tài khoản</th>
            <th>Mật khẩu</th>
            <th>Số điện thoại</th>
            <th>Chức vụ</th>
            <th></th>
         </tr>
      </thead>
      <tbody class="text-center" id="table_admin"></tbody>
   </table>
</div>

<!-- Modal Thêm Nhân Viên -->
<div class="modal fade" id="modal_add_admin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title text-success fw-bold fs-5" id="exampleModalLabel">Thêm Nhân Viên</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form id="form_add_admin">
            <div class="modal-body">
               <div class="container">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Họ Tên</label> <br>
                           <small id="emp_name_error" class="badge text-danger"></small>
                           <input name="emp_name" id="emp_name" type="text" class="form-control">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Ngày làm việc</label> <br>
                           <small id="datepicker_error" class="badge text-danger"></small>
                           <input name="emp_start_date" type="text" id="datepicker" class="form-control"
                              placeholder="Chọn ngày">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Tài Khoản</label> <br>
                           <small id="emp_username_error" class="badge text-danger"></small>
                           <input name="emp_username" id="emp_username" type="text" class="form-control">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Mật khẩu</label> <br>
                           <small id="emp_password_error" class="badge text-danger"></small>
                           <input name="emp_password" id="emp_password" type="text" class="form-control">
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Số điện thoại</label> <br>
                           <small id="emp_phone_error" class="badge text-danger"></small>
                           <input name="emp_phone" id="emp_phone" type="text" class="form-control">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Chức vụ</label> <br>
                           <small id="emp_position_error" class="badge text-danger"></small>
                           <input name="emp_position" id="emp_position" type="text" class="form-control">
                        </div>
                     </div>
                  </div>

                  <!-- Phân quyền chức năng -->
                  <h5 class="fw-bolder mb-4 mt-4">Quản trị người dùng: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem thông tin khách hàng" type="checkbox">
                           <span class="mx-2">Xem thông tin khách hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xem thông tin nhân viên" type="checkbox">
                           <span class="mx-2">Xem thông tin nhân viên</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa nhân viên" type="checkbox">
                           <span class="mx-2">Xóa nhân viên</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Chỉnh sửa mật khẩu" type="checkbox">
                           <span class="mx-2">Chỉnh sửa mật khẩu</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Liên hệ" type="checkbox">
                           <span class="mx-2">Liên hệ</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Khôi phục khách hàng" type="checkbox">
                           <span class="mx-2">Khôi phục khách hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Ẩn khách hàng" type="checkbox">
                           <span class="mx-2">Ẩn khách hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa khách hàng" type="checkbox">
                           <span class="mx-2">Xóa khách hàng</span>
                        </div>
                     </div>
                  </div>

                  <h5 class="fw-bolder mb-4 mt-4">Quản trị doanh mục: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Xem chi tiết sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Thêm chi tiết sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Chỉnh sửa chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Chỉnh sửa chi tiết sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Xóa chi tiết sản phẩm</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm, xóa thương hiệu" type="checkbox">
                           <span class="mx-2">Thêm, xóa thương hiệu</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm, xóa loại giày" type="checkbox">
                           <span class="mx-2">Thêm, xóa loại giày</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm, xóa size" type="checkbox">
                           <span class="mx-2">Thêm, xóa size</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Ẩn hiện sản phẩm" type="checkbox">
                           <span class="mx-2">Ẩn hiện sản phẩm</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm sản phẩm" type="checkbox">
                           <span class="mx-2">Thêm sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xem chi tiết" type="checkbox">
                           <span class="mx-2">Xem chi tiết</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Chỉnh sửa sản phẩm" type="checkbox">
                           <span class="mx-2">Chỉnh sửa sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa sản phẩm" type="checkbox">
                           <span class="mx-2">Xóa sản phẩm</span>
                        </div>
                     </div>
                  </div>

                  <h5 class="fw-bolder mb-4 mt-4">Quản trị thống kê: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem doanh thu" type="checkbox">
                           <span class="mx-2">Xem doanh thu</span>
                        </div>
                     </div>
                  </div>

                  <h5 class="fw-bolder mb-4 mt-4">Quản trị đơn hàng: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem đơn hàng" type="checkbox">
                           <span class="mx-2">Xem đơn hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xem chi tiết đơn hàng" type="checkbox">
                           <span class="mx-2">Xem chi tiết đơn hàng</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem đơn hàng đã giao" type="checkbox">
                           <span class="mx-2">Xem đơn hàng đã giao</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Cập nhật tình trạng đơn hàng" type="checkbox">
                           <span class="mx-2">Cập nhật tình trạng đơn hàng</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem đơn hàng đã hủy" type="checkbox">
                           <span class="mx-2">Xem đơn hàng đã hủy</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-success">Thêm</button>
            </div>
         </form>
      </div>
   </div>
</div>

<!-- Modal Sửa Nhân Viên -->
<div class="modal fade" id="modal_edit_admin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title text-success fw-bold fs-5" id="exampleModalLabel">Chỉnh sửa nhân Viên</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form id="form_edit_admin">
            <div class="modal-body">
               <div class="container">
                  <input type="hidden" name="emp_admin_id" id="emp_admin_id" value="">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Họ Tên</label> <br>
                           <small id="emp_name1_error" class="badge text-danger"></small>
                           <input name="emp_name1" id="emp_name1" type="text" class="form-control">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Ngày làm việc</label> <br>
                           <small id="datepicker1_error" class="badge text-danger"></small>
                           <input name="emp_start_date1" type="text" id="datepicker1" class="form-control"
                              placeholder="Chọn ngày">
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Tài Khoản</label> <br>
                           <small id="emp_username1_error" class="badge text-danger"></small>
                           <input name="emp_username1" id="emp_username1" type="text" class="form-control">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Mật khẩu</label> <br>
                           <small id="emp_password1_error" class="badge text-danger"></small>
                           <input name="emp_password1" id="emp_password1" type="text" class="form-control">
                        </div>
                     </div>
                  </div>

                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Số điện thoại</label> <br>
                           <small id="emp_phone1_error" class="badge text-danger"></small>
                           <input name="emp_phone1" id="emp_phone1" type="text" class="form-control">
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label for="" class="form-label fw-bolder">Chức vụ</label> <br>
                           <small id="emp_position1_error" class="badge text-danger"></small>
                           <input name="emp_position1" id="emp_position1" type="text" class="form-control">
                        </div>
                     </div>
                  </div>

                  <!-- Phân quyền chức năng -->
                  <h5 class="fw-bolder mb-4 mt-4">Quản trị người dùng: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem thông tin khách hàng" type="checkbox">
                           <span class="mx-2">Xem thông tin khách hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xem thông tin nhân viên" type="checkbox">
                           <span class="mx-2">Xem thông tin nhân viên</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa nhân viên" type="checkbox">
                           <span class="mx-2">Xóa nhân viên</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Chỉnh sửa mật khẩu" type="checkbox">
                           <span class="mx-2">Chỉnh sửa mật khẩu</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Liên hệ" type="checkbox">
                           <span class="mx-2">Liên hệ</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Khôi phục khách hàng" type="checkbox">
                           <span class="mx-2">Khôi phục khách hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Ẩn khách hàng" type="checkbox">
                           <span class="mx-2">Ẩn khách hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa khách hàng" type="checkbox">
                           <span class="mx-2">Xóa khách hàng</span>
                        </div>
                     </div>
                  </div>

                  <h5 class="fw-bolder mb-4 mt-4">Quản trị doanh mục: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Xem chi tiết sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Thêm chi tiết sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Chỉnh sửa chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Chỉnh sửa chi tiết sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa chi tiết sản phẩm" type="checkbox">
                           <span class="mx-2">Xóa chi tiết sản phẩm</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm, xóa thương hiệu" type="checkbox">
                           <span class="mx-2">Thêm, xóa thương hiệu</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm, xóa loại giày" type="checkbox">
                           <span class="mx-2">Thêm, xóa loại giày</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm, xóa size" type="checkbox">
                           <span class="mx-2">Thêm, xóa size</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Ẩn hiện sản phẩm" type="checkbox">
                           <span class="mx-2">Ẩn hiện sản phẩm</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Thêm sản phẩm" type="checkbox">
                           <span class="mx-2">Thêm sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xem chi tiết" type="checkbox">
                           <span class="mx-2">Xem chi tiết</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Chỉnh sửa sản phẩm" type="checkbox">
                           <span class="mx-2">Chỉnh sửa sản phẩm</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xóa sản phẩm" type="checkbox">
                           <span class="mx-2">Xóa sản phẩm</span>
                        </div>
                     </div>
                  </div>

                  <h5 class="fw-bolder mb-4 mt-4">Quản trị thống kê: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem doanh thu" type="checkbox">
                           <span class="mx-2">Xem doanh thu</span>
                        </div>
                     </div>
                  </div>

                  <h5 class="fw-bolder mb-4 mt-4">Quản trị đơn hàng: </h5>
                  <div class="row mt-2">
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem đơn hàng" type="checkbox">
                           <span class="mx-2">Xem đơn hàng</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Xem chi tiết đơn hàng" type="checkbox">
                           <span class="mx-2">Xem chi tiết đơn hàng</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem đơn hàng đã giao" type="checkbox">
                           <span class="mx-2">Xem đơn hàng đã giao</span>
                        </div>
                        <div class="d-flex">
                           <input name="feature[]" value="Cập nhật tình trạng đơn hàng" type="checkbox">
                           <span class="mx-2">Cập nhật tình trạng đơn hàng</span>
                        </div>
                     </div>
                     <div class="col-lg-4">
                        <div class="d-flex">
                           <input name="feature[]" value="Xem đơn hàng đã hủy" type="checkbox">
                           <span class="mx-2">Xem đơn hàng đã hủy</span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="submit" class="btn btn-success">Cập nhật</button>
            </div>
         </form>
      </div>
   </div>
</div>

<script>
   flatpickr("#datepicker", {
      dateFormat: "d-m-Y"
   });

   flatpickr("#datepicker1", {
      dateFormat: "d-m-Y"
   });
</script>