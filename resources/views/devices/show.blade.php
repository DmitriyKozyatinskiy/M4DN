@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">Devices</h3>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>User agent</th>
          <th></th>
          <th></th>
        </tr>
      </thead>
      @foreach ($devices as $device)
        <tr>
          <th>{{ $loop->iteration }}</th>
          <th>{{ $loop->name }}</th>
          <th>{{ $loop->userAgent }}</th>
          <th>
            <span class="glyphicon glyphicon-cog" role="button"></span>
          </th>
          <th>
            <span class="glyphicon glyphicon-remove text-danger" role="button"></span>
          </th>
        </tr>
      @endforeach
    </table>
  </div>
@endsection
