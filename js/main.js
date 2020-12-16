const navSlider = () => {
    const burguer = document.querySelector('.burguer');
    const nav = document.querySelector('.menu_principal');
    const navlinks = document.querySelectorAll('.menu_principal li');
    /* animacion del nav*/
    burguer.addEventListener('click', () => {
        nav.classList.toggle('nav-active');
        /* animacion de los li */
        navlinks.forEach((link, index) => {
            const efectoFadeEntrada = `efectoFadeEntrada 0.5s ease forwards ${index / 7 + 0.3}s`;
            if (link.style.animation) {
                link.style.animation = '';
                link.style.transition = 'opacity 1s ease';
            } else {
                link.style.animation = efectoFadeEntrada;
            }
            console.log(index)
        });

        //animacion hamburguesa
        burguer.classList.toggle('toggle');

    });

}
navSlider();