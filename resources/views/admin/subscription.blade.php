<form role="form"  method="POST" action="{{ url('/admin/subscription') }}">
  {{ csrf_field() }}

  <input type="hidden" name="braintree_id" value="{{ $plan->id }}">
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
    <input id="hours" type="number" class="form-control" name="hours" value="{{ $hours ? $hours : '' }}" required
           autofocus placeholder="7">
    @if ($errors->has('hours'))
      <span class="help-block">
        <strong>{{ $errors->first('hours') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group text-right">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
