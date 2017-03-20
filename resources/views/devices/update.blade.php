<form role="form"  method="POST" action="{{ secure_url('/devices/update') }}">
  {{ csrf_field() }}

  <input type="hidden" name="id" value="{{ $device ? $device->id : '' }}">
  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
    <label for="name" class="control-label">Name</label>
    <input id="name" class="form-control" name="name" value="{{ $device ? $device->name : '' }}" required autofocus>
    @if ($errors->has('name'))
      <span class="help-block">
        <strong>{{ $errors->first('name') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group{{ $errors->has('userAgent') ? ' has-error' : '' }}">
    <label for="userAgent" class="control-label">User agent</label>
    <input id="userAgent" class="form-control" name="userAgent" value="{{ $device ? $device->userAgent : '' }}" autofocus>
    @if ($errors->has('userAgent'))
      <span class="help-block">
        <strong>{{ $errors->first('userAgent') }}</strong>
      </span>
    @endif
  </div>

  <div class="checkbox">
    <label>
      <input type="checkbox" name="useCurrentUserAgent"> Use current browser settings
    </label>
  </div>

  <div class="form-group text-right">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form>
