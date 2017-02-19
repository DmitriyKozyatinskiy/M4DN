@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">Subscription</h3>
    <form role="form" method="POST" action="{{ url('/account/subscription') }}">
      {{ csrf_field() }}
      <div class="row">
        @foreach ($plans as $plan)
          <div class="col-xs-4">
            <label for="subscription-input-{{ $plan->id }}"
                   class="js-subscription thumbnail Subscription {{ $currentPlan && $plan->id === $currentPlan->id ? 'Subscription--IsActive' : '' }}">
              <input type="radio"
                     name="subscriptionID"
                     id="subscription-input-{{ $plan->id }}"
                     class="js-subscription-input"
                     value="{{ $plan->id }}" {{ $currentPlan && $plan->id === $currentPlan->id ? 'checked' : '' }}>

              @if (Auth::user()->isAdmin)
                <span class="pull-right glyphicon glyphicon-cog Subscription__Settings js-subscription-settings"
                      data-id="{{ $plan->id }}"></span>
              @endif

              <div class="caption">
                <h3>{{ $plan->name }}</h3>
                <p>{{ $plan->devices  }} device/browser</p>
                <p>Saves history for last {{ $plan->days }} days</p>
              </div>
            </label>
          </div>
        @endforeach
        <div class="col-xs-12">
          @if (Auth::user()->isAdmin)
            <button type="button" class="btn btn-default" id="js-add-plan">Add plan</button>
          @endif

          @if (count($plans))
            <button type="submit" class="btn btn-primary">Save</button>
          @endif
        </div>
      </div>
    </form>
  </div>
@endsection
