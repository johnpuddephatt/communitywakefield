@extends('frontend', ['classes' => 'single-pattern'])

@section('content')

<div class="container container__row-reverse entry-single">
  <div class="entry-single--main">
    <div class="entry-single--title-wrapper">
      <h2 class="entry-single--title">{{ $entry->title}}</h2>
      <a class="button button__secondary entry-single--enquire-button"
        href="{{ route(strtolower(get_class($entry)::$name) . '.enquire', ['entry' => $entry ])}}">Enquire</a>
    </div>
    <div class="entry-single--intro">{{ $entry->intro }}</div>

    <div class="entry-single--key-features">
      @if(isset($entry->cost))
      <span class="entry-single--key-feature">
        <x-icon.cost /> {{ $entry->cost ? $entry->cost : 'Free' }}</span>
      @endif
      @if(isset($entry->hours))
      <span class="entry-single--key-feature">
        <x-icon.clock /> {{ $entry->hours ? $entry->hours . ' hrs / week' : 'Flexible hours' }}</span>
      @endif
      @if(isset($entry->start_date))
      <span class="entry-single--key-feature">
        <x-icon.calendar /> {{ $entry->date_range() }}</span>
      @endif
      @if($entry->address_ward && isset($entry->address['value']))
      <span class="entry-single--key-feature">
        <x-icon.map-marker /> {{ $entry->address_ward }} <a target="_blank"
          href="https://maps.google.com/?q={{ urlencode($entry->address['value']) }}">view map</a></span>
      @endif
    </div>

    <div class="entry-single--description">
      {!! $entry->content !!}

      @if($entry->qualification)
      <div class="entry-single--qualification">
        <h3>Qualification</h3>
        {!! nl2br(htmlspecialchars($entry->qualification)) !!}
      </div>
      @endif

      @if($entry->times)
      <div class="entry-single--times">
        <h3>Times</h3>
        {!! nl2br(htmlspecialchars($entry->times)) !!}
      </div>
      @endif

      @if($entry->booking_link || $entry->booking_instructions)
      <div class="entry-single--book">
        <h3>How to book</h3>
        {!! nl2br(htmlspecialchars($entry->booking_instructions)) ?? 'You can book using the button below.' !!}
        @if($entry->booking_link)
        <a href="{{ $entry->booking_link }}" target="_blank" class="button">Book</a>
        @endif
      </div>
      @endif

      @if($entry->directions)
      <div class="entry-single--expenses">
        <h3>Directions</h3>
        {!! nl2br(htmlspecialchars($entry->directions)) !!}
      </div>
      @endif

      @if($entry->what_to_bring)
      <div class="entry-single--expenses">
        <h3>What to bring</h3>
        {!! nl2br(htmlspecialchars($entry->what_to_bring)) !!}
      </div>
      @endif

      @if($entry->expenses)
      <div class="entry-single--expenses">
        <h3>Expenses</h3>
        {!! nl2br(htmlspecialchars($entry->expenses)) !!}
      </div>
      @endif
    </div>

    @if($entry->deadline)
    <div class="entry-single--deadline alert alert__info">Deadline:
      <strong>{{ date("D jS F, Y", strtotime($entry->deadline)) }}</strong></div>
    @endif

    <div class="entry-single--other-features">

      @if($entry->places)
      <div>
        <h3>Places</h3>
        {{ $entry->places }}
      </div>
      @endif
      @if($entry->categories && $entry->categories->count())
      <div>
        <h3>Categories</h3>
        {{ $entry->categories->pluck('title')->join(', ') }}
      </div>
      @endif

      @if($entry->suitabilities && $entry->suitabilities->count())
      <div>
        <h3>Suitable for</h3>
        {{ $entry->suitabilities->pluck('title')->join(', ') }}
      </div>
      @endif

      @if($entry->accessibilities && $entry->accessibilities->count())
      <div>
        <h3>Accessibility</h3>
        {{ $entry->accessibilities->pluck('title')->join(', ') }}
      </div>
      @endif

      @if($entry->minimum_age && $entry->maximum_age)
      <div>
        <h3>Age range</h3>
        {{ $entry->minimum_age }} – {{ $entry->maximum_age }}
      </div>
      @elseif($entry->minimum_age)
      <div>
        <h3>Minimum age</h3>
        {{ $entry->minimum_age }}
      </div>
      @elseif($entry->maximum_age)
      <div>
        <h3>Maximum age</h3>
        {{ $entry->maximum_age }}
      </div>
      @endif

      @if($entry->skills_gained && $entry->skills_gained->count())
      <div>
        <h3>Skills gained</h3>
        {{ is_array($entry->skills_gained) ? implode(', ', $entry->skills_gained) : $entry->skills_gained}}
      </div>
      @endif

      @if($entry->skills_needed && $entry->skills_needed->count())
      <div>
        <h3>Skills needed</h3>
        {{ is_array($entry->skills_needed) ? implode(', ', $entry->skills_needed) : $entry->skills_needed}}
      </div>
      @endif

      @if($entry->requirements && $entry->requirements->count())
      <div>
        <h3>Requirements</h3>
        {{ is_array($entry->requirements) ? implode(', ', $entry->requirements) : $entry->requirements}}
      </div>
      @endif
    </div>
  </div>
  <div class="entry-single--sidebar">

    @if($entry->team->photo)
    <img class="entry-single--sidebar--photo" src="{{ $entry->team->photo }}" />
    @else
    <img class="entry-single--sidebar--photo" src="/images/community-wakefield-placeholder.svg" />
    @endif
    @if($entry->team->logo)
    <img class="entry-single--sidebar--logo" src="{{ $entry->team->logo }}" />
    @endif
    <h3 class="entry-single--sidebar--name">{{ $entry->team->name }}</h3>
    @if($entry->subteam)
    <h3 class="entry-single--sidebar--name">{{ $entry->subteam->name }}</h3>
    @endif
    @if($entry->team->address && isset($entry->team->address['value']))
    <div class="entry-single--sidebar--address">{{ $entry->team->address['value'] }}</div>
    @endif
    @if($entry->team->info)
    <div class="entry-single--sidebar--info">{!! nl2br($entry->team->info) !!}</div>
    @endif
    @if($entry->phone)
    <div class="entry-single--sidebar--phone">
      <x-icon.phone /> {{ $entry->phone }}</div>
    @endif
    @if($entry->email)
    <div class="entry-single--sidebar--email">
      <x-icon.email /> <a href="mailto:{{ $entry->email }}">{{ $entry->email }}</a></div>
    @endif
    {{-- <a class="button button__inverted" href="{{ route('entry.index') }}?{{ http_build_query(['organisation' => $entry->team->slug]) }}">See
    all opportunities with this organisation</a> --}}
  </div>
  @endsection