@extends('frontend', ['classes' => 'double-pattern no-fade'])

@section('content')

<div class="home-hero--image"></div>

<section class="section section__home-hero">

    <div class="container">
    <div class="hero--search-box--container">
      <div class="hero--search-box">
        <h2 class="hero--search-box--title">Find the volunteering opportunity that’s right for you.</h2>
        <form method="GET" action="{{ route('opportunities.index', Request()->all()) }}">
          @csrf
          <input class="input" type="text" name="postcode" placeholder="Enter postcode">
          <input class="button" type="submit" value="Find opportunities" />
        </form>
        <p>Alternatively, <a href="{{ route('opportunities.index')}}">view all opportunities</a>
      </div>
    </div>
  </div>
</section>

@if(isset($opportunities) && count($opportunities))
  <section class="section section__home-opportunities">
    <div class="container">
      <h2 class="section-title">Latest opportunities</h2>
      @foreach($opportunities as $opportunity)
          @include('entry-card', ['route' => 'opportunities.single', 'entry' => $opportunity])
      @endforeach
      <div class="home-opportunities--footer">
        <a href="{{ route('opportunities.index')}}">view all opportunities</a>
      </div>
    </div>
  </section>
@endif

{{-- @if(isset($categories) && count($categories) >= 4)
  <section class="section section__home-categories">
    <h2 class="section-title">Explore by category</h2>
    <div class="home-categories-scroller scroller-outer">
      <div class="home-categories-inner scroller-inner">
        @foreach($categories as $category)
          <a href="{{ url('opportunities?category=' . $category->slug)}}" class="home-category">
            @if($category->image)
              <img class="home-category--image" src="{{ $category->image }}" />
            @else
              <img class="home-category--image" src="//placehold.it/320x240?text=×" />
            @endif
            <div class="home-category--text">
              {{ $category->label }}
            </div>
          </a>
        @endforeach
      </div>

      <div class="scroller-navigation">
        <button class="scroller-previous" tabindex="-1">
          <svg viewBox="0 0 18 18" aria-label="Previous" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg>
        </button>
        <button class="scroller-next">
          <svg viewBox="0 0 18 18"  aria-label="Next" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg>
        </button>
      </div>
    </div>
  </section>
@endif

@if(isset($locations) && count($locations) >= 3)
  <section class="section section__home-locations">
    <h2 class="section-title">Search by location</h2>

    <div class="container">
      @foreach($locations as $location)
        <a class="home-location" href="{{ route('volunteer.opportunity.index', ['location' => $location->slug ] )}}">
          <div class="home-location--text">
            {{ $location->label }}
            @include('icons.arrow')
          </div>
        </a>
      @endforeach
    </div>
  </section>
@endif

<section class="section section__home-casestudies">
  <div class="case-study--text">
    <div class="container">
      <h2 class="case-study--title">Volunteer to show you care</h2>
      <p>Every year thousands of people across Wakefield give something back by volunteering.</p>
    </div>
    @include('icons.arrow')
  </div>
  <div class="case-study--image">
    <img src="/images/home-casestudies.jpg"/>
  </div>
</section>

@if(isset($suitabilities) && count($suitabilities) >= 3)
  <section class="section section__home-suitabilities">
    <h2 class="section-title">Find the opportunity that’s right for you</h2>
    <div class="home-categories-scroller scroller-outer" data-slideby=".334">

      <div class="container scroller-inner">
        @foreach($suitabilities as $suitability)
          <a class="home-suitability" href="{{ route('volunteer.opportunity.index', ['suitability' => $suitability->slug ] )}}">
            <div class="home-suitability--text">
              @include('icons.arrow')
              {{ $suitability->label }}
            </div>
            @if($suitability->image)
              <img class="home-suitability--image" src="{{ $suitability->image }}" />
            @else
              <img class="home-suitability--image" src="//placehold.it/350x525" />
            @endif
          </a>
        @endforeach
      </div>

      <div class="scroller-navigation">
        <button class="scroller-previous" aria-label="Previous" tabindex="-1">
          <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg>
        </button>
        <button class="scroller-next" aria-label="Next">
          <svg viewBox="0 0 18 18" role="presentation" aria-hidden="true" focusable="false" style="height: 1em; width: 1em; display: block; fill: currentcolor;"><path d="m4.29 1.71a1 1 0 1 1 1.42-1.41l8 8a1 1 0 0 1 0 1.41l-8 8a1 1 0 1 1 -1.42-1.41l7.29-7.29z" fill-rule="evenodd"></path></svg>
        </button>
      </div>
    </div>
  </section>
@endif --}}

@endsection
