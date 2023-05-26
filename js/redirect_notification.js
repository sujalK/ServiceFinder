// UI elements
const notificationIcon = document.getElementById('notification-bell');

// add event listener
notificationIcon
.addEventListener('click', () => {
    window.location.href = 'notifications.php'
});

// change color
notificationIcon.style = 'font-size: 1.5rem; color: #4caf4f; cursor: pointer;';