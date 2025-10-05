<div class="container py-5">
  <div class="text-center">
    <div class="display-6 text-success mb-3">Thanh toán thành công</div>
    <p>Cảm ơn bạn đã mua hàng. Đơn hàng của bạn đã được ghi nhận.</p>
    <a href="index.php?action=home" class="btn btn-primary mt-3">Về trang chủ</a>
  </div>
</div>
<script>
  // Đảm bảo xóa giỏ hàng phía client và cập nhật badge sau khi thanh toán
  try {
    // Gọi server để xóa session cart nhằm đảm bảo đồng bộ
    fetch('Controller/paypal.php?act=clear_cart', { method: 'POST' }).catch(() => {});
    // Nếu trang có badge tổng số lượng
    var badge = document.getElementById('totalCart');
    if (badge) badge.textContent = '0';
    // Nếu có lưu cart ở localStorage để hỗ trợ front-end thì xóa
    if (window.localStorage) {
      localStorage.removeItem('cart');
    }
  } catch (e) {}
</script>

