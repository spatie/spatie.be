const $$ = selectors => [...document.querySelectorAll(selectors)];

function setImageSizes(image) {
    // Take object-fit into account: size needed can be bigger when image is clipped
    const imageRatio = image.naturalWidth / image.naturalHeight;
    const objectFitRatio = image.getBoundingClientRect().width / image.getBoundingClientRect().height;
    const width = Math.ceil((image.getBoundingClientRect().width * imageRatio) / objectFitRatio);

    image.setAttribute('sizes', width + 'px');
}

function handleIntersection(entries, observer) {
    entries.filter(entry => entry.intersectionRatio > 0).forEach(entry => {
        observer.unobserve(entry.target);
        setImageSizes(entry.target);
    });
}

export default function() {
    const observer = new IntersectionObserver(handleIntersection, {
        rootMargin: '100px 0px',
    });

    $$('[srcset][sizes="1px"]').forEach(image => {
        observer.observe(image);
    });

    let resizeTimer;

    window.addEventListener('resize', () => {
        window.clearTimeout(resizeTimer);

        resizeTimer = window.setTimeout(() => {
            $$('[srcset]:not([sizes="1px"])').forEach(image => {
                setImageSizes(image);
            });
        }, 250);
    });
}
