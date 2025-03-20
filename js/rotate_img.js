document.addEventListener('DOMContentLoaded', function() {
    const images = document.querySelectorAll('.banner-image img');
    let currentIndex = 0;
    const totalImages = images.length;

    function changeImage() {
        images[currentIndex].classList.remove('active');
        // console.log(currentIndex);
        currentIndex = (currentIndex+1) % totalImages;
        images[currentIndex].classList.add('active');
        // console.log(currentIndex);
    }

    images[currentIndex].classList.add('active');

    setInterval(changeImage, 5000);
});
