@include('pages.includes.header')
	<!-- Page Wrapper -->
	<div class="page-wrapper">
	
		<!-- Page Content -->
		<div class="content container-fluid">
		
			<!-- Page Header -->
			<div class="page-header">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">Clients</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('index')}}">Dashboard</a></li>
							<li class="breadcrumb-item active">Clients</li>
						</ul>
					</div>
					<div class="col-auto float-end ms-auto">
						<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#edit-modal"><i class="fa fa-plus"></i> Add Client</a>
						<!-- <div class="view-icons">
							<a href="clients.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
							<a href="clients-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
						</div> -->
					</div>
				</div>
			</div>
			<!-- /Page Header -->
			
			
			<div class="row staff-grid-row">
				@foreach($allClients as $client)
				<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
					<div class="profile-widget">
						<div class="profile-img">
							<span class="avatar">
								@if($client->photo == '')
								<img alt="" src="{{ URL::to('/') }}{{ MYHOST }}/public/user.png">
								@else
								<img alt="" src="{{ URL::to('/') }}{{ MYHOST }}/{{$client->photo}}">
								@endif
							</span>
						</div>
						<div class="dropdown profile-action">
							<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" onclick="edit(<?= $client->id ?>)" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
							<a class="dropdown-item" onclick="deleteR(<?= $client->id ?>)" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
						</div>
						</div>
						<h4 class="user-name m-t-10 mb-0 text-ellipsis">{{$client->name}}</h4>
						<h5 class="user-name m-t-10 mb-0 text-ellipsis">{{$client->companyName}}</h5>
						<!-- <div class="small text-muted">CEO</div> -->
						<!-- <a href="chat.html" class="btn btn-white btn-sm m-t-10">Message</a>
						<a href="client-profile.html" class="btn btn-white btn-sm m-t-10">View Profile</a> -->
					</div>
				</div>
				@endforeach
			</div>
		</div>
		<!-- /Page Content -->
	
		<!-- Add Client Modal -->
		<div id="modal" class="modal custom-modal fade" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Client</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{route('clientsAdd')}}" id="profileForm" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Name <span class="text-danger">*</span></label>
										<input type="hidden" name="editId" id="editId">
										<input class="form-control" name="name" id="name" required type="text">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Email <span class="text-danger">*</span></label>
										<input class="form-control floating" required name="email" id="email" type="email">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Phone <span class="text-danger">*</span></label>
										<input class="form-control" required name="phone" id="phone" minlength="10" maxlength="10" type="text">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Company Name <span class="text-danger">*</span></label>
										<input class="form-control" required name="companyName" id="companyName" type="text">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Photo </label>
										<img src="" height="200" width="200" id="pImg" style="display:none;">
										<input type="hidden" id="imgExt" value="no">
										<input class="form-control" multiple="multiple" name="photo[]" id="photo" accept=".jpeg" onChange='getoutput()' type="file">
									</div>
								</div>
							</div>
							<div class="submit-section">
								<button type="submit" id="btnSubmit" class="btn btn-primary submit-btn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Add Client Modal -->

		<!-- Add Client Modal -->
		<div id="edit-modal" class="modal custom-modal fade" role="dialog">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add Client</h5>
						<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form action="{{route('clientsAdd')}}" id="profileForm1" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Name <span class="text-danger">*</span></label>
										<input type="hidden" name="editId">
										<input class="form-control" name="name"id="name1" required type="text">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Email <span class="text-danger">*</span></label>
										<input class="form-control floating" required name="email" id="email1" type="email">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Phone <span class="text-danger">*</span></label>
										<input class="form-control" required name="phone" id="phone" minlength="10" maxlength="10" type="text">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Company Name <span class="text-danger">*</span></label>
										<input class="form-control" required name="companyName" id="companyName1" type="text">
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-form-label">Photo </label>
										<img src="" height="200" width="200" id="pImg" style="display:none;">
										<input type="hidden" id="imgExt1" value="no">
										<input class="form-control" multiple="multiple" name="photo[]" id="photo1" accept=".jpeg" onChange='getoutput1()' type="file">
									</div>
								</div>
							</div>
							<div class="submit-section">
								<button type="submit" id="btnSubmit1" class="btn btn-primary submit-btn">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- /Add Client Modal -->
		
		
	</div>
	<!-- /Page Wrapper -->

