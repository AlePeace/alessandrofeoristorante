/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';
import Lenis from 'lenis'

gsap.registerPlugin(ScrollTrigger);

function initLenis() {
	const lenis = new Lenis({
		duration: 2, // Durata dell'animazione di scroll
		easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)), // Easing personalizzato
		direction: 'vertical', // Direzione dello scroll
		gestureDirection: 'vertical', // Direzione dei gesti
		smooth: true, // Abilita smooth scroll
		mouseMultiplier: 1, // Moltiplicatore per il mouse
		smoothTouch: false, // Disabilita su touch per performance migliori
		touchMultiplier: 1, // Moltiplicatore per touch
		infinite: false, // Scroll infinito disabilitato
		autoResize: true, // Auto resize
		anchors: {
			offset: 100, // Offset per compensare l'header fisso
			onComplete: () => {
				console.log('Scrolled to anchor with Lenis');
			},
		},
	});

	// Integrazione con GSAP ScrollTrigger
	lenis.on('scroll', ScrollTrigger.update);

	gsap.ticker.add((time) => {
		lenis.raf(time * 1000);
	});

	gsap.ticker.lagSmoothing(0);

	return lenis;
}
// OTTIMIZZAZIONE SCROLLTRIGGER
function optimizeScrollTrigger() {
	ScrollTrigger.config({
		limitCallbacks: true,
		ignoreMobileResize: true,
		autoRefreshEvents: 'visibilitychange,DOMContentLoaded,load',
		syncInterval: 150,
	});
}

document.addEventListener('DOMContentLoaded', () => {
	optimizeScrollTrigger();

	const lenis = initLenis();

	// Scroll to top function
	window.scrollToTop = () => {
		lenis.scrollTo(0);
	};

	// Scroll to element function
	window.scrollToElement = (element, offset = 0) => {
		lenis.scrollTo(element, { offset: offset });
	};

	// Stop/start smooth scroll
	window.stopSmoothScroll = () => {
		lenis.stop();
	};

	window.startSmoothScroll = () => {
		lenis.start();
	};
});

// ─────────────────────────────────────────────
// HEADER — FASE LUNARE
// ─────────────────────────────────────────────

const MOON_PHASE_NAMES = [
	'LUNA NUOVA',
	'LUNA CRESCENTE',
	'PRIMO QUARTO',
	'GIBBOSA CRESCENTE',
	'LUNA PIENA',
	'GIBBOSA CALANTE',
	'ULTIMO QUARTO',
	'LUNA CALANTE',
];

/**
 * Genera l'SVG della fase lunare.
 *
 * Tecnica: arco esterno (outline del cerchio) + path che combina
 * l'arco illuminato e il terminatore (ellisse che separa luce/ombra).
 *
 * Cerchio: cx=12 cy=12 r=9 (SVG 24×24)
 * Arco orario   (sweep=1): va a DESTRA
 * Arco antiorario (sweep=0): va a SINISTRA
 * Dall'interno (dal basso verso l'alto):
 *   sweep=1 → curva a SINISTRA  (ombra sul lato sinistro)
 *   sweep=0 → curva a DESTRA   (ombra sul lato destro)
 */
