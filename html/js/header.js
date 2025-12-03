const arrowButton = document.getElementById('arrowButton');
const navSection = document.getElementById('navSection');

arrowButton.addEventListener('click', function (e) {
    e.preventDefault();

    if (navSection.classList.contains('max-h-0')) {
        // Open the section
        navSection.classList.remove('max-h-0', 'opacity-0');
        navSection.classList.add('max-h-[200px]', 'opacity-100');
    } else {
        // Close the section
        navSection.classList.remove('max-h-[200px]', 'opacity-100');
        navSection.classList.add('max-h-0', 'opacity-0');
    }
});