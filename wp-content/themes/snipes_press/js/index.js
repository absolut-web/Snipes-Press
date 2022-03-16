/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
(function () {

    const docBody = document.body


    function menuHandler() {

        const siteNavigation = document.querySelector('.site-menu__container')

        if (!siteNavigation) {
            return
        }

        const button = document.querySelector('.site-menu-button')

        if ('undefined' === typeof button) {
            return
        }

        const menu = siteNavigation.getElementsByTagName('ul')[0];

        if ('undefined' === typeof menu) {
            button.style.display = 'none';
            return
        }

        if (!menu.classList.contains('nav-menu')) {
            menu.classList.add('nav-menu')
        }

        button.addEventListener('click', function () {
            this.classList.toggle('site-menu-button--toggled')
            siteNavigation.classList.toggle('site-menu__container--visible')
            docBody.classList.toggle('overflow-hidden')
            docBody.classList.toggle('overflow-hidden--mobile')

            if (button.getAttribute('aria-expanded') === 'true') {
                button.setAttribute('aria-expanded', 'false')
            } else {
                button.setAttribute('aria-expanded', 'true')
            }
        });

        const links = menu.getElementsByTagName('a')
        const linksWithChildren = menu.querySelectorAll('.menu-item-has-children > a, .page_item_has_children > a')

        for (const link of links) {
            link.addEventListener('focus', toggleFocus, true)
            link.addEventListener('blur', toggleFocus, true)
        }

        for (const link of linksWithChildren) {
            link.addEventListener('touchstart', toggleFocus, false)
        }

        function toggleFocus() {
            if (event.type === 'focus' || event.type === 'blur') {
                let self = this
                // Move up through the ancestors of the current link until we hit .nav-menu.
                while (!self.classList.contains('nav-menu')) {
                    // On li elements toggle the class .focus.
                    if ('li' === self.tagName.toLowerCase()) {
                        self.classList.toggle('focus')
                    }
                    self = self.parentNode
                }
            }
            if (event.type === 'touchstart') {
                const menuItem = this.parentNode
                event.preventDefault()
                for (const link of menuItem.parentNode.children) {
                    if (menuItem !== link) {
                        link.classList.remove('focus')
                    }
                }
                menuItem.classList.toggle('focus')
            }
        }
    }

    menuHandler()


    // Header Opacity on Scroll
    const headerImage = document.querySelector('.article-header')
    const observerOptions = {
        root: null, rootMargin: '0px', threshold: [...Array(50).keys()].map(x => x / 49)
    }

    let headerImageObserver = new IntersectionObserver(function (entries, observer) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                let headerImage = entry.target
                headerImage.style.opacity = Math.round((entry.intersectionRatio + Number.EPSILON) * 100) / 100
            }
        })
    }, observerOptions)

    headerImageObserver.observe(headerImage)


    // Image Lightbox
    function lightbox() {
        const imageGallery = document.querySelector('.image-gallery--lightbox')

        if (imageGallery) {
            const imageGalleryItem = imageGallery.querySelectorAll('.image-gallery__item')

            imageGalleryItem.forEach((item, index) => {
                const itemData = {
                    'item': item,
                    'index': index,
                    'image': item.dataset.image,
                    'image_width': item.dataset.imagew,
                    'image_height': item.dataset.imageh,
                    'download': item.dataset.download,
                    'size': item.dataset.size,
                    'extension': item.dataset.extension,
                    'caption': item.dataset.caption
                }

                //const lightBox = document.querySelector('.lightbox--' + itemData.index)

                //let lightboxExist = false

                item.addEventListener('click', () => {
                    handleClick()
                })

                item.addEventListener('keyup', (event) => {
                    if (event.key === 'Enter' || event.key === ' ') {
                        handleClick()
                    }
                })

                function handleClick() {
                    const lightbox = document.querySelector("[data-lightbox='" + itemData.index + "']")
                    closeOther()
                    item.setAttribute('aria-expanded', 'true')
                    if (lightbox) {
                        lightbox.classList.remove('visually-hidden')
                        const closeButton = lightbox.querySelector('.lightbox-content__close')
                        closeButton.focus()
                        docBody.classList.add('overflow-hidden')
                    } else {
                        createLightbox(itemData)
                    }
                }

            })

            function createLightbox(itemData) {
                const lightbox = document.createElement('div')
                lightbox.classList.add('lightbox')
                lightbox.setAttribute('data-lightbox', itemData.index)
                lightbox.innerHTML = `<div class="lightbox__inner lightbox-content">
                    <div class="lightbox-content__image">
                        <img width="${itemData.image_width}" height="${itemData.image_height}" src="${itemData.image}" alt="Download">
                    </div>
                    <div class="lightbox-content__links">
                        <a class="button-look" href="${itemData.download}" download>Download ${itemData.caption ? `• ${itemData.caption}` : ``} • ${itemData.extension} • ${itemData.size}</a>
                    </div>
                    <button tabindex="-1" aria-label="Close" type="button" class="lightbox-content__close"><span>Close</span></button>
                </div>
                <div class="lightbox__background"></div>`
                docBody.append(lightbox)
                docBody.classList.add('overflow-hidden')

                const closeButton = lightbox.querySelector('.lightbox-content__close')
                const background = lightbox.querySelector('.lightbox__background')

                closeButton.focus()
                closeButton.addEventListener('click', () => {
                    handleClick()
                })

                closeButton.addEventListener('keyup', (event) => {
                    if (event.key === 'Escape' || event.key === 'Enter' || event.key === ' ') {
                        handleClick()
                    }
                })

                background.addEventListener('click', () => {
                    handleClick()
                })

                function handleClick() {
                    closeOther()
                    setTimeout(() => {
                        itemData.item.focus()
                    }, 500)
                    //itemData.item.focus()
                    itemData.item.setAttribute('aria-expanded', 'false')
                    //  docBody.classList.remove('overflow-hidden', 'overflow-hidden--mobile')
                }
            }

            function closeOther() {
                docBody.classList.remove('overflow-hidden')

                imageGalleryItem.forEach((item) => {
                    item.setAttribute('aria-expanded', 'false')
                })

                let lightboxes = document.querySelectorAll('[data-lightbox]')
                lightboxes.forEach((item) => {
                        item.classList.add('visually-hidden')
                    }
                )
            }

        }
    }

    lightbox()

    function langMenu() {
        const langMenuButton = document.querySelector('.lang-button')

        if (langMenuButton) {
            const langMenu = document.querySelector('#language-switch-menu')

            langMenuButton.addEventListener('click', () => {
                if (langMenuButton.classList.contains('lang-button--active')) {
                    hideLangMenu()
                } else {
                    showLangMenu()
                }
            })

            function showLangMenu() {
                langMenuButton.classList.add('lang-button--active')
                langMenuButton.setAttribute('aria-expanded', 'true')
                langMenu.classList.add('visually-hidden--show')
                setTimeout(() => {
                    document.addEventListener('click', outsideClickListener)
                }, 10)

            }

            function hideLangMenu() {
                langMenuButton.classList.remove('lang-button--active')
                langMenuButton.setAttribute('aria-expanded', 'false')
                langMenu.classList.remove('visually-hidden--show')
                document.removeEventListener('click', outsideClickListener)
            }

            const outsideClickListener = (event) => {
                if (!langMenu.contains(event.target)) {
                    hideLangMenu()
                }
            }

        }

    }

    langMenu()

    // Accordion
    function accordionFunction() {
        const accordion = document.querySelectorAll('.accordion');
        if (accordion) {
            accordion.forEach((item) => {
                const button = item.querySelector('.accordion-header__button')
                const content = item.querySelector('.accordion-content')
                button.addEventListener('click', () => {
                    button.classList.toggle('accordion-header__button--active')
                    if (button.getAttribute('aria-expanded') === 'true') {
                        button.setAttribute('aria-expanded', 'false')
                        content.style.maxHeight = null
                    } else {
                        button.setAttribute('aria-expanded', 'true')
                        content.style.maxHeight = content.scrollHeight + 'px'
                    }
                })
            });
        }
    }

    accordionFunction()


    // Date Block Width

    function dateWidthFunction() {
        const articleBlock = document.querySelectorAll('.article-single');

        if (articleBlock) {
            articleBlock.forEach((item) => {
                const dateBlock = item.querySelector('.section--content-meta')
                if (dateBlock.nextElementSibling.classList.contains('section--small')) {
                    dateBlock.classList.add('section--small')
                }
            })
        }
    }
    dateWidthFunction()

}());