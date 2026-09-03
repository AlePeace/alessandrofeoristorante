<?php
/**
 * Template part: footer visivo per le landing page ads.
 *
 * Solo contatti essenziali e link legali: niente voci menu, niente social.
 * Usa le classi Tailwind del tema, come il resto del sito.
 *
 * Testi gestiti via ACF (campi lp_footer_…, field group registrato in
 * inc/acf-fields.php) tramite alessandrofeoristorante_the_field(), così sono
 * modificabili e traducibili (WPML) dall'admin. Fallback ai testi di default
 * se i campi sono vuoti o ACF è assente. Vedi inc/acf-helpers.php.
 *
 * @package alessandrofeoristorante
 */

$lp_telefono_testo = alessandrofeoristorante_field( 'lp_footer_telefono_testo', '+39 328 8937 083' );
$lp_telefono_href  = alessandrofeoristorante_field( 'lp_footer_telefono_href', '+393288937083' );
$lp_email           = alessandrofeoristorante_field( 'lp_footer_email', 'info@feoristorante.it' );
?>

<footer class="bg-blue text-white text-center px-6 py-14">
	<div class="max-w-md mx-auto font-typewriter text-sm leading-7">

		<p class="opacity-75"><?php alessandrofeoristorante_the_field( 'lp_footer_indirizzo', 'Via Angelo Lista, 24 — 84040 Casal Velino (SA)' ); ?></p>

		<p class="mt-1">
			<a href="tel:<?php echo esc_attr( $lp_telefono_href ); ?>" class="hover:text-gold transition-colors"><?php echo esc_html( $lp_telefono_testo ); ?></a>
			&nbsp;&middot;&nbsp;
			<a href="mailto:<?php echo esc_attr( $lp_email ); ?>" class="hover:text-gold transition-colors"><?php echo esc_html( $lp_email ); ?></a>
		</p>

		<p class="opacity-75 mt-1"><?php alessandrofeoristorante_the_field( 'lp_footer_orari', 'Aperti tutte le sere a cena' ); ?></p>

		<p class="text-xs opacity-50 tracking-wide mt-6">
			&copy; <?php echo esc_html( date( 'Y' ) ); ?> Alessandro Feo
			&middot;
			<a href="<?php echo esc_url( home_url( '/dichiarazione-sulla-privacy-ue' ) ); ?>" class="underline hover:text-gold transition-colors"><?php alessandrofeoristorante_the_field( 'lp_footer_privacy_label', 'Privacy Policy' ); ?></a>
			&middot;
			<a href="<?php echo esc_url( home_url( '/cookie-policy' ) ); ?>" class="underline hover:text-gold transition-colors"><?php alessandrofeoristorante_the_field( 'lp_footer_cookie_label', 'Cookie policy' ); ?></a>
		</p>

	</div>
</footer>
