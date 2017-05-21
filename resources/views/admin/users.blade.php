@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">Admin panel</h3>
    <ul class="nav nav-tabs">
      <li role="presentation" class="active">
        <a href="#">
          <span>Users</span>
          <strong>({{ $users->count() }})</strong>
        </a>
      </li>
    </ul>
    <br>

    <div class="collapse in" id="js-history-form-container">
      <form action="{{ secure_url('admin/users') }}" class="form-inline well" id="js-users-form">
        <div class="form-group">
          <input class="form-control" name="keyword" id="js-users-search" placeholder="Search" value="{{ $keyword }}">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" id="js-users-submit-button">Search</button>
        </div>
      </form>
    </div>

    <table class="table table-condensed table-striped table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Email</th>
          <th>Name</th>
          <th>Devices</th>
          <th>Registered</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($users as $user)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>
            <a href="{{ secure_url('admin/users', [ $user->id ]) }}">{{ $user->email }}</a>
          </td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->devices->count() }}</td>
          <td>{{ date('d-m-Y', strtotime($user->created_at)) }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

  @push('scripts')
  {{--<script src="/js/history.js"></script>--}}
  @endpush
@endsection
