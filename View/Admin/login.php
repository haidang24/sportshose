<section class="admin-auth-section">
	<div class="admin-auth-background">
		<div class="admin-floating-shapes">
			<div class="admin-shape admin-shape-1"></div>
			<div class="admin-shape admin-shape-2"></div>
			<div class="admin-shape admin-shape-3"></div>
			<div class="admin-shape admin-shape-4"></div>
		</div>
	</div>
	
	<div class="container">
		<div class="row justify-content-center align-items-center min-vh-100">
			<div class="col-12 col-md-8 col-lg-6 col-xl-5">
				<div class="admin-auth-card">
					<div class="admin-auth-header">
						<div class="admin-logo-container">
							<div class="admin-logo-icon">
								<i class="fas fa-shield-alt"></i>
							</div>
							<h1 class="admin-logo-text">ADMIN <span>PANEL</span></h1>
						</div>
						<h2 class="admin-auth-title">Chào mừng trở lại</h2>
						<p class="admin-auth-subtitle">Đăng nhập vào hệ thống quản trị</p>
					</div>

					<div class="admin-auth-body">
						<!-- MetaMask Login Button -->
						<div class="admin-wallet-login mb-4">
							<button id="metamaskLogin" class="btn btn-admin-metamask">
								<svg class="admin-metamask-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M20.5 8.5L13 3L5.5 8.5L8 13.5L13 15.5L18 13.5L20.5 8.5Z" fill="#E17726" stroke="#E17726" stroke-width="0.5"/>
									<path d="M8 13.5L5.5 18L11 21L13 19.5V15.5L8 13.5Z" fill="#E27625"/>
									<path d="M18 13.5L13 15.5V19.5L15 21L20.5 18L18 13.5Z" fill="#E27625"/>
									<path d="M13 3L8 13.5L13 15.5L18 13.5L13 3Z" fill="#E27625"/>
								</svg>
								<span>Kết nối với MetaMask</span>
							</button>
						</div>

						<!-- Social Login Buttons -->
						<div class="admin-social-login mb-4">
							<button class="btn btn-admin-social btn-admin-google">
								<i class="fab fa-google"></i>
								<span>Google</span>
							</button>
							<button class="btn btn-admin-social btn-admin-facebook">
								<i class="fab fa-facebook-f"></i>
								<span>Facebook</span>
							</button>
						</div>

						<!-- Divider -->
						<div class="admin-divider">
							<span>Hoặc đăng nhập bằng tài khoản</span>
						</div>

						<!-- Traditional Login Form -->
						<form id="formLogin" class="admin-auth-form">
							<div class="admin-form-group mb-3">
								<label class="admin-form-label">
									<i class="fas fa-user"></i>
									Tên đăng nhập
								</label>
								<input id="username" placeholder="Nhập tên đăng nhập" type="text" class="admin-form-control">
							</div>
							
							<div class="admin-form-group mb-3">
								<label class="admin-form-label">
									<i class="fas fa-lock"></i>
									Mật khẩu
								</label>
								<div class="admin-password-input">
									<input id="password" placeholder="Nhập mật khẩu" type="password" class="admin-form-control">
									<button class="admin-password-toggle" type="button" id="togglePassword">
										<i class="fas fa-eye"></i>
									</button>
								</div>
							</div>

							<div class="admin-form-options mb-4">
								<div class="admin-form-check">
									<input class="admin-form-check-input" type="checkbox" id="rememberMe">
									<label class="admin-form-check-label" for="rememberMe">
										Ghi nhớ đăng nhập
									</label>
								</div>
								<a href="#" class="admin-forgot-link">
									<i class="fas fa-key"></i>
									Quên mật khẩu?
								</a>
							</div>

							<button type="submit" class="btn btn-admin-primary">
								<span class="btn-text">Đăng nhập</span>
								<i class="fas fa-arrow-right btn-icon"></i>
							</button>
						</form>

						<!-- Footer -->
						<div class="admin-auth-footer">
							<p class="admin-auth-link">
								Quay lại <a href="index.php" class="admin-link-primary">trang chủ</a>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
