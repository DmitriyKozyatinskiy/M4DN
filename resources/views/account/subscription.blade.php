@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">Subscription</h3>
    @if (session('subscription-save-success'))
      <div class="alert alert-success">
        {{ session('subscription-save-success') }}
      </div>
    @endif

    <form role="form" method="POST" action="{{ url('/account/subscription') }}">
      {{ csrf_field() }}
      <div class="row">
        @foreach ($plans as $plan)
          <div class="col-xs-4">
            <label for="subscription-input-{{ $plan->id }}"
                   class="js-subscription thumbnail Subscription {{ $currentPlan && $plan->id === $currentPlan->id ? 'Subscription--IsActive' : '' }}">
              <input type="radio"
                     name="subscription_id"
                     id="subscription-input-{{ $plan->id }}"
                     class="js-subscription-input"
                     value="{{ $plan->id }}" {{ $currentPlan && $plan->id === $currentPlan->id ? 'checked' : '' }}>

              @if (Auth::user()->isAdmin)
                <span class="pull-right glyphicon glyphicon-cog Subscription__Settings js-subscription-settings"
                      data-id="{{ $plan->id }}"></span>
                {{--<span class="pull-right glyphicon glyphicon-remove Subscription__Settings js-subscription-remove"--}}
                      {{--data-id="{{ $plan->id }}"></span>--}}
              @endif

              <div class="caption">
                <h3>{{ $plan->name }}</h3>
                {{--<p>{{ $plan->devices  }} device/browser</p>--}}
                {{--Saves history for last {{ $plan->hours }} days--}}
                <p>{{ $plan->description  }}</p>
                @if ($plan->price)
                  <p>${{ $plan->price }} per month</p>
                @else
                  <p>{{ 'FREE' }}</p>
                @endif

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

  @push('scripts')
  <script src="/js/subscription.js"></script>
  @endpush
@endsection
