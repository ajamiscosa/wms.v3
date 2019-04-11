@php
$count = 0;
$product = $lineItem->Product();
@endphp

<style>
    .middle-center {
        display: inline-flex;
        align-items: center;
        padding: auto;
    }
</style>
<form method="post" action="/order-item/store" id="createOrderItemForm{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}">
    {{ csrf_field() }}
    <input type="hidden" name="LineItem" value="{{ $lineItem->ID }}"/>
    <input type="hidden" name="OrderNumber" value="{{ $lineItem->OrderNumber }}"/>
<div class="card card-danger card-outline flat"> <!--  collapsed-card-->
    <div class="card-header">
        <div class="middle-center"><i class="far fa-file-alt pt-1"></i>&nbsp;&nbsp;<strong>Available Quotations</strong></div>
        <a href="#" class="btn btn-flat btn-danger btn-sm float-right" id="btn{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}">Approve Quotation</a>
    </div>
    <div class="card-body">
        <table class="table table-secondary table-bordered table-responsive-lg">
            <tr>
                <th></th>
                <th>Supplier</th>
                <th>Valid Until</th>
                <th class="text-right">Quoted Price</th>
                <th>Quote Document</th>
            </tr>
            @if(count($product->ValidQuotes())>0)
                @foreach($product->ValidQuotes() as $quote)
                    <tr>
                        <td class="text-center">
                            <input type="radio" class="radio iradio_square-red" name="Quote" id="{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}" value="{{ $quote->ID }}"/>
                        </td>
                        <td class="supplierName">[{{ $quote->Supplier()->Code }}] {{ $quote->Supplier()->Name }}</td>
                        <td>{{ $quote->ValidFrom->addDays($quote->Validity)->format("F d, Y") }}</td>
                        <td class="quote text-right">
                            {{ $quote->Currency()->Code }} {{ number_format($quote->Amount,2,'.',',') }}
                            <input type="hidden" class="actual-price" value={{ $quote->Amount }} />
                            <input type="hidden" class="currency-code" value={{ $quote->Currency()->Code }} />
                        </td>
                        @if($quote->FileName=="N/A")
                            <td>No Attached File</td>
                        @else
                            <td><a href="/quotes/{{ $quote->FileName }}">Download</a></td>
                        @endif
                    </tr>
                    @php($count++)
                @endforeach
                @if($count==0)
                    <tr>
                        <td colspan="4">No Available Data</td>
                    </tr>
                @endif
            @else
                <tr>
                    <td colspan="4">No Available Data</td>
                </tr>
            @endif
        </table>
    </div>
</div>
</form>
<script>
    var x = $(".radio").iCheck({
        radioClass: 'iradio_square-red'
    });
    // dis function fo proper initial check boi.
    x.each(function (e) {
        var id = "{{$product->PreferredQuote()->ID}}";
        if($(x[e]).val()==id) {
            $(x[e]).iCheck('check');
        }
    })
</script>

<script type="text/javascript">
    $(document).on('click','#btn{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}', function(e){
        e.preventDefault();
        var tr = $("input[id='{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}']:checked").closest('tr');
        var supplierName = tr.find('.supplierName').text();
        swal({
            html: true,
            title: 'Confirm Action',
            text: "Do you wish to accept the quotation from <br/><strong>"+supplierName+"</strong>?",
            type: 'warning',
            showConfirmButton: true,
            showCancelButton: true,
            confirmButtonColor: '#DC3545',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        },function(x){
            if(x) {
                $("#createOrderItemForm{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}").submit();
            } else {

            }
        });

    });

    $(document).on('ifChecked','#{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}',function(){
        var row = $("#X{{ $lineItem->OrderNumber }}-{{ $lineItem->ID }}");
        var amt = row.find('td.quote-amount');
        var srp = row.find('td.total-price');
        var qty = row.find('td.total-quantity');

        var quoteID = row.find('input[type=hidden].SelectedQuote');
        var quoteField = $(this).closest('tr').find('.quote');
        quoteID.val($(this).val());
        console.log($(this).val());
        var rsID = row.find('input[type=hidden].Requisition');
        var lineItemID = row.find('input[type=hidden].LineItem');
        var actualID = row.find('.checkSingle');
        actualID.val(lineItemID.val()+'-'+rsID.val()+'-'+quoteID.val());

        var amtField = $(this).closest('tr').find('.actual-price');
        var curField = $(this).closest('tr').find('.currency-code');

        srp.text(curField.val()+" "+addCommas(number_format(amtField.val()*qty.text(),2,'.',',')));



        amt.text(quoteField.text());
        // this fucking done now.

    });

    function number_format (number, decimals, dec_point, thousands_sep) {

        number = (number + '').replace(/[^0-9+-Ee.]/g, '');
        var n = !isFinite(+number) ? 0 : +number,
            prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
            sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
            dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
            s = '',
            toFixedFix = function (n, prec) {
                var k = Math.pow(10, prec);
                return '' + Math.round(n * k) / k;
            };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
            s[0] = s[0].replace(/B(?=(?:d{3})+(?!d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
            s[1] = s[1] || '';
            s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
    }
    function addCommas(nStr){
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>