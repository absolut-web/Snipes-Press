/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {

    const docBody = document.body;


    function menuHandler() {

        const siteNavigation = document.querySelector('.site-menu__container');

        if (!siteNavigation) {
            return;
        }

        const button = document.querySelector('.site-menu-button');

        if ('undefined' === typeof button) {
            return;
        }

        const menu = siteNavigation.getElementsByTagName('ul')[0];

        if ('undefined' === typeof menu) {
            button.style.display = 'none';
            return;
        }

        if (!menu.classList.contains('nav-menu')) {
            menu.classList.add('nav-menu');
        }

        button.addEventListener('click', function () {
            this.classList.toggle('site-menu-button--toggled')
            siteNavigation.classList.toggle('site-menu__container--visible');
            docBody.classList.toggle('overflow-hidden');
            docBody.classList.toggle('overflow-hidden--mobile');

            if (button.getAttribute('aria-expanded') === 'true') {
                button.setAttribute('aria-expanded', 'false');
            } else {
                button.setAttribute('aria-expanded', 'true');
            }
        });

        const links = menu.getElementsByTagName('a');
        const linksWithChildren = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a');

        for (const link of links) {
            link.addEventListener('focus', toggleFocus, true);
            link.addEventListener('blur', toggleFocus, true);
        }

        for (const link of linksWithChildren) {
            link.addEventListener('touchstart', toggleFocus, false);
        }

        function toggleFocus() {
            if (event.type === 'focus' || event.type === 'blur') {
                let self = this;
                // Move up through the ancestors of the current link until we hit .nav-menu.
                while (!self.classList.contains('nav-menu')) {
                    // On li elements toggle the class .focus.
                    if ('li' === self.tagName.toLowerCase()) {
                        self.classList.toggle('focus');
                    }
                    self = self.parentNode;
                }
            }
            if (event.type === 'touchstart') {
                const menuItem = this.parentNode;
                event.preventDefault();
                for (const link of menuItem.parentNode.children) {
                    if (menuItem !== link) {
                        link.classList.remove('focus');
                    }
                }
                menuItem.classList.toggle('focus');
            }
        }
    }

    menuHandler()


    // Lazy Load

    const headerImage = document.querySelector('.article-header')

    // Lazy Load
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: [...Array(50).keys()].map(x => x / 49)
    };

    let headerImageObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                let headerImage = entry.target;
                headerImage.style.opacity = Math.round((entry.intersectionRatio + Number.EPSILON) * 100) / 100
            }
        });
    }, observerOptions)

    headerImageObserver.observe(headerImage)


}());
