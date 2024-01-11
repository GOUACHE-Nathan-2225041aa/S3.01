document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault()
        const gameId = e.target.dataset.gameId
        const gameType = e.target.dataset.gameType
        fetch(`/api/games`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                game_id: gameId,
                game_type:gameType,
                param: 'delete',
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                e.target.parentElement.remove()
            } else {
                console.error(data.error)
            }
        })
        .catch(error => {
            console.error(error)
        });
    })
})
