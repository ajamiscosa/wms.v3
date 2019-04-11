<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header flat">
        <h3 class="card-title"><strong>Product Consumption Details: </strong> {{ $data->UniqueID }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">

        <div class="card">
            <div class="card-header no-border">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">Monthly Consumption</h3>
                    <a href="javascript:void(0);">View Report</a>
                </div>
            </div>
            <div class="card-body">
                <div class="position-relative mb-4">
                    <canvas id="visitors-chart" height="200"></canvas>
                </div>
            </div>
        </div>
        <!-- /.card -->

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->