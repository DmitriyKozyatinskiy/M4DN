$ = window.$;
import braintree from 'braintree-web';
import checkRequestStatus from './helpers';

const $warning = $('#js-billing-warning');

braintree.client.create({
  authorization: window.braintreeToken
}, function (err, clientInstance) {
  if (err) {
    console.error(err);
    return;
  }

  braintree.hostedFields.create({
    client: clientInstance,
    styles: {
      'input': {
        'font-size': '14px',
        'font-family': 'helvetica, tahoma, calibri, sans-serif',
        'color': '#3a3a3a'
      },
      ':focus': {
        'color': 'black'
      }
    },
    fields: {
      number: {
        selector: '#card-number',
        placeholder: window.braintreeLastFour ? `**** **** **** ${ window.braintreeLastFour }` : '**** **** **** ****'
      },
      cvv: {
        selector: '#cvv',
        placeholder: '***'
      },
      expirationMonth: {
        selector: '#expiration-month',
        placeholder: 'MM'
      },
      expirationYear: {
        selector: '#expiration-year',
        placeholder: 'YY'
      }
    }
  }, function (err, hostedFieldsInstance) {
    if (err) {
      console.error(err);
      return;
    }

    hostedFieldsInstance.on('validityChange', function (event) {
      $('#js-billing-warning').addClass('hidden');
      $('#js-billing-success').addClass('hidden');

      const field = event.fields[event.emittedBy];

      if (field.isValid) {
        $warning.addClass('hidden');

        if (event.emittedBy === 'expirationMonth' || event.emittedBy === 'expirationYear') {
          if (event.fields.expirationMonth.isValid) {
            const $field = $('#expiration-month');
            // $field.parents('.form-group').removeClass('has-warning').addClass('has-success');
            $field.next('span').text('');
          }

          if (!event.fields.expirationMonth.isValid || !event.fields.expirationYear.isValid) {
            return;
          }
        } else if (event.emittedBy === 'number') {
          $('#card-number').next('span').text('');
        }

        // Apply styling for a valid field
        $(field.container).parents('.form-group').addClass('has-success');
      } else if (field.isPotentiallyValid) {
        // Remove styling  from potentially valid fields
        $(field.container).parents('.form-group').removeClass('has-warning');
        $(field.container).parents('.form-group').removeClass('has-success');
        if (event.emittedBy === 'number') {
          $('#card-number').next('span').text('');
        } else if (event.emittedBy === 'expirationMonth') {
          $('#expiration-month').next('span').text('');
        }
      } else {
        // Add styling to invalid fields
        $(field.container).parents('.form-group').addClass('has-warning');
        // Add helper text for an invalid card number
        if (event.emittedBy === 'number') {
          $('#card-number').next('span').text('Card number is invalid.');
        } else if (event.emittedBy === 'expirationMonth') {
          $('#expiration-month').next('span').text('Expiration month is invalid.')
        }
      }
    });

    hostedFieldsInstance.on('cardTypeChange', function (event) {
      // Handle a field's change, such as a change in validity or credit card type
      if (event.cards.length === 1) {
        $('#card-type').text(event.cards[0].niceType);
      } else {
        $('#card-type').text('Card');
      }
    });

    $('.panel-body').submit(function (event) {
      event.preventDefault();
      hostedFieldsInstance.tokenize(function (err, payload) {
        if (err) {
         $warning.text('Some fields are invalid or empty.').removeClass('hidden');
          console.error(err);
          return;
        }
        $warning.addClass('hidden');

        // This is where you would submit payload.nonce to your server
        sendNonce(payload.nonce).then(response => {
          $('#js-billing-warning').addClass('hidden');
          $('#js-billing-success').removeClass('hidden').text('Billing information was saved');
        }, error => {
          $('#js-billing-success').addClass('hidden');
          $('#js-billing-warning').removeClass('hidden').text(error.status);
          console.log(error);
        });
        // alert('Submit your nonce to your server here!');
      });
    });
  });
});

function sendNonce(nonce) {
  return new Promise((resolve, reject) => {
    fetch('/account/billing', {
      method: 'POST',
      credentials: 'include',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': window.axios.defaults.headers.common['X-CSRF-TOKEN']
      },
      body: JSON.stringify({
        nonce: nonce
      })
    })
      .then(checkRequestStatus)
      .then(resolve)
      .catch(error => {
        reject(error.response);
      });
  });
}