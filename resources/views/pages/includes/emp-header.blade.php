<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <meta name="robots" content="noindex, nofollow">
        <title>MyOffice Unlimited</title>
		
		<!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::to('/') }}{{ MYHOST }}/public/web/favicon.png">
		
		<!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/font-awesome.min.css">
		
		<!-- Lineawesome CSS -->
		<link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/line-awesome.min.css">
		
		<!-- Select2 CSS -->
		<link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/select2.min.css">
		
		<!-- Datetimepicker CSS -->
		<link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/bootstrap-datetimepicker.min.css">
		
		<!-- Ck Editor -->
		<link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/ckeditor.css">

		<!-- Main CSS -->
        <link rel="stylesheet" href="{{ URL::to('/') }}{{ MYHOST }}/public/css/style.css">

		<script src="https://cdn.tiny.cloud/1/gi5oow5lxtkoet6j8runfdtka61bedqhfs5dkpet7ozliynd/tinymce/5/tinymce.min.js"></script>
		
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/html5shiv.min.js"></script>
			<script src="{{ URL::to('/') }}{{ MYHOST }}/public/js/respond.min.js"></script>
		<![endif]-->
    </head>
    <body>
		<!-- Main Wrapper -->
        <div class="main-wrapper">
		
			<!-- Header -->
            <div class="header">
			
				<!-- Logo -->
                <div class="header-left">
                    <a href="{{route('index')}}" class="logo">
						<img src="{{ URL::to('/') }}{{ MYHOST }}/public/web/logo.png" alt="">
					</a>
                </div>
				<!-- /Logo -->
				
				<a id="toggle_btn" href="javascript:void(0);">
					<span class="bar-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
				</a>
				
				<!-- Header Title -->
                <div class="page-title-box">
					<!-- <h3>Dreamguy's Technologies</h3> -->
                </div>
				<!-- /Header Title -->
				
				<a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>
				
				<!-- Header Menu -->
				<ul class="nav user-menu">
				
					<li class="nav-item dropdown has-arrow main-drop">
						<a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
							<span class="user-img">
								@if($uimg == '')
								<img alt="" src="{{ URL::to('/') }}{{ MYHOST }}/public/user.png">
								@else
								<img alt="" src="{{ URL::to('/') }}{{ MYHOST }}/{{$uimg}}">
								@endif
								<span class="status online"></span>
							</span>
							<span>{{$uname}}</span>
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="{{route('profile')}}">My Profile</a>
							<!-- <a class="dropdown-item" href="settings.html">Settings</a> -->
							<a class="dropdown-item" href="{{route('empLogout')}}">Logout</a>
						</div>
					</li>
				</ul>
				<!-- /Header Menu -->
				
				<!-- Mobile Menu -->
				<div class="dropdown mobile-user-menu">
					<a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>
					<div class="dropdown-menu dropdown-menu-right">
						<a class="dropdown-item" href="{{route('profile')}}">My Profile</a>
						<!-- <a class="dropdown-item" href="settings.html">Settings</a> -->
						<a class="dropdown-item" href="{{route('empLogout')}}">Logout</a>
					</div>
				</div>
				<!-- /Mobile Menu -->
				
            </div>
			<!-- /Header -->
			
			<!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
					<div id="sidebar-menu" class="sidebar-menu">
						<ul>
							<!-- <li class="menu-title"> 
								<span>Main</span>
							</li> -->
                            <li class=""> 
								<a href="{{route('eindex')}}"><i class="la la-home"></i> <span>Dashboard</span></a>
							</li>
							<li class=""> 
								<a href="{{route('taskboard')}}"><i class="la la-edit"></i> <span>Task Board</span></a>
							</li>
						</ul>
					</div>
                </div>
            </div>
			<!-- /Sidebar -->
			