import ScrollReveal from 'scrollreveal';

const sr = ScrollReveal({
  distance: '20px',
  duration: 600,
  easing: 'ease-in-out',
  origin: 'bottom',
  reset: false,
});

// Default reveal for single elements (delayed for elements not in initial viewport)
sr.reveal('[data-reveal]', {
  interval: 150,
  delay: 100,
});

// Reveal sliding down (origin top)
sr.reveal('[data-reveal-down]', {
  origin: 'top',
  delay: 200,
});

// Staggered reveal for children of a container
document.querySelectorAll('[data-reveal-children]').forEach((container) => {
  sr.reveal(container.children, {
    interval: 100,
    delay: 200,
  });
});
