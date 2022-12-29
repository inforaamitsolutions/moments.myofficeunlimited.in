<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Task Manager - Register</title>
		
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
						<a href="{{route('index')}}"><img src="{{ URL::to('/') }}{{ MYHOST }}/public/web/logo.png" style="width:200px"></a>
					</div>
					<!-- /Account Logo -->
					
					<div class="account-box">
						<div class="account-wrapper">
							<h3 class="account-title">Register</h3>
							<p class="account-subtitle">Access to dashboard</p>
							
							<!-- Account Form -->
							<form action="{{route('registerCheck')}}" id="formEmp" method="POST">
                                @csrf 
                                <div class="form-group">
									<label>Name<span class="mandatory">*</span></label>
									<input class="form-control" name="name" id="name" required type="text">
								</div>
								<div class="form-group">
									<label>Email<span class="mandatory">*</span></label>
									<input class="form-control" name="email" id="email" required type="email">
								</div>
								<div class="form-group">
									<label>Password<span class="mandatory">*</span></label>
									<input class="form-control" name="password" id="password" required type="password">
								</div>
								<div class="form-group">
									<label>Repeat Password<span class="mandatory">*</span></label>
									<input class="form-control" name="confirmPassword" id="confirmPassword" required type="password">
								</div>
								<div class="form-group text-center">
									<button class="btn btn-primary account-btn" id="btnSubmit" type="button">Register</button>
								</div>
								<div class="account-footer">
									<p>Already have an account? <a href="{{route('login')}}">Login</a></p>
								</div>
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
		
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
		<script>

		$("#btnSubmit").click(function()
		{
			if ($("#password").val() != $("#confirmPassword").val())
			{
				alert("Password and Confirm Password should be same!");
			}else {
				$("#formEmp").submit();
			}
		});

        </script>

    </body>
</html>