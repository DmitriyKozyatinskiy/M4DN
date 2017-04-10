<div class="panel panel-default">
  <div class="panel-heading" role="tab" id="js-billing-group-paypal-heading">
    <h4 class="panel-title">
      <a class="Billing_SectionToggler" role="button" data-toggle="collapse" data-parent="#js-billing-groups"
         href="#js-billing-group-paypal" aria-expanded="false" aria-controls="js-billing-group-paypal">
        <span class="js-billing-group-arrow glyphicon glyphicon-chevron-right
          Billing_SectionArrow {{ $isPayPal ? 'Billing_SectionArrow--Rotated' : '' }} text-muted"
              aria-hidden="true" id="js-paypal-panel-arrow"></span>
        &nbsp;&nbsp;
        PayPal
        &nbsp;&nbsp;
        <img src="{{ secure_asset('images/paypal_logo.png') }}" title="PayPal" alt="PayPal">
      </a>
    </h4>
  </div>
  <div id="js-billing-group-paypal" class="panel-collapse collapse {{ $isPayPal ? 'in' : '' }}"
       role="tabpanel" aria-labelledby="js-billing-group-paypal-heading">
    <div class="panel-body">
      <script src="https://www.paypalobjects.com/api/button.js?"
              data-merchant="braintree"
              data-id="paypal-button"
              data-button="checkout"
              data-color="blue"
              data-size="medium"
              data-shape="rect"
              data-button_type="submit"
              data-button_disabled="false"
      ></script>
    </div>
  </div>
</div>
