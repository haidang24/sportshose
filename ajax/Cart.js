$(document).ready(() => {
    // Lấy id item trong giỏ hàng để xóa
    $(document).on('click', '#drop_ItemCart', function () {
        id_item = $(this).val();
        $.ajax({
            url: 'Controller/details_product.php?act=delete_ItemCart',
            method: 'post',
            data: { id_item: id_item },
            dataType: 'json',
            success: (res) => {
                window.location.reload();
            }
        });
    })

    // Thay đổi số lượng trên giỏ hàng
    $.ajax({
        url: 'Controller/cart.php?act=update_Quantity_Cart',
        method: 'post',
        dataType: 'json',
        success: (res) => {
            $('.position-absolute').text(res);
        }
    });

    // Tăng số lượng trong giỏ hàng
    $('.increase_cart').on('click', function () {
        var button = $(this); // Lưu trữ thẻ button được nhấp
        sp_id = $(this).data('id');
        $.ajax({
            url: 'Controller/cart.php?act=increase_cart',
            method: 'POST',
            data: { sp_id: sp_id },
            dataType: 'json',
            success: (res) => {
                button.closest('.d-flex').find('.quantity_cart').text(res.quantity);
                updateCartTotal();
                checkProductQuantities();
            }
        })
    })

    // Giảm số lượng trong giỏ hàng
    $('.decrease_cart').on('click', function () {
        var button = $(this); // Lưu trữ thẻ button được nhấp
        sp_id = $(this).data('id');
        $.ajax({
            url: 'Controller/cart.php?act=decrease_cart',
            method: 'POST',
            data: { sp_id: sp_id },
            dataType: 'json',
            success: (res) => {
                button.closest('.d-flex').find('.quantity_cart').text(res.quantity);
                updateCartTotal();
                checkProductQuantities();
            }
        })
    })

    // Kiểm tra số lượng sản phẩm trong kho
    function checkProductQuantities() {
        $('.repo_cart').each(function() {
            var $this = $(this);
            var productName = $this.data('name');
            var size = $this.data('size');
            var $stockElement = $this.next('.stock-count');
            
            console.log('Checking stock for:', {
                productName: productName,
                size: size,
                element: $this
            });
            
            if (!productName || !size) {
                console.warn('Missing product data:', { productName, size });
                $stockElement.text('N/A').css('color', '#dc3545');
                return;
            }
            
            $.ajax({
                url: 'Controller/cart.php?act=get_stock_by_size',
                method: 'POST',
                data: { 
                    name_product: productName,
                    size_id: size
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Stock API response:', response);
                    
                    if (response && response.available !== undefined) {
                        let stockText = response.available;
                        if (response.in_cart > 0) {
                            stockText += ' (Có ' + response.in_cart + ' trong giỏ)';
                        }
                        if (response.warning) {
                            stockText += ' ⚠️';
                        }
                        console.log('Setting stock text:', stockText);
                        $stockElement.text(stockText);
                        
                        // Update stock color based on availability
                        if (response.warning) {
                            $stockElement.css('color', '#dc3545'); // Red for warning
                        } else if (response.available > 10) {
                            $stockElement.css('color', '#28a745'); // Green for good stock
                        } else if (response.available > 0) {
                            $stockElement.css('color', '#ffc107'); // Yellow for low stock
                        } else {
                            $stockElement.css('color', '#dc3545'); // Red for no stock
                        }
                    } else {
                        console.warn('Invalid stock response:', response);
                        $stockElement.text('N/A').css('color', '#dc3545');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Stock API error:', error, xhr.responseText);
                    $stockElement.text('N/A').css('color', '#dc3545');
                }
            });
        });
    }

    // Gọi hàm kiểm tra khi trang load
    checkProductQuantities();

    // Cập nhật tổng tiền giỏ hàng
    function updateCartTotal() {
        let total = 0;
        $('.cart-line-total span').each(function() {
            const priceText = $(this).text().replace(/[^\d]/g, '');
            const price = parseFloat(priceText) || 0;
            total += price;
        });
        
        $('#cart-subtotal').text(formatPrice(total));
        $('#cart-total').text(formatPrice(total));
    }

    // Format price
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
    }

    // Gọi hàm cập nhật tổng tiền khi trang load
    updateCartTotal();
});