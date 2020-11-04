'use strict';

document.addEventListeners('DOMContentLoaded', () => {
    let frames = document.querySelectorAll('.splitscreen');
    let options = {
        threshold: 0.3,
    };
    let observer = new IntersectionObserver(handleIntersection, options);

    // pour chaque frame correspondant à la classe sliptscreen, un eventListener est
    // appliqué, déclenchant la fonction handleInstersection
    frames.forEach(frame => observer.observe(frame));

});


function handleIntersection(intersection) {
    // si la div concernée (splitscreen) entre en intersection avec la fenetre du navigateur, la class .visible est activée et lance les animations en CSS.
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

