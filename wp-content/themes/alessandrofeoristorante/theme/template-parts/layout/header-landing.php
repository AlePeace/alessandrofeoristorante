<?php
/**
 * Template part: header visivo per le landing page ads.
 *
 * Solo il logo (non cliccabile, nessun link verso la home) e la fase
 * lunare (widget informativo, non un link): niente full menu, niente
 * audio. Usa le classi Tailwind del tema, come il resto del sito.
 *
 * La fase lunare è popolata via JS da initMoonPhase() (javascript/script.js),
 * già in esecuzione su ogni pagina: basta che gli elementi #moon-phase-icon
 * e #moon-phase-name esistano nel DOM, come nel masthead del sito
 * (template-parts/layout/header-content.php).
 *
 * Selettore lingua WPML a sinistra (do_action( 'wpml_add_language_selector' ),
 * stesso hook usato dal masthead del sito principale): il markup è generato
 * da WPML, qui viene solo forzato in stile bianco/typewriter coerente con
 * l'header per qualunque template WPML sia configurato (lista o dropdown).
 * Se WPML non è attivo, non stampa nulla (nessun placeholder).
 *
 * @package alessandrofeoristorante
 */
?>

<style>
.lp-lang-switcher,
.lp-lang-switcher * {
	font-family: 'typewriter', monospace;
	font-size: 0.7rem;
	letter-spacing: 0.05em;
	text-transform: uppercase;
	color: #ffffff !important;
}
.lp-lang-switcher ul {
	list-style: none;
	display: flex;
	align-items: center;
	gap: 0.35rem;
	margin: 0;
	padding: 0;
}
.lp-lang-switcher a {
	display: inline-block;
	padding: 4px 6px !important;
	color: #ffffff !important;
	text-decoration: none;
}
.lp-lang-switcher a:hover {
	color: #C9B47C !important;
}
.lp-lang-switcher img {
	display: none;
}
/* Mobile: ancora più stretto, per non toccare il logo centrale */
@media (max-width: 480px) {
	.lp-lang-switcher,
	.lp-lang-switcher * {
		font-size: 0.6rem;
	}
	.lp-lang-switcher ul {
		gap: 0.15rem;
	}
	.lp-lang-switcher a {
		padding: 3px 4px !important;
	}
}
</style>

<header class="relative w-full bg-blue flex items-center justify-center py-8 px-5 lg:px-10">

	<!-- Selettore lingua (WPML) -->
	<div class="absolute left-5 lg:left-10 lp-lang-switcher" aria-label="<?php esc_attr_e( 'Cambia lingua', 'alessandrofeoristorante' ); ?>">
		<?php if ( function_exists( 'icl_get_languages' ) ) : ?>
			<?php do_action( 'wpml_add_language_selector' ); ?>
		<?php endif; ?>
	</div>

	<span class="block w-14 lg:w-16" aria-hidden="true">
		<svg viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
			<g clip-path="url(#lp_header_clip)">
				<path d="M73.9483 30.1681C68.1404 29.7093 62.6683 32.7837 60.1272 37.9811C59.0047 40.2769 58.5418 42.5636 58.6689 45.1518C58.9627 51.129 63.0737 56.4268 68.9201 58.0842C71.4072 58.7892 74.0995 58.8063 76.6291 58.1104C80.6463 57.0047 83.8602 54.1965 85.6221 50.5123C86.5249 48.6246 86.9666 46.6103 86.9988 44.518C87.1132 37.0658 81.4456 30.7609 73.9483 30.1681ZM80.8487 48.2473C79.6394 51.3461 76.9068 53.5667 73.4652 53.7679C72.0155 53.8522 70.6671 53.6801 69.3847 53.117C65.6987 51.4994 63.9161 47.6716 64.0518 43.805C64.2255 38.8526 67.5573 34.774 72.7729 34.7466C76.9862 34.725 80.2311 37.4294 81.249 41.4226C81.828 43.695 81.7015 46.062 80.8487 48.2473Z" fill="white"/>
				<path d="M48.552 30.8548L48.5508 57.8704L30.0202 57.8738L29.9609 57.5198L29.9638 53.313L43.4088 53.3135L43.4105 46.2637L34.2243 46.2626V41.7228L43.4123 41.7222V35.3683L30.9167 35.3689L30.9178 30.8457L48.552 30.8548Z" fill="white"/>
				<path d="M14.4496 42.3743L14.453 46.9163L5.14028 46.918V57.8738L0 57.8732L0.00115008 30.8565L17.5933 30.8457L17.5979 35.3695L5.14143 35.3678L5.14258 42.3749L14.4496 42.3743Z" fill="white"/>
			</g>
			<defs>
				<clipPath id="lp_header_clip">
					<rect width="87" height="55" fill="white" transform="translate(0 16)"/>
				</clipPath>
			</defs>
		</svg>
	</span>

	<!-- Fase lunare (popolata via JS) -->
	<div class="absolute right-5 lg:right-10 flex items-center gap-1.5" id="moon-phase-widget" aria-live="polite" aria-label="<?php esc_attr_e( 'Fase lunare corrente', 'alessandrofeoristorante' ); ?>">
		<span id="moon-phase-icon" class="flex-shrink-0 flex items-center justify-center w-5 h-5"></span>
		<span id="moon-phase-name" class="hidden lg:inline font-typewriter text-white text-xs uppercase tracking-widest whitespace-nowrap"></span>
	</div>
</header>
