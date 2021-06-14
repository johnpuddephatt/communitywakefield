<footer class="primary-footer">
  <div class="container container__wide">
    <div class="primary-footer--left">
      <h3 class="footer-brand">
          {!! convert_name_to_logo(config('settings.name'))!!}
      </h3>
      <nav>
          @foreach(config('settings.footer_navigation') as $key => $value)
            <a href="{{ $value }}">{{ $key }}</a>
          @endforeach
      </nav>
    </div>
    <div class="primary-footer--right">
      <h3>Contact Us</h3>
      {{-- <div>Call: +44 (0)12 3456 7890</div> --}}
      <div>Email: <a href="mailto:{{ config('settings.email') }}">{{config('settings.email')}}</a></div>
      <div>©{{ date('Y') }} Nova Wakefield District Limited</div>
    </div>
  </div>
</footer>
