document.getElementById('save-progress').addEventListener('click', () => {
    fetch(`/api/progress`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log(data)
            } else {
                console.error(data.error)
            }
            location.reload()
        })
        .catch((error) => {
            console.log('Error:', error)
        })
})
