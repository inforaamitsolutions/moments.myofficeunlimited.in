@include('pages.includes.emp-header')
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
				<!-- <a href="#" class="btn btn-white float-end ms-2" data-bs-toggle="modal" data-bs-target="#add_task_board"><i class="fa fa-plus"></i> Create List</a> -->
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
								<input type="hidden" name="taskId" id="taskId" value="<?= $task->id ?>">
							</div>
						</div>
						<div class="kanban-wrap">
							@foreach($tasks as $t)
								@if($task->id == $t->tasklist)
								<div class="card panel">
									<div class="kanban-box">
										<div class="task-board-header">
											<span class="status-title">{{$t->name}}</span>
											
											<div class="dropdown kanban-task-action">
												<a href="" data-bs-toggle="dropdown">
													<i class="fa fa-angle-down"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-right">
													<!-- <a class="dropdown-item" onclick="editTask(<?= $task->id ?>)" data-bs-toggle="modal" data-bs-target="#edit_task_modal">Edit</a> -->
													<a class="dropdown-item" onclick="retask(<?= $task->id ?>)" data-bs-toggle="modal" data-bs-target="#edit_task_modal">Complete Task</a>

												</div>
											</div>
										</div>
										<div class="task-board-body">
											<div class="kanban-footer">
												<span class="task-info-cont">

													<div class="accordion" id="accordionPanelsStayOpenExample">
														<div class="accordion-item" style="border: 0px solid #fff !important;">
															<a style="font-size: 14px;font-weight: 500;background:#fff;padding-left: 0% !important;" 
															class="btn btn-link collapsed" data-bs-toggle="collapse" data-bs-target="#desc<?= $t->id ?>" aria-expanded="false">View Description</a>
															<!-- </h2> -->
															<div id="desc<?= $t->id ?>" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingTwo">
															<div class="accordion-body">
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
													@if($t->forwardedTo != '')
													<br>
													<span class=""><b>Re-assigned To :</b> {{$t->forwardedTo}} </span>
													@endif
												</span>
											</div>
										</div>
									</div>
								</div>

								<div id="reassign" class="modal custom-modal fade" role="dialog">
									<div class="modal-dialog modal-dialog-centered">
										<div class="modal-content">
											<div class="modal-header">
												<h4 class="modal-title">Task Status</h4>
												<button type="button" class="close" data-bs-dismiss="modal">&times;</button>
											</div>
											<div class="modal-body">
												<form action="{{route('reassignTask')}}" method="POST" enctype="multipart/form-data">
													@csrf 
													<div class="form-group">
														<label>Complete Task <span class="text-danger">*</span></label>
														<input type="hidden" name="editReassign" id="editReassign" value="{{$uid}}">
														<input type="hidden" name="taskIdRe" id="taskIdRe" value="{{$t->id}}">
														<select class="form-control select" id="forwardedTo" required name="forwardedTo[]">
															<option value="" selected disabled>Select</option>
															<option value="2">Task Completed</option>
														</select>
													</div>
													<div class="m-t-20 text-center">
														<button class="btn btn-primary btn-lg">Submit</button>
													</div>
												</form>
											</div>
										</div>
									</div>
								</div>
								@endif
							@endforeach
						</div>
					</div>
					@endforeach
				</div>
			</div>
		</div>
		
	</div>
	<!-- /Page Content -->
	
	
	
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script>

		$(document).ready(function() {

			tinymce.init({
			selector: '#desc'
			});


			$('.kanban-wrap').each(function(i, valueDiv) {

				if($(valueDiv).find(".card").length > 0)
				{
				}else {
					// console.log(i +"blank");
					$(this).parent().css('display','none');
				}

			});
		});
		
		function retask(userId) {
			// // console.log(userId + " userId");
			// $.ajax({
			// 	url: "{{ URL::to('/') }}{{ MYHOST }}/reassignTask/" + userId,
			// 	type: 'GET',
			// 	success: function(res) {
			// 		console.log(res);
			// 		$("#editId").val(res.id);
			// 		$("#name").val(res.name);
					
			// 		$('input:radio[name=color]').filter("[value="+res.color+"]").prop('checked', true);

			// 		$('#add_task_board').modal('show');
			// 	}

			// });

			$('#reassign').modal('show');

		}

	</script>

</div>
<!-- /Page Wrapper -->
@include('pages.includes.emp-footer')