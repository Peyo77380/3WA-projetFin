'use strict';

console.log('ok');

let frames = document.querySelectorAll('.splitscreen');

function handleIntersection(intersection) {
    intersection.map((el) => {

        if (el.isIntersecting) {
            console.log('inters');
            console.log(el);
            el.target.classList.add('visible');

        } else {
            console.log('not inters');
            console.log(el);
            el.target.classList.remove('visible');
        }


    });
}

let options = {
    threshold: 0.3,
};
let observer = new IntersectionObserver(handleIntersection, options);

frames.forEach(frame => observer.observe(frame));