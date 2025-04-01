window.onload = function() {
    const video = document.getElementById('splash-video');
    const splashScreen = document.getElementById('video-splash');
    const mainContent = document.getElementById('main-content');

    // Event listener for when the video ends
    video.onended = function() {
        // Hide the video splash screen
        splashScreen.style.display = 'none';

        // Show the main content
        mainContent.style.display = 'block';
    }
}