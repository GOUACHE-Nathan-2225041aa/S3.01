document.querySelectorAll('.btn-update').forEach(btn => {
    btn.addEventListener('click', (e) => {
        e.preventDefault();
        const gameId = e.target.dataset.gameId;
        const gameType = e.target.dataset.gameType;
        fetch(`/api/games`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                game_id: gameId,
                game_type: gameType,
                param: 'update',
            }),
        })
        window.location.href = '/admin';
    });
});
