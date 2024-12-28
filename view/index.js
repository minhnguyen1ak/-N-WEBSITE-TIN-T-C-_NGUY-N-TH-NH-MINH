document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.banner img');
    const prevButton = document.querySelector('.btn-left');
    const nextButton = document.querySelector('.btn-right');
    let currentIndex = 0;

    const intervalTime = 4000; // 4 seconds

    function showSlide(index) {
        if (index >= slides.length) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = slides.length - 1;
        } else {
            currentIndex = index;
        }
        const offset = -currentIndex * 100;
        document.querySelector('.banner').style.transform = `translateX(${offset}%)`;
    }


    function nextSlide() {
        showSlide(currentIndex + 1);
    }

    prevButton.addEventListener('click', function () {
        showSlide(currentIndex - 1);
    });

    nextButton.addEventListener('click', function () {
        showSlide(currentIndex + 1);
    });

    // Set interval to automatically change slides
    setInterval(nextSlide, intervalTime);

    showSlide(currentIndex);
});




