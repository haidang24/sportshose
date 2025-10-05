<div class="container mt-3">
   <h1 class="fw-bold mb-3 text-success text-center">KHÁCH HÀNG LIÊN HỆ</h1>
   <div class="row">
      <div class="col-lg-12">
         <table class="table table-bordered">
            <thead class="table-success">
               <tr class="text-center">
                  <th>Họ tên</th>
                  <th>Số điện thoại</th>
                  <th>Email</th>
                  <th>Nội dung</th>
                  <th>Thời gian</th>
                  <th>Đã đọc</th>
               </tr>
            </thead>
            <tbody>
               <?php 
                  $contact = new Contact();
                  $Result_contact = $contact->getAll_Contact();
                  while($Result_set = $Result_contact->fetch()):
               ?>
               <tr class="text-center" height="70px">
                  <input id="contact_id" type="hidden" value="<?php echo $Result_set['id']?>">
                  <td style="line-height: 40px;"><?php echo $Result_set['fullname']?></td>
                  <td style="line-height: 40px;"><?php echo $Result_set['email']?></td>
                  <td style="line-height: 40px;"><?php echo $Result_set['number_phone']?></td>
                  <td style="line-height: 40px;"><?php echo $Result_set['content']?></td>
                  <td style="line-height: 40px;"><?php echo $Result_set['create_at']?></td>
                  <td style="line-height: 40px;"><input <?php echo ($Result_set['status'] == 'Đã xử lý'?'checked disabled':'')?> value="<?php echo $Result_set['id']?>" id="read_contact" type="checkbox" style="cursor: pointer;"></td>
               </tr>
               <?php endwhile?>
            </tbody>
         </table>
      </div>
   </div>
</div>