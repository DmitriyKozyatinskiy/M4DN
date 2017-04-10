<div class="panel panel-default">
  <div class="panel-heading" role="tab" id="js-billing-group-card-heading">
    <h4 class="panel-title">
      <a class="Billing_SectionToggler" role="button" data-toggle="collapse" data-parent="#js-billing-groups"
         href="#js-billing-group-card" aria-expanded="true" aria-controls="js-billing-group-card">
            <span class="js-billing-group-arrow glyphicon glyphicon-chevron-right
                Billing_SectionArrow {{ !$isPayPal ? 'Billing_SectionArrow--Rotated' : '' }} text-muted"
                  aria-hidden="true" id="js-card-panel-arrow"></span>
        &nbsp;&nbsp;
        Credit Card
        &nbsp;&nbsp;
        <img src="{{ secure_asset('images/visa_logo.png') }}" title="Visa" alt="Visa">
        &nbsp;
        <img src="{{ secure_asset('images/mastercard_logo.png') }}" title="MasterCard" alt="MasterCard">
        &nbsp;
        <img src="{{ secure_asset('images/amex_logo.png') }}" title="Amex" alt="Amex">
      </a>
    </h4>
  </div>
  <div id="js-billing-group-card" class="panel-collapse collapse {{ !$isPayPal ? 'in' : '' }}"
       role="tabpanel" aria-labelledby="js-billing-group-card-heading">
    <div class="panel-body">
      <form>
        {{ csrf_field() }}
        <div class="row">
          <div class="form-group col-xs-6">
            <label class="control-label" for="js-braintree-user-first-name">First Name</label>
            <input class="form-control" name="user_first_name" id="js-braintree-user-first-name" required
                   placeholder="First name" value="{{ $firstName }}">
            <span class="text-warning"></span>
          </div>
          <div class="form-group col-xs-6">
            <label class="control-label" for="js-braintree-user-last-name">Last Name</label>
            <input class="form-control" name="user_last_name" id="js-braintree-user-last-name" required
                   placeholder="Last name" value="{{ $lastName }}">
            <span class="text-warning"></span>
          </div>
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
          <div class="form-group col-xs-12 col-sm-9">
            <label class="control-label" for="js-braintree-user-address">Billing Address</label>
            <input class="form-control" name="user_address" id="js-braintree-user-address" required
                   placeholder="Address">
            <span class="text-warning"></span>
          </div>
          <div class="form-group col-xs-12 col-sm-3">
            <label class="control-label">Zipcode</label>
            <!--  Hosted Fields div container -->
            <div class="form-control" id="postal-code"></div>
          </div>
        </div>
        <button value="submit" id="submit" class="btn btn-primary btn-lg">Save <span
              id="card-type">Card</span></button>
      </form>
    </div>
  </div>
</div>
