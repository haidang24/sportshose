
<div class="container">
   <h1 class="mt-3 text-success text-center fw-bold">Đơn hàng</h1>
   <span class="fs-5">Đang có <b class="text-success" id="count_order_wating"></b> đơn chờ xử lý...</span>
   <div class="row">
      <div class="col-lg-12">
         <table class="table table-bordered">
            <thead class="table-success">
               <tr class="text-center">
                  <th>Khách Hàng</th>
                  <th>Địa Chỉ</th>
                  <th>Đặt Hàng</th>
                  <th>Đang Giao</th>
                  <th>Tình Trạng</th>
                  <th></th>
               </tr>
            </thead>
            <!-- Đổ dữ liệu bên ajax order.js -->
            <tbody id="table_order"></tbody>
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