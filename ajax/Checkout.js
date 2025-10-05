/*
Premium E-commerce Checkout JavaScript
Modern Cart, Checkout and Payment Handling
*/

$(document).ready(function() {
    // ===== VARIABLES =====
    let paypalRendered = false;
    let selectedPaymentMethod = null;
    let selectedAddress = null;
    let orderItemsLoaded = false;

    // ===== INITIALIZATION =====
    initCheckout();

    function initCheckout() {
        loadProfileAddresses();
        setupEventListeners();
    }

    // ===== LOAD PROFILE ADDRESSES =====
    function loadProfileAddresses() {
        const userId = $('#user_id').val();
        console.log('Loading addresses for user:', userId);
        
        if (userId && userId > 0) {
            $.ajax({
                url: 'Controller/info_user.php',
                method: 'GET',
                data: { act: 'get_address_user' },
                dataType: 'json',
                success: function(addresses) {
                    console.log('Addresses loaded:', addresses);
                    
                    if (addresses && Array.isArray(addresses) && addresses.length > 0) {
                        displayProfileAddresses(addresses);
                    } else {
                        console.log('No addresses found, showing fallback form');
                        displayFallbackAddressForm();
                    }
                    
                    updateCheckoutButton();
                },
                error: function(xhr, status, error) {
                    console.error('Error loading addresses:', error, xhr.responseText);
                    displayFallbackAddressForm();
                    updateCheckoutButton();
                }
            });
        } else {
            displayFallbackAddressForm();
        }
    }

    // ===== DISPLAY PROFILE ADDRESSES =====
    function displayProfileAddresses(addresses) {
        const container = $('#profile-addresses-container');
        const fallbackForm = $('#fallback-address-form');
        
        container.empty();
        fallbackForm.hide();
        
        addresses.forEach((address, index) => {
            const addressHtml = `
                <div class="address-option" data-address='${JSON.stringify(address)}'>
                    <div class="address-content">
                        <div class="address-header">
                            <h6 class="address-name">${address.fullname || 'N/A'}</h6>
                            <span class="address-phone">${address.number_phone || 'N/A'}</span>
                        </div>
                        <div class="address-details">
                            <p class="address-text">${address.address || 'N/A'}</p>
                            <div class="address-location">
                                <span>${address.province || 'N/A'}</span>
                                <span>${address.district || 'N/A'}</span>
                                <span>${address.wards || 'N/A'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.append(addressHtml);
        });
        
        // Auto-select first address
        if (addresses.length > 0) {
            container.find('.address-option').first().click();
        }
    }

    // ===== DISPLAY FALLBACK ADDRESS FORM =====
    function displayFallbackAddressForm() {
        const container = $('#profile-addresses-container');
        const fallbackForm = $('#fallback-address-form');
        
        container.empty();
        fallbackForm.show();
        
        // Pre-fill form with session data if available
        const sessionData = window.sessionData || {};
        fallbackForm.find('input[name="fullname"]').val(sessionData.fullname || '');
        fallbackForm.find('input[name="phone"]').val(sessionData.number_phone || '');
        fallbackForm.find('input[name="address"]').val(sessionData.address || '');
    }

    // ===== SETUP EVENT LISTENERS =====
    function setupEventListeners() {
        // Show checkout modal
        $(document).on('click', '#btn_show_modal', function() {
            $('#modal_pay').modal('show');
        });

        // Modal events
        $('#modal_pay').on('shown.bs.modal', function() {
            if (!orderItemsLoaded) {
                loadCheckoutOrderItems();
                orderItemsLoaded = true;
            }
        });

        $('#modal_pay').on('hidden.bs.modal', function() {
            orderItemsLoaded = false;
        });

        // Address selection
        $(document).on('click', '.address-option', function() {
            $('.address-option').removeClass('selected');
            $(this).addClass('selected');
            selectedAddress = $(this).data('address');
            updateCheckoutButton();
        });

        // Payment method selection
        $(document).on('click', '.payment-method-card', function() {
            $('.payment-method-card').removeClass('selected');
            $(this).addClass('selected');
            selectedPaymentMethod = $(this).data('payment');
            
            // Show/hide PayPal notice
            if (selectedPaymentMethod === 'paypal') {
                $('#paypal-notice').slideDown();
            } else {
                $('#paypal-notice').slideUp();
            }
            updateCheckoutButton();
        });

        // Checkout confirmation
        $(document).on('click', '#checkout-confirm-btn', function() {
            processOrder();
        });

        // Close modal
        $(document).on('click', '.checkout-cancel-btn', function() {
            $('#modal_pay').modal('hide');
        });
    }

    // ===== LOAD CHECKOUT ORDER ITEMS =====
    function loadCheckoutOrderItems() {
        if (orderItemsLoaded) return;
        
        console.log('Loading checkout order items...');
        
        const orderItemsContainer = $('#checkout-order-items');
        orderItemsContainer.empty(); // Clear any loading message
        
        let totalItems = 0;
        let subtotal = 0;
        let hasItems = false;
        
        // Extract items from cart
        $('.cart-item-row').each(function() {
            const $item = $(this);
            
            const productName = $item.find('.cart-product-name').text().trim() || 'Sản phẩm';
            const productSize = $item.find('.cart-product-size').text().replace('Size:', '').trim() || 'N/A';
            const priceText = $item.find('.cart-price .current-price').text().replace(/[^\d]/g, '') || '0';
            const quantity = parseInt($item.find('.quantity_cart').text()) || 1;
            const imageSrc = $item.find('.cart-product-image').attr('src') || 'View/assets/img/placeholder.jpg';
            const itemTotal = $item.find('.cart-line-total span').text().replace(/[^\d]/g, '') || '0';
            
            const price = parseFloat(priceText) || 0;
            const total = parseFloat(itemTotal) || (price * quantity);
            
            totalItems += quantity;
            subtotal += total;
            hasItems = true;
            
            const itemHtml = `
                <div class="order-item-summary mb-3">
                    <div class="d-flex align-items-center">
                        <img src="${imageSrc}" alt="${productName}" class="order-item-image me-3" 
                             style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;"
                             onerror="this.src='View/assets/img/placeholder.jpg'">
                        <div class="flex-grow-1">
                            <h6 class="order-item-name mb-1">${productName}</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small">Size: ${productSize} | SL: ${quantity}</span>
                                <span class="fw-bold text-primary">${formatPrice(total)}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            orderItemsContainer.append(itemHtml);
        });
        
        // If no items found, show message
        if (!hasItems) {
            orderItemsContainer.html('<div class="text-center p-3 text-muted"><i class="fas fa-shopping-cart"></i><br>Giỏ hàng trống</div>');
        }
        
        // Update summary
        $('#checkout-subtotal').text(formatPrice(subtotal));
        $('#checkout-total').text(formatPrice(subtotal));
        
        orderItemsLoaded = true;
    }

    // ===== UPDATE CHECKOUT BUTTON =====
    function updateCheckoutButton() {
        const $btn = $('#checkout-confirm-btn');
        const hasAddress = selectedAddress || $('#fallback-address-form input[name="address"]').val();
        const hasPayment = selectedPaymentMethod;
        
        if (hasAddress && hasPayment) {
            $btn.prop('disabled', false).removeClass('btn-secondary').addClass('btn-success');
            $btn.html('<i class="fas fa-credit-card"></i> Đặt hàng');
        } else {
            $btn.prop('disabled', true).removeClass('btn-success').addClass('btn-secondary');
            $btn.html('<i class="fas fa-exclamation-triangle"></i> Chọn địa chỉ và phương thức thanh toán');
        }
    }

    // ===== PROCESS ORDER =====
    function processOrder() {
        const $btn = $('#checkout-confirm-btn');
        const originalText = $btn.html();
        
        // Set processing state
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang xử lý...');
        
        // Validate address and payment
        if (!selectedAddress && !$('#fallback-address-form input[name="address"]').val()) {
            resetButton($btn, originalText);
            Swal.fire('Lỗi', 'Vui lòng chọn địa chỉ giao hàng', 'error');
            return;
        }
        
        if (!selectedPaymentMethod) {
            resetButton($btn, originalText);
            Swal.fire('Lỗi', 'Vui lòng chọn phương thức thanh toán', 'error');
            return;
        }
        
        // Save shipping info first (but don't fail if it's not critical)
        saveShippingInfo().then(() => {
            console.log('Shipping info saved, proceeding with payment...');
            
            // Process based on payment method
            if (selectedPaymentMethod === 'cod') {
                processCODOrder();
            } else if (selectedPaymentMethod === 'paypal') {
                processPayPalOrder();
            } else if (selectedPaymentMethod === 'vnpay') {
                processVNPayOrder();
            }
        }).catch((error) => {
            console.error('Failed to save shipping info, but continuing with payment:', error);
            
            // Continue with payment even if shipping info save fails
            // The payment endpoint will handle validation
            if (selectedPaymentMethod === 'cod') {
                processCODOrder();
            } else if (selectedPaymentMethod === 'paypal') {
                processPayPalOrder();
            } else if (selectedPaymentMethod === 'vnpay') {
                processVNPayOrder();
            }
        });
    }

    // ===== SAVE SHIPPING INFO =====
    function saveShippingInfo() {
        return new Promise((resolve, reject) => {
            let shippingData = {};
            
            console.log('Selected address:', selectedAddress);
            console.log('Fallback form exists:', $('#fallback-address-form').length > 0);
            
            if (selectedAddress) {
                // Use selected profile address
                shippingData = {
                    fullname: selectedAddress.fullname,
                    number_phone: selectedAddress.number_phone,
                    address: selectedAddress.address,
                    province_id: selectedAddress.province_id || 0,
                    district_id: selectedAddress.district_id || 0,
                    wards_id: selectedAddress.wards_id || 0
                };
                console.log('Using selected address data');
            } else {
                // Use fallback form data
                const formData = $('#fallback-address-form').serializeArray();
                console.log('Form data:', formData);
                
                formData.forEach(item => {
                    shippingData[item.name] = item.value;
                });
                
                // Set default location IDs if not provided
                shippingData.province_id = shippingData.province_id || 0;
                shippingData.district_id = shippingData.district_id || 0;
                shippingData.wards_id = shippingData.wards_id || 0;
                
                console.log('Using fallback form data');
            }
            
            console.log('Sending shipping data:', shippingData);
            
            // If no data from form or selected address, try to get from session
            if (!shippingData.fullname || !shippingData.number_phone || !shippingData.address) {
                console.log('No shipping data found, checking session...');
                
                // Try to get from a hidden input or global variable if available
                const userId = $('#user_id').val();
                if (userId && userId > 0) {
                    // Get user info from a global variable or make an AJAX call
                    shippingData = {
                        fullname: window.userFullname || 'Khách hàng',
                        number_phone: window.userPhone || '0123456789',
                        address: window.userAddress || 'Địa chỉ giao hàng',
                        province_id: window.userProvince || 0,
                        district_id: window.userDistrict || 0,
                        wards_id: window.userWards || 0
                    };
                } else {
                    // Fallback to default values
                    shippingData = {
                        fullname: 'Khách hàng',
                        number_phone: '0123456789',
                        address: 'Địa chỉ giao hàng',
                        province_id: 0,
                        district_id: 0,
                        wards_id: 0
                    };
                }
            }
            
            // Ensure we have valid data
            console.log('Final shipping data before sending:', shippingData);
            
            // Final validation - but don't fail, just log warning
            if (!shippingData.fullname || !shippingData.number_phone || !shippingData.address) {
                console.warn('Shipping data incomplete:', shippingData);
                // Don't reject, let the payment endpoint handle validation
            }
            
            $.ajax({
                url: 'Controller/checkout.php?act=set_info',
                method: 'POST',
                data: shippingData,
                dataType: 'json',
                success: function(response) {
                    console.log('Shipping info saved:', response);
                    if (response && response.status === 'OK') {
                        console.log('Shipping info saved successfully');
                        resolve(response);
                    } else {
                        console.error('Invalid response from server:', response);
                        reject(new Error('Invalid response from server'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error saving shipping info:');
                    console.error('Status:', status);
                    console.error('Error:', error);
                    console.error('Response:', xhr.responseText);
                    console.error('Status Code:', xhr.status);
                    console.error('URL:', xhr.responseURL);
                    
                    let errorMessage = 'Có lỗi xảy ra khi lưu thông tin địa chỉ';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Không tìm thấy endpoint xử lý. Vui lòng kiểm tra đường dẫn.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Lỗi máy chủ, vui lòng thử lại';
                    } else if (xhr.status === 0) {
                        errorMessage = 'Không thể kết nối đến máy chủ';
                    }
                    
                    reject(new Error(errorMessage));
                }
            });
        });
    }

    // ===== PROCESS COD ORDER =====
    function processCODOrder() {
        // Ensure we have session data before proceeding
        console.log('Processing COD order...');
        console.log('User ID:', $('#user_id').val());
        console.log('User data available:', {
            fullname: window.userFullname,
            phone: window.userPhone,
            address: window.userAddress
        });
        
        $.ajax({
            url: 'Controller/paypal.php',
            method: 'POST',
            data: { act: 'cod' },
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Đang xử lý đơn hàng...',
                    text: 'Vui lòng chờ trong giây lát',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                console.log('COD order response:', response);
                
                if (response.status === 'OK') {
                    Swal.fire({
                        title: 'Đặt hàng thành công!',
                        text: 'Đơn hàng của bạn đã được tạo thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Clear cart and redirect
                        window.location.href = 'index.php?action=order_success&order_id=' + response.order_id;
                    });
                } else {
                    Swal.fire({
                        title: 'Lỗi đặt hàng!',
                        text: response.message || 'Có lỗi xảy ra khi tạo đơn hàng COD',
                        icon: 'error'
                    });
                }
                
                resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
            },
            error: function(xhr, status, error) {
                console.error('COD order error:', error, xhr.responseText);
                
                let errorMessage = 'Có lỗi xảy ra khi tạo đơn hàng COD. Vui lòng thử lại.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMessage = 'Lỗi máy chủ. Vui lòng thử lại sau.';
                } else if (xhr.status === 0) {
                    errorMessage = 'Không thể kết nối đến máy chủ. Vui lòng kiểm tra kết nối.';
                }
                
                Swal.fire({
                    title: 'Lỗi đặt hàng!',
                    text: errorMessage,
                    icon: 'error'
                });
                resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
            }
        });
    }

    // ===== PROCESS PAYPAL ORDER =====
    function processPayPalOrder() {
        // Initialize PayPal SDK and process payment
        console.log('Processing PayPal order...');
        
        $.ajax({
            url: 'Controller/paypal.php',
            method: 'POST',
            data: { act: 'create' },
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Đang khởi tạo PayPal...',
                    text: 'Vui lòng chờ trong giây lát',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                console.log('PayPal order response:', response);
                console.log('Response status:', response.status);
                console.log('PayPal order ID:', response.id);
                
                if (response.id && response.status === 'CREATED') {
                    console.log('PayPal order created successfully, initializing PayPal SDK');
                    // Initialize PayPal SDK and render buttons
                    initializePayPal(response.id);
                } else {
                    console.error('PayPal order creation failed:', response);
                    const errorMessage = response.message || 'Có lỗi xảy ra khi tạo đơn hàng PayPal';
                    Swal.fire({
                        title: 'Lỗi đặt hàng!',
                        text: errorMessage,
                        icon: 'error'
                    });
                    resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
                }
            },
            error: function(xhr, status, error) {
                console.error('PayPal order error:', error, xhr.responseText);
                
                let errorMessage = 'Có lỗi xảy ra khi tạo đơn hàng PayPal. Vui lòng thử lại.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMessage = 'Lỗi máy chủ. Vui lòng thử lại sau.';
                } else if (xhr.status === 0) {
                    errorMessage = 'Không thể kết nối đến máy chủ. Vui lòng kiểm tra kết nối.';
                }
                
                Swal.fire({
                    title: 'Lỗi đặt hàng!',
                    text: errorMessage,
                    icon: 'error'
                });
                resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
            }
        });
    }

    // PayPal simulation function removed - now using real PayPal SDK

    // ===== INITIALIZE PAYPAL SDK =====
    function initializePayPal(orderId) {
        // Close current modal
        Swal.close();
        
        // Show PayPal payment modal
        Swal.fire({
            title: 'Thanh toán PayPal',
            html: `
                <div style="text-align: center; padding: 20px;">
                    <div style="margin-bottom: 20px;">
                        <i class="fab fa-paypal" style="font-size: 48px; color: #0070ba;"></i>
                    </div>
                    <h4 style="color: #333; margin-bottom: 15px;">Hoàn tất thanh toán</h4>
                    <p style="margin-bottom: 20px; color: #666;">
                        Vui lòng nhấn nút bên dưới để thanh toán qua PayPal
                    </p>
                    <div id="paypal-button-container" style="margin-top: 20px; min-height: 100px; display: flex; align-items: center; justify-content: center;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <span class="ms-2">Đang tải PayPal...</span>
                    </div>
                    <div style="margin-top: 15px; font-size: 12px; color: #999;">
                        <i class="fas fa-shield-alt"></i> Thanh toán được bảo mật bởi PayPal
                    </div>
                </div>
            `,
            showCancelButton: true,
            cancelButtonText: 'Hủy',
            showConfirmButton: false,
            allowOutsideClick: false,
            width: '500px',
            customClass: {
                popup: 'paypal-modal'
            }
        });

        // Load PayPal SDK
        if (typeof paypal === 'undefined') {
            const script = document.createElement('script');
            script.src = 'https://www.paypal.com/sdk/js?client-id=AZvIU6INrhjnHNS3BHM8fDCI_23YhD_nRJbTwBIL5MfqhJZCZn4cnuP26QAT3FyG9399x_oQl49VpIbz&currency=USD&intent=capture';
            script.onload = () => {
                renderPayPalButtons(orderId);
            };
            document.head.appendChild(script);
        } else {
            renderPayPalButtons(orderId);
        }
    }

    // ===== RENDER PAYPAL BUTTONS =====
    function renderPayPalButtons(orderId) {
        // Clear loading spinner
        const container = document.getElementById('paypal-button-container');
        if (container) {
            container.innerHTML = '';
        }
        
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color: 'blue',
                shape: 'rect',
                label: 'paypal',
                height: 45
            },
            createOrder: function(data, actions) {
                // Return the order ID from our server
                return orderId;
            },
            onApprove: function(data, actions) {
                console.log('PayPal onApprove called with data:', data);
                
                // Capture the payment
                return actions.order.capture().then(function(details) {
                    console.log('PayPal payment captured:', details);
                    
                    // Send capture request to our server
                    console.log('Sending capture request to server...');
                    return fetch('Controller/paypal.php?act=capture', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            orderID: details.id
                        })
                    }).then(function(response) {
                        console.log('Capture response status:', response.status);
                        return response.json();
                    }).then(function(result) {
                        console.log('Capture result from server:', result);
                        
                        // Close PayPal modal
                        Swal.close();
                        
                        // Show success message
                        Swal.fire({
                            title: 'Thanh toán thành công!',
                            text: 'Cảm ơn bạn đã mua hàng. Đơn hàng sẽ được xử lý sớm nhất.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Clear cart and redirect
                            clearCartAndRedirect();
                        });
                    }).catch(function(error) {
                        console.error('PayPal capture error:', error);
                        Swal.fire({
                            title: 'Lỗi thanh toán!',
                            text: 'Có lỗi xảy ra khi xử lý thanh toán PayPal. Vui lòng thử lại.',
                            icon: 'error'
                        });
                    });
                }).catch(function(error) {
                    console.error('PayPal payment capture failed:', error);
                    Swal.fire({
                        title: 'Lỗi thanh toán!',
                        text: 'Không thể xử lý thanh toán PayPal. Vui lòng thử lại.',
                        icon: 'error'
                    });
                });
            },
            onCancel: function(data) {
                console.log('Payment cancelled:', data);
                
                Swal.fire({
                    title: 'Thanh toán bị hủy',
                    text: 'Bạn đã hủy thanh toán PayPal.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then(() => {
                    resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
                });
            },
            onError: function(err) {
                console.error('PayPal error:', err);
                
                Swal.fire({
                    title: 'Lỗi thanh toán',
                    text: 'Có lỗi xảy ra khi thanh toán PayPal. Vui lòng thử lại.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then(() => {
                    resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
                });
            }
        }).render('#paypal-button-container');
    }

    // ===== CLEAR CART AND REDIRECT =====
    function clearCartAndRedirect() {
        // Clear cart via AJAX
        $.ajax({
            url: 'Controller/cart.php',
            method: 'POST',
            data: { act: 'clear_cart' },
            success: function() {
                // Update cart count in header
                updateCartCount(0);
                
                // Redirect to success page
                window.location.href = 'index.php?action=order_success&payment_method=paypal';
            },
            error: function() {
                // Even if clear cart fails, redirect to success
                window.location.href = 'index.php?action=order_success&payment_method=paypal';
            }
        });
    }

    // ===== UPDATE CART COUNT =====
    function updateCartCount(count) {
        // Update cart count in header
        $('.cart-count').text(count);
        $('.cart-quantity').text(count);
        
        // Update cart badge
        if (count > 0) {
            $('.cart-count').show();
        } else {
            $('.cart-count').hide();
        }
    }

    // ===== PROCESS VNPAY ORDER =====
    function processVNPayOrder() {
        // Process VNPay order similar to COD
        $.ajax({
            url: 'Controller/paypal.php',
            method: 'POST',
            data: { act: 'vnpay' },
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                    title: 'Đang xử lý đơn hàng VNPay...',
                    text: 'Vui lòng chờ trong giây lát',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(response) {
                console.log('VNPay order response:', response);
                
                if (response.status === 'OK' || response.status === 'success') {
                    Swal.fire({
                        title: 'Đặt hàng thành công!',
                        text: 'Đơn hàng VNPay của bạn đã được tạo thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        // Clear cart and redirect
                        window.location.href = 'index.php?action=order_success&order_id=' + (response.order_id || 'VNPAY-' + Date.now());
                    });
                } else {
                    const errorMessage = response.message || 'Có lỗi xảy ra khi tạo đơn hàng VNPay';
                    Swal.fire({
                        title: 'Lỗi đặt hàng!',
                        text: errorMessage,
                        icon: 'error'
                    });
                }
                
                resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
            },
            error: function(xhr, status, error) {
                console.error('VNPay order error:', error, xhr.responseText);
                
                let errorMessage = 'Có lỗi xảy ra khi tạo đơn hàng VNPay. Vui lòng thử lại.';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.status === 500) {
                    errorMessage = 'Lỗi máy chủ. Vui lòng thử lại sau.';
                } else if (xhr.status === 0) {
                    errorMessage = 'Không thể kết nối đến máy chủ. Vui lòng kiểm tra kết nối.';
                }
                
                Swal.fire({
                    title: 'Lỗi đặt hàng!',
                    text: errorMessage,
                    icon: 'error'
                });
                resetButton($('#checkout-confirm-btn'), '<i class="fas fa-credit-card"></i> Đặt hàng');
            }
        });
    }

    // ===== RESET BUTTON =====
    function resetButton($btn, originalText) {
        $btn.prop('disabled', false).html(originalText);
    }

    // ===== FORMAT PRICE =====
    function formatPrice(price) {
        if (!price || isNaN(price)) return '0đ';
        return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
    }
});