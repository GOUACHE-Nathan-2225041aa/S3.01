window.onload = () => {
    document.querySelectorAll('img[data-src]').forEach(img => {
        const tempImg = new Image()
        tempImg.src = img.dataset.src
        tempImg.onload = function() {
            if (this.width > this.height) {
                img.classList.add('horizontal')
            } else {
                img.classList.add('vertical')
            }
            img.src = this.src;
        }
    })
}
