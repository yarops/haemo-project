class ScrollMenuHandler {
    private menuElement: HTMLElement;
    private scrollThreshold: number;
    private className: string;

    constructor(selector: string, className: string = 'scrolled', threshold: number = 50) {
        const element = document.querySelector(selector);

        if (!element || !(element instanceof HTMLElement)) {
            throw new Error(`Элемент с селектором "${selector}" не найден или не является HTMLElement.`);
        }

        this.menuElement = element;
        this.className = className;
        this.scrollThreshold = threshold;

        this.handleScroll = this.handleScroll.bind(this);
        this.init();
    }

    private init() {
        window.addEventListener('scroll', this.handleScroll);
        this.handleScroll(); // на случай, если страница уже прокручена
    }

    private handleScroll() {
        const scrollY = window.scrollY;

        if (scrollY > this.scrollThreshold) {
            this.menuElement.classList.add(this.className);
        } else {
            this.menuElement.classList.remove(this.className);
        }
    }

    public destroy() {
        window.removeEventListener('scroll', this.handleScroll);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const menuScrollHandler = new ScrollMenuHandler('.navbar');

    // Если нужно будет отключить слежение за скроллом:
    // menuScrollHandler.destroy();
});

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
