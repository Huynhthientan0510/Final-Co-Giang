// Smooth scroll
document.querySelectorAll('a.nav-link').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Navbar shrink on scroll
window.addEventListener('scroll', function () {
    const navbar = document.getElementById('navbar');
    if (window.scrollY > 100) {
        navbar.classList.add('shrink');
    } else {
        navbar.classList.remove('shrink');
    }
});

// Theme toggle
const themeToggle = document.getElementById('theme-toggle');
themeToggle.addEventListener('click', function () {
    document.body.classList.toggle('dark-mode');
    document.querySelectorAll('.accordion-button').forEach(button => {
        button.classList.toggle('dark-mode');
    });
    if (document.body.classList.contains('dark-mode')) {
        themeToggle.textContent = 'Light Mode';
    } else {
        themeToggle.textContent = 'Dark Mode';
    }
});

// Run code from textarea
document.getElementById('run-code').addEventListener('click', function () {
    const code = document.getElementById('code').value;
    const output = eval(code);  // Note: Be careful with eval()
    document.getElementById('output').textContent = output;
});
