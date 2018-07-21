/* Enhance medialibrary srcset script when upsizing a browser */

export default function() {
    const srcsets = document.querySelectorAll('[srcset][sizes="1px"]');

    for (let i = 0; i < srcsets.length; ++i) {
        const img = srcsets[i];

        /* Take object-fit into account: size needed can be bigger when image is clipped */
        const imgRatio = img.naturalWidth/img.naturalHeight;
        const objectFitRatio = img.getBoundingClientRect().width/img.getBoundingClientRect().height;
        const width = Math.ceil(img.getBoundingClientRect().width * imgRatio / objectFitRatio);

        srcsets[i].setAttribute(
            'sizes',
            width + 'px'
        );
    }
}
