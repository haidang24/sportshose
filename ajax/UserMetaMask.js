$(document).ready(function () {
  $(document).on('click', '#userMetaMaskLogin', async function () {
    if (typeof window.ethereum === 'undefined') {
      Swal.fire({
        icon: 'warning',
        title: 'MetaMask chưa được cài',
        text: 'Hãy cài tiện ích MetaMask để sử dụng tính năng này',
        footer: '<a href="https://metamask.io/download/" target="_blank">Tải MetaMask</a>'
      });
      return;
    }

    try {
      $(this).addClass('loading');
      const accounts = await window.ethereum.request({ method: 'eth_requestAccounts' });
      const address = accounts[0];
      const message = 'Đăng nhập GIAYTHETHAO bằng ví MetaMask\n\nNonce: ' + Date.now();
      const signature = await window.ethereum.request({
        method: 'personal_sign',
        params: [message, address]
      });

      $.ajax({
        url: 'Controller/User.php?act=metamask_login',
        method: 'POST',
        dataType: 'json',
        data: { address, signature, message },
        success: (res) => {
          $(this).removeClass('loading');
          if (res && res.status === 200) {
            Swal.fire({ icon: 'success', title: 'Đăng nhập MetaMask thành công!', timer: 1200, showConfirmButton: false });
            setTimeout(() => { window.location.href = 'index.php'; }, 1200);
          } else {
            Swal.fire({ icon: 'error', title: 'Xác thực thất bại', text: res.message || 'Không thể đăng nhập bằng MetaMask' });
          }
        },
        error: () => {
          $(this).removeClass('loading');
          Swal.fire({ icon: 'error', title: 'Lỗi kết nối', text: 'Không thể kết nối máy chủ' });
        }
      });
    } catch (e) {
      $(this).removeClass('loading');
      Swal.fire({ icon: 'error', title: 'Lỗi MetaMask', text: e.message || 'Không thể kết nối MetaMask' });
    }
  });
});


