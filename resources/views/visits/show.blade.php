@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">History</h3>

    <a class="btn btn-primary hidden" id="js-history-form-toggler" role="button"
       data-toggle="collapse" href="#js-history-form-container" aria-expanded="false" aria-controls="js-history-form-container">
      Filters
    </a>
    <div class="collapse in" id="js-history-form-container">
      <form class="History__SearchForm form-inline well" id="js-history-form">
        <div class="form-group">
          <select class="form-control" id="js-history-device-selector">
            <option value="" selected>All devices</option>
            @foreach ($devices as $device )
              <option value="{{ $device->id }}">{{ $device->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <input class="form-control" id="js-history-keyword" placeholder="Keyword">
        </div>
        <div class="input-group History__FormDatesContainer">
          <input class="form-control input-groupdate date js-history-date"
                 id="js-history-start-date"
                 data-date-format="YYYY-MM-DD HH:mm:ss" placeholder="Start date">
          <div class="input-group-addon">to</div>
          <input class="form-control input-groupdate date js-history-date"
                 id="js-history-end-date"
                 data-date-format="YYYY-MM-DD HH:mm:ss" placeholder="End date">
        </div>
        <div class="form-group History__FormControlButtons">
          <button type="submit" class="btn btn-primary" id="js-history-submit-button">Search</button>
          <button type="reset" class="btn btn-default" id="js-history-reset-button">Reset</button>
        </div>
      </form>
    </div>
    <div class="form-group History__RemoveButtonsContainer">
      <button type="button" class="btn btn-default" id="js-history-remove-selected-button">Remove selected</button>
      <button type="button" class="btn btn-warning" id="js-history-remove-all-button">Remove all</button>
    </div>


    <div class="History__Container hidden" id="js-ads-container">
      <div class="clearfix History__Row History__Row--Ads js-ads-row">
        <div class="col-xs-11 col-xs-offset-1">
          <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-4770238595923264"
               data-ad-slot="9531882433"
               data-ad-format="link">
          </ins>
        </div>
      </div>
      <div class="clearfix History__Row History__Row--Ads js-ads-row">
        <div class="col-xs-11 col-xs-offset-1">
          <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-4770238595923264"
               data-ad-slot="9531882433"
               data-ad-format="link">
          </ins>
        </div>
      </div>
      <div class="clearfix History__Row History__Row--Ads js-ads-row">
        <div class="col-xs-11 col-xs-offset-1">
          <ins class="adsbygoogle"
               style="display:block"
               data-ad-client="ca-pub-4770238595923264"
               data-ad-slot="9531882433"
               data-ad-format="link">
          </ins>
        </div>
      </div>
    </div>
    <div class="History__Container" id="js-history"></div>
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

  <div class="modal fade" id="js-history-confirmation-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title">Are you sure to clear history?</h4>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-warning" id="js-history-all-remove-proceed">Proceed</button>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script src="/js/history.js"></script>
  @endpush
@endsection
