
@extends('frontend')

@section('content')
    @if (session('subscribed'))
        <div class="alert alert-success">
            {{ session('subscribed') }}
        </div>
    @endif
    <div class="hero">
      <div class="container">
        <div class="hero__text">
          <h1 class="hero__title">Community <span></span> Wakefield</h1>
          <p class="hero__subtitle">The new place for services, activities, opportunities and events across Wakefield District</p>
          <p>We’ve put together this page to talk you through all the exciting features of the new Community Wakefield website.</p>
          <p>Want to know when it’s launching? <a href="#signup">Sign up here</a>.</p>
        </div>
        <div class="hero__image">
          <img src="/images/hero.png" />
        </div>
      </div>
    </div>

    <div class="intro">
      <div class="container intro__container">
        <img class="intro__image" width="480" height="480" src="/images/woman2.jpg" />
        <div class="intro__text">
            <div class="intro__pre-title">Purpose</div>
            <h2 class="intro__title">A service built around the needs of community-focused organisations and services.</h2>
            <ul class="intro__list">
                <li>Quickly and easily promote what you do</li>
                <li>Be found and contacted easily</li>
                <li>Receive referrals from health and wellbeing professionals</li>
            </ul>
        </div>
      </div>
    </div>

    <div class="feature feature--odd">
      <div class="container feature__container">
        @include('images.activities',['class' => 'feature__image'])
        <div class="feature__text">
            <div class="feature__pre-title">Easy</div>
            <h2 class="feature__title">Simple to use.</h2>
            <p>The content you add will look good without effort – just answer questions about things like who it’s suitable for and when and where it takes place and we’ll do the rest.</p>
            <p>By asking you the right questions, we’ll categorise your listing so it’s easy for people to find.</p>
        </div>
      </div>
    </div>

    <div class="feature">
      <div class="container feature__container">
        @include('images.login',['class' => 'feature__image'])
        <div class="feature__text">
            <div class="feature__pre-title">Effective</div>
            <h2 class="feature__title">Making your job easier.</h2>
            <p>You’ll receive emails reminding you when your listings need reviewing to keep them up to date.</p>
            <p>Have multiple team members able to manage your organisation’s listings, and create subteams which share your branding.</p>
        </div>
      </div>
    </div>

    <div class="feature feature--odd">
      <div class="container feature__container">
         @include('images.profile',['class' => 'feature__image'])
        <div class="feature__text">
            <div class="feature__pre-title">Integrated</div>
            <h2 class="feature__title">A service that’s well connected.</h2>
            <p>Manage your Community > Wakefield and Volunteer > Wakefield content all in one place.</p>
            <p>A widget will make it simple to display data from Community > Wakefield on your website. Use it to display your own listings, or content relevant to your audience – and know that it’ll be kept up to date automatically.</p>
        </div>
      </div>
    </div>

    <div class="accessibility">
        <div class="accessibility__pre-title container">Open and accessible</div>
        <h2 class="accessibility__title container">How we’re making design choices that benefit everyone</h2>

    <div class="container accessibility__container">

        <div class="accessibility__item">
          <div class="accessibility__item__text">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0" y="0" viewBox="0 0 101.739 101.739" xml:space="preserve" width="101.739" height="101.739"><style type="text/css" id="style833">.st10{fill:none;stroke:#ff03e1;stroke-width:8.2591;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10}</style><g id="g913" transform="translate(-1187.12 -798.48)"><path class="st10" d="M1284.73 845.08v4.3c-.01 25.81-20.95 46.73-46.77 46.71-25.81-.01-46.73-20.95-46.71-46.77.01-25.81 20.95-46.73 46.77-46.71 6.55 0 13.02 1.38 19 4.05" id="path909"/><path class="st10" id="polyline911" d="M1284.73 811.99l-46.74 46.79-14.02-14.02"/></g></svg>
            <h2 class="accessibility__item__title">Guided by the UK Government Digital Service Standard</h2>
            <p>We’re following service design principles that will benefit both organisations and users.</p>
          </div>
        </div>


        <div class="accessibility__item">
          <div class="accessibility__item__text">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0" y="0" viewBox="0 0 101.739 101.739" xml:space="preserve" width="101.739" height="101.739"><style type="text/css" id="style833">.st10{fill:none;stroke:#ff03e1;stroke-width:8.2591;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10}</style><g id="g913" transform="translate(-1187.12 -798.48)"><path class="st10" d="M1284.73 845.08v4.3c-.01 25.81-20.95 46.73-46.77 46.71-25.81-.01-46.73-20.95-46.71-46.77.01-25.81 20.95-46.73 46.77-46.71 6.55 0 13.02 1.38 19 4.05" id="path909"/><path class="st10" id="polyline911" d="M1284.73 811.99l-46.74 46.79-14.02-14.02"/></g></svg>
              <h2 class="accessibility__item__title">Following current accessibility guidelines</h2>
              <p>Targets full compliance with the latest Web Content Accessibility Guidelines (WCAG 2.1).</p>
          </div>
        </div>


        <div class="accessibility__item">
          <div class="accessibility__item__text">
              <svg xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0" y="0" viewBox="0 0 101.739 101.739" xml:space="preserve" width="101.739" height="101.739"><style type="text/css" id="style833">.st10{fill:none;stroke:#ff03e1;stroke-width:8.2591;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10}</style><g id="g913" transform="translate(-1187.12 -798.48)"><path class="st10" d="M1284.73 845.08v4.3c-.01 25.81-20.95 46.73-46.77 46.71-25.81-.01-46.73-20.95-46.71-46.77.01-25.81 20.95-46.73 46.77-46.71 6.55 0 13.02 1.38 19 4.05" id="path909"/><path class="st10" id="polyline911" d="M1284.73 811.99l-46.74 46.79-14.02-14.02"/></g></svg>
              <h2 class="accessibility__item__title">Enabling open data</h2>
              <p>Data on the platform will be available for use on other platforms through an API.</p>
          </div>
        </div>

    </div>
  </div>

  <div class="timeline">
    <div class="container timeline__container">
      <div class="timeline__text">
          <div class="timeline__pre-title">Timeline</div>
          <h2 class="timeline__title">Where we’re up to.</h2>
          <ul class="timeline__list">
              <li class="complete">
                  <h3>Consultation</h3>
                  <p>We’ve talked to community groups, council services and Wakefield residents to build a picture of what will make the service a success.</p>
              </li>
              <li class="complete">
                  <h3>Branding and system build</h3>
                  <p>We’ve developed a new brand identity for Community Wakefield that works in partnership with Volunteer Wakefield. The new system is currently being built.</p>
              </li>
              <li>
                  <h3>Launch to groups and services</h3>
                  <p>We’ll be inviting groups to set up an account and add their listings in advance of the public launch.</p>
              </li>
              <li>
                  <h3>District-wide public launch campaign</h3>
                  <p>We’ll be running a district-wide launch campaign in the coming months.</p>
              </li>
          </ul>

      </div>
      <div class="timeline__image">
          <img width="444" height="366" src="/images/man.jpg" />
          <img width="444" height="366" src="/images/three-women.jpg" />
      </div>

    </div>
  </div>

  <div class="signup" id="signup">
    <div class="container signup__container">
      <div class="signup__text">
        <h1 class="signup__title">Sign up to find out when we’re launching</h1>
        <div>

            <form action="{{ route('subscribers.store') }}" method="post">
                @csrf
                @if (session('subscribed'))
                    <div class="alert alert-success">
                        {{ session('subscribed') }}
                    </div>
                @else
                    <input name="email" size="30" type="text" class="input" placeholder="Enter your email address">
                    <input type="submit" class="button button--white" value="Sign me up!">
                @endif
            </form>
        </div>
      </div>
    </div>
  </div>



@endsection
