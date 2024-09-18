// Smooth scroll to sections
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
	anchor.addEventListener('click', function (e) {
		e.preventDefault();
		document.querySelector(this.getAttribute('href')).scrollIntoView({
			behavior: 'smooth'
		});
	});
});

// Fade in sections on scroll
const faders = document.querySelectorAll('.courses-section, .course-card');

const appearOptions = {
	threshold: 0.15, // Slightly increase the threshold to reduce animation lag
	rootMargin: "0px 0px -100px 0px" // Adjust margin for smoother animation
};

const appearOnScroll = new IntersectionObserver((entries, observer) => {
	entries.forEach(entry => {
		if (entry.isIntersecting) {
			entry.target.classList.add('appear');
			observer.unobserve(entry.target);
		}
	});
}, appearOptions);

faders.forEach(fader => {
	appearOnScroll.observe(fader);
});

// Button hover animation
document.querySelectorAll('.btn').forEach(button => {
	button.addEventListener('mouseenter', () => {
		button.style.transform = 'scale(1.05)';
	});
	button.addEventListener('mouseleave', () => {
		button.style.transform = 'scale(1)';
	});
});
