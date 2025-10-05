<style>
   .rounded {
      border-radius: 30px !important;
   }

   .border {
      margin: 0 auto;
      height: 67vh;
      /* Chiều cao của đường viền dọc */
      width: 1px;
      border: 5px solid #666;
      /* Đường viền bên trái rộng 100px */
   }
</style>
<div class="container mt-5">
   <div class="row">
      <div class="col-lg-4">
         <div class="bg-info shadow-lg p-3 mb-5 bg-tertiary rounded d-flex justify-content-around">
            <i class="bi bi-cash-coin fs-1 mt-3"></i>
            <div>
               <h3>Tổng tiền</h3>
               <b class="fs-3">
                  <?php
                  $statistical = new Statistical();
                  $Order = new Order();
                  $total_money = $Order->sum_order_deliveried();
                  echo number_format($total_money['total_money']);
                  ?>đ
               </b>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="bg-warning shadow-lg p-3 mb-5 bg-tertiary rounded d-flex justify-content-around">
            <i class="bi bi-cart-check fs-1 mt-3"></i>
            <div>
               <h3>Đơn hàng</h3>
               <b style="margin-left: 45px;" class="fs-3">
                  <?php
                  $total_goods_sold = $statistical->total_Goods_Sold();
                  echo $total_goods_sold['goods_sold'];
                  ?>
               </b>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="bg-success shadow-lg p-3 mb-5 bg-tertiary rounded d-flex justify-content-around">
            <i class="bi bi-people fs-1 mt-3"></i>
            <div>
               <h3>Thành viên</h3>
               <b style="margin-left: 45px;" class="fs-3">
                  <?php
                  $total_goods_sold = $statistical->total_User();
                  echo $total_goods_sold['total_user'];
                  ?>
               </b>
            </div>
         </div>
      </div>
   </div>

   <div class="row">
      <div class="col-lg-6">
         <div class="card">
            <div class="card-header text-center">
               <span class="fw-bold fs-4">Thống Kê Đơn Tháng</span>
            </div>
            <div class="card-body">
               <table class="table">
                  <thead class="table-danger">
                     <tr class="text-center">
                        <th>Tháng</th>
                        <th>Đơn Hàng</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $statistical = new Statistical();
                     $total_order_month = $statistical->getOrder_ByMonth();
                     while ($set = $total_order_month->fetch()):
                        ?>
                        <tr class="text-center">
                           <td><?php echo $set['month'] ?></td>
                           <td><?php echo $set['total_orders'] ?></td>
                        </tr>
                     <?php endwhile ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-lg-6">
         <h3 class="text-center">TOP 3 SẢN PHẨM BÁN CHẠY</h3>
         <canvas id="myPieChart"></canvas>
      </div>
      <!-- <div class="col-lg-4">
         <div class="card">
            <div class="card-header text-center">
               <span class="fw-bold fs-4">Thống Kê Đơn Tháng</span>
            </div>
            <div class="card-body">
               <table class="table">
                  <thead class="table-danger">
                     <tr class="text-center">
                        <th>Tháng</th>
                        <th>Đơn Hàng</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
      <div class="col-lg-4">
         <div class="card">
            <div class="card-header text-center">
               <span class="fw-bold fs-4">Thống Kê Đơn Tháng</span>
            </div>
            <div class="card-body">
               <table class="table">
                  <thead class="table-danger">
                     <tr class="text-center">
                        <th>Tháng</th>
                        <th>Đơn Hàng</th>
                     </tr>
                  </thead>
                  <tbody>
                     
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                     <tr class="text-center">
                        <td>1</td>
                        <td>152 đơn</td>
                     </tr>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div> -->

      <!-- <div class="row">
      <div class="col-lg-5">
         <h3 class="text-center">THỐNG KÊ BIỂU ĐỒ NGÀY</h3>
         <canvas height="200" id="myLineChart"></canvas>
      </div>
      <div class="col-lg-2">
         <div class="border"></div>
      </div>
      <div class="col-lg-5">
         <h3 class="text-center">THỐNG KÊ ĐƠN HÀNG THÁNG</h3>
         <canvas height="200" id="myBarChart"></canvas>
      </div>
      
   </div>

   <div class="row mt-5">
      <div class="col-lg-4">
         <h3 class="text-center">TOP 3 SẢN PHẨM BÁN CHẠY</h3>
         <canvas id="myPieChart"></canvas>
      </div>
   </div> -->
   </div>

   <!-- Biểu đồ tròn thống kê TOP 3 sản phẩm bán nhiều nhất -->
   <?php
   $product = [];
   $pro_bestsale = $statistical->getProduct_BestSale();
   while ($result = $pro_bestsale->fetch()) {
      $product[] = $result; // Thêm dữ liệu vào mảng $product
   }
   // Chuyển mảng $product sang dạng JSON và đưa vào đoạn mã JavaScript
   echo "<script>const productData = " . json_encode($product) . ";</script>";
   ?>

   <script>
      // Sử dụng dữ liệu từ PHP
      const labels = productData.map(item => item.product_name); // Giả sử tên sản phẩm được lưu trong trường product_name
      const values = productData.map(item => item.total_sold); // Giả sử số lượng bán được lưu trong trường sales_quantity
      const backgroundColors = [
         'rgb(255, 99, 132)',
         'rgb(54, 162, 235)',
         'rgb(255, 205, 86)',
      ]; // Có thể thay đổi màu sắc nếu cần

      // Cập nhật dữ liệu cho biểu đồ
      const data = {
         labels: labels,
         datasets: [{
            data: values,
            backgroundColor: backgroundColors,
            hoverOffset: 4
         }]
      };

      // Tạo biểu đồ
      const ctx = document.getElementById('myPieChart').getContext('2d');
      const myPieChart = new Chart(ctx, {
         type: 'doughnut',
         data: data
      });
   </script>

   <!-- Biểu đồ cột thống kê đơn hàng theo tháng -->
   <?php
   $product_month = [];
   $pro_month = $statistical->getOrder_ByMonth();
   while ($result = $pro_month->fetch()) {
      $product_month[] = $result; // Thêm dữ liệu vào mảng $product
   }
   // Chuyển mảng $product sang dạng JSON và đưa vào đoạn mã JavaScript
   echo "<script>const product_month = " . json_encode($product_month) . ";</script>";
   ?>
   <script>
      // Lấy số lượng đơn hàng từ dữ liệu trả về
      const orderCounts = product_month.map(item => item.total_orders);

      // Cập nhật dữ liệu cho biểu đồ
      const dataForBarChart = {
         labels: ['Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10'],
         datasets: [{
            label: 'Số đơn hàng',
            data: orderCounts,
            backgroundColor: [
               'rgba(255, 99, 132, 0.2)',
               'rgba(255, 159, 64, 0.2)',
               'rgba(255, 205, 86, 0.2)',
               'rgba(75, 192, 192, 0.2)',
               'rgba(54, 162, 235, 0.2)',
               'rgba(153, 102, 255, 0.2)',
               'rgba(201, 203, 207, 0.2)'
            ],
            borderColor: [
               'rgb(255, 99, 132)',
               'rgb(255, 159, 64)',
               'rgb(255, 205, 86)',
               'rgb(75, 192, 192)',
               'rgb(54, 162, 235)',
               'rgb(153, 102, 255)',
               'rgb(201, 203, 207)'
            ],
            borderWidth: 1
         }]
      };

      const configForBarChart = {
         type: 'bar',
         data: dataForBarChart,
         options: {
            scales: {
               y: {
                  beginAtZero: true,
                  max: 50  // Đặt giá trị max là 100
               }
            }
         }
      };

      const ctxForBarChart = document.getElementById('myBarChart').getContext('2d');
      const myBarChart = new Chart(ctxForBarChart, configForBarChart);
   </script>

   <!-- Biểu đồ đường thống kê đơn hàng theo ngày -->
   <?php
   $product_day = [];
   $pro_day = $statistical->getOrder_ByDay();
   while ($result = $pro_day->fetch()) {
      $product_day[] = $result; // Thêm dữ liệu vào mảng $product
   }
   // Chuyển mảng $product sang dạng JSON và đưa vào đoạn mã JavaScript
   echo "<script>const product_day = " . json_encode($product_day) . ";</script>";
   ?>
   <script>
      // Dữ liệu và cấu hình của biểu đồ
      const lineLabels = product_day.map(item => item.day); // Sử dụng ngày từ dữ liệu PHP
      const lineData = {
         labels: lineLabels,
         datasets: [{
            label: 'Số đơn hàng',
            data: product_day.map(item => item.total_orders), // Số đơn hàng theo từng ngày từ dữ liệu PHP
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
         }]
      };

      const lineConfig = {
         type: 'line',
         data: lineData,
         options: {
            scales: {
               y: {
                  beginAtZero: true,
                  max: 20  // Đặt giá trị max là 100
               }
            }
         }
      };

      // Vẽ biểu đồ
      const lineCtx = document.getElementById('myLineChart').getContext('2d');
      const myLineChart = new Chart(lineCtx, lineConfig);
   </script>