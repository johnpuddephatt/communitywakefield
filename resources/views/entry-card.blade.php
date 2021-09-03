<div class="entry-card">
  <div class="entry-card--header">
    @if($entry->is_new())
    <div class="entry-card--new-badge">New!</div>
    @endif
    <h3 class="entry-card--title"><a
        href="{{ route(($route ?? 'volunteer.single'), ['team' => $entry->team->slug, strtolower(basename(str_replace('\\', '/', get_class($entry)))) => $entry->slug]) }}">{{$entry->title}}</a>
    </h3>
    <div class="entry-card--organisation">{{ $entry->team->name }}</div>
  </div>
  <p class="entry-card--intro">{!! $entry->intro !!}</p>
  <div class="entry-card--footer">
    <div class="entry-card--footer--left">
      <span class="entry-card--hours">
        <x-icon.clock />{{ $entry->hours ? $entry->hours . ' hrs / week' : 'Flexible hours' }}</span>
    </div>
    <div class="entry-card--footer--right">
      @if($entry->from_home)
      <span class="entry-card--location">
        <x-icon.house />From home</span>
      @elseif($entry->address_ward)
      <span class="entry-card--location">
        <x-icon.map-marker />{{ $entry->address_ward }}</span>
      @endif
      @if($entry->latitude && $entry->distance)
      <span class="entry-card--distance">{{ round($entry->distance, 1) }} miles away</span>
      @endif
    </div>
  </div>
</div>