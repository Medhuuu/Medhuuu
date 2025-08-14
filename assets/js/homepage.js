// Homepage JavaScript for CineLog

// Play click sound when buttons are pressed
function playClickSound() {
    const audio = document.getElementById('clickSound');
    if (audio) {
        // Reset the audio to the beginning in case it's already playing
        audio.currentTime = 0;
        audio.play().catch(function(error) {
            // Handle the case where audio playback fails (e.g., user hasn't interacted with page yet)
            console.log('Audio playback failed:', error);
        });
    }
}

// Redirect function with slight delay for sound
function redirectTo(url) {
    setTimeout(function() {
        window.location.href = url;
    }, 150); // Small delay to let the sound play
}

// Create click sound programmatically if audio files don't exist
function createClickSound() {
    // Create a simple click sound using Web Audio API
    const audioContext = new (window.AudioContext || window.webkitAudioContext)();
    
    function playTone(frequency, duration) {
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        oscillator.frequency.value = frequency;
        oscillator.type = 'sine';
        
        gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + duration);
        
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + duration);
    }
    
    // Play a pleasant UI click sound
    playTone(800, 0.1);
    setTimeout(() => playTone(1000, 0.05), 50);
}

// Fallback click sound function
function fallbackClickSound() {
    createClickSound();
}

// Enhanced playClickSound function with fallback
function playClickSound() {
    const audio = document.getElementById('clickSound');
    if (audio && audio.canPlayType) {
        audio.currentTime = 0;
        audio.play().catch(function(error) {
            console.log('Audio file playback failed, using fallback sound');
            fallbackClickSound();
        });
    } else {
        // Use Web Audio API fallback
        fallbackClickSound();
    }
}

// Add smooth scroll behavior and additional animations
document.addEventListener('DOMContentLoaded', function() {
    // Add entrance animations to elements
    const elements = document.querySelectorAll('.main-header, .tagline-section, .action-buttons, .features-preview');
    
    elements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.3}s`;
    });
    
    // Add click event listeners to buttons for better accessibility
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add visual feedback
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        });
        
        // Add keyboard support
        button.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });
    });
    
    // Add particle effect on mouse move for extra visual appeal
    let mouseX = 0;
    let mouseY = 0;
    
    document.addEventListener('mousemove', function(e) {
        mouseX = e.clientX;
        mouseY = e.clientY;
        
        // Create subtle floating particles
        if (Math.random() < 0.02) { // 2% chance per mouse move
            createParticle(mouseX, mouseY);
        }
    });
    
    function createParticle(x, y) {
        const particle = document.createElement('div');
        particle.style.position = 'fixed';
        particle.style.left = x + 'px';
        particle.style.top = y + 'px';
        particle.style.width = '4px';
        particle.style.height = '4px';
        particle.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
        particle.style.borderRadius = '50%';
        particle.style.pointerEvents = 'none';
        particle.style.zIndex = '1000';
        particle.style.animation = 'particleFloat 2s ease-out forwards';
        
        document.body.appendChild(particle);
        
        // Remove particle after animation
        setTimeout(() => {
            if (particle.parentNode) {
                particle.parentNode.removeChild(particle);
            }
        }, 2000);
    }
    
    // Add CSS animation for particles
    const style = document.createElement('style');
    style.textContent = `
        @keyframes particleFloat {
            0% {
                opacity: 1;
                transform: translateY(0px) scale(1);
            }
            100% {
                opacity: 0;
                transform: translateY(-100px) scale(0);
            }
        }
    `;
    document.head.appendChild(style);
});

// Add some Easter eggs
let clickCount = 0;
document.addEventListener('click', function() {
    clickCount++;
    if (clickCount === 10) {
        console.log('🎬 Welcome to CineLog! You seem to really like clicking things!');
    } else if (clickCount === 25) {
        console.log('🍿 Fun fact: The first movie theater opened in 1905!');
    }
});

// Preload audio context for better performance
window.addEventListener('load', function() {
    // Try to initialize audio context on first user interaction
    document.addEventListener('click', function initAudio() {
        if (typeof AudioContext !== 'undefined' || typeof webkitAudioContext !== 'undefined') {
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            // Remove this listener after first initialization
            document.removeEventListener('click', initAudio);
        }
    }, { once: true });
});