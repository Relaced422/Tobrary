function scrollBooks(direction) {
    const container = document.getElementById('booksContainer');
    const scrollAmount = 520; // Card width + gap

    if (direction === 'left') {
        container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
    } else {
        container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    }
}