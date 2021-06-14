@extends('frontend', ['classes' => 'double-pattern'])

@section('content')
<div class="container container__row container__center">

    <div class="entry-index--wrapper">
        <label class="button" for="sidebar-trigger">Filter {{ $name }}</label>
        <input id="sidebar-trigger" type="checkbox" class="entry-index--sidebar--trigger">
        @include('index-sidebar')

        <div class="card">
            <div class="card-header">
                @if($location)
                <a href="{{ route(strtolower($name) . '.index') }}">
                    <x-icon.arrow-left /> View all {{ $name}}</a>
                @endif
                <div>
                    <h2 class="card-title">{{ $name }} {{$location ? "near " . $location->name : NULL }}</h2>
                    @if( $filters->summary )
                    <span>Showing {{ $entries->total() }} {{ $name }}</span>
                    @else
                    {{-- Viewing all {{ $name }} --}}
                    @endif
                </div>
            </div>

            <div class="card-body">
                @include('filter-summary')
                @forelse($entries as $entry)
                @include('entry-card', [ 'route' => strtolower($name) . '.single', 'entry' => $entry ])
                @empty
                <div class="placeholder">
                    No {{ $name }} to show you.
                </div>
                @endforelse
            </div>

            <div class="card-footer">
                {{ $entries->appends(request()->input())->render() }}
            </div>
        </div>
    </div>
</div>
@endsection