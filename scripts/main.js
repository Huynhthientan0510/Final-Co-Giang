// Typing Effect
let i = 0;
let text = 'Learn C++ Online';
let speed = 100;

function typeEffect() {
    if (i < text.length) {
        document.getElementById("typing-text").innerHTML += text.charAt(i);
        i++;
        setTimeout(typeEffect, speed);
    }
}
window.onload = typeEffect;

// Scroll Animation
const sections = document.querySelectorAll('.section');
window.addEventListener('scroll', () => {
    sections.forEach(section => {
        const sectionTop = section.getBoundingClientRect().top;
        if (sectionTop < window.innerHeight - 100) {
            section.classList.add('visible');
        }
    });
});

// Navbar Slide-In
document.querySelector('.navbar-toggle').addEventListener('click', () => {
    document.querySelector('.navbar').classList.toggle('active');
});
