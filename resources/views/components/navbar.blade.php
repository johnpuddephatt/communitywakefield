<nav class="navbar navbar__primary">
    <div class="container container__wide">
        <a class="navbar--brand" href="{{ url('/') }}">
            {!! convert_name_to_logo(config('settings.name'))!!}
        </a>
        <button class="navbar--toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <x-icon.menu />
        </button>

        <div class="navbar--navs">
            <!-- Left Side Of Navbar -->
            <ul class="navbar--nav">
                @foreach(config('settings.primary_navigation') as $key => $value)
                <li class="nav-item">
                    <a class="nav-link" href="{!! $value !!}">{{ $key }}</a>
                </li>
                @endforeach
            </ul>
            <ul class="navbar--nav navbar--nav__right">
                <li class="nav-item">
                    <a class="button button__inverted nav-link" href="{{ route('dashboard')}}">Manage listings</a>
                </li>
            </ul>
        </div>
</nav>
