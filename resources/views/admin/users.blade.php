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
