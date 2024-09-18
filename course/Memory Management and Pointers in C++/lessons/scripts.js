// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
	anchor.addEventListener('click', function(e) {
		e.preventDefault();
		document.querySelector(this.getAttribute('href')).scrollIntoView({
			behavior: 'smooth'
		});
	});
});

// Fade in sections on scroll
const faders = document.querySelectorAll('.lesson-section, .hero-content');

const appearOptions = {
	threshold: 0.1, // Element appears once 10% is visible
	rootMargin: "0px 0px -100px 0px"
};

const appearOnScroll = new IntersectionObserver(function(entries, appearOnScroll) {
	entries.forEach(entry => {
		if (!entry.isIntersecting) {
			return;
		}
		entry.target.classList.add('appear');
		appearOnScroll.unobserve(entry.target);
	});
}, appearOptions);

faders.forEach(fader => {
	appearOnScroll.observe(fader);
});

// Button hover animation with JS
const buttons = document.querySelectorAll('.cta-btn, .quiz-btn');

buttons.forEach(button => {
	button.addEventListener('mouseenter', () => {
		button.style.transform = 'scale(1.1)';
		button.style.transition = 'transform 0.3s ease';
	});

	button.addEventListener('mouseleave', () => {
		button.style.transform = 'scale(1)';
	});
});
