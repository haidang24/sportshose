// ===== FLOATING CHAT WIDGET JAVASCRIPT =====

// Scroll to Top Function
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// Toggle Chat
function toggleChat() {
    const chatbox = document.getElementById('chatbox');
    if (chatbox) {
        chatbox.classList.toggle('active');
    }
}

// Send Message with AI Integration
function sendMessage() {
    const input = document.getElementById('chatInput');
    const messagesContainer = document.getElementById('chatMessages');
    const message = input.value.trim();

    if (message) {
        // Add user message
        const userMsg = document.createElement('div');
        userMsg.className = 'chat-message user';
        userMsg.innerHTML = `<div class="message-bubble">${escapeHtml(message)}</div>`;
        messagesContainer.appendChild(userMsg);

        // Clear input
        input.value = '';
        input.style.height = 'auto';

        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;

        // Show typing indicator
        showTypingIndicator();

        // Send to AI (simulate response)
        setTimeout(() => {
            hideTypingIndicator();
            addBotResponse(message);
        }, 1500);
    }
}

// Show typing indicator
function showTypingIndicator() {
    const messagesContainer = document.getElementById('chatMessages');
    const typingIndicator = document.createElement('div');
    typingIndicator.className = 'chat-message bot typing-message';
    typingIndicator.innerHTML = `
        <div class="typing-indicator">
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
            <div class="typing-dot"></div>
        </div>
    `;
    messagesContainer.appendChild(typingIndicator);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Hide typing indicator
function hideTypingIndicator() {
    const typingMessage = document.querySelector('.typing-message');
    if (typingMessage) {
        typingMessage.remove();
    }
}

// Add bot response
function addBotResponse(userMessage) {
    const messagesContainer = document.getElementById('chatMessages');
    const botMsg = document.createElement('div');
    botMsg.className = 'chat-message bot';
    
    // Simple AI responses based on keywords
    let response = getAIResponse(userMessage);
    
    botMsg.innerHTML = `<div class="message-bubble">${response}</div>`;
    messagesContainer.appendChild(botMsg);
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

// Simple AI response logic
function getAIResponse(message) {
    const lowerMessage = message.toLowerCase();
    
    // Product related
    if (lowerMessage.includes('giày') || lowerMessage.includes('sản phẩm')) {
        return 'Chúng tôi có nhiều loại giày thể thao chất lượng cao từ các thương hiệu nổi tiếng như Nike, Adidas, Puma. Bạn có thể xem danh sách sản phẩm tại trang chủ hoặc tìm kiếm theo thương hiệu yêu thích.';
    }
    
    // Price related
    if (lowerMessage.includes('giá') || lowerMessage.includes('tiền') || lowerMessage.includes('cost')) {
        return 'Giá sản phẩm được cập nhật liên tục và có nhiều chương trình khuyến mãi. Bạn có thể xem giá chi tiết khi chọn sản phẩm. Chúng tôi cũng có chính sách bảo hành và đổi trả linh hoạt.';
    }
    
    // Shipping related
    if (lowerMessage.includes('giao hàng') || lowerMessage.includes('ship') || lowerMessage.includes('vận chuyển')) {
        return 'Chúng tôi giao hàng toàn quốc với phí vận chuyển miễn phí cho đơn hàng trên 500.000đ. Thời gian giao hàng: 1-3 ngày nội thành, 3-7 ngày toàn quốc. Bạn có thể theo dõi đơn hàng qua số điện thoại.';
    }
    
    // Size related
    if (lowerMessage.includes('size') || lowerMessage.includes('cỡ')) {
        return 'Chúng tôi có đầy đủ size từ 35-45 cho cả nam và nữ. Nếu bạn không chắc về size, hãy liên hệ hotline 0983785604 để được tư vấn chính xác. Chúng tôi cũng hỗ trợ đổi size miễn phí trong 7 ngày.';
    }
    
    // Contact related
    if (lowerMessage.includes('liên hệ') || lowerMessage.includes('hotline') || lowerMessage.includes('phone')) {
        return 'Bạn có thể liên hệ với chúng tôi qua:\n• Hotline: 0983785604\n• Email: haidangattt@gmail.com\n• Zalo: 0983785604\n• Facebook: HD\n• Địa chỉ: Thành phố Hồ Chí Minh\nChúng tôi hỗ trợ 24/7!';
    }
    
    // Order related
    if (lowerMessage.includes('đơn hàng') || lowerMessage.includes('order') || lowerMessage.includes('mua')) {
        return 'Để đặt hàng, bạn có thể:\n1. Chọn sản phẩm và thêm vào giỏ hàng\n2. Điền thông tin giao hàng\n3. Chọn phương thức thanh toán\n4. Xác nhận đơn hàng\nChúng tôi sẽ xử lý đơn hàng trong 24h và giao hàng nhanh chóng.';
    }
    
    // Return/Exchange related
    if (lowerMessage.includes('đổi') || lowerMessage.includes('trả') || lowermessage.includes('return')) {
        return 'Chúng tôi có chính sách đổi trả linh hoạt:\n• Đổi size miễn phí trong 7 ngày\n• Hoàn tiền 100% nếu sản phẩm lỗi\n• Sản phẩm phải còn nguyên tem, hộp\n• Liên hệ hotline để được hỗ trợ đổi trả.';
    }
    
    // Default response
    return 'Cảm ơn bạn đã liên hệ! Tôi có thể giúp bạn về:\n• Thông tin sản phẩm và giá cả\n• Hướng dẫn đặt hàng\n• Chính sách giao hàng\n• Đổi trả và bảo hành\n• Liên hệ hỗ trợ\nBạn có câu hỏi gì cụ thể không?';
}

// Escape HTML to prevent XSS
function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}

// Auto-resize chat input
function initChatWidget() {
    const chatInput = document.getElementById('chatInput');
    if (chatInput) {
        chatInput.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 120) + 'px';
        });

        // Send message on Enter (but allow Shift+Enter for new line)
        chatInput.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                sendMessage();
            }
        });
    }

    // Close chatbox when clicking outside
    document.addEventListener('click', function(e) {
        const chatbox = document.getElementById('chatbox');
        const chatBtn = document.querySelector('.chat-float-btn');

        if (chatbox && chatbox.classList.contains('active') &&
            !chatbox.contains(e.target) &&
            !chatBtn.contains(e.target)) {
            chatbox.classList.remove('active');
        }
    });
}

// Initialize scroll to top button visibility
function initScrollToTop() {
    const scrollToTopBtn = document.querySelector('.scroll-to-top-btn');
    
    if (scrollToTopBtn) {
        // Show/hide button based on scroll position
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                scrollToTopBtn.classList.remove('hidden');
            } else {
                scrollToTopBtn.classList.add('hidden');
            }
        });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initChatWidget();
    initScrollToTop();
});
