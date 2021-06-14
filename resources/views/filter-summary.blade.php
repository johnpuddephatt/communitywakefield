@if( $filters->summary )
<div class="entry-filter">
  <div>
    <span>Filters:<span>
        @foreach ($filters->summary as $filter => $value)
        <span class="badge">{{ $value['label'] }}
          <a class="button" href="{{ $value['reset_url']}}">Clear
            <x-icon.cross /></a>
        </span>
        @endforeach
  </div>
</div>
@endif