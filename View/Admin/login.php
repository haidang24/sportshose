<section class="background vh-100">
	<div class="container py-5 h-100">
		<div class="row d-flex justify-content-center align-items-center h-100">
			<div class="col-12 col-md-8 col-lg-6 col-xl-4">
				<div class="card login-card shadow-lg" style="border-radius: 15px;">
					<div class="card-body p-5">
						<h3 class="text-center mb-4">Đăng nhập</h3>
						<form id="formLogin">
							<div class="form-group mb-3">
								<label class="form-label">Tài khoản</label>
								<input id="username" placeholder="Nhập tài khoản của bạn" type="text" class="form-control">
							</div>
							<div class="form-group mb-4">
								<label class="form-label">Mật khẩu</label>
								<input id="password" placeholder="Nhập mật khẩu của bạn" type="password" class="form-control">
							</div>
							<div class="d-flex justify-content-end">
								<button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<style>
	body, html {
		height: 100%;
		margin: 0;
		font-family: 'Arial', sans-serif;
	}

	.background {
		background: linear-gradient(45deg, #4b6cb7 0%, #182848 100%);
		height: 100vh;
		display: flex;
		justify-content: center;
		align-items: center;
		position: relative;
		overflow: hidden;
	}

	.background::before {
		content: 'Goal!\nSpeed\nControl\nVictory\nPassion\nStrike\nDribble\nChampion\nSoccer\nPerformance';
		font-size: 50px;
		color: rgba(255, 255, 255, 0.05);
		position: absolute;
		white-space: pre;
		top: 50%;
		left: 50%;
		transform: translate(-50%, -50%);
		text-align: center;
		z-index: 0;
		line-height: 1.5;
		animation: moveText 10s linear infinite;
	}

	@keyframes moveText {
		0% { transform: translate(-50%, -50%) translateY(-50px); }
		50% { transform: translate(-50%, -50%) translateY(50px); }
		100% { transform: translate(-50%, -50%) translateY(-50px); }
	}

	.login-card {
		background: rgba(255, 255, 255, 0.85);
		backdrop-filter: blur(10px);
		border: none;
		box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
		border-radius: 15px;
		overflow: hidden;
		position: relative;
		z-index: 1;
	}

	.card-body {
		color: #333;
		border-radius: 15px;
	}

	.form-control {
		border-radius: 10px;
	}

	.btn-primary {
		background: linear-gradient(to right, #4b6cb7, #182848);
		border: none;
		border-radius: 10px;
		transition: background 0.3s ease;
	}

	.btn-primary:hover {
		background: linear-gradient(to right, #182848, #4b6cb7);
	}

	.form-label {
		font-weight: bold;
		color: #4b6cb7;
	}
</style>
