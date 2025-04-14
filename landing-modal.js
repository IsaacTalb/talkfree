// JavaScript to handle modal functionality
document.addEventListener('DOMContentLoaded', () => {
    const modals = {
        login: document.getElementById('login-modal'),
        signup: document.getElementById('signup-modal'),
        getStarted: document.getElementById('get-started-modal'),
    };
    const closeButtons = document.querySelectorAll('.close-button');
    const triggerButtons = {
        login: document.querySelector('.login-button'),
        signup: document.querySelector('.sign-up-button'),
        getStarted: document.querySelector('.get-started-button'),
    };

    // Open the respective modal when a trigger button is clicked
    Object.keys(triggerButtons).forEach(action => {
        triggerButtons[action].addEventListener('click', (e) => {
            e.preventDefault();
            modals[action].style.display = 'block';
        });
    });

    // Close modal when any close button is clicked
    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            Object.values(modals).forEach(modal => modal.style.display = 'none');
        });
    });

    // Close modal when clicking outside the modal content
    window.addEventListener('click', (e) => {
        Object.values(modals).forEach(modal => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });
    });
});