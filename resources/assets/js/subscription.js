$ = window.$;

function setActiveSubscription(event) {
  $('.js-subscription').removeClass('Subscription--IsActive');
  $(event.target).parent('.js-subscription').addClass('Subscription--IsActive');
}

function openSettings(event) {
  const id = $(event.target).data('id');
  const name = $(event.target).data('name');
  $.get(`/admin/subscription/${ id }`, response => {
    const title = `Change "${ name }" plan settings`;
    $('#js-modal-title').html(title);
    $('#js-modal-body').html(response);
    $('#js-modal').modal('show');
  })
}

$(document)
  .on('click', '.js-subscription', setActiveSubscription)
  .on('click', '.js-subscription-settings, #js-add-plan', openSettings);
