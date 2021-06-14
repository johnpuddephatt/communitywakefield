@if ($message = Session::get('success'))
<div class="alert--wrapper fixed autodismiss">
  <div class="alert alert__success">
    <strong>{{ $message }}</strong>
  </div>
</div>
@endif


@if ($message = Session::get('error'))
<div class="alert--wrapper fixed">
  <div class="alert alert__danger">
  	<button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
  </div>
</div>
@endif


@if ($message = Session::get('warning'))
<div class="alert--wrapper fixed ">
  <div class="alert alert__warning">
  	<strong>{{ $message }}</strong>
  </div>
</div>
@endif


@if ($message = Session::get('info'))
  <div class="alert--wrapper fixed  autodismiss">
  <div class="alert alert__info">
  	<strong>{{ $message }}</strong>
  </div>
</div>
@endif

@if ($errors->any())
<div class="alert--wrapper fixed autodismiss">
  <div class="alert alert__danger">
  	Please check the form below for errors
  </div>
</div>
@endif
