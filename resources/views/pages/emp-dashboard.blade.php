@include('pages.includes.emp-header')
<!-- Page Wrapper -->
<div class="page-wrapper">

    <!-- Page Content -->
    <div class="content container-fluid">
    
        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome {{$uname}}!</h3>
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
                        <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                        <div class="dash-widget-info">
                            <h3>{{$allemps}}</h3>
                            <span>Tasks</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
    </div>
    <!-- /Page Content -->

</div>
<!-- /Page Wrapper -->
@include('pages.includes.emp-footer')