function getMoonPhaseSVG(phaseIndex) {
	const open    = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">`;
	const outline = `<circle cx="12" cy="12" r="9" stroke="rgba(255,255,255,0.35)" stroke-width="1" fill="rgba(255,255,255,0.05)"/>`;

	switch (phaseIndex) {
		case 0: // Luna Nuova — solo contorno
			return `${open}<circle cx="12" cy="12" r="9" stroke="rgba(255,255,255,0.45)" stroke-width="1.5" fill="rgba(255,255,255,0.06)"/></svg>`;

		case 1: // Luna Crescente — falce sottile a destra
			// Arco esterno CW (destra) → terminatore CCW rx=6 (→ x=18) → striscia x=18..21
			return `${open}${outline}<path d="M12,3 A9,9 0 0,1 12,21 A6,9 0 0,0 12,3 Z" fill="white"/></svg>`;

		case 2: // Primo Quarto — metà destra
			return `${open}${outline}<path d="M12,3 A9,9 0 0,1 12,21 L12,3 Z" fill="white"/></svg>`;

		case 3: // Gibbosa Crescente — luce a destra, ombra sottile a sinistra
			// Arco esterno CW (destra) → terminatore CW rx=3 (→ x=9) → area x=9..21
			return `${open}${outline}<path d="M12,3 A9,9 0 0,1 12,21 A3,9 0 0,1 12,3 Z" fill="white"/></svg>`;

		case 4: // Luna Piena
			return `${open}<circle cx="12" cy="12" r="9" fill="white"/></svg>`;

		case 5: // Gibbosa Calante — luce a sinistra, ombra sottile a destra
			// Arco esterno CCW (sinistra) → terminatore CCW rx=3 (→ x=15) → area x=3..15
			return `${open}${outline}<path d="M12,3 A9,9 0 0,0 12,21 A3,9 0 0,0 12,3 Z" fill="white"/></svg>`;

		case 6: // Ultimo Quarto — metà sinistra
			return `${open}${outline}<path d="M12,3 A9,9 0 0,0 12,21 L12,3 Z" fill="white"/></svg>`;

		case 7: // Luna Calante — falce sottile a sinistra
			// Arco esterno CCW (sinistra) → terminatore CW rx=6 (→ x=6) → striscia x=3..6
			return `${open}${outline}<path d="M12,3 A9,9 0 0,0 12,21 A6,9 0 0,1 12,3 Z" fill="white"/></svg>`;

		default:
			return `${open}${outline}</svg>`;
	}
}

/**
 * Calcola la fase lunare corrente (0–7).
 * Riferimento: luna nuova del 6 gennaio 2000 alle 18:14 UTC.
 */
function calcMoonPhaseIndex() {
	const now             = new Date();
	const knownNewMoon    = new Date( Date.UTC( 2000, 0, 6, 18, 14, 0 ) );
	const lunarCycleDays  = 29.530588853;
	const daysSince       = ( now.getTime() - knownNewMoon.getTime() ) / 86400000;
	const age             = ( ( daysSince % lunarCycleDays ) + lunarCycleDays ) % lunarCycleDays;
	return Math.round( ( age / lunarCycleDays ) * 8 ) % 8;
}

function initMoonPhase() {
	const iconEl = document.getElementById( 'moon-phase-icon' );
	const nameEl = document.getElementById( 'moon-phase-name' );
	if ( ! iconEl || ! nameEl ) return;

	const phase  = calcMoonPhaseIndex();
	iconEl.innerHTML  = getMoonPhaseSVG( phase );
	nameEl.textContent = MOON_PHASE_NAMES[ phase ];
}

// ─────────────────────────────────────────────
// HEADER — AUDIO MARE
// ─────────────────────────────────────────────

const SVG_AUDIO_OFF = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M12 4L9.91 6.09L12 8.18M4.27 3L3 4.27L7.73 9H3V15H7L12 20V13.27L16.25 17.53C15.58 18.04 14.83 18.46 14 18.7V20.77C15.38 20.45 16.63 19.82 17.68 18.96L19.73 21L21 19.73L12 10.73M19 12C19 12.94 18.8 13.82 18.46 14.64L19.97 16.15C20.6455 14.8709 20.999 13.4465 21 12C21 7.72 18 4.14 14 3.23V5.29C16.89 6.15 19 8.83 19 12ZM16.5 12C16.5 10.23 15.5 8.71 14 7.97V10.18L16.45 12.63C16.5 12.43 16.5 12.21 16.5 12Z" fill="white"/></svg>`;

// Altoparlante con onde sonore (Material Icons volume_up)
const SVG_AUDIO_ON = `<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4-.91 7-4.49 7-8.77s-3-7.86-7-8.77z" fill="white"/></svg>`;

function initAudio() {
	const btn     = document.getElementById( 'audio-toggle' );
	const iconEl  = document.getElementById( 'audio-icon' );
	const labelEl = document.getElementById( 'audio-label' );
	const audio   = document.getElementById( 'mare-audio' );

	if ( ! btn || ! iconEl || ! labelEl ) return;

	// Nessun file audio configurato: bottone visivamente disabilitato
	if ( ! audio || btn.dataset.noAudio === 'true' ) {
		btn.style.opacity = '0.35';
		btn.style.cursor  = 'not-allowed';
		btn.setAttribute( 'title', 'File audio non configurato' );
		return;
	}

	let playing = false;

	btn.addEventListener( 'click', async () => {
		if ( playing ) {
			audio.pause();
			playing = false;
			iconEl.innerHTML   = SVG_AUDIO_OFF;
			labelEl.textContent = 'ASCOLTA IL MARE: OFF';
			btn.setAttribute( 'aria-pressed', 'false' );
		} else {
			try {
				await audio.play();
				playing = true;
				iconEl.innerHTML   = SVG_AUDIO_ON;
				labelEl.textContent = 'ASCOLTA IL MARE: ON';
				btn.setAttribute( 'aria-pressed', 'true' );
			} catch ( e ) {
				console.warn( 'Riproduzione audio non riuscita:', e );
			}
		}
	} );

	// Aggiorna stato se il browser interrompe l'audio (es. tab in background)
	audio.addEventListener( 'pause', () => {
		if ( playing ) {
			playing = false;
			iconEl.innerHTML   = SVG_AUDIO_OFF;
			labelEl.textContent = 'ASCOLTA IL MARE: OFF';
			btn.setAttribute( 'aria-pressed', 'false' );
		}
	} );
}

