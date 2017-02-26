@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">History</h3>

    @foreach ($visitGroups as $key => $visits )
      <div class="History__Header">{{ $key }}</div>
        @foreach ($visits as $visit)
          <div class="row History__Row">
            <div class="col-xs-1 History__Col">
                <span title="{{ $visit->created_at }}">
                  {{ \Carbon\Carbon::parse($visit->created_at)->format('g:i a') }}
                </span>
              </div>
              <div class="col-xs-1  History__Col">
                <span title="{{ $visit->device->userAgent }}">{{ $visit->device->name }}</span>
              </div>
              <div class="col-xs-5 History__Col">
                <a href="{{ $visit->url }}" title="{{ $visit->url }}">{{ $visit->url }}</a>
              </div>
              <div class="col-xs-5 History__Col">
                <span title="{{ $visit->title }}">{{ $visit->title }}</span>
              </div>
            </div>
        @endforeach
      <br>
    @endforeach
  </div>
@endsection
