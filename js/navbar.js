function toggleMenu() {
    const links = document.querySelector('.navbar .links');
    const menuButton = document.querySelector('.menu-button');

    links.classList.toggle('active');
    menuButton.classList.toggle('active');
}
