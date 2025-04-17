import Cookies from 'js-cookie';

document.addEventListener('DOMContentLoaded', function () {

    // Privacy policy
    const privacyBox = document.querySelector('.privacy');
    const privacyHide = document.querySelector('.js-policy-agree');
    var policyCookie = Cookies.get('_policy');

    if (policyCookie === undefined) {
        privacyBox.classList.remove('hidden');
    }

    privacyHide.addEventListener('click', function (e) {
        e.preventDefault();
        privacyBox.classList.add('hidden');
        Cookies.set('_policy', 1, {expires: 368, path: '/'});
    });

});
