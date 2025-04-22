document.addEventListener('DOMContentLoaded', function () {
    const sideNav = document.querySelector('.js-sidenav');
    const wrapper = document.querySelector('.js-wrapper');

    if (sideNav === null || wrapper === null) {
        return;
    }

    const toggler = document.querySelector('.js-sidenav-toggler');

    if (toggler !== null) {
        toggler.addEventListener('click', function (e) {
            e.preventDefault();

            if (sideNav.classList.contains('active')) {
                sideNav.classList.remove('active');
                wrapper.classList.remove('active');
            } else {
                sideNav.classList.add('active');
                wrapper.classList.add('active');
            }
        });
    }

    const closer = document.querySelector('.js-sidenav-closer');
    if (closer !== null) {
        closer.addEventListener('click', function (e) {
            e.preventDefault();

            sideNav.classList.remove('active');
            wrapper.classList.remove('active');
        });
    }
});
