let hint = ''

function requestHint() {
    fetch(`/api/hint`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
        .then(response => response.json())
        .then(data => {
            hint = data
            document.getElementById('dialogue-text').textContent = hint
            document.getElementById('head').src = '/assets/images/characters/me/me_head.png'
            document.getElementById('name').textContent = 'Me'
        })
        .catch((error) => {
            console.log('Error:', error)
        })
}

document.getElementById('btn-hint').addEventListener('click', showHint)
document.getElementById('btn-dialogue').addEventListener('click', closeHint)

function showHint() {
    if (hint === '') requestHint()
    let hintElement = document.getElementById('bas')
    hintElement.style.display = 'flex'
}

function closeHint() {
    let hintElement = document.getElementById('bas')
    hintElement.style.display = 'none'
}
