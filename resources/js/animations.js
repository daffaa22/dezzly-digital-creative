import Lenis from 'lenis';
import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

export function initStudioAnimations() {
    // 1. Inisialisasi Lenis Smooth Scroll (Inertial Momentum Scrolling)
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    let lenis = null;

    if (!prefersReducedMotion) {
        try {
            lenis = new Lenis({
                duration: 1.2,
                easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
                direction: 'vertical',
                gestureDirection: 'vertical',
                smooth: true,
                smoothTouch: false,
                touchMultiplier: 2,
            });

            // Sinkronisasi Lenis dengan GSAP ScrollTrigger
            lenis.on('scroll', ScrollTrigger.update);

            gsap.ticker.add((time) => {
                lenis.raf(time * 1000);
            });

            gsap.ticker.lagSmoothing(0);
        } catch (e) {
            console.warn('Lenis fallback to standard smooth scroll', e);
        }
    }

    // 2. Interactive Ambient Cursor Glow / Spotlight
    initCursorSpotlight();

    // 3. Interactive 3D Perspective Tilt on Portfolio & Package Cards
    init3DCardTilt();

    // 4. Scroll-Triggered Staggered Fade & Rise Animations
    initScrollReveals();

    // 5. Animated Number Counters
    initStatCounters();

    // 6. Smooth Anchor Navigation Click Handler
    initSmoothAnchors(lenis);
}

/**
 * Interactive cursor spotlight effect that follows mouse movement
 */
function initCursorSpotlight() {
    const spotlight = document.getElementById('ambient-cursor-spotlight');
    if (!spotlight) return;

    let mouseX = window.innerWidth / 2;
    let mouseY = window.innerHeight / 2;
    let currentX = mouseX;
    let currentY = mouseY;

    window.addEventListener('pointermove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        spotlight.style.opacity = '1';
    }, { passive: true });

    window.addEventListener('mouseleave', () => {
        spotlight.style.opacity = '0';
    });

    // Smooth lerp loop for the glow
    function animateSpotlight() {
        currentX += (mouseX - currentX) * 0.15;
        currentY += (mouseY - currentY) * 0.15;
        spotlight.style.transform = `translate3d(${currentX}px, ${currentY}px, 0)`;
        requestAnimationFrame(animateSpotlight);
    }
    requestAnimationFrame(animateSpotlight);
}

/**
 * Interactive 3D Perspective Tilt on hover (Award-winning agency style)
 */
function init3DCardTilt() {
    const cards = document.querySelectorAll('.card-3d-tilt');
    if (!cards.length) return;

    cards.forEach((card) => {
        let bounds;

        function rotateToMouse(e) {
            bounds = card.getBoundingClientRect();
            const mouseX = e.clientX;
            const mouseY = e.clientY;
            const leftX = mouseX - bounds.x;
            const topY = mouseY - bounds.y;
            const center = {
                x: leftX - bounds.width / 2,
                y: topY - bounds.height / 2,
            };

            const maxTilt = 7; // degrees
            const xPercent = center.x / (bounds.width / 2);
            const yPercent = center.y / (bounds.height / 2);

            const rotateX = -yPercent * maxTilt;
            const rotateY = xPercent * maxTilt;

            card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) scale3d(1.015, 1.015, 1.015)`;
        }

        card.addEventListener('mouseenter', () => {
            bounds = card.getBoundingClientRect();
            card.style.transition = 'transform 0.1s ease-out';
        });

        card.addEventListener('mousemove', rotateToMouse);

        card.addEventListener('mouseleave', () => {
            card.style.transition = 'transform 0.5s cubic-bezier(0.25, 1, 0.5, 1)';
            card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
        });
    });
}

/**
 * Scroll-triggered staggered reveal animations using GSAP & ScrollTrigger
 */
function initScrollReveals() {
    const revealElements = document.querySelectorAll('.gsap-reveal');
    if (!revealElements.length) return;

    revealElements.forEach((el) => {
        const delay = el.dataset.delay ? parseFloat(el.dataset.delay) : 0;
        const direction = el.dataset.direction || 'up';

        let yOffset = 36;
        if (direction === 'down') yOffset = -36;

        gsap.fromTo(
            el,
            {
                opacity: 0,
                y: yOffset,
            },
            {
                opacity: 1,
                y: 0,
                duration: 0.9,
                delay: delay,
                ease: 'power3.out',
                scrollTrigger: {
                    trigger: el,
                    start: 'top 88%',
                    toggleActions: 'play none none none',
                    once: true,
                },
            }
        );
    });

    // Staggered reveal for grid containers (.gsap-stagger-container)
    const staggerContainers = document.querySelectorAll('.gsap-stagger-container');
    staggerContainers.forEach((container) => {
        const items = container.querySelectorAll('.gsap-stagger-item');
        if (!items.length) return;

        gsap.fromTo(
            items,
            {
                opacity: 0,
                y: 32,
            },
            {
                opacity: 1,
                y: 0,
                duration: 0.8,
                stagger: 0.12,
                ease: 'power2.out',
                scrollTrigger: {
                    trigger: container,
                    start: 'top 85%',
                    toggleActions: 'play none none none',
                    once: true,
                },
            }
        );
    });
}

/**
 * Animated number counters on scroll
 */
function initStatCounters() {
    const counters = document.querySelectorAll('.animated-counter');
    if (!counters.length) return;

    counters.forEach((counter) => {
        const target = parseInt(counter.dataset.target, 10) || 0;
        const suffix = counter.dataset.suffix || '';
        const prefix = counter.dataset.prefix || '';

        const obj = { val: 0 };
        gsap.to(obj, {
            val: target,
            duration: 2,
            ease: 'power2.out',
            scrollTrigger: {
                trigger: counter,
                start: 'top 90%',
                once: true,
            },
            onUpdate: () => {
                counter.innerText = prefix + Math.floor(obj.val).toLocaleString('id-ID') + suffix;
            },
        });
    });
}

/**
 * Smooth Anchor Navigation
 */
function initSmoothAnchors(lenis) {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', function (e) {
            const targetId = this.getAttribute('href');
            if (!targetId || targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                if (lenis) {
                    lenis.scrollTo(targetElement, { offset: -70 });
                } else {
                    targetElement.scrollIntoView({ behavior: 'smooth' });
                }
            }
        });
    });
}

