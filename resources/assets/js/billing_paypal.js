$ = window.$;
import braintree from 'braintree-web';
import checkRequestStatus from './helpers';

const paypalButton = document.querySelector('.paypal-button');

braintree.client.create({
  authorization: window.braintreeToken
}, function (clientErr, clientInstance) {
  // Create PayPal component
  braintree.paypal.create({
    client: clientInstance
  }, function (paypalErr, paypalInstance) {
    paypalButton.addEventListener('click', function () {
      // Tokenize here!
      paypalInstance.tokenize({
        flow: 'vault', // This enables the Vault flow
        billingAgreementDescription: 'Your agreement description',
        locale: 'en_US',
        enableShippingAddress: true,
        shippingAddressEditable: false
      }, function (err, tokenizationPayload) {
        console.log(tokenizationPayload);
        sendNonce(tokenizationPayload.nonce).then(response => {
          $('#js-billing-warning').addClass('hidden');
          $('#js-billing-success').removeClass('hidden').text('Billing information was saved');
        }, error => {
          $('#js-billing-success').addClass('hidden');
          $('#js-billing-warning').removeClass('hidden').text(error.status);
          console.log(error);
        });
        // Tokenization complete
        // Send tokenizationPayload.nonce to server
      });
    });
  });
});

function sendNonce(nonce, isPayPal) {
  return new Promise((resolve, reject) => {
    fetch('/account/billing', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN']
      },
      body: JSON.stringify({
        nonce: nonce,
        isPayPal: isPayPal
      })
    })
      .then(checkRequestStatus)
      .then(resolve)
      .catch(error => {
        reject(error.response);
      });
  });
}
