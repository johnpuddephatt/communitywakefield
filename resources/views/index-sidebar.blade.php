<div class="entry-index--sidebar">
  @if(!$location)
  <button class="filter-heading">Location
    <x-icon.chevron-right /></button>
  <div class="filter-section">
    @if (isset($filters->summary->location))
    <span class="badge">{{ $filters->summary->location['label'] }}
      <a aria-label="Remove location filter" class="button" href="{{ $filters->summary->location['reset_url'] }}">Clear
        <x-icon.cross /></a>
    </span>
    @elseif(isset($filters->summary->postcode))
    <span class="badge">{{ $filters->summary->postcode['label'] }}
      <a aria-label="Remove postcode filter" class="button" href="{{ $filters->summary->postcode['reset_url'] }}">Clear
        <x-icon.cross /></a>
    </span>
    @else
    <form class="filter-postcode-form" method="GET" action="{{ Request::url() }}">
      <input class="input" type="text" name="postcode" placeholder="Enter postcode">
      <button class="button" type="submit" aria-label="Submit postcode">
        <x-icon.search /></button>
      @foreach($_GET as $key => $value)
      <input type="hidden" name="{{ strip_tags($key) }}" value="{{ strip_tags($value) }}" />
      @endforeach
    </form>
    @endif
  </div>
  @endif
  @if(isset($filters->options->categories) && $filters->options->categories->count())
  <button class="filter-heading">Categories
    <x-icon.chevron-right /></button>
  <div tabindex="-1" class="filter-section">
    @if (isset($filter->summary->category))
    <span class="badge">{{ $filter->summary->category['label'] }}
      <a class="button" href="{{ $filter->summary->category['reset_url'] }}">Clear
        <x-icon.cross /></a>
    </span>
    @else
    @foreach($filters->options->categories as $category)
    <a class="filter-link" href="{{ append_query(['categories'=>$category->slug]) }}">{{ $category->title }}</a>
    @endforeach
    @endif
  </div>
  @endif

  @if(!empty($filters->options->team))
  <button class="filter-heading">Organisation
    <x-icon.chevron-right /></button>
  <div tabindex="-1" class="filter-section">
    @if (isset($filters->summary->organisation))
    <span class="badge">{{ $filter->summary->organisation['label'] }}
      <a class="button" href="{{ $filter->summary->organisation['reset_url'] }}">Clear
        <x-icon.cross /></a>
    </span>
    @else
    @foreach($filters->options->team as $team)
    <a class="filter-link" href="{{ append_query(['team' => $team->slug ]) }}">{{ $team->name }}</a>
    @endforeach
    @endif
  </div>
  @endif

  @if(!empty($filters->options->suitabilities))
  <button class="filter-heading">Suitable for
    <x-icon.chevron-right /></button>
  <div class="filter-section">
    @if (isset($filter->summary->suitability))
    <span class="badge">{{ $filter->summary->suitability['label'] }}
      <a class="button" href="{{ $filter->summary->suitability['reset_url'] }}">Clear
        <x-icon.cross /></a>
    </span>
    @else
    @foreach($filters->options->suitabilities as $suitability)
    <a class="filter-link"
      href="{{ append_query(['suitability' => $suitability->slug ]) }}">{{ $suitability->title }}</a>
    @endforeach
    @endif
  </div>
  @endif
  <div class="filter-section spacer"></div>
</div>