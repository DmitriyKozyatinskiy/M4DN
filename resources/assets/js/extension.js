$ = window.$;

$(document).on('click', '#js-install-extension-button', () => {
  chrome.webstore.install('', () => {
    $('#js-install-extension-button').remove();
  });
});
