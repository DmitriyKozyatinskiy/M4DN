@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">Admin panel</h3>
    <ul class="nav nav-tabs">
      <li role="presentation">
        <a href="{{ secure_url('admin/users') }}">
          <span>Users</span>
        </a>
      </li>
    </ul>
    <br>
    <ul>
      <li>Name: {{ $user->name }}</li>
      <li>Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a></li>
      <li>Registered at: {{ $user->created_at }}</li>
      <li>Last record date: {{ $lastRecordDate }}</li>
      <li>Is admin: {{ $user->isAdmin ? 'Yes' : 'No' }}</li>
      <li>Is subscribed: {{ $user->is_subscribed ? 'Yes' : 'No' }}</li>
      <li>Card brand: {{ $user->card_brand }}</li>
      <li>Card last four: {{ $user->card_last_four }}</li>
    </ul>

    <h4>
      <span>Devices </span>
      <strong>({{ $user->devices->count() }})</strong>
    </h4>
    <ul>
      @foreach ($user->devices as $device)
        <li>
          <div>Name: {{ $device->name }}</div>
          <div>User agent: {{ $device->userAgent }}</div>
          <div>Created at: {{ $device->created_at }}</div>
        </li>
      @endforeach
    </ul>
  </div>

  @push('scripts')
  {{--<script src="/js/history.js"></script>--}}
  @endpush
@endsection