@include('pages.includes.footer')

<script>
	function edit(userId) {
		// console.log(userId + " userId");
		$.ajax({
			url: "{{ URL::to('/') }}{{ MYHOST }}/editClient/" + userId,
			type: 'GET',
			success: function(res) {
				console.log(res);
				$("#editId").val(res.id);
				$("#name").val(res.name);
				$("#email").val(res.email);
				$("#phone").val(res.phone);
				$("#companyName").val(res.companyName);    
				if (res.photo == null)
				{
					$("#pImg").attr("src", 'public/user.png');
				}else {
					$("#pImg").attr("src", res.photo);
				}
				
				$("#pImg").css('display', 'block');
				$('#modal').modal('show');
			}

		});
	}

	function deleteR(userId) {
		// console.log(userId + " userId");
		var r = confirm("Are you sure you want to delete?");
		if (r == true) {
			$.ajax({
				url: "{{ URL::to('/') }}{{ MYHOST }}/deleteClient/" + userId,
				type: 'GET',
				success: function(res) {
					if (res == 'done') {
						window.location.replace("{{ URL::to('/') }}{{ MYHOST }}/clientsList");
					}
				}

			});
		}
	}

	function getoutput() {
		var file = $('input[id=photo]').val().split('\\').pop().split('.').pop();

		if (file !='jpeg' && file !='jpg')
		{
			alert("Please choose JPEG or JPG file!");
			$("#imgExt").val(file);
			$("#photo").val('');
		}else {
			$("#imgExt").val(file);
		}
	}

	$("#btnSubmit").click(function()
	{
		var file = $('#imgExt').val();
		var myForm = $('form#profileForm')
		
		if (file !='jpeg' && file != 'no' && file != 'jpg')
		{
			alert("Please choose JPEG or JPG file!");
			return false;
		}else {
			if(!myForm[0].checkValidity()) {
			} else {
				$("#profileForm").submit();
			}
		}    
	});

	function getoutput1() {
		var file = $('input[id=photo1]').val().split('\\').pop().split('.').pop();

		if (file !='jpeg' && file !='jpg')
		{
			alert("Please choose JPEG or JPG file!");
			$("#imgExt1").val(file);
			$("#photo1").val('');
		}else {
			$("#imgExt1").val(file);
		}
	}

	$("#btnSubmit1").click(function()
	{
		var file = $('#imgExt1').val();
		var myForm = $('form#profileForm1')
		
		
		if (file !='jpeg' && file != 'no' && file != 'jpg')
		{
			alert("Please choose JPEG or JPG file!");
			return false;
		}else {
			if(!myForm[0].checkValidity()) {
			}else {
				$("#profileForm1").submit();
			}
		}    
	});

	$("#companyName1").change(function()
	{
		console.log($(this).val());
		var name = $("#companyName1").val();

		$.ajax({
			url: "{{ URL::to('/') }}{{ MYHOST }}/checkClient/" + name,
			type: 'GET',
			success: function(res) {
				if (res == '1') {
					alert("Company Name name already exist!");
					$("#companyName1").val('');
				}
			}

		});
	});

	$("#companyName").change(function()
	{
		console.log($(this).val());
		var name = $("#companyName").val();

		$.ajax({
			url: "{{ URL::to('/') }}{{ MYHOST }}/checkClient/" + name,
			type: 'GET',
			success: function(res) {
				if (res == '1') {
					alert("Company Name name already exist!");
					$("#companyName").val('');
				}
			}

		});
	});
</script>