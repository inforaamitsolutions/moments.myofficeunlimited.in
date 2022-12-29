<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="description" content="Smarthr - Bootstrap Admin Template">
		<meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
        <meta name="author" content="Dreamguys - Bootstrap Admin Template">
        <meta name="robots" content="noindex, nofollow">
        <title>Task Manager - Login</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('/') }}{{ MYHOST }}/public/img/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/font-awesome.min.css">
		
		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/style.css">
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/html5shiv.min.js"></script>
			<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body class="account-page">
	
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<div class="account-content">
				<div class="container">
				
					<!-- Account Logo -->
					<div class="account-logo">
						<a href="#!"><img src="{{ URL::to('/') }}{{ MYHOST }}/public/web/logo.png" style="width:200px"></a>
                    </div>
					<!-- /Account Logo -->
					
					<div class="account-box">
						<div class="account-wrapper">
							<h3 class="account-title">Reset Password</h3>
							<!-- <p class="account-subtitle">Enter your email to get a password reset link</p> -->
							
                            @if ($message = Session::get('success'))
							<div class="alert alert-success">{{ $message }}</div>
							@endif
							@if ($message = Session::get('error'))
							<div class="alert alert-danger">{{ $message }}</div>
							@endif
                            
							<!-- Account Form -->
							<form action="{{route('passwordReset')}}" method="POST">
                                @csrf
                                <div class="form-group">
									<label>OTP<span class="mandatory">*</span></label>
                                    <input type="hidden" name="userId" value="{{$id}}">
                                    <input type="hidden" name="user" value="{{$user}}">
                                    <input type="hidden" name="otpCheck" value="{{$otp}}">
									<input class="form-control" name="otp" id="otp" required type="text">
								</div>
								<div class="form-group text-center">
                                    <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
								</div>
								<!-- <div class="account-footer">
									<p>Remember your password? <a href="{{route('login')}}">Login</a></p>
								</div> -->
							</form>
							<!-- /Account Form -->
							
						</div>
					</div>
				</div>
			</div>
        </div>
		<!-- /Main Wrapper -->
		
		<!-- jQuery -->
        <script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/jquery-3.6.0.min.js"></script>
		
		<!-- Bootstrap Core JS -->
        <script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/bootstrap.bundle.min.js"></script>
		
		<!-- Custom JS -->
		<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/app.js"></script>

		
    </body>
</html>