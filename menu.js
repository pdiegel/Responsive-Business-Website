const hamburger = document.getElementById('hamburger');
const navUL = document.getElementById('nav-ul');

hamburger.addEventListener('click', () => {
    navUL.classList.toggle('show');
    if (navUL.classList.contains('show')) {
        hamburger.src = 'images/close.svg';
    } else {
        hamburger.src = 'images/hamburger.svg';
    }
});