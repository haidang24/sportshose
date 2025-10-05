<!-- Contact Page - Modern Professional Layout -->
<div class="container py-5">
    <div class="row align-items-center mb-4">
        <div class="col-12 text-center">
            <h1 class="fw-bold mb-2">Liên hệ với chúng tôi</h1>
            <p class="text-muted mb-0">Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Contact Info Card -->
        <div class="col-lg-4">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="fas fa-headset me-2 text-primary"></i>Thông tin liên hệ</h5>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-map-marker-alt text-primary me-3"></i>
                        <div>
                            <div class="fw-semibold">Văn phòng</div>
                            <div class="text-muted">123 Đường ABC, Quận 1, TP.HCM</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-envelope text-primary me-3"></i>
                        <div>
                            <div class="fw-semibold">Email</div>
                            <a href="mailto:support@example.com" class="text-decoration-none">support@example.com</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start mb-3">
                        <i class="fas fa-phone text-primary me-3"></i>
                        <div>
                            <div class="fw-semibold">Điện thoại</div>
                            <a href="tel:0123456789" class="text-decoration-none">0123 456 789</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <i class="fas fa-clock text-primary me-3"></i>
                        <div>
                            <div class="fw-semibold">Giờ làm việc</div>
                            <div class="text-muted">Thứ 2 - Thứ 7: 8:00 - 18:00</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-4 shadow-sm">
                <div class="card-body p-0">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15676.149140244674!2d106.68769842633786!3d10.8084562993147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529f46a40e90d%3A0x5c0f75c20edc5dd9!2zQ8O0bmcgVHkgQ-G7lSBQaOG6p24gQ8O0bmcgTmdo4buHIFZp4buHdCBOYW0gLSBWaW5hdGVrcw!5e0!3m2!1svi!2s!4v1716862783490!5m2!1svi!2s"
                        style="width:100%; height: 260px; border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <!-- Contact Form Card -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5 class="card-title mb-3"><i class="fas fa-paper-plane me-2 text-primary"></i>Gửi tin nhắn</h5>
                    <form id="Form_Contact">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Họ & Tên</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" placeholder="VD: Nguyễn Văn A">
                                <small id="fullname_error" class="text-danger"></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com">
                                <small id="email_error" class="text-danger"></small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="number_phone" name="number_phone" placeholder="0123456789">
                                <small id="number_phone_error" class="text-danger"></small>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nội dung</label>
                                <textarea class="form-control" id="content" name="content" rows="6" placeholder="Nhập nội dung bạn muốn gửi..."></textarea>
                                <small id="content_error" class="text-danger"></small>
                            </div>
                            <div class="col-12 d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary px-4" id="contact_submit">
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