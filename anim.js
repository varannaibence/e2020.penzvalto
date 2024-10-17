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

const observer2 = new IntersectionObserver((belepes2) => {
    belepes2.forEach((entry) => {
        if (entry.isIntersecting) {
            entry.target.classList.add("cardAnim");
        }
/*         else {
            entry.target.classList.remove("cryptoAnim");
        } */
    });
});

const cardList = document.querySelectorAll(".cardAnimZ");
cardList.forEach((el2) => observer2.observe(el2));



/* https://www.youtube.com/watch?v=T33NN_pPeNI&t=48s */
/* https://www.queryselectorall.com/foreach */
const cardElements = document.querySelectorAll(".cardAnimZ");
cardElements.forEach((el, index) => {
    el.style.transitionDelay = `${index * 100}ms`;
});

