$(document)
  .on('click', '.js-update-device, #js-add-device', openDeviceForm)
  .on('click', '.js-remove-device', removeDevice);

function openDeviceForm(event) {
  const id = $(event.target).data('id') || null;
  $.get(`/devices/update/${ id }`, response => {
    const title = id ? 'Update device' : 'Add new device';
    $('#js-modal-title').html(title);
    $('#js-modal-body').html(response);
    $('#js-modal').modal('show');
  })
}

function removeDevice(event) {
  const id = $(event.target).data('id');
  const name = $(event.target).data('name');
  $.get(`/devices/delete`, response => {
    const title = `Remove "${ name }" device`;
    $('#js-modal-title').html(title);
    $('#js-modal-body').html(response);
    $('#js-remove-device-id').val(id);
    $('#js-modal').modal('show');
  });
}
