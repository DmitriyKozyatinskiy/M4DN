@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <h3 class="Title">Subscription</h3>
    @if (session('subscription-save-success'))
      <div class="alert alert-success">
        {{ session('subscription-save-success') }}
      </div>
    @endif

    <form role="form" method="POST" action="{{ secure_url('/account/subscription') }}">
      {{ csrf_field() }}
      <div class="row">
        @foreach ($braintreePlans as $plan)
          <div class="col-xs-4">
            <label for="subscription-input-{{ $plan->id }}"
                   class="js-subscription thumbnail Subscription {{ $currentBraintreePlan && $plan->id == $currentBraintreePlan->braintree_plan ? 'Subscription--IsActive' : '' }}">
              <input type="radio"
                     name="subscription_id"
                     id="subscription-input-{{ $plan->id }}"
                     class="js-subscription-input"
                     value="{{ $plan->id }}" {{ $currentBraintreePlan && $plan->id === $currentBraintreePlan->id ? 'checked' : '' }}>

              @if (Auth::user()->isAdmin)
                <span class="pull-right glyphicon glyphicon-cog Subscription__Settings js-subscription-settings"
                      data-id="{{ $plan->id }}"
                      data-name="{{ $plan->name }}"></span>
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
      </div>

      @if ($cardLastFour || $isPayPal)
        <div class="row">
          <div class="col-xs-12">
            <h3>Your Details</h3>
            <ul class="Subscription__PaymentMethodDetails">
              <li>
                <span class="text-muted">Name:</span>
                <span
                    class="Subscription__PaymentMethodValue">{{ $firstName ? $firstName : Auth::user()->name }} {{ $lastName }}</span>
              </li>
              <li>
                <span class="text-muted">Email:</span>
                <span class="Subscription__PaymentMethodValue">{{ Auth::user()->email }}</span>
              </li>
              <li>
                <span class="text-muted">Payment information:</span>
                @if ($isPayPal)
                  <span class="Subscription__PaymentMethodValue">PayPal</span>
                @else
                  <span class="Subscription__PaymentMethodValue">{{ $cardType }} •••• •••• •••• {{ $cardLastFour }}</span>
                @endif
                <span>&nbsp;&nbsp;&nbsp;&nbsp;</span>
                <a href="{{ secure_url('account/billing') }}">Edit Payment</a>
              </li>
            </ul>
          </div>
        </div>

        @if (count($braintreePlans))
          <br>
          <button type="submit" class="btn btn-primary">Start Subscription</button>
        @endif
      @else
        <br>
        <a href="{{ secure_url('account/billing') }}" class="btn btn-primary">Add Payment Method</a>
      @endif
    </form>
  </div>

  @push('scripts')
  <script src="/js/subscription.js"></script>
  @endpush
@endsection
