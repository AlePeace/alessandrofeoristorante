<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package alessandrofeoristorante
 */

$logo_image_url = get_site_url() . '/wp-content/uploads/2026/03/FEO_logo-1.png';
$logo_id        = attachment_url_to_postid( $logo_image_url );
?>

<footer id="colophon" class="bg-blue text-white">

	<!-- Main footer body -->
	<div class="max-w-6xl mx-auto px-6 lg:px-12 pt-16 pb-10">

		<!-- Logo centrato -->
		<div class="flex justify-center mb-8">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php bloginfo( 'name' ); ?> – Home">
				<?php if ( $logo_id ) : ?>
					<img
						src="<?php echo esc_url( $logo_image_url ); ?>"
						alt="<?php bloginfo( 'name' ); ?>"
						class="h-20 w-auto object-contain"
					/>
				<?php else : ?>
					<span class="font-typewriter text-white text-3xl tracking-widest">FEO</span>
				<?php endif; ?>
			</a>
		</div>

		<!-- Tagline -->
		<p class="text-center font-script text-gold text-lg lg:text-4xl mb-12 leading-relaxed">
			Il mare mi guida, l&rsquo;orto mi ispira,<br> la tavola accoglie.
		</p>

		<!-- Tre colonne -->
		<div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">

			<!-- Colonna sinistra: indirizzo -->
			<div class="text-sm leading-7 font-typewriter tracking-wide">
				<p>Via Angelo Lista, 24</p>
				<p>84040 Casal Velino (SA)</p>
				<p>+39 328 8937 083</p>
				<p>
					<a href="mailto:info@feoristorante.it" class="hover:text-gold transition-colors">
						info@feoristorante.it
					</a>
				</p>
			</div>

			<!-- Colonna centro: menu footer -->
			<div class="text-sm font-typewriter tracking-widest uppercase leading-8 md:text-center">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-2',
						'container'      => false,
						'menu_class'     => '',
						'walker'         => null,
						'items_wrap'     => '<ul class="space-y-1">%3$s</ul>',
						'link_before'    => '',
						'link_after'     => '',
						'fallback_cb'    => function() {
							echo '<ul class="space-y-1">
								<li><a href="#" class="hover:text-gold transition-colors">Voce Menu #1</a></li>
								<li><a href="#" class="hover:text-gold transition-colors">Voce Menu #2</a></li>
								<li><a href="#" class="hover:text-gold transition-colors">Voce Menu #3</a></li>
								<li><a href="#" class="hover:text-gold transition-colors">Voce Menu #4</a></li>
							</ul>';
						},
					)
				);
				?>
			</div>

			<!-- Colonna destra: orari + social -->
			<div class="text-sm font-typewriter tracking-wide md:text-right">
				<p class="font-bold uppercase tracking-widest mb-2">Orari</p>
				<p>Pranzo: 12:30 &ndash; 14:30</p>
				<p>Cena: 18:30 &ndash; 23:30</p>

				<!-- Social icons -->
				<div class="flex gap-4 mt-5 md:justify-end">
					<!-- Facebook -->
					<a href="https://www.facebook.com/alessandrofeoristorante/?ref=NONE_xav_ig_profile_page_web#" target="_blank" aria-label="Facebook" class="text-white hover:text-gold transition-colors">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
							<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
						</svg>
					</a>
					<!-- Instagram -->
					<a href="https://www.instagram.com/alessandrofeoristorante/" target="_blank" aria-label="Instagram" class="text-white hover:text-gold transition-colors">
						<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24" aria-hidden="true">
							<rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
							<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/>
							<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
						</svg>
					</a>
				</div>
			</div>

		</div>

		<!-- Divisore -->
		<hr class="border-white/20 mb-6">

		<!-- Bottom bar -->
		<div class="flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-xs font-typewriter tracking-wide text-white/60 text-center flex-wrap">
			<span>&copy; <?php echo date( 'Y' ); ?> Alessandro Feo. Tutti i diritti riservati</span>
			<span class="hidden sm:inline text-white/30">|</span>
			<a href="/dichiarazione-sulla-privacy-ue" class="hover:text-gold transition-colors">Privacy Policy</a>
			<span class="hidden sm:inline text-white/30">|</span>
			<a href="/cookie-policy" class="hover:text-gold transition-colors">Cookie policy</a>
			<span class="hidden sm:inline text-white/30">|</span>
			<a href="https://qcore.it" target="_blank" rel="noopener noreferrer" class="hover:text-gold transition-colors">Fatto Qoore</a>
		</div>

	</div>

</footer><!-- #colophon -->
