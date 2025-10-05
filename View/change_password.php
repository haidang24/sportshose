<div class="container mt-5 mb-5">
   <div class="row">
      <div class="col-lg-7 offset-md-3">
         <div class="card">
            <div class="card-header">
               <h4 class="fw-bold text-success text-center">Thay đổi mật khẩu</h4>
            </div>
            <div class="card-body">
               <form id="form_change_password">
                  <input type="hidden" name="user_id"
                     value="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '' ?>">
                  <div class="mb-3">
                     <label class="form-label fw-bolder fs-6">Mật khẩu cũ</label>
                     <input name="password_old" id="password_old" type="password" class="form-control"
                        placeholder="Nhập mật khẩu">
                     <small id="password_old_error" class="text-danger badge"></small>
                  </div>
                  <div class="mb-3">
                     <label class="form-label fw-bolder fs-6">Mật khẩu mới</label>
                     <input name="password_new" id="password_new" type="password" class="form-control"
                        placeholder="Nhập mật khẩu">
                     <small id="password_new_error" class="text-danger badge"></small>
                  </div>
                  <div class="mb-3">
                     <label class="form-label fw-bolder fs-6">Nhập lại khẩu mới</label>
                     <input name="confirm_password_new" id="confirm_password_new" type="password" class="form-control"
                        placeholder="Nhập mật khẩu">
                     <small id="confirm_password_new_error" class="text-danger badge"></small>
                  </div>
                  <div class="mb-3 form-check">
                     <input style="cursor: pointer" type="checkbox" class="form-check-input" id="show_password">
                     <label class="form-check-label fs-6">Hiển mật khẩu</label>
                  </div>
                  <div class="d-flex justify-content-end">
                     <button type="submit" class="btn btn-success text-end">Thay đổi</button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>