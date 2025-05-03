
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all favorite buttons on the page
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = e.target;
            const button = form.querySelector('button');
            const icon = form.querySelector('i');
            
            // Disable button temporarily to prevent double clicks
            button.disabled = true;
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    
                    // Add pulse animation effect
                    button.classList.add('animate-pulse');
                    
                    // Update icon based on favorite status
                    if (data.favorited) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill');
                    } else {
                        icon.classList.remove('bi-heart-fill');
                        icon.classList.add('bi-heart');
                    }
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        button.classList.remove('animate-pulse');
                    }, 300);
                } else {
                    const errorData = await response.json();
                    console.error('Error:', errorData.error);
                    
                    // If unauthorized, redirect to login
                    if (response.status === 401) {
                        window.location.href = '/clientLogin';
                    }
                }
            } catch (error) {
                console.error('Fetch error:', error);
            } finally {
                // Re-enable button
                button.disabled = false;
            }
        });
    });
});


{/* <style>
@keyframes pulse {
  0% {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
  100% {
    transform: scale(1);
  }
}

.animate-pulse {
  animation: pulse 0.3s ease-in-out;
}
</style>  */}



    /**
 * This script manages the interactive features on the property listings page
 */
document.addEventListener('DOMContentLoaded', function() {
    // Handle favorite button interactions
    setupFavoriteButtons();
    
    // Optional: Add hover effects for property cards
    setupCardHoverEffects();
    
    // Optional: Add search form animations
    setupSearchFormAnimations();
});

/**
 * Configure the favorite toggle buttons
 */
function setupFavoriteButtons() {
    document.querySelectorAll('.favorite-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const form = e.target;
            const button = form.querySelector('button');
            const icon = form.querySelector('i');
            
            // Disable button temporarily to prevent double clicks
            button.disabled = true;
            
            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': form.querySelector('[name=_token]').value,
                        'Accept': 'application/json'
                    }
                });
                
                if (response.ok) {
                    const data = await response.json();
                    
                    // Add pulse animation effect
                    button.classList.add('animate-pulse');
                    
                    // Update icon based on favorite status
                    icon.classList.toggle('bi-heart-fill', data.favorited);
                    icon.classList.toggle('bi-heart', !data.favorited);
                    
                    // Optional: Show a toast notification
                    showToastNotification(data.favorited);
                    
                    // Remove animation class after animation completes
                    setTimeout(() => {
                        button.classList.remove('animate-pulse');
                    }, 300);
                } else {
                    const errorData = await response.json();
                    
                    // If unauthorized, redirect to login
                    if (response.status === 401) {
                        window.location.href = '/clientLogin';
                    }
                }
            } catch (error) {
                console.error('Fetch error:', error);
            } finally {
                // Re-enable button
                button.disabled = false;
            }
        });
    });
}

/**
 * Add hover effects to property cards
 */
function setupCardHoverEffects() {
    // Optional: Add hover animation for property images
    document.querySelectorAll('.property-image-container img').forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
    
    // Optional: Add hover effect for cards
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.classList.add('shadow');
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.classList.remove('shadow');
            this.style.transform = 'translateY(0)';
        });
    });
}

/**
 * Add subtle animations to the search form
 */
function setupSearchFormAnimations() {
    const searchForm = document.querySelector('form[action*="clientsListings"]');
    
    if (searchForm) {
        // Optional: Add focus effects for form inputs
        searchForm.querySelectorAll('input, select').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('border-primary');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('border-primary');
            });
        });
    }
}

/**
 * Display a toast notification when favoriting/unfavoriting
 * @param {boolean} isFavorited - Whether the property was favorited
 */
function showToastNotification(isFavorited) {
    // Check if toast container exists, create if not
    let toastContainer = document.getElementById('toast-container');
    
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toastId = 'favorite-toast-' + Date.now();
    const toast = document.createElement('div');
    toast.id = toastId;
    toast.className = 'toast align-items-center text-white bg-' + (isFavorited ? 'danger' : 'secondary');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    
    // Toast content
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-${isFavorited ? 'heart-fill' : 'heart'} me-2"></i>
                Property ${isFavorited ? 'added to' : 'removed from'} favorites
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    `;
    
    // Add toast to container
    toastContainer.appendChild(toast);
    
    // Initialize and show toast
    const bsToast = new bootstrap.Toast(toast, {
        autohide: true,
        delay: 3000
    });
    
    bsToast.show();
    
    // Remove toast element after it's hidden
    toast.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}
