import '../sass/app.scss';
import './bootstrap';
import * as bootstrap from 'bootstrap';
import.meta.glob([
    '../img/**'
]);

document.addEventListener("DOMContentLoaded", function () {
    const images = document.querySelectorAll('img.lazy-load');

    images.forEach(img => {
        const realSrc = img.getAttribute('data-src');
        const tempImg = new Image();
        tempImg.src = realSrc;

        tempImg.onload = () => {
            img.src = realSrc;
        };
    })
})