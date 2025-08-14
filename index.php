<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CineLog - A Movie Review Tracker</title>
    <link rel="stylesheet" href="assets/css/homepage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Palatino+Linotype:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="hero-container">
        <div class="dramatic-background">
            <div class="clouds-overlay"></div>
            <div class="figure-silhouette"></div>
        </div>
        
        <div class="content-wrapper">
            <header class="main-header">
                <h1 class="site-title">CineLog</h1>
                <p class="site-subtitle">A Movie Review Tracker</p>
            </header>
            
            <div class="tagline-section">
                <h2 class="main-tagline">Track films you've watched.</h2>
                <h2 class="main-tagline">Save those you want to see.</h2>
                <h2 class="main-tagline">Tell your friends what's good.</h2>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-signup" onclick="playClickSound(); redirectTo('pages/signup.php')">
                    Sign Up
                </button>
                <button class="btn btn-login" onclick="playClickSound(); redirectTo('pages/login.php')">
                    Login
                </button>
            </div>
            
            <div class="features-preview">
                <p class="preview-text">Join the community of film enthusiasts</p>
            </div>
        </div>
    </div>

    <audio id="clickSound" preload="auto">
        <source src="assets/js/click-sound.mp3" type="audio/mpeg">
        <source src="assets/js/click-sound.wav" type="audio/wav">
    </audio>

    <script src="assets/js/homepage.js"></script>
</body>
</html>