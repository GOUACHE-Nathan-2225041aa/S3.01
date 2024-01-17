document.getElementById('language-selector').addEventListener('change', () => {
    fetch(`/api/language`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            language: document.getElementById('language-selector').value
        }),
    })
        .then(response => response.json())
        .then(() => {
            location.reload()
        })
        .catch((error) => {
            console.log('Error:', error)
        })
})
