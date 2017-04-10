@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-1">
        <div class="alert alert-success hidden" id="js-billing-success"></div>
        <div class="alert alert-warning hidden" id="js-billing-warning"></div>
        <div class="panel-group" id="js-billing-groups" role="tablist" aria-multiselectable="true">
          @include('account.billing_card')
          @include('account.billing_paypal')
        </div>
      </div>
    </div>
  </div>


  @push('scripts')
  <script>
    window.braintreeToken = '<?php echo $braintreeToken ?>';
  </script>
  <script>
    window.braintreeLastFour = '<?php echo $cardLastFour ?>';
  </script>
  <script src="/js/billing.js"></script>
  @endpush
@endsection
