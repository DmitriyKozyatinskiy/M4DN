@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">Login as admin</div>
          <div class="panel-body">
            @if (session('confirmation-success'))
              <div class="alert alert-success">
                {{ session('confirmation-success') }}
              </div>
            @endif
            @if (session('confirmation-danger'))
              <div class="alert alert-danger">
                {!! session('confirmation-danger') !!}
              </div>
            @endif
            <form class="form-horizontal" role="form" method="POST" action="{{ secure_url('/admin') }}">
              {{ csrf_field() }}
              <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password" required>

                  @if ($errors->has('password'))
                    <span class="help-block">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                  <button type="submit" class="btn btn-primary">Login as admin</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