// ─────────────────────────────────────────────
// HERO — DATA ODIERNA
// ─────────────────────────────────────────────

function initHeroDate() {
	var el = document.getElementById('hero-date');
	if (!el) return;
	var now  = new Date();
	var opts = { day: 'numeric', month: 'long', year: 'numeric' };
	el.textContent = now.toLocaleDateString('it-IT', opts).toUpperCase();
}

document.addEventListener( 'DOMContentLoaded', () => {
	initMoonPhase();
	initAudio();
	initHeroDate();
	initRottaSection();
	initGalleryPolaroid();
	initMareSection();
} );

// ─────────────────────────────────────────────
// ROTTA SECTION — marquee infinito + scroll animation
// ─────────────────────────────────────────────

function initRottaSection() {
	const section = document.querySelector( '.rotta-section' );
	if ( ! section ) return;

	// ── MARQUEE INFINITO ──────────────────────
	const track = section.querySelector( '.rotta-marquee-track' );
	if ( track ) {
		// Duplica i figli per loop seamless
		Array.from( track.children ).forEach( child => {
			track.appendChild( child.cloneNode( true ) );
		} );

		// Larghezza di un singolo ciclo (metà del totale dopo la duplicazione)
		const singleWidth = track.scrollWidth / 2;

		gsap.fromTo(
			track,
			{ x: 0 },
			{
				x: -singleWidth,
				duration: 25,
				ease: 'none',
				repeat: -1,
			}
		);
	}

	// ── SCROLL ANIMATION: clip-path + rotation ────
	const imgClip = section.querySelector( '.rotta-img-clip' );
	if ( imgClip ) {
		gsap.fromTo(
			imgClip,
			{
				clipPath: 'inset(0 15% 0 15%)',
				rotation: -3,
			},
			{
				clipPath: 'inset(0 0% 0 0%)',
				rotation: 3,
				ease: 'power2.out',
				scrollTrigger: {
					trigger: imgClip,
					start: 'top 85%',
					end: 'center 35%',
					scrub: 1.5,
				},
			}
		);
	}
}

// ─────────────────────────────────────────────
// GALLERY POLAROID — scroll-triggered slide-in
// ─────────────────────────────────────────────

function initGalleryPolaroid() {
	const section = document.querySelector( '.gallery-polaroid-section' );
	if ( ! section ) return;

	const itemsLeft  = section.querySelectorAll( '.gallery-polaroid-item--left' );
	const itemsRight = section.querySelectorAll( '.gallery-polaroid-item--right' );

	const triggerStart = 'top 25%';
	const triggerEnd   = 'top -20%';

	// Items che arrivano da sinistra (idx 0, 1)
	if ( itemsLeft.length ) {
		gsap.fromTo(
			itemsLeft,
			{
				xPercent: -45,
			},
			{
				xPercent: 0,
				ease: 'sine.out',
				stagger: 0.08,
				scrollTrigger: {
					trigger: section,
					start: triggerStart,
					end: triggerEnd,
					scrub: 3,
				},
			}
		);
	}

	// Items che arrivano da destra (idx 2, 3)
	if ( itemsRight.length ) {
		gsap.fromTo(
			itemsRight,
			{
				xPercent: 45,
			},
			{
				xPercent: 0,
				ease: 'sine.out',
				stagger: 0.08,
				scrollTrigger: {
					trigger: section,
					start: triggerStart,
					end: triggerEnd,
					scrub: 3,
				},
			}
		);
	}
}

// ─────────────────────────────────────────────
// MARE SECTION — video finestra → full screen + bottone CHIUDI/APRI
// ─────────────────────────────────────────────

