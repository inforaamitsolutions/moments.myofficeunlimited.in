<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Task Manager - Login</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('/') }}{{ MYHOST }}/public/web/favicon.png">
		
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
							<h3 class="account-title">Login</h3>
							<p class="account-subtitle">Access to dashboard</p>
							
							@if ($message = Session::get('success'))
							<div class="alert alert-success">{{ $message }}</div>
							@endif
							@if ($message = Session::get('error'))
							<div class="alert alert-danger">{{ $message }}</div>
							@endif

							<!-- Account Form -->
							<form action="{{route('loginCheck')}}" method="POST">
								@csrf 
								<div class="form-group">
									<label>Email Address</label>
									<input class="form-control" type="email" id="email" name="email">
								</div>
								<div class="form-group">
									<div class="row">
										<div class="col">
											<label>Password</label>
										</div>
										<div class="col-auto">
											<a class="text-muted" href="{{route('forgotPassword')}}">
												Forgot password?
											</a>
										</div>
									</div>
									<div class="position-relative">
										<input class="form-control" type="password" id="password" name="password">
										<span class="fa fa-eye-slash" id="toggle-password"></span>
									</div>
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" type="submit">Login</button>
								</div>
								<!--<div class="account-footer">-->
								<!--	<p>Don't have an account yet? <a href="{{route('register')}}">Register</a></p>-->
								<!--</div>-->
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
		
		<script>
			$("#email").change(function()
			{
				console.log($(this).val());
				var email = $("#email").val();

				$.ajax({
					url: "{{ URL::to('/') }}{{ MYHOST }}/checkEmail/" + email,
					type: 'GET',
					success: function(res) {
						if (res == '0') {
							alert("Email address doesn't exist!");
							$("#email").val('');
						}
					}

				});
			});
		</script>
    </body>
</html>