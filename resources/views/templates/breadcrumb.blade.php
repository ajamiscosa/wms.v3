<ol class="breadcrumb float-sm-right">
    @php($counter = 0)
    @foreach($breadcrumbs as $breadcrumb)
        @if($counter==0)
        <li class="breadcrumb-item"><a role="button" href="/">{{ $breadcrumb->description }}</a></li>
        @else
            @if($breadcrumb->hasLink())
                <li class="breadcrumb-item"><a role="button" href="{{ $breadcrumb->link }}">{{ $breadcrumb->description }}</a></li>
            @else
                <li class="breadcrumb-item active">{{ $breadcrumb->description }}</li>
            @endif
        @endif
        @php($counter++)
    @endforeach
</ol>
