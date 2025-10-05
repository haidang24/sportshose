<div class="container">
   <h1 class="text-success text-center fw-bold mb-3 mt-3">Đơn Hàng Đã Hủy</h1>
   <div class="row">
      <div class="col-lg-12">
         <table class="table table-bordered">
            <thead class="table-success">
               <tr class="text-center">
                  <th>Khách Hàng</th>
                  <th>Địa Chỉ</th>
                  <th>Đặt Hàng</th>
                  <th>Đã Hủy</th>
                  <th></th>
               </tr>
            </thead>
            <!-- Đổ dữ liệu bên ajax order.js -->
            <tbody id="table_order_cancel"></tbody>
         </table>
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