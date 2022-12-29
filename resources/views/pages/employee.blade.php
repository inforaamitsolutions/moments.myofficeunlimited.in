@include('pages.includes.header')
<!-- Page Wrapper -->
<div class="page-wrapper">

	<!-- Page Content -->
	<div class="content container-fluid">

		<!-- Page Header -->
		<div class="page-header">
			<div class="row align-items-center">
				<div class="col">
					<h3 class="page-title">Employee</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('index')}}">Dashboard</a></li>
						<li class="breadcrumb-item active">Employee</li>
					</ul>
				</div>
				<div class="col-auto float-end ms-auto">
					<a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_client1"><i class="fa fa-plus"></i> Add Employe</a>
					<!-- <div class="view-icons">
							<a href="clients.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
							<a href="clients-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
						</div> -->
				</div>
			</div>
		</div>
		<!-- /Page Header -->


		<div class="row staff-grid-row">
			@foreach($employee as $emp)
			<div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3">
				<div class="profile-widget">
					<div class="profile-img">
						<span class="avatar">
							@if($emp->photo == '')
							<img alt="" src="{{ URL::to('/') }}{{ MYHOST }}/public/user.png">
							@else
							<img alt="" src="{{ URL::to('/') }}{{ MYHOST }}/{{$emp->photo}}">
							@endif
						</span>
					</div>
					<div class="dropdown profile-action">
						<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" onclick="edit(<?= $emp->id ?>)" data-bs-toggle="modal" data-bs-target="#edit_client"><i class="fa fa-pencil m-r-5"></i> Edit</a>
							<a class="dropdown-item" onclick="deleteR(<?= $emp->id ?>)" data-bs-toggle="modal" data-bs-target="#delete_client"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
						</div>
					</div>
					<h4 class="user-name m-t-10 mb-0 text-ellipsis">{{$emp->name}}</h4>
					<div class="small text-muted">{{$emp->designation}}</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<!-- /Page Content -->

	<!-- Add Client Modal -->
	<div id="add_client" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Employee</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{route('employeeAdd')}}" id="form" method="POST" enctype="multipart/form-data">
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
									<input class="form-control floating" name="email" id="email" required type="email">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Phone <span class="text-danger">*</span></label>
									<input class="form-control" name="phone" id="phone" minlength="10" maxlength="10" required type="text">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Designation <span class="text-danger">*</span></label>
									<input class="form-control" name="designation" id="designation" required type="text">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Gender <span class="text-danger">*</span></label> <br>
									<input type="radio" id="html" name="gender" required value="Male">
									<label for="html">Male</label><br>
									<input type="radio" id="css" name="gender" value="Female">
									<label for="css">Female</label><br>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Address <span class="text-danger">*</span></label>
									<textarea class="form-control" name="address" required id="address"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">State <span class="text-danger">*</span></label>
									<input class="form-control" type="text" required id="state" name="state">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Country <span class="text-danger">*</span></label>
									<input class="form-control" type="text" required id="country" name="country">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Pincode <span class="text-danger">*</span></label>
									<input class="form-control" type="text" id="pincode" name="pincode" required minlength="6" maxlength="6">
								</div>
							</div>
							<div class="col-md-6" id="pwd">
								<div class="form-group">
									<label class="col-form-label">Password </label>
									<input class="form-control" name="password" id="password" type="password">
								</div>
							</div>
							<div class="col-md-6" id="cpwd">
								<div class="form-group">
									<label class="col-form-label">Confirm Password </label>
									<input class="form-control" name="confirmPassword" id="confirmPassword" type="password">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Photo </label>
								<img src="" height="200" width="200" id="pImg" style="display:none;">
								<input type="hidden" id="imgExt"  value="no">
								<input class="form-control" multiple="multiple" name="photo[]" id="photo" accept=".jpeg" onChange='getoutput()' type="file">
							</div>
						</div>
						<div class="submit-section">
							<button id="btn" type="submit" class="btn btn-primary submit-btn">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Client Modal -->

	<!-- Add Client Modal -->
	<div id="add_client1" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Add Employee</h5>
					<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="{{route('employeeAdd')}}" id="formEmp" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Name <span class="text-danger">*</span></label>
									<input type="hidden" name="editId">
									<input class="form-control" name="name" id="name1" required type="text">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Email <span class="text-danger">*</span></label>
									<input class="form-control floating" name="email" id="email1" required type="email">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Phone <span class="text-danger">*</span></label>
									<input class="form-control" name="phone" id="phone1" minlength="10" maxlength="10" required type="text">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Designation <span class="text-danger">*</span></label>
									<input class="form-control" name="designation" id="designation1" required type="text">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Gender <span class="text-danger">*</span></label> <br>
									<input type="radio" id="Male" name="gender" required value="Male">
									<label for="html">Male</label><br>
									<input type="radio" id="Female" name="gender" value="Female">
									<label for="css">Female</label><br>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Address <span class="text-danger">*</span></label>
									<textarea class="form-control" name="address" required id="address1"></textarea>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">State <span class="text-danger">*</span></label>
									<input class="form-control" type="text" required id="state1" name="state">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Country <span class="text-danger">*</span></label>
									<input class="form-control" type="text" required id="country1" name="country">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-form-label">Pincode <span class="text-danger">*</span></label>
									<input class="form-control" type="text" id="pincode1" required name="pincode" minlength="6" maxlength="6">
								</div>
							</div>
							<div class="col-md-6" id="pwd">
								<div class="form-group">
									<label class="col-form-label">Password <span class="text-danger">*</span></label>
									<input class="form-control" name="password" id="password1" required type="password">
								</div>
							</div>
							<div class="col-md-6" id="cpwd">
								<div class="form-group">
									<label class="col-form-label">Confirm Password <span class="text-danger">*</span></label>
									<input class="form-control" name="confirmPassword" id="confirmPassword1" required type="password">
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label class="col-form-label">Photo </label>
								<img src="" height="200" width="200" id="pImg" style="display:none;">
								<input type="hidden" id="imgExt1"  value="no">
								<input class="form-control" multiple="multiple" name="photo[]" id="photo1" accept=".jpeg" onChange='getoutput1()' type="file">
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

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script>
		function getoutput() {
			var file = $('input[id=photo]').val().split('\\').pop().split('.').pop();

			if (file != 'jpeg' && file != 'jpg') {
				alert("Please choose JPEG or JPG file!");
				$("#imgExt").val(file);
				$("#photo").val('');
			} else {
				$("#imgExt").val(file);
			}
		}

		$("#btn").click(function() {
			var file = $('#imgExt').val();

			var myForm = $('form#form')
				// alert("**");
				
			if (file !='jpeg' && file != 'no' && file != 'jpg') {
				alert("Please choose JPEG or JPG file!");
				return false;
			} else {
				if(!myForm[0].checkValidity()) {
				}else
				{
					if ($("#password").val() != $("#confirmPassword").val()) {
						alert("Password and Confirm Password should be same!");
						return false;
					} else {
						$("#form").submit();
					}
				}
				
			}	
		});

		function getoutput1() {
			var file = $('input[id=photo1]').val().split('\\').pop().split('.').pop();

			if (file != 'jpeg' && file != 'jpg') {
				alert("Please choose JPEG or JPG file!");
				$("#imgExt1").val(file);
				$("#photo1").val('');
			} else {
				$("#imgExt1").val(file);
			}
		}

		$("#btnSubmit").click(function() {
			var file = $('#imgExt1').val();
			var myForm = $('form#formEmp')
				// alert("**");
			if (file !='jpeg' && file != 'no' && file != 'jpg') {
				alert("Please choose JPEG or JPG file!");
				return false;
			} else {
				if(!myForm[0].checkValidity()) {
				}else
				{
					if ($("#password1").val() != $("#confirmPassword1").val()) {
						alert("Password and Confirm Password should be same!");
						return false;
					}else {
						$("#formEmp").submit();
					}
				}
				
			}	
				// $("#formEmp").submit();
		});

		function edit(userId) {
			// console.log(userId + " userId");
			$.ajax({
				url: "{{ URL::to('/') }}{{ MYHOST }}/editEmployeee/" + userId,
				type: 'GET',
				success: function(res) {
					console.log(res);
					$("#editId").val(res.id);
					$("#name").val(res.name);
					$("#email").val(res.email);
					$("#phone").val(res.phone);
					$("#designation").val(res.designation);
					$("#address").val(res.address);
					$("#state").val(res.state);
					$("#country").val(res.country);
					$("#city").val(res.city);
					$("#pincode").val(res.pincode);
					$('input:radio[name=gender]').filter("[value=" + res.gender + "]").prop('checked', true);
					if (res.photo == null) {
						$("#pImg").attr("src", 'public/user.png');
					} else {
						$("#pImg").attr("src", res.photo);
					}
					$("#pImg").css('display', 'block');
					$('#add_client').modal('show');
				}

			});
		}

		function deleteR(userId) {
			// console.log(userId + " userId");
			var r = confirm("Are you sure you want to delete?");
			if (r == true) {
				$.ajax({
					url: "{{ URL::to('/') }}{{ MYHOST }}/deleteEmployeee/" + userId,
					type: 'GET',
					success: function(res) {
						if (res == 'done') {
							window.location.replace("{{ URL::to('/') }}{{ MYHOST }}/employees");
						}
					}

				});
			}
		}

		$("#email").change(function()
		{
			console.log($(this).val());
			var email = $("#email").val();

			$.ajax({
				url: "{{ URL::to('/') }}{{ MYHOST }}/checkEmailAddress/" + email,
				type: 'GET',
				success: function(res) {
					if (res == '1') {
						alert("Email already exist!");
						$("#email").val('');
					}
				}

			});
		});

		$("#email1").change(function()
		{
			console.log($(this).val());
			var email = $("#email1").val();

			$.ajax({
				url: "{{ URL::to('/') }}{{ MYHOST }}/checkEmailAddress/" + email,
				type: 'GET',
				success: function(res) {
					if (res == '1') {
						alert("Email already exist!");
						$("#email1").val('');
					}
				}

			});
		});

	</script>

</div>
<!-- /Page Wrapper -->
@include('pages.includes.footer')