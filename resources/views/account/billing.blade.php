@extends('layouts.app')

@section('content')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-md-offset-1">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Enter Card Details</h3>
          </div>
          <form class="panel-body">
            {{ csrf_field() }}
            <div class="alert alert-success hidden" id="js-billing-success"></div>
            <div class="alert alert-warning hidden" id="js-billing-warning"></div>
            <div class="row">
              <div class="form-group col-xs-12 col-sm-5">
                <label class="control-label">Card Number</label>
                <!--  Hosted Fields div container -->
                <div class="form-control" id="card-number"></div>
                <span class="text-warning"></span>
              </div>
              <div class="form-group col-xs-6 col-sm-5">
                <div class="row">
                  <label class="control-label col-xs-12">Expiration Date</label>
                  <div class="col-xs-6">
                    <!--  Hosted Fields div container -->
                    <div class="form-control" id="expiration-month"></div>
                    <span class="text-warning"></span>
                  </div>
                  <div class="col-xs-6">
                    <!--  Hosted Fields div container -->
                    <div class="form-control" id="expiration-year"></div>
                  </div>
                </div>
              </div>
              <div class="form-group col-xs-6 col-sm-2">
                <label class="control-label">CVV</label>
                <!--  Hosted Fields div container -->
                <div class="form-control" id="cvv"></div>
              </div>
            </div>
            <button value="submit" id="submit" class="btn btn-primary btn-lg">Save <span
                  id="card-type">Card</span></button>
          </form>
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
