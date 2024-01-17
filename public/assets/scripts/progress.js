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
            if (data['saveClient']) {
                localStorage.setItem('progressData', JSON.stringify(data));
                console.log('Progress saved to local storage')
            }
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

document.getElementById('load-progress').addEventListener('click', () => {
    const progressData = localStorage.getItem('progressData');

    if (progressData) {
        fetch(`/api/progress`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: progressData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Data sent successfully');
                } else {
                    console.error('Failed to send data: ', data.error);
                }
                location.reload();
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }
})
