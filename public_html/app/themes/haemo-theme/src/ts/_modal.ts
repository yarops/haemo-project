document.addEventListener('DOMContentLoaded', function () {

    // Получаем все элементы
    const modals = document.querySelectorAll<HTMLElement>('.js-modal');
    const togglers = document.querySelectorAll<HTMLElement>('.js-modal-toggler');
    const backdrop = document.querySelector<HTMLElement>('.js-modal-backdrop');
    const body = document.body;

    // Обработчики на клики по фону для закрытия
    document.addEventListener('click', (e) => {
        const target = e.target as HTMLElement;

        const clickedInsideModal = Array.from(modals).some((modal) => {
            return target !== modal && modal.contains(target);
        });
        const clickedToggler = Array.from(togglers).some((toggler) => toggler.contains(target));

        if (clickedInsideModal || clickedToggler) return;

        modals.forEach((modal) => {
            if (modal.classList.contains('show')) {
                closeModal(modal);
            }
        });
    });

    function openModal(modal: HTMLElement) {
        modal.classList.add('show');
        body.classList.add('modal-open');

        if (backdrop) {
            backdrop.classList.add('show');
        }
    }

    function closeModal(modal: HTMLElement) {
        modal.classList.remove('show');
        body.classList.remove('modal-open');

        if (backdrop) {
            backdrop.classList.remove('show');
        }

        // Убираем fade после анимации, если нужно
        setTimeout(() => {
            modal.classList.remove('show');
            if (backdrop) {
                backdrop.classList.remove('show');
            }
        }, 300); // 300мс — длительность CSS-анимации
    }

// Навешиваем обработчики на переключатели
    togglers.forEach((toggler) => {
        toggler.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = toggler.getAttribute('data-target');
            if (!targetId) return;

            const modal = document.querySelector<HTMLElement>(targetId);
            if (!modal) return;

            const isOpen = modal.classList.contains('show');
            if (isOpen) {
                closeModal(modal);
            } else {
                openModal(modal);
            }
        });
    });
});
