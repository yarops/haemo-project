document.addEventListener('DOMContentLoaded', function () {

    const form = document.querySelector('.search-form') as HTMLFormElement;
    const button = document.querySelector('.search-form__button')as HTMLElement;

    // Search form
    button.addEventListener('click', function (e) {
        e.preventDefault();
        form.submit();
    });
});

