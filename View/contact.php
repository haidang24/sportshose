<!-- Contact Page - Modern Professional Layout -->
<div class="contact-hero py-5 mb-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h1 class="fw-bold mb-2 text-white">Liên hệ với chúng tôi</h1>
                <p class="hero-subtitle mb-0">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7</p>
            </div>
        </div>
    </div>
    <div class="hero-shape"></div>
    <div class="hero-shape hero-shape-2"></div>
</div>

<div class="container pb-5 contact-section">

    <div class="row g-4">
        <!-- Contact Info Card -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3"><i class="fas fa-headset me-2 text-primary"></i>Thông tin liên hệ</h5>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-map-marker-alt text-primary me-3 contact-icon"></i>
                        <div>
                            <div class="fw-semibold">Văn phòng</div>
                            <div class="text-muted">123 Đường ABC, Quận 1, TP.HCM</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-envelope text-primary me-3 contact-icon"></i>
                        <div>
                            <div class="fw-semibold">Email</div>
                            <a href="mailto:support@example.com" class="text-decoration-none">support@example.com</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-phone text-primary me-3 contact-icon"></i>
                        <div>
                            <div class="fw-semibold">Điện thoại</div>
                            <a href="tel:0123456789" class="text-decoration-none">0123 456 789</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fas fa-clock text-primary me-3 contact-icon"></i>
                        <div>
                            <div class="fw-semibold">Giờ làm việc</div>
                            <div class="text-muted">Thứ 2 - Thứ 7: 8:00 - 18:00</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4 shadow-sm border-0 rounded-4 overflow-hidden map-card">
                <div class="card-body p-0">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15676.149140244674!2d106.68769842633786!3d10.8084562993147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529f46a40e90d%3A0x5c0f75c20edc5dd9!2zQ8O0bmcgVHkgQ-G7lSBQaOG6p24gQ8O0bmcgTmdo4buHIFZp4buHdCBOYW0gLSBWaW5hdGVrcw!5e0!3m2!1svi!2s!4v1716862783490!5m2!1svi!2s"
                        style="width:100%; height: 340px; border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <!-- Contact Form Card -->
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title mb-0"><i class="fas fa-paper-plane me-2 text-primary"></i>Gửi tin nhắn</h5>
                        <span class="badge rounded-pill text-bg-light">Thời gian phản hồi ~24h</span>
                    </div>
                    <form id="Form_Contact">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Họ & Tên</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light"><i class="fas fa-user"></i></span>
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="VD: Nguyễn Văn A">
                                </div>
                                <small id="fullname_error" class="text-danger"></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                                </div>
                                <small id="email_error" class="text-danger"></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control" id="number_phone" name="number_phone" placeholder="0123456789">
                                </div>
                                <small id="number_phone_error" class="text-danger"></small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nội dung</label>
                                <div class="position-relative">
                                    <textarea class="form-control form-control-lg" id="content" name="content" rows="6" placeholder="Nhập nội dung bạn muốn gửi..."></textarea>
                                    <small class="text-muted position-absolute end-0 pe-2" style="bottom:-22px;">Tối thiểu 10 ký tự</small>
                                </div>
                                <small id="content_error" class="text-danger"></small>
                            </div>
                            <div class="col-12 d-flex flex-wrap gap-2 justify-content-between align-items-center mt-3">
                                <div class="trust-icons text-muted small d-flex align-items-center gap-3">
                                    <span><i class="fas fa-shield-alt me-1"></i>Bảo mật</span>
                                    <span><i class="fas fa-lock me-1"></i>Mã hóa SSL</span>
                                    <span><i class="fas fa-check-circle me-1"></i>Phản hồi nhanh</span>
                                </div>
                                <button type="submit" class="btn btn-primary px-4 btn-lg rounded-pill" id="contact_submit">
                                    <span class="btn-text">Gửi</span>
                                    <span class="spinner-border spinner-border-sm d-none ms-2" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.contact-hero { position: relative; background: linear-gradient(135deg, #0d6efd, #3b82f6); overflow: hidden; border-bottom-left-radius: 24px; border-bottom-right-radius: 24px; box-shadow: 0 10px 30px rgba(13,110,253,.25); }
.contact-hero { z-index: 0; }
.contact-hero .hero-subtitle { color: rgba(255,255,255,0.9); }
.contact-hero .hero-shape { position: absolute; width: 220px; height: 220px; background: rgba(255,255,255,0.15); border-radius: 50%; right: -60px; top: -60px; filter: blur(2px); z-index: 0; }
.contact-hero .hero-shape-2 { left: -70px; top: 40px; right: auto; background: rgba(255,255,255,0.12); }
.contact-icon { width: 24px; text-align: center; }
.input-group-text { border-right: 0; }
.input-group .form-control { border-left: 0; }
.rounded-4 { border-radius: 1rem !important; }
textarea.form-control-lg { min-height: 160px; }
/* Ensure map is above decorative layers */
.map-card { position: relative; z-index: 1; }
/* Subtle elevation and spacing */
.map-card { box-shadow: 0 12px 28px rgba(0,0,0,.12); }
.card.shadow-lg { box-shadow: 0 14px 32px rgba(0,0,0,.16)!important; }
.contact-section { margin-top: -10px; }
.trust-icons span { opacity: .9; }
@media (max-width: 576px) { .contact-hero { border-radius: 0; } }
@media (max-width: 768px) { .map-card iframe { height: 280px !important; } }
</style>