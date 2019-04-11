<div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
    <table id="approvedTable" class="table table-responsive-lg dataTable dtr-inline" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
        <thead>
        <tr role="row">
            <th>Purchase Order #</th>
            <th>Vendor</th>
            <th>Date Created</th>
            <th class="text-right">Total Price</th>
            <th>Status</th>
        </tr>
        </thead>
        <tfoot>
        <tr>
            <th>PO #</th>
            <th>Vendor</th>
            <th>Date Created</th>
            <th class="text-right">Total Price</th>
            <th>Status</th>
        </tr>
        </tfoot>
        <tbody>

        </tbody>
    </table>
</div>

@section('scripts')
    <script>
        $(function () {
            var pathname = window.location.pathname;

            var approvedTable = $('#approvedTable').DataTable( {
                serverSide: false,
                processing: true,
                searching: true,
                ajax: pathname+'/data/A',
                dataSrc: 'data',
                columns: [
                    { data:"OrderNumber", orderable: false },
                    { data:"Supplier", orderable: false },
                    { data:"OrderDate", orderable: false },
//                    { data:"DeliveryDate", orderable: false },
                    { data:"Total", orderable: false, class:"text-right" },
                    { data:"Status", orderable: false }
                ],
                columnDefs: [
                    {
                        render: function ( data, type, row ) {
                            return '<a href="/purchase-order/view/'+data+'">'+data+'</a>';
                        },
                        targets: 0
                    }
                ],
                pagingType: "full_numbers",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search Purchase Order",
                    infoFiltered: ""
                }
            } );
        });

    </script>
@endsection