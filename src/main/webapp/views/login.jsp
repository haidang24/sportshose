<%@ page language="java" contentType="text/html; charset=UTF-8"
	pageEncoding="UTF-8"%>
<%@ include file="/common/taglib.jsp"%>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Đăng nhập</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Roboto', sans-serif;
}
</style>
</head>
<body>
	<!-- ... existing code ... -->
	
	<div class="login-container">
		<div class="login-wrapper">
			<div class="login-form-container">
				<div class="login-header">
					<h2>Đăng nhập</h2>
					<p>Chào mừng bạn quay trở lại</p>
				</div>
				
				<c:if test="${not empty message}">
					<div class="alert alert-${alert}">${message}</div>
				</c:if>
				
				<form action="<c:url value='/dang-nhap'/>" id="formLogin" method="post">
					<div class="form-group">
						<label for="username">Tên đăng nhập</label>
						<input type="text" class="form-control" id="username" name="username" 
							placeholder="Nhập tên đăng nhập" required>
					</div>
					
					<div class="form-group">
						<label for="password">Mật khẩu</label>
						<div class="password-input-wrapper">
							<input type="password" class="form-control" id="password" name="password" 
								placeholder="Nhập mật khẩu" required>
							<span class="password-toggle" onclick="togglePassword()">
								<i class="fa fa-eye" id="toggleIcon"></i>
							</span>
						</div>
					</div>
					
					<div class="form-options">
						<div class="remember-me">
							<input type="checkbox" id="remember" name="remember">
							<label for="remember">Ghi nhớ đăng nhập</label>
						</div>
						<div class="forgot-password">
							<a href="<c:url value='/quen-mat-khau'/>">Quên mật khẩu?</a>
						</div>
					</div>
					
					<button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
					
					<div class="social-login">
						<p>Hoặc đăng nhập với</p>
						<div class="social-buttons">
							<a href="#" class="btn btn-facebook"><i class="fab fa-facebook-f"></i> Facebook</a>
							<a href="#" class="btn btn-google"><i class="fab fa-google"></i> Google</a>
						</div>
					</div>
					
					<div class="register-link">
						<p>Bạn chưa có tài khoản? <a href="<c:url value='/dang-ky'/>">Đăng ký ngay</a></p>
					</div>
					
					<input type="hidden" value="login" name="action"/>
				</form>
			</div>
			
			<div class="login-banner">
				<img src="<c:url value='/template/web/images/login-banner.jpg'/>" alt="Thể thao - Đam mê">
				<div class="banner-content">
					<h3>Chào mừng đến với Giày Thể Thao</h3>
					<p>Khám phá bộ sưu tập giày thể thao mới nhất và tận hưởng trải nghiệm mua sắm tuyệt vời</p>
				</div>
			</div>
		</div>
	</div>
	
	<!-- ... existing code ... -->
	
	<style>
.login-container {
    padding: 60px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.login-wrapper {
    display: flex;
    max-width: 1000px;
    width: 100%;
    margin: 0 auto;
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    transform: translateY(0);
    transition: all 0.3s ease;
}

.login-wrapper:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.form-control {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #eee;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.form-control:focus {
    border-color: #4a90e2;
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.15);
    background: #fff;
}

.btn-primary {
    background: linear-gradient(135deg, #4a90e2 0%, #357abd 100%);
    color: white;
    border: none;
    padding: 14px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    position: relative;
    overflow: hidden;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(74, 144, 226, 0.3);
}

.btn-primary:active {
    transform: translateY(0);
}

.social-buttons {
    display: flex;
    gap: 15px;
    margin-top: 15px;
}

.btn-facebook, .btn-google {
    flex: 1;
    padding: 12px;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.btn-facebook {
    background: linear-gradient(135deg, #3b5998 0%, #2d4373 100%);
}

.btn-google {
    background: linear-gradient(135deg, #dd4b39 0%, #c23321 100%);
}

.btn-facebook:hover, .btn-google:hover {
    transform: translateY(-2px);
    opacity: 0.95;
}

.remember-me {
    display: flex;
    align-items: center;
    gap: 8px;
}

.remember-me input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: #4a90e2;
    cursor: pointer;
}

.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #777;
    transition: all 0.3s ease;
}

.password-toggle:hover {
    color: #4a90e2;
}

.register-link a, .forgot-password a {
    color: #4a90e2;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.register-link a:hover, .forgot-password a:hover {
    color: #357abd;
    text-decoration: underline;
}

.alert {
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from {
        transform: translateY(-10px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

@media (max-width: 768px) {
    .login-wrapper {
        flex-direction: column;
        margin: 20px;
    }

    .login-form-container {
        padding: 30px 20px;
    }

    .social-buttons {
        flex-direction: column;
    }

    .form-options {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
    }
}
	</style>
	
	<script>
		function togglePassword() {
			const passwordInput = document.getElementById('password');
			const toggleIcon = document.getElementById('toggleIcon');
			
			if (passwordInput.type === 'password') {
				passwordInput.type = 'text';
				toggleIcon.classList.remove('fa-eye');
				toggleIcon.classList.add('fa-eye-slash');
			} else {
				passwordInput.type = 'password';
				toggleIcon.classList.remove('fa-eye-slash');
				toggleIcon.classList.add('fa-eye');
			}
		}
	</script>
</body>
</html>