/* ===== ADMIN AUTH SECTION STYLES ===== */
.admin-auth-section {
   min-height: 100vh;
   position: relative;
   overflow: hidden;
   display: flex;
   align-items: center;
   background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
   font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.admin-auth-background {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   z-index: 1;
}

.admin-floating-shapes {
   position: absolute;
   width: 100%;
   height: 100%;
}

.admin-shape {
   position: absolute;
   border-radius: 50%;
   background: rgba(255, 255, 255, 0.05);
   animation: adminFloat 8s ease-in-out infinite;
}

.admin-shape-1 {
   width: 100px;
   height: 100px;
   top: 15%;
   left: 10%;
   animation-delay: 0s;
}

.admin-shape-2 {
   width: 150px;
   height: 150px;
   top: 60%;
   right: 15%;
   animation-delay: 3s;
}

.admin-shape-3 {
   width: 80px;
   height: 80px;
   bottom: 20%;
   left: 20%;
   animation-delay: 6s;
}

.admin-shape-4 {
   width: 120px;
   height: 120px;
   top: 10%;
   right: 30%;
   animation-delay: 2s;
}

@keyframes adminFloat {
   0%, 100% { transform: translateY(0px) rotate(0deg); opacity: 0.3; }
   50% { transform: translateY(-30px) rotate(180deg); opacity: 0.6; }
}

/* ===== ADMIN AUTH CARD ===== */
.admin-auth-card {
   background: rgba(255, 255, 255, 0.95);
   backdrop-filter: blur(20px);
   border-radius: 24px;
   box-shadow: 0 25px 80px rgba(0, 0, 0, 0.4);
   border: 1px solid rgba(255, 255, 255, 0.3);
   position: relative;
   z-index: 2;
   animation: adminSlideUp 0.8s ease-out;
   overflow: hidden;
}

@keyframes adminSlideUp {
   from {
      opacity: 0;
      transform: translateY(60px);
   }
   to {
      opacity: 1;
      transform: translateY(0);
   }
}

/* ===== ADMIN AUTH HEADER ===== */
.admin-auth-header {
   text-align: center;
   padding: 40px 40px 20px;
   background: linear-gradient(135deg, rgba(26, 26, 46, 0.1) 0%, rgba(22, 33, 62, 0.1) 100%);
}

.admin-logo-container {
   margin-bottom: 20px;
}

.admin-logo-icon {
   width: 90px;
   height: 90px;
   margin: 0 auto 15px;
   background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   box-shadow: 0 10px 25px rgba(26, 26, 46, 0.4);
   animation: adminPulse 3s ease-in-out infinite;
}

.admin-logo-icon i {
   font-size: 40px;
   color: white;
}

@keyframes adminPulse {
   0%, 100% { transform: scale(1); }
   50% { transform: scale(1.05); }
}

.admin-logo-text {
   font-size: 32px;
   font-weight: 800;
   color: #1a1a2e;
   margin: 0;
   letter-spacing: 3px;
}

.admin-logo-text span {
   color: #667eea;
}

.admin-auth-title {
   font-size: 28px;
   font-weight: 700;
   color: #1a1a2e;
   margin-bottom: 8px;
}

.admin-auth-subtitle {
   color: #718096;
   font-size: 16px;
   margin: 0;
}

/* ===== ADMIN AUTH BODY ===== */
.admin-auth-body {
   padding: 20px 40px 40px;
}

.admin-auth-form {
   width: 100%;
}

/* ===== ADMIN BUTTONS ===== */
.btn-admin-metamask {
   background: linear-gradient(135deg, #f6851b 0%, #e2761b 100%);
   color: white;
   border: none;
   border-radius: 16px;
   padding: 16px 24px;
   font-size: 16px;
   font-weight: 600;
   width: 100%;
   display: flex;
   align-items: center;
   justify-content: center;
   gap: 12px;
   transition: all 0.3s ease;
   box-shadow: 0 4px 15px rgba(246, 133, 27, 0.3);
   margin-bottom: 20px;
}

.btn-admin-metamask:hover {
   transform: translateY(-2px);
   box-shadow: 0 6px 20px rgba(246, 133, 27, 0.4);
   background: linear-gradient(135deg, #e2761b 0%, #c9641a 100%);
}

.admin-metamask-icon {
   width: 24px;
   height: 24px;
}

.admin-social-login {
   display: flex;
   gap: 12px;
   margin-bottom: 20px;
}

.btn-admin-social {
   flex: 1;
   background: white;
   border: 2px solid #e2e8f0;
   border-radius: 16px;
   padding: 14px 20px;
   font-size: 14px;
   font-weight: 600;
   color: #4a5568;
   display: flex;
   align-items: center;
   justify-content: center;
   gap: 8px;
   transition: all 0.3s ease;
}

.btn-admin-social:hover {
   transform: translateY(-2px);
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-admin-google:hover {
   border-color: #db4437;
   color: #db4437;
}

.btn-admin-facebook:hover {
   border-color: #4267B2;
   color: #4267B2;
}

/* ===== ADMIN DIVIDER ===== */
.admin-divider {
   position: relative;
   text-align: center;
   margin: 24px 0;
}

.admin-divider::before {
   content: '';
   position: absolute;
   top: 50%;
   left: 0;
   right: 0;
   height: 1px;
   background: #e2e8f0;
}

.admin-divider span {
   position: relative;
   background: rgba(255, 255, 255, 0.95);
   padding: 0 20px;
   color: #a0aec0;
   font-size: 14px;
   font-weight: 500;
}

/* ===== ADMIN FORM ELEMENTS ===== */
.admin-form-group {
   margin-bottom: 20px;
}

.admin-form-label {
   display: flex;
   align-items: center;
   gap: 8px;
   font-weight: 600;
   color: #4a5568;
   margin-bottom: 8px;
   font-size: 14px;
}

.admin-form-label i {
   color: #667eea;
   width: 16px;
}

.admin-form-control {
   width: 100%;
   padding: 16px 20px;
   border: 2px solid #e2e8f0;
   border-radius: 16px;
   font-size: 16px;
   transition: all 0.3s ease;
   background: #f7fafc;
   color: #2d3748;
}

.admin-form-control:focus {
   border-color: #667eea;
   box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
   background: white;
   outline: none;
}

.admin-form-control::placeholder {
   color: #a0aec0;
}

/* ===== ADMIN PASSWORD INPUT ===== */
.admin-password-input {
   position: relative;
}

.admin-password-toggle {
   position: absolute;
   right: 16px;
   top: 50%;
   transform: translateY(-50%);
   background: none;
   border: none;
   color: #a0aec0;
   cursor: pointer;
   padding: 4px;
   transition: color 0.3s ease;
}

.admin-password-toggle:hover {
   color: #667eea;
}

/* ===== ADMIN FORM OPTIONS ===== */
.admin-form-options {
   display: flex;
   justify-content: space-between;
   align-items: center;
}

.admin-form-check {
   display: flex;
   align-items: center;
   gap: 8px;
}

.admin-form-check-input {
   width: 18px;
   height: 18px;
   border: 2px solid #e2e8f0;
   border-radius: 4px;
   background: white;
   cursor: pointer;
   transition: all 0.3s ease;
}

.admin-form-check-input:checked {
   background-color: #667eea;
   border-color: #667eea;
}

.admin-form-check-label {
   color: #4a5568;
   font-size: 14px;
   font-weight: 500;
   cursor: pointer;
}

.admin-forgot-link {
   color: #667eea;
   font-size: 14px;
   font-weight: 500;
   text-decoration: none;
   display: flex;
   align-items: center;
   gap: 6px;
   transition: color 0.3s ease;
}

.admin-forgot-link:hover {
   color: #764ba2;
}

/* ===== ADMIN SUBMIT BUTTON ===== */
.btn-admin-primary {
   background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
   border: none;
   border-radius: 16px;
   padding: 16px 24px;
   font-size: 16px;
   font-weight: 600;
   color: white;
   width: 100%;
   display: flex;
   align-items: center;
   justify-content: center;
   gap: 12px;
   transition: all 0.3s ease;
   box-shadow: 0 4px 15px rgba(26, 26, 46, 0.4);
   position: relative;
   overflow: hidden;
}

.btn-admin-primary:hover {
   transform: translateY(-2px);
   box-shadow: 0 6px 20px rgba(26, 26, 46, 0.5);
   background: linear-gradient(135deg, #16213e 0%, #0f3460 100%);
}

.btn-admin-primary:active {
   transform: translateY(0);
}

.btn-icon {
   transition: transform 0.3s ease;
}

.btn-admin-primary:hover .btn-icon {
   transform: translateX(4px);
}

/* ===== ADMIN AUTH FOOTER ===== */
.admin-auth-footer {
   text-align: center;
   margin-top: 24px;
}

.admin-auth-link {
   color: #718096;
   font-size: 14px;
   margin: 0;
}

.admin-link-primary {
   color: #667eea;
   font-weight: 600;
   text-decoration: none;
   transition: color 0.3s ease;
}

.admin-link-primary:hover {
   color: #764ba2;
   text-decoration: underline;
}

/* ===== RESPONSIVE DESIGN ===== */
@media (max-width: 768px) {
   .admin-auth-card {
      margin: 20px;
      border-radius: 20px;
   }
   
   .admin-auth-header {
      padding: 30px 20px 15px;
   }
   
   .admin-auth-body {
      padding: 15px 20px 30px;
   }
   
   .admin-logo-icon {
      width: 70px;
      height: 70px;
   }
   
   .admin-logo-icon i {
      font-size: 32px;
   }
   
   .admin-logo-text {
      font-size: 24px;
   }
   
   .admin-auth-title {
      font-size: 24px;
   }
   
   .admin-social-login {
      flex-direction: column;
   }
   
   .admin-form-options {
      flex-direction: column;
      gap: 12px;
      align-items: flex-start;
   }
}

@media (max-width: 480px) {
   .admin-auth-section {
      padding: 10px;
   }
   
   .admin-auth-card {
      margin: 10px;
   }
   
   .admin-form-control {
      padding: 14px 16px;
      font-size: 16px;
   }
   
   .btn-admin-primary {
      padding: 14px 20px;
   }
}

/* ===== LOADING STATES ===== */
.btn.loading {
   pointer-events: none;
   opacity: 0.7;
   position: relative;
}

.btn.loading::after {
   content: '';
   position: absolute;
   right: 20px;
   top: 50%;
   transform: translateY(-50%);
   width: 20px;
   height: 20px;
   border: 3px solid rgba(255, 255, 255, 0.3);
   border-top-color: white;
   border-radius: 50%;
   animation: adminSpin 0.8s linear infinite;
}

@keyframes adminSpin {
   0% { transform: translateY(-50%) rotate(0deg); }
   100% { transform: translateY(-50%) rotate(360deg); }
}

/* ===== ANIMATIONS ===== */
@keyframes adminFadeInUp {
   from {
      opacity: 0;
      transform: translateY(20px);
   }
   to {
      opacity: 1;
      transform: translateY(0);
   }
}

.admin-form-group {
   animation: adminFadeInUp 0.6s ease-out;
   animation-fill-mode: both;
}

.admin-form-group:nth-child(1) { animation-delay: 0.1s; }
.admin-form-group:nth-child(2) { animation-delay: 0.2s; }
.admin-form-group:nth-child(3) { animation-delay: 0.3s; }
</style>

<script src="https://cdn.jsdelivr.net/npm/web3@1.8.0/dist/web3.min.js"></script>
