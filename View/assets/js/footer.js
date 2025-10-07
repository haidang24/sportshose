// Simple Footer JavaScript
$(document).ready(function() {
    
    // Add easing function if not available
    if (!$.easing.easeInOutQuart) {
        $.easing.easeInOutQuart = function (x, t, b, c, d) {
            if ((t/=d/2) < 1) return c/2*t*t*t*t + b;
            return -c/2 * ((t-=2)*t*t*t - 2) + b;
        };
    }
    
    // Newsletter form submission (placeholder)
    $('.newsletter-form').on('submit', function(e) {
        e.preventDefault();
        const email = $(this).find('input[type="email"]').val();
        
        if (email) {
            // Simulate newsletter subscription
            Swal.fire({
                icon: 'success',
                title: 'Đăng ký thành công!',
                text: 'Cảm ơn bạn đã đăng ký nhận tin tức từ chúng tôi.',
                timer: 3000,
                showConfirmButton: false
            });
            $(this)[0].reset();
        }
    });
    
    // Smooth scroll for anchor links
    $('a[href^="#"]').on('click', function(e) {
        const target = $(this.getAttribute('href'));
        if (target.length) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 800, 'easeInOutQuart');
        }
    });
    
    // Add hover effect to social links
    $('.social-link').on('mouseenter', function() {
        $(this).addClass('animate__animated animate__pulse');
    }).on('mouseleave', function() {
        $(this).removeClass('animate__animated animate__pulse');
    });
    
    // Add animation to footer sections on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe footer sections
    $('.footer-section').each(function() {
        $(this).css({
            'opacity': '0',
            'transform': 'translateY(20px)',
            'transition': 'all 0.6s ease'
        });
        observer.observe(this);
    });
});

// Add CSS animations dynamically
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .footer-section {
        animation: fadeInUp 0.6s ease forwards;
    }
    
    .footer-section:nth-child(1) { animation-delay: 0.1s; }
    .footer-section:nth-child(2) { animation-delay: 0.2s; }
    .footer-section:nth-child(3) { animation-delay: 0.3s; }
    .footer-section:nth-child(4) { animation-delay: 0.4s; }
`;
document.head.appendChild(style);