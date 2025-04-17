document.addEventListener('DOMContentLoaded', function () {

    // Shares
    const modalPopup = document.querySelector('.js-modal');
    const modalPopupTogglers = document.querySelectorAll('.js-modal-toggler');

    if (!modalPopup || !modalPopupTogglers) {
        console.log('Shares elements not found');
        return;
    }

    modalPopupTogglers.forEach((modalPopupToggler) => {
        console.log('modalPopupToggler', modalPopupToggler);
        modalPopupToggler.addEventListener('click', function (e) {
            e.preventDefault();
            const elToggler = e.target as HTMLElement;
            const modalSelector = elToggler.dataset.modal;

            console.log(modalSelector);

            if (!modalSelector) return;
            const modal = document.getElementById(modalSelector);

            if (!modal) return;
            if (modal.classList.contains('active')) {
                modal.classList.remove('active');
            } else {
                modal.classList.add('active');
            }
        });
    });

    const modalPopupCloses = document.querySelectorAll('.js-modal-close');
    modalPopupCloses.forEach((modalPopupClose) => {
        modalPopupClose.addEventListener('click', function (e) {
            e.preventDefault();

            const modalPopups = document.querySelectorAll('.js-modal');
            modalPopups.forEach(el => el.classList.remove('active'));
        });
    });
});
