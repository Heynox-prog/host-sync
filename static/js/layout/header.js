function headerDropdown() {
    const togglers = document.querySelectorAll('.dropdown-toggler');
    const menus = document.querySelectorAll('.dropdown-links');
    const chevrons = document.querySelectorAll('.dropdown-chevron');
    
    togglers.forEach((toggler, i) => {
        toggler.addEventListener('click', () => {
            const isActive = toggler.classList.contains('active');

            togglers.forEach(toggler => toggler.classList.remove('active'));
            menus.forEach((menu) => { menu.classList.remove('active'); });
            chevrons.forEach((chevron) => { chevron.classList.remove('active'); });

            if (!isActive) {
                toggler.classList.add('active');
                menus[i].classList.add('active');
                chevrons[i].classList.add('active');
            }
        });
    });
}

headerDropdown();

function eventOnScroll() {
    const headerContainer = document.querySelector('.header-container');
    let scrollTop = document.documentElement.scrollTop;
    let mainContainer = document.querySelector('main');
    let mainHeight = mainContainer.offsetHeight;

    if (scrollTop > mainHeight / 2) { headerContainer.classList.add('scrolled'); } 
    else { headerContainer.classList.remove('scrolled'); }
}

window.addEventListener('scroll', eventOnScroll);

function headerResponsive() {
    const headerContainer = document.querySelector('.header-nav');
    const responsiveToggler = document.querySelector('.toggle-responsive-header');
    const lines = document.querySelectorAll('.line');

    responsiveToggler.addEventListener('click', () => {
        lines.forEach((line) => {
            line.classList.toggle('active');
            headerContainer.classList.toggle('active');
        });
    })
}

headerResponsive();