document.addEventListener('DOMContentLoaded', function() {
    // Like button functionality
    const likeButtons = document.querySelectorAll('.like-btn');
    
    likeButtons.forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            const photoId = this.getAttribute('data-id');
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => {
                if (response.status === 401) {
                    // User is not authenticated - redirect to login
                    window.location.href = '/login';
                    return Promise.reject('Not authenticated');
                }
                return response.json();
            })
            .then(data => {
                // Update the like count
                const likeCountSpan = this.querySelector('.like-count');
                likeCountSpan.textContent = data.likes_count;
                
                // Update the heart icon
                const heartSpan = this.querySelector('.heart');
                if (data.liked) {
                    heartSpan.textContent = '❤️';
                    this.classList.add('liked');
                } else {
                    heartSpan.textContent = '🤍';
                    this.classList.remove('liked');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                if (error !== 'Not authenticated') {
                    alert('Please log in to like photos!');
                }
            });
        });
    });
});
