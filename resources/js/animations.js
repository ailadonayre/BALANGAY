// Page transitions and scroll reveal animations

function initPageTransitions() {
  document.documentElement.classList.add('page-enter');

  // Fade in on load
  window.addEventListener('load', () => {
    document.documentElement.classList.remove('page-enter');
  });

  // Intercept internal link clicks to show exit animation
  document.addEventListener('click', (e) => {
    const a = e.target.closest('a');
    if (!a) return;
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || a.target === '_blank' || href.startsWith('mailto:') || href.startsWith('tel:')) return;
    // Only handle same-origin links
    try {
      const url = new URL(href, window.location.origin);
      if (url.origin === window.location.origin) {
        e.preventDefault();
        document.documentElement.classList.add('page-exit');
        setTimeout(() => { window.location.href = url.href; }, 300);
      }
    } catch (err) {
      // ignore
    }
  });
}

function initRevealObservers() {
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('active');
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -80px 0px' });

  document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

  // Lazy image enhancements: add loaded class when in view and when loaded
  const imgObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const img = entry.target;
        if (img.dataset.src) {
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
        }
        img.loading = 'lazy';
        img.decoding = 'async';
        img.addEventListener('load', () => img.classList.add('loaded'));
        imgObserver.unobserve(img);
      }
    });
  }, { rootMargin: '200px 0px' });

  document.querySelectorAll('img[data-src], img.lazy').forEach(img => imgObserver.observe(img));

  // Toggle-password event delegation: makes it robust for dynamically inserted buttons
  const svgEyeOpen = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>';
  const svgEyeClosed = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.958 9.958 0 012.223-3.428M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/></svg>';

  document.addEventListener('click', (e) => {
    const btn = e.target.closest('.toggle-password');
    if (!btn) return;
    const targetId = btn.dataset.target;
    const input = document.getElementById(targetId);
    if (!input) return;
    if (input.type === 'password') {
      input.type = 'text';
      btn.setAttribute('aria-pressed', 'true');
      btn.setAttribute('aria-label', 'Hide password');
      btn.innerHTML = svgEyeClosed;
    } else {
      input.type = 'password';
      btn.setAttribute('aria-pressed', 'false');
      btn.setAttribute('aria-label', 'Show password');
      btn.innerHTML = svgEyeOpen;
    }
  });
}

export function initAnimations() {
  initPageTransitions();
  initRevealObservers();
}

// Auto-initialize when script loaded in browser
if (typeof window !== 'undefined') {
  document.addEventListener('DOMContentLoaded', () => {
    initAnimations();
  });
}
