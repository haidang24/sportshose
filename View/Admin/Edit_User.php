<div class="container">
   <div class="row">
      <div class="col-lg-6 offset-md-3" style="margin-top: 40px">
         <div id="card_update">
            <div class="card">
               <div class="card-header bg-info">
                  <h4 class="text-dark text-center">SỬA THÔNG TIN</h4>
               </div>
               <div class="card-body">
                  <form>
                     <?php 
                        if(isset($_GET['id'])) {
                           $id = $_GET['id'];
                           $user = new User();
                           $kq = $user->getOne_User($id);
                           $fullname = $kq['firstname'] . '' . $kq['lastname'];
                           $email = $kq['email'];
                           $password = $kq['password'];
                        }
                     ?>
                     <div class="form-group mb-3">
                        <label class="form-label">Họ tên</label>
                        <input disabled type="text" value="<?php echo $fullname?$fullname:''?>" id="fullname" class="form-control">
                     </div>
                     <div class="form-group mb-3">
                        <label class="form-label">Email</label>
                        <input disabled type="text" value="<?php echo $email?$email:''?>" id="email" class="form-control">
                     </div>
                     <div class="form-group mb-3">
                        <label class="form-label">Mật khẩu</label>
                        <input type="text" id="newpass" value="<?php echo $password?$password:''?>" id="password" class="form-control">
                        <small id="password_error" class="text-danger"></small>
                     </div>

                     <button id="update_action" value="<?php echo $id?>" class="mt-4 btn btn-primary">CẬP NHẬT</button>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
