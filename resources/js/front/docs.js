import partition from 'lodash/partition';

export default function() {
    let elementsInView = [];
    const navLinks = [...document.querySelectorAll('.docs-submenu-item')];

    navLinks.forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth',
            });
        });
    });

    const intersectionObserver = new IntersectionObserver(entries => {
        elementsInView = updateElementsInView(entries);

        if (!elementsInView.length) {
            return;
        }

        const elementClosestToTop = getElementClosestToTop(elementsInView);

        toggleNavLinkActive(navLinks, elementClosestToTop);
    });

    navLinks.forEach(link => {
        const element = document.querySelector(link.getAttribute('href'));

        if (!element) {
            return;
        }

        intersectionObserver.observe(element);
    });

    function toggleNavLinkActive(navLinks, elementClosestToTop) {
        navLinks.forEach(link => {
            if (link.getAttribute('href').substr(1) === elementClosestToTop.id) {
                link.classList.add('is-active');
            } else {
                link.classList.remove('is-active');
            }
        });
    }

    function updateElementsInView(entries) {
        const [elementsEntering, elementsLeaving] = partition(entries, entry => entry.isIntersecting).map(entries =>
            entries.map(entry => entry.target)
        );

        return [...elementsInView.filter(el => !elementsLeaving.includes(el)), ...elementsEntering];
    }

    function getElementClosestToTop(elementsInView) {
        return elementsInView.reduce((elementClosestToTop, element) => {
            return offsetTop(element) < offsetTop(elementClosestToTop) ? element : elementClosestToTop;
        }, elementsInView[0]);
    }

    function offsetTop(element) {
        return window.pageYOffset + element.getBoundingClientRect().top;
    }
}
