function logout(event) {
    event.preventDefault();
    document.getElementById('js-logout-form').submit();
}

function toggleTray(event) {
    event.preventDefault();
    const $tray = $('#js-tray');
    $tray.toggle();
}

function closeTray(event) {
    event.stopPropagation();
    const $trigger = $(event.target);
    const $tray = $('#js-tray');
    if ($tray.is(':visible')
        && !$trigger.hasClass('js-tray-trigger')
        && !$trigger.closest('#js-tray-trigger').length
        && !$trigger.hasClass('js-tray')
        && !$trigger.closest('#js-tray').length) {
        $tray.hide();
    }
}

$(document)
    .on('click', '.js-logout', logout)
    .on('click', 'body', closeTray)
    .on('click', '#js-tray-trigger', toggleTray);