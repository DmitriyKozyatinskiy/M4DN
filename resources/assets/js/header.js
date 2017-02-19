function logout(event) {
    event.preventDefault();
    document.getElementById('logout-form').submit();
}

$(document).on('click', '#js-logout', logout);