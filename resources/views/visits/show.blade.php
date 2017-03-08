@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">History</h3>
    <form class="History__SearchForm form-inline" id="js-history-form">
      <div class="form-group">
        <select class="form-control">
          <option selected>Filter by</option>
          @foreach ($devices as $device )
            <option value="{{ $device->id }}">{{ $device->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="input-group">
        <input class="form-control input-groupdate date js-history-date" id="js-history-start-date" data-date-format="YYYY-MM-DD HH:mm:ss">
        <div class="input-group-addon">to</div>
        <input class="form-control input-groupdate date js-history-date" id="js-history-end-date" data-date-format="YYYY-MM-DD HH:mm:ss">
      </div>

      {{--<div class="input-group">--}}
      {{--<div class="input-groupdate" id="js-history-start-date">--}}
      {{--<input class="form-control">--}}
      {{--<span class="input-group-addon">--}}
      {{--<span class="glyphicon glyphicon-calendar"></span>--}}
      {{--</span>--}}
      {{--</div>--}}
      {{--<div class="input-group date" id="js-history-end-date">--}}
      {{--<input class="form-control">--}}
      {{--<span class="input-group-addon">--}}
      {{--<span class="glyphicon glyphicon-calendar"></span>--}}
      {{--</span>--}}
      {{--</div>--}}
      {{--</div>--}}
      <button type="submit" class="btn btn-primary">Search</button>
      <button type="reset" class="btn btn-default">Reset</button>
    </form>

    <div id="js-history"></div>
    {{--<nav aria-label="Page navigation">--}}
      {{--<ul class="pagination">--}}
        {{--<li>--}}
          {{--<a href="#" aria-label="Previous">--}}
            {{--<span aria-hidden="true">&laquo;</span>--}}
          {{--</a>--}}
        {{--</li>--}}
        {{--<li class="active">--}}
          {{--<span>1--}}
            {{--<span class="sr-only">(current)</span>--}}
          {{--</span>--}}
        {{--</li>--}}
        {{--<li><a href="#">2</a></li>--}}
        {{--<li>--}}
          {{--<a href="#" aria-label="Next">--}}
            {{--<span aria-hidden="true">&raquo;</span>--}}
          {{--</a>--}}
        {{--</li>--}}
      {{--</ul>--}}
    {{--</nav>--}}
    {{--@foreach ($visitGroups as $key => $visits )--}}
    {{--<div class="History__Header">{{ $key }}</div>--}}
    {{--@foreach ($visits as $visit)--}}
    {{--<div class="clearfix History__Row">--}}
    {{--<div class="col-xs-1 History__Col">--}}
    {{--<span title="{{ $visit->created_at }}">--}}
    {{--{{ \Carbon\Carbon::parse($visit->created_at)->format('g:i a') }}--}}
    {{--</span>--}}
    {{--</div>--}}
    {{--<div class="col-xs-1  History__Col">--}}
    {{--<span title="{{ $visit->device->userAgent }}">{{ $visit->device->name }}</span>--}}
    {{--</div>--}}
    {{--<div class="col-xs-5 History__Col">--}}
    {{--<a href="{{ $visit->url }}" title="{{ $visit->url }}">{{ $visit->url }}</a>--}}
    {{--</div>--}}
    {{--<div class="col-xs-5 History__Col">--}}
    {{--<span title="{{ $visit->title }}">{{ $visit->title }}</span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}
    {{--<br>--}}
    {{--@endforeach--}}
  </div>

  @push('scripts')
  <script src="/js/history.js"></script>
  @endpush
@endsection
