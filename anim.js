const observer = new IntersectionObserver((belepes) => {
    belepes.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("cryptoAnim");
        }
/*         else {
            entry.target.classList.remove("cryptoAnim");
        } */
    });
});

const cryptoElements = document.querySelectorAll(".crypto");
cryptoElements.forEach((el) => observer.observe(el));
