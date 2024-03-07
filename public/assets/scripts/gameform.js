document.getElementById('audio').addEventListener('change', function(e) {
    let fileName = e.target.files[0].name;
    let label = document.getElementById('audio-input-label');
    label.textContent = fileName;
});
document.getElementById('image').addEventListener('change', function(e) {
    let fileName = e.target.files[0].name;
    let label = document.getElementById('image-input-label');
    label.textContent = fileName;
});
