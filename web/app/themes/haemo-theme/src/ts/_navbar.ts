document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.js-navbar-panel');

    if (navbar === null) {
        return;
    }

    const toggler = document.querySelector('.js-navbar-panel-toggler');

    if (toggler !== null) {
        toggler.addEventListener('click', function (e) {
            e.preventDefault();

            if (navbar.classList.contains('active')) {
                navbar.classList.remove('active');
            } else {
                navbar.classList.add('active');
            }
        });
    }

    const closer = document.querySelector('.js-navbar-panel-closer');
    if (closer !== null) {
        closer.addEventListener('click', function (e) {
            e.preventDefault();

            navbar.classList.remove('active');
        });
    }
});
