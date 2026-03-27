<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package alessandrofeoristorante
 */

// Logo dal media library WordPress
$logo_image_url = get_site_url() . '/wp-content/uploads/2026/03/FEO_logo-1.png';
$logo_id        = attachment_url_to_postid( $logo_image_url );

// Audio del mare – aggiorna con l'URL del tuo file audio caricato in WordPress
// Esempio: get_site_url() . '/wp-content/uploads/2026/03/suono-mare.mp3'
$audio_url = '';
?>

<header id="masthead" class="fixed w-full top-0 left-0 right-0 z-50">

	<div class="relative w-full flex items-center justify-between px-5 lg:px-20 py-6">

		<!-- SINISTRA: bottone full menu (flusso normale) -->
		<button
			id="full-menu-toggle"
			class="flex items-center justify-center opacity-90 hover:opacity-100 transition-opacity cursor-pointer"
			aria-label="<?php esc_attr_e( 'Apri menu', 'alessandrofeoristorante' ); ?>"
		>
			<svg width="22" height="27" viewBox="0 0 24 30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
				<path d="M0 30V3.33333C0 2.41667 0.326666 1.63222 0.98 0.98C1.63333 0.327778 2.41778 0.00111111 3.33333 0H20C20.9167 0 21.7017 0.326667 22.355 0.98C23.0083 1.63333 23.3344 2.41778 23.3333 3.33333V30L11.6667 25L0 30ZM3.33333 24.9167L11.6667 21.3333L20 24.9167V3.33333H3.33333V24.9167Z" fill="white"/>
			</svg>
		</button>

		<!-- CENTRO: logo FEO — assoluto al 50% esatto della pagina -->
		<div class="absolute left-1/2 -translate-x-1/2 pointer-events-none">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pointer-events-auto relative block w-full overflow-hidden" aria-label="<?php bloginfo( 'name' ); ?> – Home">
				<?php if ( $logo_id ) : ?>
					<?php echo get_custom_responsive_image( $logo_id, 'full', 'object-contain object-center' ); ?>
				<?php else : ?>
					<span class="font-typewriter text-white text-xl tracking-widest">FEO</span>
				<?php endif; ?>
			</a>
		</div>

		<!-- DESTRA: fase lunare + audio mare (flusso normale) -->
		<div class="flex items-center gap-5">

			<!-- Fase lunare (popolata via JS) -->
			<div class="flex items-center gap-1.5" id="moon-phase-widget" aria-live="polite" aria-label="Fase lunare corrente">
				<span id="moon-phase-icon" class="flex-shrink-0 flex items-center justify-center w-5 h-5"></span>
				<span id="moon-phase-name" class="hidden lg:inline font-typewriter text-white text-xs uppercase tracking-widest whitespace-nowrap"></span>
			</div>

			<!-- Toggle audio mare -->
			<button
				id="audio-toggle"
				class="flex items-center gap-1.5 opacity-90 hover:opacity-100 transition-opacity cursor-pointer"
				aria-label="<?php esc_attr_e( 'Ascolta il suono del mare', 'alessandrofeoristorante' ); ?>"
				aria-pressed="false"
				<?php if ( empty( $audio_url ) ) : ?>data-no-audio="true"<?php endif; ?>
			>
				<span id="audio-icon" class="flex-shrink-0 flex items-center justify-center w-5 h-5">
					<!-- Icona audio OFF (default) – aggiornata via JS -->
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M12 4L9.91 6.09L12 8.18M4.27 3L3 4.27L7.73 9H3V15H7L12 20V13.27L16.25 17.53C15.58 18.04 14.83 18.46 14 18.7V20.77C15.38 20.45 16.63 19.82 17.68 18.96L19.73 21L21 19.73L12 10.73M19 12C19 12.94 18.8 13.82 18.46 14.64L19.97 16.15C20.6455 14.8709 20.999 13.4465 21 12C21 7.72 18 4.14 14 3.23V5.29C16.89 6.15 19 8.83 19 12ZM16.5 12C16.5 10.23 15.5 8.71 14 7.97V10.18L16.45 12.63C16.5 12.43 16.5 12.21 16.5 12Z" fill="white"/>
					</svg>
				</span>
				<span id="audio-label" class="hidden lg:inline font-typewriter text-white text-xs uppercase tracking-widest whitespace-nowrap">
					<?php esc_html_e( 'ASCOLTA IL MARE: OFF', 'alessandrofeoristorante' ); ?>
				</span>
			</button>

		</div>
	</div>

	<!-- Elemento audio (src impostata via $audio_url in PHP) -->
	<?php if ( ! empty( $audio_url ) ) : ?>
	<audio id="mare-audio" loop preload="none">
		<source src="<?php echo esc_url( $audio_url ); ?>" type="audio/mpeg">
	</audio>
	<?php endif; ?>

</header><!-- #masthead -->
