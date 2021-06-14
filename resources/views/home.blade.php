@extends('frontend', ['classes' => 'no-fade'])

@section('content')

<div class="home-hero--image"></div>
<x-icon.communitywakefield-hero />
<x-icon.heart />

<section class="section section__home-hero">

  <div class="container">
    <div class="hero--search-box--container">
      <div class="hero--search-box">
        <h2 class="hero--search-box--title">Find services, activities, opportunities &amp; events across
          Wakefield District.</h2>
        <form method="GET" action="{{ route('home.search') }}">
          <label for="hero-categories" class="hero--search-box--label">I’m looking for...</label>
          <select id="hero-categories" class="input hero--search-box--select" name="category" class="input">
            <option selected value="services">Services</option>
            {{-- <option value="opportunities">Volunteering</option> --}}
            <option value="courses">Courses</option>
            <option value="activities">Activities</option>
            <option value="events">Events</option>
          </select>
          <div class="hero--search-box--postcode">
            <input class="input" type="text" name="postcode" placeholder="Enter postcode">
            <button class="button" type="submit">
              Search
              <x-icon.search />
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

@if(count($locations))
<section class="section section__home-district">

  <div class="container">
    <h2 class="section-title">Search the district.</h2>
    <form method="POST">
      @csrf
      <p class="district--intro">Show me <select name="category" class="input">
          <option selected value="services">services</option>
          {{-- <option value="opportunities">volunteering</option> --}}
          <option value="courses">courses</option>
          <option value="activities">activities</option>
          <option value="events">events</option>
        </select> near to...</p>

      <div class="district--grid">
        @foreach($locations as $location)
        <button class="district--button" type="submit"
          formaction="{{ route('home.location', ['location' => $location->slug]) }}">
          {{ $location->name }}
          {!! $location->icon !!}
        </button>
        @endforeach
      </div>
    </form>
  </div>
</section>
@endif

<section class="section section__home-types">

  <div class="container container__wide">
    <h2 class="section-title">Find what you’re looking for.</h2>
    <div class="type--grid">
      <a href="{{ route('services.index') }}" class="type type__services">
        <img src="/images/home-services.jpg" alt="Woman working on laptop offering advice to another woman">
        <div class="type--text">
          <div>
            <h3 class="type--heading">Services</h3>
            <p>Access help and advice</p>
          </div>
          <x-icon.chevron-right />
        </div>
      </a>
      <a href="{{ route('activities.index') }}" class="type type__activities">
        <img src="/images/home-activities.jpg" alt="Older woman smiling as she takes part in an exercise class">
        <div class="type--text">
          <div>
            <h3 class="type--heading">Activities</h3>
            <p>Find something new to do</p>
          </div>
          <x-icon.chevron-right />
        </div>
      </a>
      <a href="{{ route('courses.index') }}" class="type type__courses">
        <img src="/images/home-courses.jpg" alt="Close up of person explaining an idea in a classroom">
        <div class="type--text">
          <div>
            <h3 class="type--heading">Courses</h3>
            <p>Learn something new</p>
          </div>
          <x-icon.chevron-right />
        </div>
      </a>
      <a href="{{ route('events.index') }}" class="type type__events">
        <img src="/images/home-events.jpg" alt="Band performing on stage">
        <div class="type--text">
          <div>
            <h3 class="type--heading">Events</h3>
            <p>See what’s happening</p>
          </div>
          <x-icon.chevron-right />
        </div>
      </a>
    </div>
  </div>
</section>

<section class="section section__home-pullout">

  <x-icon.pullout-lower />
  <x-icon.pullout-upper />
  <div class="container">
    <div class="pullout--image">
      <img src="/images/three-laughing-women.jpg" alt="Three woman stood laughing with each other" />
    </div>
    <h2 class="section-title">Together, for a happier, healthier Wakefield District</h2>

  </div>
</section>

@endsection