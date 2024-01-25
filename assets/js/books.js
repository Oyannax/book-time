// const notifContainer = document.getElementById('notifContainer');
// if (notifContainer.children.length > 0) setTimeout(() => notifContainer.innerHTML = '', 2000);


const carousel = document.querySelector('.carousel-content');
const firstSlide = document.querySelectorAll('.slide')[0];
const nextSlide = document.querySelectorAll('.slide')[1];
const arrows = document.querySelectorAll('.controls-container .arrow');
const dots = document.querySelectorAll('.dot-container .dot');

let currentIndex = 0;
carousel.scrollLeft = 0;
dots[0].classList.add('active');

carousel.addEventListener('scroll', showDisabledArrow);
document.addEventListener('scroll', showActiveDot);

function showDisabledArrow() {
    let scrollWidth = carousel.scrollWidth - carousel.clientWidth;
    if (carousel.scrollLeft === 0) {
        arrows[0].setAttribute('disabled', '');
    } else {
        arrows[0].removeAttribute('disabled');
    }
    if (carousel.scrollLeft === scrollWidth) {
        arrows[1].setAttribute('disabled', '');
    } else {
        arrows[1].removeAttribute('disabled');
    }
}

function showActiveDot() {
    for (let i = 0; i < dots.length; i++) {
        if (i === currentIndex) {
            dots[i].classList.add('active');
        } else {
            dots[i].classList.remove('active');
        }
    }
}

arrows.forEach(arrow => {
    arrow.addEventListener('click', (e) => {
        let firstSlideWidth = firstSlide.clientWidth + 17;
        let nextSlideWidth = nextSlide.clientWidth + 17;
        if (!e.detail || e.detail === 1) {
            if (arrow.id === 'next') {
                if (carousel.scrollLeft === 0) {
                    carousel.scrollLeft += firstSlideWidth;
                    currentIndex++;
                } else {
                    carousel.scrollLeft += nextSlideWidth;
                    currentIndex++;
                }
            } else {
                carousel.scrollLeft -= nextSlideWidth;
                currentIndex--;
            }
            setTimeout(() => showDisabledArrow(), 60);
            showActiveDot();
        } else {
            return;
        }
    })
})



const toRead = document.querySelector('.to-read-content');
const listWrap = document.querySelector('.list-container');

let isDragStart = false;

let prevPageX;
let prevScrollLeft;

function dragStart(e) {
    isDragStart = true;
    prevPageX = e.pageX || e.touches[0].pageX;
    prevScrollLeft = this.scrollLeft;
    this.style.cursor = 'grabbing';
}

function dragStop() {
    isDragStart = false;
    this.style.cursor = 'grab';
}

function dragging(e) {
    if (!isDragStart) return;
    e.preventDefault();
    let positionDiff = (e.pageX || e.touches[0].pageX) - prevPageX;
    this.scrollLeft = prevScrollLeft - positionDiff;
}

toRead.addEventListener('mousedown', dragStart);
toRead.addEventListener('touchstart', dragStart);

toRead.addEventListener('mouseup', dragStop);
toRead.addEventListener('touchend', dragStop);

toRead.addEventListener('mousemove', dragging);
toRead.addEventListener('touchmove', dragging);


listWrap.addEventListener('mousedown', dragStart);
listWrap.addEventListener('touchstart', dragStart);

listWrap.addEventListener('mouseup', dragStop);
listWrap.addEventListener('touchend', dragStop);

listWrap.addEventListener('mousemove', dragging);
listWrap.addEventListener('touchmove', dragging);