@extends('frontend', ['classes' => 'single-pattern'])

@section('content')
<div class="container container__row-reverse container__full entry-single">
  <div class="entry-single--main">
    <h2 class="entry-single--title">{{ $entry->title }}</h2>
    <div class="entry-single--intro">{{$entry->team->name}}</div>

    @if (session('message'))
    <div class="alert alert-success">
      {{ session('message') }}
    </div>
    @endif

    <form method="POST" action="{{ Request::url() }}" class="opportunity-form">
      @csrf
      <div class="form-group">
        <label for="name" class="control-label">Name</label>
        <input name="name" type="text" id="name" class="input">
      </div>
      <div class="form-group">
        <label for="email" class="control-label">Email</label>
        <input name="email" type="text" id="email" class="input">
      </div>
      <div class="form-group">
        <label for="phone" class="control-label">Phone</label>
        <input name="phone" type="text" id="phone" class="input"></div>
      <div class="form-group">
        <label for="message" class="control-label">Message</label>
        <textarea rows="5" name="message" cols="50" id="message" class="input"></textarea>
      </div>
      <button type="submit" class="button">Submit</button>
    </form>
  </div>
</div>
@endsection