<form role="form"  method="POST" action="{{ url('/admin/subscription') }}">
  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{ $plan ? $plan->id : '' }}">
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="control-label">Name</label>
    <input id="name" class="form-control" name="name" value="{{ $plan ? $plan->name : '' }}" required autofocus>
    @if ($errors->has('name'))
      <span class="help-block">
        <strong>{{ $errors->first('name') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('devices') ? ' has-error' : '' }}">
    <label for="devices" class="control-label">Devices</label>
    <input id="devices" class="form-control" name="devices" value="{{ $plan ? $plan->devices : '' }}" required autofocus>
    @if ($errors->has('devices'))
      <span class="help-block">
        <strong>{{ $errors->first('devices') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('days') ? ' has-error' : '' }}">
    <label for="days" class="control-label">Days</label>
    <input id="days" class="form-control" name="days" value="{{ $plan ? $plan->days : '' }}" required autofocus>
    @if ($errors->has('days'))
      <span class="help-block">
        <strong>{{ $errors->first('days') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
    <label for="price" class="control-label">Price</label>
    <input id="price" class="form-control" name="price" value="{{ $plan ? $plan->price : '' }}" required autofocus>
    @if ($errors->has('price'))
      <span class="help-block">
        <strong>{{ $errors->first('price') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group text-right">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
