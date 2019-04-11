<div id="datatables_wrapper" class="dataTables_wrapper dt-bootstrap">
    <div class="row">
        <div class="col-sm-12">
            <table id="{{ $table['Name'] }}" class="table {{ $table['Classes'] }}" cellspacing="0" width="100%" style="width: 100%;" role="grid" aria-describedby="datatables_info">
                <thead>
                <tr role="row">
                    @foreach($table['Headers'] as $header)
                        <th class="{{ $header['Classes'] }}">{{ $header['Text'] }}</th>
                    @endforeach
                </tr>
                </thead>
                <tfoot>
                <tr>
                    @foreach($table['Headers'] as $header)
                        <th class="{{ $header['Classes'] }}">{{ $header['Text'] }}</th>
                    @endforeach
                </tr>
                </tfoot>
                <tbody>
                    @if(isset($rows) && count($rows)>0)
                    
                        @foreach($rows as $row)

                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>