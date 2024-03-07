document.querySelectorAll('img[data-src]').forEach(img => {
    const tempImg = new Image()
    tempImg.src = img.dataset.src
    tempImg.onload = function() {
        const aspectRatio = this.width / this.height
        if (Math.abs(aspectRatio - 1.33) < 0.01) {
            img.classList.add('square')
        } else if (this.width > this.height) {
            img.classList.add('horizontal')
        } else {
            img.classList.add('vertical')
        }
        img.src = this.src;
    }
})

let img = document.getElementById('zoom-img');

img.addEventListener('mouseover', function() {
    img.classList.add('zoom');
});

img.addEventListener('mouseout', function() {
    img.classList.remove('zoom');
});
