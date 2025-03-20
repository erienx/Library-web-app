document.addEventListener("DOMContentLoaded", () => {
    const sliders = document.querySelectorAll(".card-wrapper");

    sliders.forEach((slider) => {
        const cardList = slider.querySelector(".card-list");
        const btnLeft = slider.querySelector(".slider-button.left");
        const btnRight = slider.querySelector(".slider-button.right");
        const cardItem = slider.querySelector(".card-item");

        const scrollAmount = cardItem.offsetWidth + 100;

        function updateButtonVisibility() {
            const isAtLeft = cardList.scrollLeft === 0;
            const isAtRight = cardList.scrollLeft + cardList.offsetWidth >= cardList.scrollWidth;

            btnLeft.style.display = isAtLeft ? "none" : "block";
            btnRight.style.display = isAtRight ? "none" : "block";
        }

        btnRight.addEventListener("click", () => {
            cardList.scrollBy({ left: scrollAmount, behavior: "smooth" });
        });
        btnLeft.addEventListener("click", () => {
            cardList.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });

        updateButtonVisibility();

        cardList.addEventListener("scroll", updateButtonVisibility);
    });
});
