<?php
/**
 * Template Name: Prenota Tavolo — Landing Ads
 *
 * Landing page indipendente pensata per il traffico a pagamento (Google/Meta
 * Ads): header/footer snelliti (get_header( 'landing' ) / get_footer( 'landing' )),
 * niente link di navigazione, nessuna voce menu la referenzia da nessuna
 * parte. Va assegnata a una Pagina a sé da Attributi pagina → Template, con
 * lo slug/URL che preferisci per la campagna (es. /prenota-estate/).
 *
 * Non è collegata da nessuna parte del sito (nessuna voce menu, nessun link
 * in header/footer): resta raggiungibile solo tramite il link diretto
 * dell'inserzione. Nessuna scelta è stata fatta qui riguardo ai motori di
 * ricerca (niente noindex, niente esclusione dalla sitemap).
 *
 * Stile: usa le stesse classi Tailwind/font del resto del tema (font-icon-serif,
 * font-typewriter, bg-blue, color-gold, ecc.) e riusa integralmente la CSS già
 * compilata per la sezione "Riserva il tuo tavolo" della home (.riserva-section
 * / .riserva-card / .riserva-field / .riserva-acceptance in
 * tailwind/custom/base.css) per lo stile del form — nessun CSS duplicato qui.
 *
 * Il form va creato in Contact Form 7 usando il contenuto di
 * `cf7-form-prenota-ads.txt` (root del tema) e collegato sostituendo l'ID
 * nello shortcode più in basso. Il redirect alla thank you page (/grazie/)
 * dopo l'invio è già gestito globalmente in functions.php.
 *
 * Testi gestiti via ACF (campi lp_hero_… e lp_form_…, field group
 * registrato in inc/acf-fields.php) tramite alessandrofeoristorante_the_field(), così
 * sono modificabili e traducibili (WPML) dall'admin. Fallback ai testi di
 * default se i campi sono vuoti o ACF è assente. Vedi inc/acf-helpers.php.
 *
 * @package alessandrofeoristorante
 */

get_header( 'landing' );
?>

<main id="main">

	<!-- ═══ HERO — breve descrizione ═══ -->
	<section class="relative w-full min-h-svh bg-blue overflow-hidden flex items-center justify-center text-center px-5">
		<div class="lp-hero-content w-[90%] max-w-2xl pt-0 pb-20 lg:pb-28">

			<span class="block font-typewriter text-white text-[clamp(0.55rem,1.1vw,0.8rem)] tracking-[0.25em] opacity-60 mb-8">
				(&nbsp;&nbsp;<?php alessandrofeoristorante_the_field( 'lp_hero_coordinate', '40°10′31″N   15°07′01″E' ); ?>&nbsp;&nbsp;)
			</span>

			<p class="font-typewriter text-white text-[clamp(0.65rem,1vw,0.78rem)] tracking-[0.28em] uppercase opacity-85 mb-5">
				<?php alessandrofeoristorante_the_field( 'lp_hero_kicker', 'Casal Velino · Cilento' ); ?>
			</p>

			<h1 class="font-icon-serif text-white text-[clamp(2.4rem,7vw,5rem)] leading-[1.05] uppercase mb-7">
				<?php alessandrofeoristorante_the_field( 'lp_hero_titolo_riga_1', 'Alessandro Feo' ); ?><br>
				<?php alessandrofeoristorante_the_field( 'lp_hero_titolo_riga_2', 'Ristorante' ); ?>
			</h1>

			<p class="font-typewriter text-white text-[clamp(0.8rem,1.1vw,0.95rem)] leading-[1.9] opacity-90 max-w-[46ch] mx-auto mb-10 text-balance">
				<?php
				alessandrofeoristorante_the_field(
					'lp_hero_lead',
					"Un ristorante affacciato sul mare del Cilento, dove il pescato del giorno incontra le erbe dell'orto e la cucina dello chef Alessandro Feo racconta ogni sera una rotta diversa. Prenota il tuo tavolo e vivi una cena a due passi dall'acqua."
				);
				?>
			</p>

			<a
				href="#prenota"
				class="inline-block font-typewriter text-white text-[clamp(0.62rem,0.9vw,0.74rem)] tracking-[0.22em] uppercase border border-gold rounded-full px-11 py-4 hover:bg-gold hover:text-blue transition-colors"
			>
				<?php alessandrofeoristorante_the_field( 'lp_hero_cta_label', 'Prenota il tuo tavolo' ); ?>
			</a>

		</div>
	</section>

	<!-- ═══ FORM — Contact Form 7 ═══ -->
	<section id="prenota" class="riserva-section w-full bg-blue px-6 py-20 lg:py-32">
		<div class="riserva-card lp-form-card max-w-2xl mx-auto bg-white px-10 py-12 lg:px-16 lg:py-16">

			<h2 class="font-icon-serif text-[clamp(2.2rem,5.5vw,4.5rem)] uppercase leading-[1.05] text-blue mb-4">
				<?php alessandrofeoristorante_the_field( 'lp_form_titolo', 'Prenota il tuo tavolo' ); ?>
			</h2>

			<p class="font-typewriter text-blue text-[clamp(0.72rem,0.95vw,0.85rem)] tracking-wide leading-[1.8] mb-10">
				<?php alessandrofeoristorante_the_field( 'lp_form_sottotitolo', 'Compila i campi qui sotto: ti ricontatteremo per confermare la tua serata.' ); ?>
			</p>

			<?php
			echo do_shortcode( '[contact-form-7 id="16dea87" title="Form Landing"]' );
			?>
		</div>
	</section>

</main>

<?php
get_footer( 'landing' );
