@include('pages.includes.header')
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Task Reports</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('index')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Task Reports</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <!-- Content Starts -->
        <!-- Search Filter -->
            <form method="GET" id="formFilter">
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">
                        <label class="focus-label">Employee</label>
                        <div class="form-group form-focus">
                            <div>
                                <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
                                <select class="form-control floating select" name="employee" id="employee">
                                    <option value=""> Select </option>
                                    @foreach($allemps as $emp)
                                    <option value="{{$emp->id}}">
                                        {{$emp->name}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <label class="focus-label">Status</label>
                        <div class="form-group form-focus">
                            <div>
                                <select class="form-control floating select" name="status" id="status">
                                    <option value=""> Select </option>
                                    <option value="1"> Active </option>
                                    <option value="2"> Complete </option>
                                    <option value="3"> Pending </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2 col-12">
                        <label class="focus-label">From</label>

                        <div class="form-group form-focus">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" data-date-format="Y-M-D" type="text" name="fromDate" id="fromDate">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2 col-lg-2 col-xl-2 col-12">
                        <label class="focus-label">To</label>

                        <div class="form-group form-focus">
                            <div class="cal-icon">
                                <input class="form-control floating datetimepicker" data-date-format="Y-M-D" type="text" name="toDate" id="toDate">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-2">
                        <label class="focus-label"></label>

                        <button type="button" id="btnFiler" class="btn btn-success w-100"> Search </button>
                    </div>
                </div>
            </form>
        <!-- /Search Filter -->

        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive" id="appendHere">
                    <table class="table table-striped custom-table mb-0 datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Task Name</th>
                                <th>Status</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Assigned To</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td>{{$task->tId}}</td>
                                <td>{{$task->tName}}</td>
                                <td>
                                    <div class="dropdown action-label">
                                        <span class="btn btn-white btn-sm btn-rounded" style="cursor: inherit !important;">
                                            @if($task->tStatus == 1)
                                            <i class="fa fa-dot-circle-o text-warning"></i> Active 
                                            @elseif ($task->tStatus == 2)
                                                <i class="fa fa-dot-circle-o text-success"></i> Completed
                                            @elseif ($task->tStatus == '3')
                                                <i class="fa fa-dot-circle-o text-danger"></i> Pending 
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                        $date=date_create($task->sDate);
                                        echo date_format($date, 'd/m/Y') 
                                    ?>
                                </td>
                                <td>{{$task->dueDate}}</td>
                                <td>{{$task->eName}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- /Content End -->

    </div>
    <!-- /Page Content -->

    
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script>
			

		$("#btnFiler").click(function() {
            
            var employee = $("#employee").val();
            var status = $("#status").val();
            var fromDate = $("#fromDate").val();
            var toDate = $("#toDate").val();

            console.log(toDate);

			$.ajax({
				url: "{{ URL::to('/') }}{{ MYHOST }}/applyFilter",
				type: 'POST',
                data: {employee:employee, status:status, fromDate:fromDate, toDate:toDate},
                headers : {
                    'X-CSRF-TOKEN': jQuery('#token').val()
                },
				success: function(res) {
					console.log(res);         
                    $("#appendHere").html('');           
                    $("#appendHere").append(res);           
				}

			});
		});

    </script>
</div>
<!-- /Page Wrapper -->
@include('pages.includes.footer')