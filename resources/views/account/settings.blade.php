@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Update account</div>
          <div class="panel-body">
            @if (session('settings-change-success'))
              <div class="alert alert-success">
                {{ session('settings-change-success') }}
              </div>
            @endif
            <a class="btn btn-link" href="{{ secure_url('account/billing') }}">Billing settings</a>
            <form class="form-horizontal" role="form" method="POST" action="{{ secure_url('/account/settings') }}">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label for="name" class="col-md-4 control-label">Name</label>
                <div class="col-md-6">
                  <input id="name" class="form-control" name="name" value="{{ Auth::user()->name }}"
                         required autofocus>

                  @if ($errors->has('name'))
                    <span class="help-block">
                      <strong>{{ $errors->first('name') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <label for="timezone-selector" class="col-md-4 control-label">Timezone</label>
                <div class="col-md-6">
                  {!! Timezone::selectForm('US/Central', 'Select a timezone', [
                    'class' => 'form-control',
                    'id' => 'js-timezone-selector',
                    'name' => 'timezone',
                  ]) !!}
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Update
                  </button>
                </div>
              </div>
            </form>

            <hr>

            <h4>Change Password</h4>
            <form class="form-horizontal" role="form" method="POST" action="{{ secure_url('/account/password') }}">
              {{ csrf_field() }}
              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>
                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password">
                  @if ($errors->has('password'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
              </div>
              <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password_confirmation" class="col-md-4 control-label">Confirm password</label>
                <div class="col-md-6">
                  <input id="password_confirmation" type="password" class="form-control" name="password_confirmation">
                </div>
              </div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">
                    Change Password
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    window.timezone = '<?php echo $timezone ?>';
  </script>
  <script src="/js/account_settings.js"></script>
  @endpush
@endsection
