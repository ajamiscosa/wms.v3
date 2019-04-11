<!-- small box -->
<div class="small-box {{ $box['background'] }}">
    <div class="inner">
        <h3>{{ $box['text'] }}</h3>
        @if(isset($box['subtext']))
        <p>{{ $box['subtext'] }}</p>
        @endif
    </div>
    <div class="icon">
        <i class="{{ $box['icon'] }}"></i>
    </div>
    <a href="{{ $box['link'] }}" class="small-box-footer">{{ $box['linktext']}} <i class="fa fa-arrow-circle-right"></i></a>
</div>