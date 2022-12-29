@include('pages.includes.header')
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
    
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome Admin!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
    
        <div class="row">
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="fa fa-files-o"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$projects}}</h3>
                            <span>Projects</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-users"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$allClients}}</h3>
                            <span>Clients</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-users"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$allVendors}}</h3>
                            <span>Vendors</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-edit"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$tasks}}</h3>
                            <span>Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-edit"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$activeTasks}}</h3>
                            <span>Active Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-edit"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$completeTasks}}</h3>
                            <span>Completed Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-edit"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$pendingTasks}}</h3>
                            <span>Pending Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <div class="card-body">
                        <span class="dash-widget-icon"><i class="la la-user"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$employee}}</h3>
                            <span>Employees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@include('pages.includes.footer')