function initMareSection() {
	const section     = document.querySelector( '.mare-video-section' );
	if ( ! section ) return;

	// ── MARQUEE INFINITO ──────────────────────
	const track = section.querySelector( '.mare-marquee-track' );
	if ( track ) {
		Array.from( track.children ).forEach( child => {
			track.appendChild( child.cloneNode( true ) );
		} );
		const singleWidth = track.scrollWidth / 2;
		gsap.fromTo(
			track,
			{ x: 0 },
			{ x: -singleWidth, duration: 28, ease: 'none', repeat: -1 }
		);
	}

	// ── SEZIONE SUCCESSIVA: effetto "footer overlap" ─────────────────────────
	const nextSection = section.nextElementSibling;
	if ( nextSection ) {
		const getOverlap   = () => Math.min( window.innerHeight, nextSection.offsetHeight );
		const adjustMargin = () => { nextSection.style.marginTop = -getOverlap() + 'px'; };
		adjustMargin();
		ScrollTrigger.addEventListener( 'revert', adjustMargin );
		ScrollTrigger.create( {
			trigger: nextSection,
			start: () => 'top ' + ( window.innerHeight - getOverlap() ),
			end: () => '+=' + getOverlap(),
			pin: true,
		} );
	}

	// ── VIDEO FRAME — stato iniziale piccolo + ruotato ────
	const frame = section.querySelector( '.mare-video-frame' );
	const btn   = section.querySelector( '.mare-toggle-btn' );
	const label = section.querySelector( '.mare-toggle-label' );
	if ( ! frame ) return;

	gsap.set( frame, { scale: 0.42, rotation: -5, transformOrigin: 'center center' } );

	// ── APPROCCIO MANUALE: ScrollTrigger legge il progresso, ticker lerp lo applica ────
	// Non usiamo "animation + scrub" (che crea un tween interno incontrollabile).
	// Invece: ST aggiorna rawProgress → ticker fa lerp smooth → applica al tween.
	// Questo ci permette di stoppare/riavviare l’animazione senza glitch.
	const mareTween = gsap.to( frame, {
		scale: 1,
		rotation: 0,
		ease: 'none',
		paused: true,
	} );

	let rawProgress    = 0; // progresso reale dello scroll (0-1)
	let smoothProgress = 0; // progresso smoothed applicato al tween
	let stActive       = true; // false = bottone ha disabilitato l’animazione

	ScrollTrigger.create( {
		trigger: section,
		start: 'top bottom',   // entra dal fondo del viewport
		end: 'bottom bottom',  // finisce quando il bottom della section = bottom del viewport
		onUpdate: ( self ) => {
			rawProgress = self.progress;
		},
	} );

	// Lerp factor ~0.04 ≈ scrub 2s a 60fps
	gsap.ticker.add( () => {
		if ( ! stActive ) return;
		smoothProgress += ( rawProgress - smoothProgress ) * 0.04;
		mareTween.progress( smoothProgress );
	} );

	// ── BOTTONE CHIUDI / APRI ────────────────────────────────────
	if ( ! btn || ! label ) return;

	let btnState   = 'open'; // ‘open’ = animazione attiva
	let closeTween = null;   // traccia il tween di ritorno (non uccidere mai mareTween)

	btn.addEventListener( 'click', () => {
		if ( btnState === 'open' ) {
			// ── CHIUDI: ferma il ticker e ripristina lo stato iniziale del frame ──
			stActive = false;
			if ( closeTween ) closeTween.kill();
			closeTween = gsap.to( frame, {
				scale: 0.42,
				rotation: -5,
				duration: 0.9,
				ease: 'power2.inOut',
				onComplete: () => {
					smoothProgress = 0;
					mareTween.progress( 0 );
					closeTween = null;
				},
			} );
			label.textContent = 'APRI';
			btn.setAttribute( 'aria-label', 'Apri il video' );
			btnState = 'closed';

		} else {
			// ── APRI: ferma eventuale tween di chiusura, resetta mareTween e riattiva il ticker ──
			if ( closeTween ) { closeTween.kill(); closeTween = null; }
			smoothProgress = 0;
			mareTween.progress( 0 );
			stActive = true;
			label.textContent = 'CHIUDI';
			btn.setAttribute( 'aria-label', 'Chiudi il video' );
			btnState = 'open';
		}
	} );
}

