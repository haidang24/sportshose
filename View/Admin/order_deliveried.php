<div class="container">
   <h1 class="text-success text-center fw-bold mb-3 mt-3">Đơn Hàng Đã Giao</h1>
   <div class="row">
      <div class="col-lg-12">
         <table class="table table-bordered">
            <thead class="table-success">
               <tr class="text-center">
                  <th>Khách Hàng</th>
                  <th>Địa Chỉ</th>
                  <th>Đặt Hàng</th>
                  <th>Đã giao</th>
                  <th></th>
               </tr>
            </thead>
            <!-- Đổ dữ liệu bên ajax order.js -->
            <tbody id="table_order_deliveried"></tbody>
         </table>

         <!-- Paginate -->
         <?php
         $order = new Order();
         $row_order = $order->getAll_Order1()->rowCount();
         $per_page = ceil($row_order / 10);
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
      </div>
   </div>
</div>

<!-- Modal Order_details -->
<div class="modal fade" id="modal_order_details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h1 class="modal-title fs-6 fw-bold text-success" id="exampleModalLabel">Chi Tiết Đơn Hàng</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <!-- Dữ liệu đổ trong ajax -->
         <div id="table_order_details" class="modal-body"></div>
      </div>
   </div>
</div>