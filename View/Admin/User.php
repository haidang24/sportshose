<h1 class="mt-3 mb-3 text-success fw-bolder text-center">Thông Tin Khách Hàng</h1>
<div class="col-lg-12">
   <div class="d-flex justify-content-center">
      <input id="search_user" style="width: 350px;" type="text" class="form-control" placeholder="Tìm kiếm khách hàng">
   </div>
   <table class="table table-bordered">
      <thead class="table-primary">
         <tr>
            <th>Mã KH</th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Mật khẩu</th>
            <th>Giới tính</th>
            <th>Ngày Sinh</th>
            <th>Số điện thoại</th>
            <th></th>
         </tr>
      </thead>

      <!-- Dữ liệu đổ bên ajax User.js -->
      <tbody id="table_user" class="table-light"></tbody>
   </table>
   <!-- Paginate -->

   <?php
   $user = new User();
   $row_user = $user->getAll_User()->rowCount();
   $per_page = ceil($row_user / 10);
   ?>

   <div class="d-flex justify-content-center">
      <nav aria-label="...">
         <ul class="pagination">
            <?php for ($i = 1; $i <= $per_page; $i++): ?>
               <li class="page-item <?php echo ($i == 1) ? 'active' : '' ?>"><a data-page_id="<?php echo $i ?>"
                     style="cursor: pointer;" class="page-link rounded-circle mx-1"><?php echo $i ?></a></li>
            <?php endfor ?>
         </ul>
      </nav>
   </div>
   <!-- Modal Chỉnh Sửa Mật Khẩu -->
   <div class="modal fade" id="modal_revise_password" tabindex="-1">
      <div class="modal-dialog">
         <div class="modal-content">
            <div class="modal-header">
               <h1 class="modal-title text-success fw-bold fs-5" id="exampleModalLabel">SỬA MẬT KHẨU</h1>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <input type="hidden" id="user_id">
               <div class="form-group">
                  <label class="form-label" for="">Email</label>
                  <input disabled id="revise_email" type="text" class="form-control">
               </div>

               <div class="form-group">
                  <label class="form-label" for="">Mật khẩu</label>
                  <input id="revise_password1" type="text" class="form-control">
                  <small class="badge text-danger" id="revise_password1_error"></small>
               </div>
               <div class="d-flex justify-content-end">
                  <button id="revise_password_action" type="button" class="btn btn-outline-success">Lưu</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>