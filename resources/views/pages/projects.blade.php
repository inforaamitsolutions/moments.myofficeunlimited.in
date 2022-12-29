@include('pages.includes.header')
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
    
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Projects</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Projects</li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#create_project1"><i class="fa fa-plus"></i> Create Project</a>
                    <!-- <div class="view-icons">
                        <a href="projects.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                        <a href="project-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                    </div> -->
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <!-- Search Filter -->
        <!-- <div class="row filter-row">
            <div class="col-sm-6 col-md-3">  
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Project Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">  
                <div class="form-group form-focus">
                    <input type="text" class="form-control floating">
                    <label class="focus-label">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3"> 
                <div class="form-group form-focus select-focus">
                    <select class="select floating"> 
                        <option>Select Roll</option>
                        <option>Web Developer</option>
                        <option>Web Designer</option>
                        <option>Android Developer</option>
                        <option>Ios Developer</option>
                    </select>
                    <label class="focus-label">Designation</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">  
                <a href="#" class="btn btn-success w-100"> Search </a>  
            </div>     
        </div> -->
        <!-- Search Filter -->
        
        <div class="row">
            @foreach($projects as $project)
            <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="dropdown dropdown-action profile-action">
                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" onclick="edit(<?= $project->id ?>)"  data-bs-toggle="modal" data-bs-target="#edit_project"><i class="fa fa-pencil m-r-5"></i> Edit</a>
                                <a class="dropdown-item" onclick="deleteR(<?= $project->id ?>)"  data-bs-toggle="modal" data-bs-target="#delete_project"><i class="fa fa-trash-o m-r-5"></i> Delete</a>
                            </div>
                        </div>
                        <h4 class="project-title">{{$project->name}}</h4>
                        <p class="text-muted">
                            <?php echo preg_replace('~^"?(.*?)"?$~', '$1', $project->desc); ?>
                        </p>
                        <div class="pro-deadline m-b-15">
                            <div class="sub-title">
                                Client:
                            </div>
                            <div class="text-muted">
                            {{$project->cName}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- /Page Content -->
    
    <!-- Create Project Modal -->
    <div id="create_project1" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Project</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('projectAdd')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Project Name <span class="text-danger">*</span></label>
									<input type="hidden" name="editId">
                                    <input class="form-control" name="name" id="name1" required type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Client <span class="text-danger">*</span></label>
                                    <select class="select" name="client" id="client1" required>
                                        <option value="" selected disabled>Select Client</option>
                                        @foreach($allClients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <div id="desc1" name="desc" required></div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Create Project Modal -->
    <!-- Create Project Modal -->
    <div id="create_project" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Project</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('projectAdd')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Project Name <span class="text-danger">*</span></label>
                                    <input type="hidden" name="editId" id="editId">
                                    <input class="form-control" name="name" id="name" required type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Client <span class="text-danger">*</span></label>
                                    <select class="select" name="client" id="client" required>
                                        <option value="" selected disabled>Select Client</option>
                                        @foreach($allClients as $client)
                                        <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <div id="desc" name="desc" required></div>
                        </div>
                        <div class="submit-section">
                            <button class="btn btn-primary submit-btn">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /Create Project Modal -->
    
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>

    $(document).ready(function() {

        tinymce.init({
        selector: '#desc'
        });
        tinymce.init({
        selector: '#desc1'
        });
    });

    function edit(userId) {
        // console.log(userId + " userId");
        $.ajax({
            url: "{{ URL::to('/') }}{{ MYHOST }}/editProject/" + userId,
            type: 'GET',
            success: function(res) {
                console.log(res);
                $("#editId").val(res.id);
                $("#name").val(res.name);
                tinymce.get('desc').setContent(res.desc);
                $("#desc").val(res.desc);
                // $("#client").val(res.client);   
                $("#client").select2('val',res.client);          
                // $("#pImg").attr("src", res.photo);
                // $("#pImg").css('display', 'block');
                $('#create_project').modal('show');
            }

        });
    }

    function deleteR(userId) {
        // console.log(userId + " userId");
        var r = confirm("Are you sure you want to delete?");
        if (r == true) {
            $.ajax({
                url: "{{ URL::to('/') }}{{ MYHOST }}/deleteProject/" + userId,
                type: 'GET',
                success: function(res) {
                    if (res == 'done') {
                        window.location.replace("{{ URL::to('/') }}{{ MYHOST }}/projects");
                    }
                }

            });
        }
    }

	</script>

<!-- /Page Wrapper -->
@include('pages.includes.footer')