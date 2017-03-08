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
          <th>{{ $device->name }}</th>
          <th>{{ $device->userAgent }}</th>
          <th>
            <span class="glyphicon glyphicon-cog js-update-device" data-id="{{ $device->id }}" role="button"></span>
          </th>
          <th>
            <span class="glyphicon glyphicon-remove text-danger js-remove-device" data-id="{{ $device->id }}" data-name="{{ $device->name }}" role="button"></span>
          </th>
        </tr>
      @endforeach
    </table>
    <button type="button" class="btn btn-primary" id="js-add-device">Add new device</button>
  </div>

  @push('scripts')
    <script src="/js/devices.js"></script>
  @endpush
@endsection
