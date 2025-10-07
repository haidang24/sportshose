<?php
if (!defined('BASE_URL')) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $base   = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    define('BASE_URL', $scheme . '://' . $host . ($base === '/' ? '' : $base));
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liên hệ với chúng tôi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            overflow-x: hidden;
        }

        /* Hero Section - Enhanced */
        .contact-hero {
            position: relative;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 80px 0 120px;
            overflow: hidden;
            margin-bottom: -60px;
        }

        .contact-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            opacity: 0.4;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 900;
            color: #fff;
            margin-bottom: 1.25rem;
            text-shadow: 0 4px 30px rgba(0,0,0,0.2);
            animation: fadeInUp 0.8s ease-out;
            letter-spacing: -1px;
        }

        .hero-subtitle {
            font-size: 1.35rem;
            color: rgba(255,255,255,0.95);
            font-weight: 400;
            animation: fadeInUp 0.8s ease-out 0.2s both;
            max-width: 600px;
            margin: 0 auto;
        }

        .hero-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            filter: blur(80px);
            animation: float 8s ease-in-out infinite;
        }

        .hero-shape-1 {
            width: 400px;
            height: 400px;
            top: -150px;
            right: -100px;
        }

        .hero-shape-2 {
            width: 350px;
            height: 350px;
            bottom: -100px;
            left: -80px;
            animation-delay: -4s;
        }

        /* Animations */
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

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(5deg); }
            66% { transform: translate(-20px, 20px) rotate(-5deg); }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Main Container */
        .contact-container {
            position: relative;
            z-index: 3;
            padding: 0 15px 80px;
        }

        /* Card Styles - Enhanced */
        .modern-card {
            background: #fff;
            border-radius: 28px;
            box-shadow: 0 15px 50px rgba(0,0,0,0.08), 0 5px 15px rgba(0,0,0,0.04);
            border: 1px solid rgba(0,0,0,0.03);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .modern-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modern-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 80px rgba(102,126,234,0.2), 0 10px 30px rgba(102,126,234,0.1);
        }

        .modern-card:hover::before {
            opacity: 1;
        }

        .card-body {
            padding: 2.5rem;
        }

        /* Contact Info Card */
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.75rem;
            padding: 1rem;
            border-radius: 16px;
            transition: all 0.3s ease;
            animation: slideIn 0.5s ease-out;
        }

        .contact-info-item:nth-child(1) { animation-delay: 0.1s; }
        .contact-info-item:nth-child(2) { animation-delay: 0.2s; }
        .contact-info-item:nth-child(3) { animation-delay: 0.3s; }
        .contact-info-item:nth-child(4) { animation-delay: 0.4s; }

        .contact-info-item:hover {
            background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%);
            transform: translateX(8px);
        }

        .contact-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border-radius: 14px;
            font-size: 1.25rem;
            margin-right: 1.25rem;
            box-shadow: 0 8px 16px rgba(102,126,234,0.25);
        }

        .contact-info-content {
            flex: 1;
        }

        .info-label {
            font-weight: 700;
            color: #2d3748;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #718096;
            font-size: 0.95rem;
        }

        .info-value a {
            color: #667eea;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .info-value a:hover {
            color: #764ba2;
        }

        /* Social Contact Styles */
        .social-contact-section {
            padding: 1rem 0;
        }

        .social-contact-card {
            background: #fff;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            border: 2px solid #f1f5f9;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .social-contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border-color: #667eea;
        }

        .zalo-card:hover {
            border-color: #0068ff;
            box-shadow: 0 20px 40px rgba(0,104,255,0.15);
        }

        .facebook-card:hover {
            border-color: #1877f2;
            box-shadow: 0 20px 40px rgba(24,119,242,0.15);
        }

        .social-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .zalo-card .social-icon {
            background: linear-gradient(135deg, #0068ff 0%, #0047cc 100%);
            color: white;
        }

        .facebook-card .social-icon {
            background: linear-gradient(135deg, #1877f2 0%, #0d5bb8 100%);
            color: white;
        }

        .social-contact-card:hover .social-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .social-content h4 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.75rem;
        }

        .social-content p {
            color: #64748b;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .contact-info {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .contact-info i {
            color: #667eea;
        }

        .social-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .zalo-btn {
            background: linear-gradient(135deg, #0068ff 0%, #0047cc 100%);
            color: white;
        }

        .facebook-btn {
            background: linear-gradient(135deg, #1877f2 0%, #0d5bb8 100%);
            color: white;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.2);
            color: white;
            text-decoration: none;
        }

        .zalo-btn:hover {
            box-shadow: 0 15px 30px rgba(0,104,255,0.3);
        }

        .facebook-btn:hover {
            box-shadow: 0 15px 30px rgba(24,119,242,0.3);
        }

        .social-btn i {
            font-size: 1.2rem;
        }

        .additional-contact {
            margin: 3rem 0 2rem;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(102,126,234,0.05) 0%, rgba(118,75,162,0.05) 100%);
            border-radius: 20px;
            border: 1px solid rgba(102,126,234,0.1);
        }

        .additional-contact h5 {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .additional-contact h5 i {
            color: #667eea;
        }

        .contact-methods {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .contact-method {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: white;
            border-radius: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .contact-method:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
            border-color: #667eea;
        }

        .contact-method i {
            font-size: 1.2rem;
            width: 24px;
        }

        .contact-method span {
            color: #4a5568;
            font-size: 0.95rem;
        }

        /* Form Styles - Enhanced */
        .form-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #f1f5f9;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #2d3748;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-title i {
            color: #667eea;
        }

        .response-badge {
            background: linear-gradient(135deg, rgba(102,126,234,0.1) 0%, rgba(118,75,162,0.1) 100%);
            color: #667eea;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
        }

        .input-group-modern {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            z-index: 5;
            font-size: 1.1rem;
        }

        .form-control-modern {
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: #fff;
            position: relative;
        }

        .form-control-modern:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 5px rgba(102,126,234,0.12), 0 8px 20px rgba(102,126,234,0.08);
            outline: none;
            transform: translateY(-2px);
        }

        .form-control-modern:hover {
            border-color: #cbd5e0;
        }

        .form-control-modern::placeholder {
            color: #cbd5e0;
            transition: color 0.3s ease;
        }

        .form-control-modern:focus::placeholder {
            color: #a0aec0;
        }

        .input-group-modern:focus-within .input-icon {
            color: #764ba2;
            transform: translateY(-50%) scale(1.1);
        }

        textarea.form-control-modern {
            min-height: 150px;
            resize: vertical;
            padding-top: 1rem;
        }

        .char-count {
            position: absolute;
            bottom: -20px;
            right: 0;
            font-size: 0.8rem;
            color: #a0aec0;
        }

        /* Trust Badges */
        .trust-badges {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin: 1.5rem 0;
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #718096;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .trust-badge i {
            color: #667eea;
        }

        /* Submit Button - Enhanced */
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            padding: 1.1rem 3rem;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 30px rgba(102,126,234,0.35);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-submit:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-submit:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 40px rgba(102,126,234,0.45);
        }

        .btn-submit:active {
            transform: translateY(-2px) scale(0.98);
        }

        .btn-submit span,
        .btn-submit i {
            position: relative;
            z-index: 1;
        }

        /* Map Card */
        .map-card {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-top: 1.5rem;
            transition: transform 0.3s ease;
        }

        .map-card:hover {
            transform: translateY(-5px);
        }

        .map-card iframe {
            width: 100%;
            height: 350px;
            border: 0;
            display: block;
        }

        /* Support Cards Grid */
        .support-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .support-card {
            background: #fff;
            padding: 2rem;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 24px rgba(0,0,0,0.06);
            border: 2px solid transparent;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .support-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 16px 48px rgba(102,126,234,0.15);
            border-color: #667eea;
        }

        .support-icon {
            width: 70px;
            height: 70px;
            margin: 0 auto 1.25rem;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            transition: transform 0.3s ease;
        }

        .support-card:hover .support-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .support-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.75rem;
        }

        .support-desc {
            color: #718096;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* FAQ Section */
        .faq-section {
            margin-top: 3rem;
        }

        .accordion-modern .accordion-item {
            border: none;
            margin-bottom: 1rem;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }

        .accordion-modern .accordion-item:hover {
            box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        }

        .accordion-modern .accordion-button {
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
            color: #2d3748;
            background: #fff;
            border: none;
            transition: all 0.3s ease;
        }

        .accordion-modern .accordion-button:not(.collapsed) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            box-shadow: 0 4px 12px rgba(102,126,234,0.3);
        }

        .accordion-modern .accordion-button:focus {
            box-shadow: none;
            border: none;
        }

        .accordion-modern .accordion-button::after {
            transition: transform 0.3s ease;
        }

        .accordion-modern .accordion-body {
            padding: 1.5rem;
            background: #f8f9fa;
            color: #4a5568;
            line-height: 1.7;
        }

        /* Stats Card */
        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 24px;
            padding: 2.5rem;
            color: #fff;
            box-shadow: 0 20px 60px rgba(102,126,234,0.35);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: rotate 20s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 0.95rem;
            opacity: 0.9;
        }

        .stats-cta {
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            z-index: 2;
        }

        .cta-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cta-icon {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .btn-cta {
            background: #fff;
            color: #667eea;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }




        /* Responsive Design */
        @media (max-width: 992px) {
            .support-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .contact-hero {
                padding: 60px 0 100px;
            }

            .card-body {
                padding: 1.5rem;
            }

            .support-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .trust-badges {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.75rem;
            }

            .stats-cta {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

        }

        @media (max-width: 576px) {
            .form-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .social-contact-card {
                padding: 1.5rem;
                margin-bottom: 1rem;
            }

            .social-icon {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .social-content h4 {
                font-size: 1.25rem;
            }

            .social-btn {
                padding: 0.75rem 1.5rem;
                font-size: 0.9rem;
            }

            .additional-contact {
                padding: 1.5rem;
                margin: 2rem 0 1.5rem;
            }

            .contact-methods {
                gap: 0.75rem;
            }

            .contact-method {
                padding: 0.75rem;
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }
            }

            .btn-submit {
                width: 100%;
                justify-content: center;
            }

            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }
        }

        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s ease-in-out infinite;
        }

        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        /* Smooth Page Load */
        body {
            animation: fadeIn 0.4s ease-out;
        }

        @keyframes pageLoad {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Focus visible for accessibility */
        *:focus-visible {
            outline: 3px solid #667eea;
            outline-offset: 2px;
        }

        /* Print styles */
        @media print {
            .hero-shape {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <!-- Hero Section -->
    <div class="contact-hero">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="container">
            <div class="hero-content">
                <h1>Liên hệ với chúng tôi</h1>
                <p class="hero-subtitle">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7</p>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container contact-container">
        <div class="row g-4">
            <!-- Left Column: Contact Info & Map -->
            <div class="col-lg-4">
                <!-- Contact Info Card -->
                <div class="modern-card">
                    <div class="card-body">
                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="contact-info-content">
                                <div class="info-label">Văn phòng</div>
                                <div class="info-value">Thành phố Hồ Chí Minh</div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="contact-info-content">
                                <div class="info-label">Email</div>
                                <div class="info-value">
                                    <a href="mailto:haidangattt@gmail.com">haidangattt@gmail.com</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="contact-info-content">
                                <div class="info-label">Điện thoại</div>
                                <div class="info-value">
                                    <a href="tel:0983785604">0983785604</a>
                                </div>
                            </div>
                        </div>

                        <div class="contact-info-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="contact-info-content">
                                <div class="info-label">Giờ làm việc</div>
                                <div class="info-value">Thứ 2 - Thứ 7: 8:00 - 18:00</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Map Card -->
                <div class="map-card">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15676.149140244674!2d106.68769842633786!3d10.8084562993147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529f46a40e90d%3A0x5c0f75c20edc5dd9!2zQ8O0bmcgVHkgQ-G7lSBQaOG6p24gQ8O0bmcgTmdo4buHIFZp4buHdCBOYW0gLSBWaW5hdGVrcw!5e0!3m2!1svi!2s!4v1716862783490!5m2!1svi!2s"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>

            <!-- Right Column: Social Contact Links -->
            <div class="col-lg-8">
                <div class="modern-card">
                    <div class="card-body">
                        <div class="form-header">
                            <div class="form-title">
                                <i class="fas fa-comments"></i>
                                Liên hệ trực tiếp
                            </div>
                            <div class="response-badge">
                                <i class="fas fa-bolt"></i> Phản hồi ngay lập tức
                            </div>
                        </div>

                        <div class="social-contact-section">
                            <div class="row g-4">
                                <!-- Zalo Contact -->
                                <div class="col-md-6">
                                    <div class="social-contact-card zalo-card">
                                        <div class="social-icon">
                                            <i class="fab fa-zalo"></i>
                                        </div>
                                        <div class="social-content">
                                            <h4>Chat Zalo</h4>
                                            <p>Liên hệ trực tiếp qua Zalo để được tư vấn nhanh chóng</p>
                                            <div class="contact-info">
                                                <i class="fas fa-phone"></i>
                                                <span>0983785604</span>
                                            </div>
                                        </div>
                                        <a href="https://zalo.me/0983785604" target="_blank" class="social-btn zalo-btn">
                                            <i class="fab fa-zalo"></i>
                                            <span>Chat ngay</span>
                                        </a>
                                    </div>
                                </div>

                                <!-- Facebook Contact -->
                                <div class="col-md-6">
                                    <div class="social-contact-card facebook-card">
                                        <div class="social-icon">
                                            <i class="fab fa-facebook-messenger"></i>
                                    </div>
                                        <div class="social-content">
                                            <h4>Messenger</h4>
                                            <p>Gửi tin nhắn qua Facebook Messenger để được hỗ trợ</p>
                                            <div class="contact-info">
                                                <i class="fab fa-facebook"></i>
                                                <span><a href="https://www.facebook.com/hd24000" target="_blank">HD</a></span>
                                </div>
                                        </div>
                                        <a href="https://www.facebook.com/hd24000" target="_blank" class="social-btn facebook-btn">
                                            <i class="fab fa-facebook"></i>
                                            <span>Facebook</span>
                                        </a>
                                    </div>
                                    </div>
                                </div>

                            <!-- Additional Contact Methods -->
                            <div class="additional-contact">
                                <h5><i class="fas fa-phone-alt"></i> Các cách liên hệ khác</h5>
                                <div class="contact-methods">
                                    <div class="contact-method">
                                        <i class="fas fa-phone text-success"></i>
                                        <span>Hotline: <strong>0983785604</strong></span>
                                    </div>
                                    <div class="contact-method">
                                        <i class="fas fa-envelope text-primary"></i>
                                        <span>Email: <strong>haidangattt@gmail.com</strong></span>
                                    </div>
                                    <div class="contact-method">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                        <span>Địa chỉ: <strong>Thành phố Hồ Chí Minh</strong></span>
                                    </div>
                                </div>
                            </div>

                            <div class="trust-badges">
                                <div class="trust-badge">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>Bảo mật</span>
                                </div>
                                <div class="trust-badge">
                                    <i class="fas fa-clock"></i>
                                    <span>24/7</span>
                                </div>
                                <div class="trust-badge">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Phản hồi nhanh</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Support Cards -->
        <div class="support-grid">
            <div class="support-card">
                <div class="support-icon" style="background: linear-gradient(135deg, rgba(102,126,234,0.15) 0%, rgba(118,75,162,0.15) 100%); color: #667eea;">
                    <i class="fas fa-headset"></i>
                </div>
                <div class="support-title">Hỗ trợ 24/7</div>
                <div class="support-desc">Đội ngũ sẵn sàng giải đáp mọi thắc mắc của bạn.</div>
            </div>

            <div class="support-card">
                <div class="support-icon" style="background: linear-gradient(135deg, rgba(34,197,94,0.15) 0%, rgba(21,128,61,0.15) 100%); color: #22c55e;">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <div class="support-title">Giao hàng nhanh</div>
                <div class="support-desc">Giao trong 24-48h nội thành, 2-4 ngày toàn quốc.</div>
            </div>

            <div class="support-card">
                <div class="support-icon" style="background: linear-gradient(135deg, rgba(234,179,8,0.15) 0%, rgba(161,98,7,0.15) 100%); color: #eab308;">
                    <i class="fas fa-undo-alt"></i>
                </div>
                <div class="support-title">Đổi trả dễ dàng</div>
                <div class="support-desc">Đổi trả trong 7 ngày nếu sản phẩm lỗi hoặc không vừa.</div>
            </div>

            <div class="support-card">
                <div class="support-icon" style="background: linear-gradient(135deg, rgba(6,182,212,0.15) 0%, rgba(8,145,178,0.15) 100%); color: #06b6d4;">
                    <i class="fas fa-lock"></i>
                </div>
                <div class="support-title">Thanh toán an toàn</div>
                <div class="support-desc">Bảo mật thông tin và mã hóa SSL tiêu chuẩn.</div>
            </div>
        </div>

        <!-- FAQ & Stats Section -->
        <div class="row g-4 faq-section">
            <div class="col-lg-7">
                <div class="modern-card">
                    <div class="card-body">
                        <div class="form-title" style="margin-bottom: 2rem;">
                            <i class="fas fa-question-circle"></i>
                            Câu hỏi thường gặp
                        </div>

                        <div class="accordion accordion-modern" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                        Làm sao để theo dõi đơn hàng của tôi?
                                    </button>
                                </h2>
                                <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Vào mục <strong>Lịch sử mua hàng</strong> trong tài khoản của bạn để xem chi tiết trạng thái và vận chuyển.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                        Chính sách đổi trả như thế nào?
                                    </button>
                                </h2>
                                <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Bạn có thể đổi trả trong vòng 7 ngày kể từ ngày nhận hàng đối với sản phẩm còn nguyên tem mác và chưa qua sử dụng.
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                        Tôi có thể thanh toán bằng phương thức nào?
                                    </button>
                                </h2>
                                <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        Chúng tôi hỗ trợ COD, PayPal và VNPay. Mọi giao dịch đều được mã hóa an toàn.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="stats-card">
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-value">24/7</div>
                            <div class="stat-label">Hỗ trợ</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">10K+</div>
                            <div class="stat-label">Khách hàng</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-value">99%</div>
                            <div class="stat-label">Hài lòng</div>
                        </div>
                    </div>

                    <div class="stats-cta">
                        <div class="cta-content">
                            <div class="cta-icon">
                                <i class="fas fa-robot"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; margin-bottom: 0.25rem;">Cần trợ giúp ngay?</div>
                                <div style="font-size: 0.9rem; opacity: 0.9;">Chat với AI trợ lý</div>
                            </div>
                        </div>
                        <a href="#" class="btn-cta" onclick="document.querySelector('.chat-float-btn').click(); return false;">
                            Bắt đầu
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Social contact button animations
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px) scale(1.05)';
            });
            
            btn.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Scroll Animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe elements
        document.addEventListener('DOMContentLoaded', function() {
            // Add initial state to animated elements
            const animatedElements = document.querySelectorAll('.modern-card, .support-card');
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(30px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });

            // Parallax effect for hero shapes
            window.addEventListener('scroll', function() {
                const scrolled = window.pageYOffset;
                const shapes = document.querySelectorAll('.hero-shape');
                shapes.forEach((shape, index) => {
                    const speed = index === 0 ? 0.3 : 0.5;
                    shape.style.transform = `translateY(${scrolled * speed}px)`;
                });
            });

            // Add ripple effect to buttons
            document.querySelectorAll('.btn-submit, .btn-cta').forEach(button => {
                button.addEventListener('click', function(e) {
                    const ripple = document.createElement('span');
                    const rect = button.getBoundingClientRect();
                    const size = Math.max(rect.width, rect.height);
                    const x = e.clientX - rect.left - size / 2;
                    const y = e.clientY - rect.top - size / 2;

                    ripple.style.cssText = `
                        position: absolute;
                        width: ${size}px;
                        height: ${size}px;
                        left: ${x}px;
                        top: ${y}px;
                        background: rgba(255,255,255,0.3);
                        border-radius: 50%;
                        transform: scale(0);
                        animation: ripple 0.6s ease-out;
                        pointer-events: none;
                    `;

                    button.appendChild(ripple);
                    setTimeout(() => ripple.remove(), 600);
                });
            });
        });

        // Add ripple animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>

    <!-- Chat Widget CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/View/assets/css/chat-widget.css">

    <!-- Floating Chat Widget -->
    <button class="chat-float-btn" onclick="toggleChat()" aria-label="Mở chat">
        <i class="fas fa-comments"></i>
    </button>

    <!-- Chatbox -->
    <div class="chatbox" id="chatbox">
        <div class="chat-header">
            <div class="chat-title">
                <i class="fas fa-robot"></i>
                Trợ lý AI
            </div>
            <button class="chat-close" onclick="toggleChat()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="chat-messages" id="chatMessages">
            <div class="chat-message bot">
                <div class="message-bubble">
                    Xin chào! Tôi là trợ lý AI. Tôi có thể giúp gì cho bạn về sản phẩm hoặc dịch vụ của chúng tôi?
                </div>
            </div>
        </div>
        <div class="chat-input-area">
            <textarea class="chat-input" id="chatInput" placeholder="Nhập câu hỏi của bạn..." rows="1"></textarea>
            <button class="chat-send-btn" onclick="sendMessage()">
                <i class="fas fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <!-- Chat Widget JavaScript -->
    <script src="<?= BASE_URL ?>/View/assets/js/chat-widget.js"></script>

</body>
</html>