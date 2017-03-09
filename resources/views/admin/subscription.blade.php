<form role="form"  method="POST" action="{{ url('/admin/subscription') }}">
  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{ $plan ? $plan->id : '' }}">
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="control-label">Name</label>
    <input id="name" class="form-control" name="name" value="{{ $plan ? $plan->name : '' }}"
           required autofocus placeholder="Name">
    @if ($errors->has('name'))
      <span class="help-block">
        <strong>{{ $errors->first('name') }}</strong>
      </span>
    @endif
  </div>

  {{--<div class="form-group{{ $errors->has('devices') ? ' has-error' : '' }}">--}}
    {{--<label for="devices" class="control-label">Devices</label>--}}
    {{--<input id="devices" class="form-control" name="devices" value="{{ $plan ? $plan->devices : '' }}" required autofocus>--}}
    {{--@if ($errors->has('devices'))--}}
      {{--<span class="help-block">--}}
        {{--<strong>{{ $errors->first('devices') }}</strong>--}}
      {{--</span>--}}
    {{--@endif--}}
  {{--</div>--}}

  <div class="form-group{{ $errors->has('hours') ? ' has-error' : '' }}">
    <label for="hours" class="control-label">Hours</label>
    <input id="hours" type="number" class="form-control" name="hours" value="{{ $plan ? $plan->hours : '' }}" required
           autofocus placeholder="7">
    @if ($errors->has('hours'))
      <span class="help-block">
        <strong>{{ $errors->first('hours') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
    <label for="price" class="control-label">Price</label>
    <input id="price" type="number" class="form-control" name="price" value="{{ $plan ? $plan->price : '' }}"
           autofocus placeholder="$">
    @if ($errors->has('price'))
      <span class="help-block">
        <strong>{{ $errors->first('price') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
    <label for="description" class="control-label">Description</label>
    <textarea id="description"
              class="form-control"
              name="description"
              placeholder="Description"
              required autofocus>{{ $plan ? $plan->description : '' }}</textarea>
    @if ($errors->has('description'))
      <span class="help-block">
        <strong>{{ $errors->first('description') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group text-right">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
