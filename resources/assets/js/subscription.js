$(document)
  .on('click', '.js-subscription', setActiveSubscription)
  .on('click', '.js-subscription-settings, #js-add-plan', openSettings);

function setActiveSubscription(event) {
  $('.js-subscription').removeClass('Subscription--IsActive');
  $(event.target).parent('.js-subscription').addClass('Subscription--IsActive');
}

function openSettings(event) {
  const id = $(event.target).data('id') || null;
  $.get(`/admin/subscription/${ id }`, response => {
    const title = id ? 'Change plan settings' : 'Add new plan';
    $('#js-modal-title').html(title);
    $('#js-modal-body').html(response);
    $('#js-modal').modal('show');
  })
}
