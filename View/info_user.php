<!-- Profile CSS -->
<link rel="stylesheet" href="View/assets/css/profile.css">

<div class="profile-container">
   <div class="profile-wrapper">
      <div class="profile-header">
         <h1 class="profile-title">Thông Tin Cá Nhân</h1>
         <p class="profile-subtitle">Quản lý hồ sơ và thông tin giao hàng của bạn</p>
      </div>
      
      <?php
         $user = new User();
         if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
         }
         $get_avatar = $user->get_avatar_id($user_id);
      ?>
      
      <div class="profile-layout">
         <!-- Profile Information Card -->
         <div class="profile-card">
            <div class="card-header">
               <div class="card-icon">
                  <i class="fas fa-user-edit"></i>
               </div>
               <h2 class="card-title">Hồ Sơ Cá Nhân</h2>
            </div>
            
            <form id="form_user_details" class="premium-form">
            <?php
            $user = new user();
            $info_user = $user->getOne_User($user_id);

            // Extract day, month, and year from the birthday
            $birthday = $info_user['birthday'];
            $day = date('d', strtotime($birthday));
            $month = date('m', strtotime($birthday));
            $year = date('Y', strtotime($birthday));
            ?>
               <div class="form-row">
                  <div class="form-group">
                     <label class="form-label" for="firstname">Họ</label>
                     <input id="firstname" type="text" class="premium-input"
                        value="<?php echo $info_user['firstname'] ?>" placeholder="Nhập họ của bạn">
                     <small id="firstname_error" class="error-message"></small>
                  </div>
                  <div class="form-group">
                     <label class="form-label" for="lastname">Tên</label>
                     <input id="lastname" type="text" class="premium-input"
                        value="<?php echo $info_user['lastname'] ?>" placeholder="Nhập tên của bạn">
                     <small id="lastname_error" class="error-message"></small>
                  </div>
               </div>
               
               <div class="form-group">
                  <label class="form-label" for="number_phone">Số điện thoại</label>
                  <input id="number_phone" type="text" class="premium-input"
                     value="<?php echo isset($info_user['number_phone'])?'0'.$info_user['number_phone']:'' ?>" 
                     placeholder="Nhập số điện thoại">
                  <small id="number_phone_error" class="error-message"></small>
               </div>
               
               <div class="form-group">
                  <label class="form-label" for="email">Email</label>
                  <input id="email" disabled type="email" class="premium-input"
                     value="<?php echo $info_user['email'] ?>" placeholder="Email của bạn">
               </div>
               <div class="gender-group">
                  <label class="form-label">Giới tính</label>
                  <div class="gender-options">
                     <div class="gender-option">
                        <input type="radio" value="Nam" name="btnradio" id="btnradio1"
                              <?php echo ($info_user['gender'] == 'Nam') ? 'checked' : ''; ?>>
                        <label class="gender-label" for="btnradio1">Nam</label>
                     </div>
                     <div class="gender-option">
                        <input type="radio" value="Nữ" name="btnradio" id="btnradio2"
                              <?php echo ($info_user['gender'] == 'Nữ') ? 'checked' : ''; ?>>
                        <label class="gender-label" for="btnradio2">Nữ</label>
                     </div>
                     <div class="gender-option">
                        <input type="radio" value="Khác" name="btnradio" id="btnradio3"
                              <?php echo ($info_user['gender'] == 'Khác') ? 'checked' : ''; ?>>
                        <label class="gender-label" for="btnradio3">Khác</label>
                     </div>
                  </div>
                  <small id="gender_error" class="error-message"></small>
               </div>

               <div class="form-group">
                  <label class="form-label">Ngày sinh</label>
                  <div class="date-selectors">
                     <select id="day" class="premium-select">
                        <option value="">Ngày</option>
                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                           <option <?php echo ($day == $i)?'selected':''?> value='<?php echo $i ?>'><?php echo $i ?></option>
                        <?php } ?>
                     </select>
                     <select id="month" class="premium-select">
                        <option value="">Tháng</option>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                           <option <?php echo ($month == $i)?'selected':''?> value='<?php echo $i ?>'>Tháng <?php echo $i ?></option>
                        <?php } ?>
                     </select>
                     <select id="year" class="premium-select">
                        <option value="">Năm</option>
                        <?php for ($i = 2023; $i >= 1950; $i--) { ?>
                           <option <?php echo ($year == $i)?'selected':''?> value='<?php echo $i ?>'><?php echo $i ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               
               <button type="submit" class="profile-submit">
                  <i class="fas fa-save"></i>
                  Lưu Thông Tin
               </button>
            </form>
         </div>
         
         <!-- Avatar & Address Card -->
         <div class="profile-card">
            <div class="card-header">
               <div class="card-icon">
                  <i class="fas fa-user-circle"></i>
               </div>
               <h2 class="card-title">Ảnh Đại Diện & Địa Chỉ</h2>
            </div>
            
            <!-- Avatar Section -->
            <div class="avatar-section">
               <div class="avatar-container">
                  <img class="profile-avatar" id="preview_avatar"
                     src="./View/assets/img/avatar/<?php echo ($get_avatar) ? $get_avatar['avatar'] : 'avatar-trang-4.jpg' ?>"
                     alt="Avatar">
                  <div class="avatar-overlay">
                     <i class="fas fa-camera"></i>
                  </div>
               </div>
               
               <form id="save_avatar" class="avatar-upload">
                  <input name="user_id" id="user_id" type="hidden" value="<?php echo $_SESSION['user_id'] ?>">
                  <input class="form-control d-none" accept="image/png, image/gif, image/jpeg, image/webp" 
                     type="file" name="avatar" id="avatar">
                  <label class="avatar-btn" for="avatar">
                     <i class="fas fa-upload"></i>
                     Chọn Ảnh
                  </label>
                  <button type="submit" class="avatar-btn avatar-save">
                     <i class="fas fa-save"></i>
                     Lưu Ảnh
                  </button>
               </form>
               <small id="avatar_error" class="error-message"></small>
            </div>

            <!-- Address Section -->
            <div class="address-section">
               <div class="address-header">
                  <h3 class="address-title">Địa Chỉ Giao Hàng</h3>
               </div>
               
               <div id="table_address_user" class="address-list"></div>

               <button id="add_address_user" class="add-address-btn">
                  <i class="fas fa-plus"></i>
                  Thêm Địa Chỉ Mới
               </button>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal thêm địa chỉ mới -->
<div class="modal fade premium-modal" id="address_user" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-xl">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title" id="exampleModalLabel">Thêm Địa Chỉ Mới</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <form id="form_info_user1">
               <input name="user_id" type="hidden" value="<?php echo $_SESSION['user_id'] ?>">
               
               <div class="form-group">
                  <label class="form-label" for="fullname">Họ tên người nhận</label>
                  <input value="" id="fullname" name="fullname" class="premium-input" type="text"
                     placeholder="Nhập họ tên người nhận">
                  <small id="fullname_error" class="error-message"></small>
               </div>

               <div class="form-group">
                  <label class="form-label" for="numberphone">Số điện thoại</label>
                  <input value="" id="numberphone" name="numberphone" class="premium-input" type="text"
                     placeholder="Nhập số điện thoại người nhận">
                  <small id="numberphone_error" class="error-message"></small>
               </div>

               <div class="form-group">
                  <label class="form-label" for="address">Địa chỉ chi tiết</label>
                  <input value="" id="address" name="address" class="premium-input" placeholder="Nhập địa chỉ chi tiết"
                     type="text">
                  <small id="address_error" class="error-message"></small>
               </div>

               <div class="modal-form-row">
                  <div class="form-group">
                     <label class="form-label" for="province">Tỉnh/Thành phố</label>
                     <select class="premium-select" name="province" id="province">
                        <option value="">Chọn tỉnh/thành phố</option>
                        <?php
                        $Address = new Address_Order();
                        $Address_Result = $Address->getAll_Province();
                        while ($Address_set = $Address_Result->fetch()):
                           ?>
                           <option value="<?php echo $Address_set['province_id'] ?>">
                              <?php echo $Address_set['name'] ?>
                           </option>
                        <?php endwhile ?>
                     </select>
                     <small id="province_error" class="error-message"></small>
                  </div>
                  
                  <div class="form-group">
                     <label class="form-label" for="district">Quận/Huyện</label>
                     <select class="premium-select" name="district" id="district">
                        <option value="">Chọn quận/huyện</option>
                     </select>
                     <small id="district_error" class="error-message"></small>
                  </div>
                  
                  <div class="form-group">
                     <label class="form-label" for="wards">Phường/Xã</label>
                     <select class="premium-select" name="wards" id="wards">
                        <option value="">Chọn phường/xã</option>
                     </select>
                     <small id="wards_error" class="error-message"></small>
                  </div>
               </div>

               <button type="submit" class="modal-submit-btn">
                  <i class="fas fa-check"></i>
                  Hoàn Thành
               </button>
            </form>
         </div>
      </div>
   </div>
</div>