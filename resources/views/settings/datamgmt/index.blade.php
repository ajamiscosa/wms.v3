@extends('templates.content',[
    'title'=>'Data Management',
    'description'=>'Manage System Data',
    'breadcrumbs' => [
        \App\Classes\Breadcrumb::create('Home','/'),
        \App\Classes\Breadcrumb::create('Data Management')
    ]
])
@section('styles')
@endsection
@section('content')
    <div class="col-lg-4 col-md-12">
        <div class="card card-danger card-outline flat"> <!--  collapsed-card-->
            <div class="card-header card-header-text">

            </div>
            <div class="card-body" style="padding-top: 4px;">
                <hr>
                <strong><i class="fa fa-box-open mr-1"></i> Product Data</strong>
                <p class="text-muted">

                <div class="form-group">
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input btn-flat" id="productData" accept=".csv">
                            <label class="custom-file-label flat" for="exampleInputFile">Choose file</label>
                        </div>
                    </div>
                    <button class="btn btn-block btn-danger btn-flat mt-2" id="btnProcess">Process</button>
                    <div class="progress mt-2">
                        <div class="progress-bar bg-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </div>
                </p>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#productData').on('change', function(e){
            var file = $('#productData').prop('files')[0];
            var formData = new FormData();
            formData.append("file", file);

            if (file) {
                var reader = new FileReader();
                reader.readAsText(file, "UTF-8");
                reader.onload = function (evt) {
                    var lines = evt.target.result.split('\n');
                    console.log(lines.length);
                    for(var i=0;i<lines.length;i++) {
                        var data = lines[i].split(',');
                        $.ajax({
                            async: false,
                            url: "/data-management/product/add",
                            method: "POST",
                            data: {
                                Name: data[0],
                                Description: data[1],
                                Status: data[2],
                                LastUnitCost: data[4],
                                InventoryGL: data[9],
                                IssuanceGL: data[10],
                                Location: data[11],
                                UOM: data[12],
                                MinimumQuantity: data[7],
                                Quantity: data[5],
                                OldID: data[13]
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(datax) {
                            },
                            error: function(xhr, status, error) {
                                console.log(data);
                                console.log(xhr.responseText);
                            }
                        });
                    }
                };
                reader.onerror = function (evt) {
                    console.log(evt.target.result);
                };
            }
            return;

            console.log(file);
            $('.custom-file-label').text(file.name);
        });
    </script>
@endsection
