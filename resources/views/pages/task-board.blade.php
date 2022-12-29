@include('pages.includes.header')
<!-- Page Wrapper -->
<div class="page-wrapper">

	<!-- Page Content -->
	<div class="content container-fluid">
	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="page-title">Task Board</h3>
					<ul class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{route('index')}}">Dashboard</a></li>
						<li class="breadcrumb-item active">Task Board</li>
					</ul>
				</div>
			</div>
		</div>
		<!-- /Page Header -->
		
		<div class="row board-view-header">
			<div class="col-4">
				<div class="pro-teams">
				</div>
			</div>
			<div class="col-8 text-end">
				<a href="#" class="btn btn-white float-end ms-2" data-bs-toggle="modal" data-bs-target="#add_task_board"><i class="fa fa-plus"></i> Create Project</a>
				<!-- <a href="project-view.html" class="btn btn-white float-end" title="View Board"><i class="fa fa-link"></i></a> -->
			</div>
		</div>
		
		<div class="kanban-board card mb-0">
			<div class="card-body">
				<div class="kanban-cont">
					@foreach($tasklist as $task)
					<div class="kanban-list kanban-{{$task->color}}">
						<div class="kanban-header">
							<span class="status-title">{{$task->name}}</span>
							<div class="dropdown kanban-action">
								<a href="" data-bs-toggle="dropdown">
									<i class="fa fa-ellipsis-v"></i>
								</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" onclick="edit(<?= $task->id ?>)" data-bs-toggle="modal" data-bs-target="#edit_task_board">Edit</a>
									<a class="dropdown-item" onclick="deleteR(<?= $task->id ?>)">Delete</a>
								</div>
							</div>
						</div>
						<div class="kanban-wrap">
							@foreach($tasks as $t)
								@if($task->id == $t->tasklist)
								<div class="card panel">
									<div class="kanban-box">
										<div class="task-board-header">
											<span class="status-title">{{$t->tName}}</span>
											
											<div class="dropdown kanban-task-action">
												<a href="" data-bs-toggle="dropdown">
													<i class="fa fa-angle-down"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="dropdown-item" onclick="editTask(<?= $t->tId ?>)" data-bs-toggle="modal" data-bs-target="#edit_task_modal">Edit</a>
													<a class="dropdown-item" onclick="deleteTask(<?= $t->tId ?>)">Delete</a>
												</div>
											</div>
										</div>
										<div class="task-board-body">
											<div class="kanban-footer">
												<span class="task-info-cont">
													<div class="accordion" id="accordionPanelsStayOpenExample">
														<div class="accordion-item" style="border: 0px solid #fff !important;">
															<a style="font-size: 14px;font-weight: 500;background:#fff;padding-left: 0% !important;" 
															class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#desc<?= $t->tId ?>" aria-expanded="false">View Description</a>
															<!-- </h2> -->
															<div id="desc<?= $t->tId ?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
															<div class="accordion-body" style="font-size: 14px !important;">
																<?php echo preg_replace('~^"?(.*?)"?$~', '$1', $t->desc); ?>
															</div>
															</div>
														</div>
													</div>
													<span class="task-date"><i class="fa fa-clock-o"></i> {{$t->dueDate}} </span>
													@if($t->priority == 'High')
													<span class="task-priority badge bg-inverse-danger">High</span>
													@elseif($t->priority == 'Normal')
													<span class="task-priority badge bg-inverse-warning">Normal</span>
													@else
													<span class="task-priority badge bg-inverse-success">Low</span>
													@endif

													<br>
													<span class="task-priority"><b>Assigned To:</b> {{$t->assignTo}} </span>


												</span>
											</div>
										</div>
									</div>
								</div>
								@endif
							@endforeach
						</div>
						<div class="add-new-task">
							<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#add_task_modal1">Add New Task</a>
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		
	</div>
	<!-- /Page Content -->
	
	<div id="add_task_board" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Task Board</h4>
					<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="{{route('tasklistAdd')}}" method="POST" enctype="multipart/form-data">
						@csrf 
						<div class="form-group">
							<label>Task Board Name</label>
							<input type="hidden" name="editId" id="editId">
							<input type="text" id="name" name="name" required class="form-control">
						</div>
						<div class="form-group task-board-color">
							<label>Task Board Color</label>
							<div class="board-color-list">
								<label class="board-control board-primary">
									<input name="color" type="radio" required class="board-control-input" value="primary" checked="">
									<span class="board-indicator"></span>
								</label>
								<label class="board-control board-success">
									<input name="color" type="radio" class="board-control-input" value="success">
									<span class="board-indicator"></span>
								</label>
								<label class="board-control board-info">
									<input name="color" type="radio" class="board-control-input" value="info">
									<span class="board-indicator"></span>
								</label>
								<label class="board-control board-purple">
									<input name="color" type="radio" class="board-control-input" value="purple">
									<span class="board-indicator"></span>
								</label>
								<label class="board-control board-warning">
									<input name="color" type="radio" class="board-control-input" value="warning">
									<span class="board-indicator"></span>
								</label>
								<label class="board-control board-danger">
									<input name="color" type="radio" class="board-control-input" value="danger">
									<span class="board-indicator"></span>
								</label>
							</div>
						</div>
						<div class="m-t-20 text-center">
							<button class="btn btn-primary btn-lg">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Add Task Modal -->
	<div id="add_task_modal" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Task</h4>
					<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form  action="{{route('taskAdd')}}" method="POST" enctype="multipart/form-data">
						@csrf 
						<div class="form-group">
							<label>Task Name <span class="text-danger">*</span></label>
							<input type="hidden" name="editIdTask" id="editIdTask">
							<input type="hidden" name="addedBy" id="addedBy" value="Admin">
							<input type="text" class="form-control" required id="nameT" name="name">
						</div>
						<div class="form-group">
							<label>Project <span class="text-danger">*</span></label>
							<select class="form-control select" name="tasklist" required id="tasklist">
								<option value="" selected disabled>Select</option>
								@foreach($tasklist as $t)
								<option value="{{$t->id}}">{{$t->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <div id="desc" name="desc" required></div>
                        </div>
						<div class="form-group">
							<label>Due Date <span class="text-danger">*</span></label>
							<div class="cal-icon">
								<input class="form-control datetimepicker" required name="dueDate" id="dueDate" type="text">
							</div>
						</div>
						<div class="form-group">
							<label>Task Priority <span class="text-danger">*</span></label>
							<select class="form-control select" name="priority" required id="taskPriority">
								<option value="" selected disabled>Select</option>
								@foreach ($priority as $p)
								<option value="{{$p}}">{{$p}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Assign Task <span class="text-danger">*</span></label>
							<select class="form-control select" id="assignTo" required name="assignTo">
								<!-- <option value="" selected disabled>Select</option> -->
								@foreach($employee as $emp)
								<option value="{{$emp->id}}">{{$emp->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="submit-section text-center">
							<button class="btn btn-primary submit-btn">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Task Modal -->

	<!-- Add Task Modal -->
	<div id="add_task_modal1" class="modal custom-modal fade" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Task</h4>
					<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form  action="{{route('taskAdd')}}" method="POST" enctype="multipart/form-data">
						@csrf 
						<div class="form-group">
							<label>Task Name <span class="text-danger">*</span></label>
							<input type="hidden" name="editIdTask">
							<input type="hidden" name="addedBy" id="addedBy" value="Admin">
							<input type="text" class="form-control" required id="nameT1" name="name">
						</div>
						<div class="form-group">
							<label>Project <span class="text-danger">*</span></label>
							<select class="form-control select" name="tasklist" required id="tasklist1">
								<option value="" selected disabled>Select</option>
								@foreach($tasklist as $t)
								<option value="{{$t->id}}">{{$t->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
                            <label>Description <span class="text-danger">*</span></label>
                            <div name="desc" id="descDiv" required></div>
                        </div>
						<div class="form-group">
							<label>Due Date <span class="text-danger">*</span></label>
							<div class="cal-icon">
								<input class="form-control datetimepicker" required name="dueDate" id="dueDate1" type="text">
							</div>
						</div>
						<div class="form-group">
							<label>Task Priority <span class="text-danger">*</span></label>
							<select class="form-control select" name="priority" required id="taskPriority1">
								<option value="" selected disabled>Select</option>
								@foreach ($priority as $p)
								<option value="{{$p}}">{{$p}}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							<label>Assign Task <span class="text-danger">*</span></label>
							<select class="form-control select" id="assignTo1" required name="assignTo">
								<option value="" selected disabled>Select</option>
								@foreach($employee as $emp)
								<option value="{{$emp->id}}">{{$emp->name}}</option>
								@endforeach
							</select>
						</div>
						<div class="submit-section text-center">
							<button class="btn btn-primary submit-btn">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- /Add Task Modal -->
	
	
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script>

		$(document).ready(function() {

			tinymce.init({
			selector: '#desc'
			});

			tinymce.init({
			selector: '#descDiv'
			});

		});


		function edit(userId) {
			// console.log(userId + " userId");
			$.ajax({
				url: "{{ URL::to('/') }}{{ MYHOST }}/editTasklist/" + userId,
				type: 'GET',
				success: function(res) {
					console.log(res);
					$("#editId").val(res.id);
					$("#name").val(res.name);
					
					$('input:radio[name=color]').filter("[value="+res.color+"]").prop('checked', true);

					$('#add_task_board').modal('show');
				}

			});
		}


		function deleteR(userId) {
			// console.log(userId + " userId");
			var r = confirm("Are you sure you want to delete?");
			if (r == true) {
				$.ajax({
					url: "{{ URL::to('/') }}{{ MYHOST }}/deleteTasklist/" + userId,
					type: 'GET',
					success: function(res) {
						if (res == 'done') {
							window.location.replace("{{ URL::to('/') }}{{ MYHOST }}/tasks");
						}
					}

				});
			}
		}

		function editTask(userId) {
			// console.log(userId + " userId");
			$.ajax({
				url: "{{ URL::to('/') }}{{ MYHOST }}/editTask/" + userId,
				type: 'GET',
				success: function(res) {
					console.log(res);
					$("#editIdTask").val(res.id);
					$("#nameT").val(res.name);
					// tinyMCE.activeEditor.setContent(res.desc);
					if ((res.desc == null)|| (res.desc == ''))
					{
						tinymce.get('desc').setContent(" ");
					}else {
						tinymce.get('desc').setContent(res.desc);
					}
					
					$("#tasklist").select2('val',res.tasklist);          
					$("#startDate").val(res.startDate);
					$("#dueDate").val(res.dueDate);	
					$("#taskPriority").val(res.priority).trigger("change");        
					$("#client").select2('val',res.client);          
					$("#vendor").select2('val',res.vendor);          
					$("#assignTo").select2('val',res.assignTo);          
					$("#project").select2('val',res.project);   
					$("#addedBy").val(res.addedBy);
					$('#add_task_modal').modal('show');
				}

			});
		}


		function deleteTask(userId) {
			// console.log(userId + " userId");
			var r = confirm("Are you sure you want to delete?");
			if (r == true) {
				$.ajax({
					url: "{{ URL::to('/') }}{{ MYHOST }}/deleteTask/" + userId,
					type: 'GET',
					success: function(res) {
						if (res == 'done') {
							window.location.replace("{{ URL::to('/') }}{{ MYHOST }}/tasks");
						}
					}

				});
			}
		}

	</script>

</div>
<!-- /Page Wrapper -->
@include('pages.includes.footer')