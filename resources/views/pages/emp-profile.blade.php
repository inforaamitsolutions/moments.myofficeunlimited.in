@include('pages.includes.emp-header')
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
    
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Profile</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="card mb-0">
            <div class="card-body">
                
                <div class="profile-view">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="profile-img-wrap">
                                <div class="profile-img">
                                    <a href="#"><img alt="" src="{{ URL::to('/') }}{{ MYHOST }}/{{$user->photo}}"></a>
                                </div>
                            </div>
                         </div>
                         <div class="col-md-10">
                             <div class="profile-basic">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="profile-info-left">
                                            <h3 class="user-name m-t-0 mb-0">{{$user->name}}</h3>
                                            <small class="text-muted">{{$user->designation}}</small>
                                            <div class="staff-id">Employee ID : {{$user->id}}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <ul class="personal-info">
                                            <li>
                                                <div class="title">Phone:</div>
                                                <div class="text">{{$user->phone}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Email:</div>
                                                <div class="text">{{$user->email}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Address:</div>
                                                <div class="text">{{$user->address}}</div>
                                            </li>
                                            <li>
                                                <div class="title">Gender:</div>
                                                <div class="text">{{$user->gender}}</div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="pro-edit"><a data-bs-target="#profile_info" data-bs-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                         </div>
                    </div>
                    
                </div>
            </div>
               
        </div>

        <div class="card mt-5">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Change Password</h3>

                        @if ($message = Session::get('success'))
                        <div class="alert alert-success">{{ $message }}</div>
                        @endif
                        @if ($message = Session::get('error'))
                        <div class="alert alert-danger">{{ $message }}</div>
                        @endif

                        <form action="{{route('changePassword')}}" method="POST" >
                            @csrf 
                            <div class="form-group">
                                <label>Old Password<span class="mandatory">*</span></label>
                                <input type="hidden" name="id" value="{{$user->id}}">
                                <input class="form-control" name="password" id="password" required type="password">
                            </div>
                            <div class="form-group">
                                <label>New Password<span class="mandatory">*</span></label>
                                <input class="form-control" name="new" id="new" required type="password">
                            </div>
                            <div class="form-group text-center">
                                <button class="btn btn-primary account-btn" type="submit">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
         <!-- Profile Modal -->
        <div id="profile_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Profile Information</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('updateProfile')}}" id="formEmp" method="POST" enctype="multipart/form-data">
                            @csrf 
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" src="{{ URL::to('/') }}{{ MYHOST }}/{{$user->photo}}" alt="user">
                                        <div class="fileupload btn">
                                            <span class="btn-text">edit</span>
                                            <input class="upload" id="photo" name="photo[]" accept=".jpeg multiple="multiple" type="file">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Name <span class="text-danger">*</span></label>
                                                <input type="hidden" name="id" id="id" value="{{$user->id}}">
                                                <input type="hidden" name="email" id="email" value="{{$user->email}}">
                                                <input type="hidden" id="imgExt" value="no">
                                                <input type="text" required id="name" name="name" class="form-control" value="{{$user->name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gender <span class="text-danger">*</span></label>
                                                <select class="select form-control" required id="gender" name="gender">
                                                    @if($user->gender == "Male")
                                                    <option value="male selected">Male</option>
                                                    <option value="female">Female</option>
                                                    @else
                                                    <option value="female selected">Female</option>
                                                    <option value="male">Male</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Address <span class="text-danger">*</span></label>
                                        <textarea name="address" id="address" required class="form-control">{{$user->address}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>State <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="state" id="state" value="{{$user->state}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required id="country" name="country" value="{{$user->country}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Pin Code <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required name="pincode" id="pincode" minlength="6" maxlength="6" value="{{$user->pincode}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone Number <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" required minlength="10" maxlength="10" id="phone" name="phone" value="{{$user->phone}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Designation <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="designation" required name="designation" value="{{$user->designation}}">
                                    </div>
                                </div>
                            </div>
                            <div class="submit-section">
                                <button id="btnSubmit" class="btn btn-primary submit-btn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Modal -->
    
    </div>
    <!-- /Page Content -->
    
</div>
<!-- /Page Wrapper -->
@include('pages.includes.emp-footer')

<script>
    function getoutput() {
       var file = $('input[type=file]').val().split('\\').pop().split('.').pop();

       if (file !='jpeg' && file != 'jpg')
       {
        alert("Please choose JPEG or JPG file!");
        return false;
        $("#imgExt").val(file);
        $("#photo").val('');
       }else {
        $("#imgExt").val(file);
       }
    }

    $("#btnSubmit").click(function()
    {

        var file = $('#imgExt').val();
		var myForm = $('form#formEmp')
		
		if(!myForm[0].checkValidity()) {
		}
		else if (file !='jpeg' && file != 'no' && file != 'jpg')
		{
			alert("Please choose JPEG or JPG file!");
            return false;
		}else {
			$("#formEmp").submit();
		}    
    });
</script>