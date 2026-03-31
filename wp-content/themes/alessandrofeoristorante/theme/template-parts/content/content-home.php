<?php

/**
 * Template part for displaying pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package alessandrofeoristorante
 */

// Wrapper ACF: evita errori di analisi statica, protegge se ACF non è attivo
$acf = function_exists('get_field')
	? Closure::fromCallable('get_field')
	: static fn() => null;

// ACF: video background (file field o URL field)
$video_acf = $acf('hero_video_url');
$video_url  = $video_acf
	? esc_url(is_array($video_acf) ? $video_acf['url'] : $video_acf)
	: esc_url(get_site_url() . '/wp-content/uploads/2026/03/0313_compressed.webm');

	$video_madre_url  = $video_acf
		? esc_url(is_array($video_acf) ? $video_acf['url'] : $video_acf)
		: esc_url(get_site_url() . '/wp-content/uploads/2026/03/video_mare_madre.webm');

// Immagine background sezione L'Orto
$orto_img_acf = $acf('orto_bg_image');
$orto_img_id  = $orto_img_acf
	? (is_array($orto_img_acf) ? $orto_img_acf['ID'] : attachment_url_to_postid($orto_img_acf))
	: attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/gallery-1-1.jpg');

// ACF: coordinate geografiche
$coordinates = $acf('hero_coordinates')
	?: __("40°10'31\"N  15°07'01\"E", 'alessandrofeoristorante');

// ACF: titolo hero (due righe separate)
$title_line_1 = $acf('hero_title_line_1')
	?: __('Diario di Bordo', 'alessandrofeoristorante');

$title_line_2 = $acf('hero_title_line_2')
	?: __('Mare Madre', 'alessandrofeoristorante');

// ACF: testi laterali (textarea → nl2br per preservare gli a capo)
$text_left = $acf('hero_text_left')
	?: __('Ogni piatto nasce dal respiro del mare e dalla terra del Cilento.', 'alessandrofeoristorante');

$text_right = $acf('hero_text_right')
	?: __("Ogni giorno annoto ciò che il mare mi consegna.\nE quel racconto diventa un menu.", 'alessandrofeoristorante');
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('overflow-x-hidden'); ?> class="m-0 p-0">

	<section class="hero-section relative w-full h-svh overflow-hidden">

		<!-- VIDEO BACKGROUND -->
		<video
			autoplay muted loop playsinline
			class="absolute inset-0 w-full h-full object-cover z-0">
			<source src="<?php echo $video_url; ?>" type="video/webm">
		</video>

		<!-- SFUMATURA BLU -->
		<div class="absolute inset-0 bg-blue/45 z-10 pointer-events-none"></div>

		<!-- BLOCCO CENTRALE: coordinate + titolo + data -->
		<div class="absolute inset-0 z-20 flex items-center justify-center pointer-events-none">
		<div class="text-center w-[90%]">

			<!-- Coordinate geografiche — font typewriter -->
			<div class="pb-10">
				<span class="font-typewriter text-white text-[clamp(0.55rem,1.1vw,0.8rem)] tracking-[0.25em]">
					(&nbsp;&nbsp;<?php echo esc_html($coordinates); ?>&nbsp;&nbsp;)
				</span>
			</div>

			<!-- Titolone — font icon-serif (New Icon Serif) -->
			<h1 class="font-icon-serif text-white text-[clamp(2.2rem,7vw,5.8rem)] leading-[1.1] uppercase mb-10">
				<?php echo esc_html($title_line_1); ?><br><?php echo esc_html($title_line_2); ?>
			</h1>

			<!-- Data odierna (JS) + SVG sottolineatura ondulata -->
			<div>
				<span
					id="hero-date"
					class="font-typewriter text-white text-xs tracking-[0.2em] block mb-1.5"></span>
				<span
					class="font-doodles text-white text-9xl scale-180 block leading-none"
					aria-hidden="true">r</span>
			</div>

		</div>
		</div>

		<!-- TESTO SINISTRA — font script -->
		<div class="absolute bottom-26 lg:bottom-42 left-[3%] -translate-x-1/2 z-20 w-1/2 lg:w-1/3 pointer-events-none -rotate-3">
			<p class="font-script text-white text-center text-2xl lg:text-3xl xl:text-4xl leading-[1.6] opacity-90 m-0">
				<?php echo nl2br(esc_html($text_left)); ?>
			</p>
		</div>

		<!-- TESTO DESTRA — font script -->
		<div class="absolute bottom-10 lg:bottom-26 -right-[25%] lg:-right-[15%] z-20 w-1/2 lg:w-1/3 text-center pointer-events-none -rotate-6">
			<p class="font-script text-white text-2xl lg:text-3xl leading-[1.6] opacity-100">
				<?php echo nl2br(esc_html($text_right)); ?>
			</p>
		</div>

		<!-- FRECCIA GIÙ — lettera Y in Morning Memories Doodles -->
		<div class="absolute bottom-[8%] left-1/2 -translate-x-1/3 lg:-translate-x-2/3 z-20 pointer-events-none rotate-90">
			<span
				class="font-doodles text-white text-9xl scale-180 block leading-none animate-[heroArrowBounce_2.4s_ease-in-out_infinite]"
				aria-hidden="true">y</span>
		</div>

	</section>
	<!-- ═══════════════════════════════════════════════
	     SEZIONE ROTTA — marquee + immagine scroll
	     ═══════════════════════════════════════════════ -->
	<section id="rotta" class="rotta-section relative w-full min-h-[90vh] flex items-center bg-white overflow-hidden justify-center px-5 py-20 lg:py-40">

		<!-- MARQUEE INFINITO — mix-blend-difference sul wrapper, non dentro il layer di trasformazione -->
		<div class="absolute top-1/2 w-full -translate-y-1/2 z-20 pointer-events-none mix-blend-difference">
			<div class="rotta-marquee-track flex whitespace-nowrap will-change-transform">
				<?php for ($i = 0; $i < 8; $i++) : ?>
					<h3 class="font-icon-serif text-white text-[7vw] uppercase tracking-[0.18em] leading-none select-none">LA MIA ROTTA</h3>
				<?php endfor; ?>
			</div>
		</div>

		<!-- IMMAGINE — ScrollTrigger: clip-path espande + rotazione da -12 a 0 -->
		<?php $plate_id = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/plate_oil.jpg'); ?>
		<div class="rotta-img-clip relative w-[90%] max-w-xl !aspect-[2/3]">
			<?php echo get_custom_responsive_image($plate_id, 'full', 'block w-full h-full object-cover object-center'); ?>
		</div>

		<!-- CITAZIONE in basso a destra -->
		<div class="hidden lg:block absolute bottom-24 -right-[5%] w-1/4 z-10 pointer-events-none -rotate-3">
			<p class="font-script text-blue text-3xl leading-relaxed m-0">
				Seguo il mare, tolgo il superfluo e lascio parlare la materia prima.
			</p>
		</div>

	</section>

	<!-- ═══════════════════════════════════════════════
	     SEZIONE STORIA — testo a due colonne
	     ═══════════════════════════════════════════════ -->
	<section class="storia-section w-full bg-white px-6 py-10 lg:px-20 lg:py-14">
		<div class="max-w-5xl mx-auto columns-1 lg:columns-2 gap-12 lg:gap-20 font-typewriter text-blue text-[clamp(0.85rem,1.1vw,1rem)] leading-[1.9] tracking-wide">
			<p class="mt-0">Aprile 2019: il mio sogno prende forma a Casal Velino Marina, nel Cilento, con un ristorante che porta il mio nome: Alessandro Feo. Sono nato in questa terra e ho sempre saputo che prima o poi sarei tornato qui, dove il mare incontra i piccoli porti di pescatori e le colline custodiscono orti, uliveti antichi e vigneti.</p><br>
			<p>Proprio il mare mi ha insegnato che non esiste orizzonte senza una terra solida a cui tornare. E io qui ascolto. Ascolto il mare quando decide cosa lasciare nelle reti, ascolto la terra quando cambia il profumo degli orti all'alba, ascolto i piccoli produttori che difendono questo territorio con il loro lavoro silenzioso.</p><br>
			<p>Il mio menu nasce così: da ciò che il mare e la terra scelgono di affidarmi ogni giorno. Le pietre di Acquavella e i mummulieddi sul soffitto custodiscono questo luogo come la stiva di una nave. Qui il tempo rallenta. Se siete seduti a questa tavola, state entrando nel mio diario di bordo.</p><br>
			<p class="mb-0"><strong>Benvenuti a casa.</strong></p>
		</div>
	</section>

	<!-- ═══════════════════════════════════════════════
	     SEZIONE GALLERY POLAROID — 4 immagini + testi script
	     ═══════════════════════════════════════════════ -->
	<?php
	$gallery_images = [
		[
			'url'  => get_site_url() . '/wp-content/uploads/2026/03/gallery-1-1.jpg',
			'text' => __('Dove finisce il mare,<br>comincia l\'orto.', 'alessandrofeoristorante'),
			'text_pos' => 'bottom', // testo sotto
		],
		[
			'url'  => get_site_url() . '/wp-content/uploads/2026/03/gallery-1-2.png',
			'text' => __('Il mare cambia ogni giorno. Il piatto racconta solo quell\'attimo.', 'alessandrofeoristorante'),
			'text_pos' => 'top', // testo sopra
		],
		[
			'url'  => get_site_url() . '/wp-content/uploads/2026/03/gallery-1-3.jpg',
			'text' => __('Non cerco effetti.<br>Cerco verità.', 'alessandrofeoristorante'),
			'text_pos' => 'bottom', // testo sotto
		],
		[
			'url'  => get_site_url() . '/wp-content/uploads/2026/03/gallery-1-4-scaled.jpg',
			'text' => __('La stagione decide.<br>Io ascolto.', 'alessandrofeoristorante'),
			'text_pos' => 'top', // testo sopra
		],
	];
	?>
	<section class="gallery-polaroid-section relative w-full bg-white overflow-hidden py-20 lg:py-32 px-4">

		<div class="gallery-polaroid-grid relative w-full mx-auto">

			<?php foreach ($gallery_images as $idx => $img) :
				$img_id = attachment_url_to_postid($img['url']);
				// left group: idx 0,1 → slide in from left; right group: idx 2,3 → slide in from right
				$from_dir = ($idx < 2) ? 'left' : 'right';
				// Rotazioni polaroid alternanti
				$rotations = ['-rotate-[3deg]', 'rotate-[2deg]', '-rotate-[1.5deg]', 'rotate-[2.5deg]'];
				$rot = $rotations[$idx];
			?>
				<div class="gallery-polaroid-item gallery-polaroid-item--<?php echo $from_dir; ?> relative flex flex-col <?php echo ($idx % 2 === 0) ? 'justify-end' : 'justify-start'; ?>"
					data-index="<?php echo $idx; ?>">

					<?php if ($img['text_pos'] === 'top') : ?>
						<!-- Testo sopra immagine -->
						<p class="gallery-polaroid-caption hidden lg:block font-script text-blue text-xl xl:text-2xl leading-[1.5] mb-4 -rotate-[2deg] text-center pointer-events-none">
							<?php echo wp_kses_post($img['text']); ?>
						</p>
					<?php endif; ?>

					<!-- Immagine -->
					<div class="gallery-polaroid-frame <?php echo $rot; ?> will-change-transform">
						<div class="w-full overflow-hidden">
							<?php if ($img_id) : ?>
								<?php echo get_custom_responsive_image($img_id, 'large', 'block w-full h-full object-cover object-center'); ?>
							<?php else : ?>
								<img src="<?php echo esc_url($img['url']); ?>" alt="" class="block w-full h-full object-cover object-center" loading="lazy">
							<?php endif; ?>
						</div>
					</div>

					<?php if ($img['text_pos'] === 'bottom') : ?>
						<!-- Testo sotto immagine -->
						<p class="gallery-polaroid-caption hidden lg:block font-script text-blue text-xl xl:text-2xl leading-[1.5] mt-4 rotate-[1.5deg] text-center pointer-events-none">
							<?php echo wp_kses_post($img['text']); ?>
						</p>
					<?php endif; ?>

				</div>
			<?php endforeach; ?>

		</div>

	</section>

	<!-- ═══════════════════════════════════════════════
     SEZIONE LO CHEF
     ═══════════════════════════════════════════════ -->
	<section id="chef" class="chef-section relative w-full bg-white px-6 py-20 lg:py-32 text-blue overflow-hidden">

		<!-- TITOLO + NOME -->
		<div class="relative w-fit mx-auto text-center pb-12 mb-6">

			<!-- "LO CHEF" — New Icon Serif -->
			<h2 class="font-icon-serif text-[clamp(3.5rem,8vw,7rem)] uppercase leading-none tracking-widest">
				<?php esc_html_e('LO CHEF', 'alessandrofeoristorante'); ?>
			</h2>

			<!-- "Alessandro Feo" — Morning Memories, gold, posizione assoluta -->
			<span class="absolute lg:bottom-10 right-0 lg:translate-x-2/3 font-script -rotate-3 text-gold text-[clamp(1.8rem,3.7vw,3rem)] leading-none whitespace-nowrap pointer-events-none">
				Alessandro Feo
			</span>

		</div>

		<!-- PARAGRAFI — Special Elite (font-typewriter) -->
		<div class="max-w-4xl mx-auto text-center font-typewriter text-[clamp(0.85rem,1.05vw,1rem)] leading-[1.9] tracking-wide space-y-6">

			<p>Sono nato nel Cilento nel 1985, in una terra dove il mare non è solo un paesaggio. È una presenza.<br>
				Da ragazzo osservavo il porto di Casal Velino Marina svegliarsi lentamente: le barche che rientravano, le cassette che cambiavano colore con le stagioni, i pescatori capaci di leggere il mare prima ancora di guardarlo.</p>

			<p>Credo che la mia cucina sia iniziata lì, molto prima delle cucine professionali nelle quali ho fatto esperienze tra Campania e altre regioni d'Italia.</p>

			<p>Ma ho scelto di tornare qui, dove oggi guido il mio ristorante.<br>
				Il mare è la mia prima ispirazione: come ingrediente, ma anche come ritmo che insegna pazienza, rispetto e attesa.<br>
				L'orto, invece, è il contatto diretto con la terra dove comprendo davvero la materia prima.</p>

		</div>

		<!-- CITAZIONE FINALE — Morning Memories (font-script) -->
		<div class="max-w-4xl mx-auto text-center pt-10 lg:pt-16 -rotate-3">
			<p class="font-script text-blue text-[clamp(1.4rem,2.8vw,2.2rem)] leading-[1.7]">
				La mia cucina nasce dall'incontro tra mare e<br>
				terra, tra memoria e intuizione, lavorando<br>
				ingredienti locali e stagionali, con interventi<br>
				essenziali. Perché quando il prodotto è giusto,<br>
				la cucina deve solo accompagnarlo.
			</p>
		</div>

	</section>

	<!-- ═══════════════════════════════════════════════
	     WRAPPER VIDEO+MARE-MADRE — effetto reveal:
	     il video (z:2) scorre via verso l'alto mentre
	     la mare-madre (z:1, margin-top:-100svh) è già
	     posizionata DIETRO il video e si rivela.
	     Il wrapper contiene il margin negativo così le
	     sezioni successive non vengono spostate.
	     ═══════════════════════════════════════════════ -->
	<div class="mare-video-wrapper">
	<section class="mare-video-section relative w-full h-screen overflow-hidden" style="z-index:2; background:#23222D;">

		<!-- MARQUEE INFINITO "MARE MADRE" -->
		<div class="absolute inset-0 flex items-center pointer-events-none z-10 overflow-hidden">
			<div class="mare-marquee-track flex whitespace-nowrap will-change-transform">
				<?php for ($i = 0; $i < 10; $i++) : ?>
					<h3 class="font-icon-serif text-white text-[7vw] uppercase tracking-[0.18em] leading-none select-none px-4">MARE&nbsp;&nbsp;MADRE</h3>
				<?php endfor; ?>
			</div>
		</div>

		<!-- VIDEO FRAME -->
		<div class="mare-video-frame absolute inset-0 will-change-transform z-20">
			<video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
				<source src="<?php echo $video_madre_url; ?>" type="video/webm">
			</video>
		</div>

		<!-- BOTTONE CIRCOLARE CHIUDI/APRI -->
		<button
			class="mare-toggle-btn absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-30 w-20 h-20 rounded-full border border-white/50 bg-white/20 backdrop-blur-sm flex items-center justify-center cursor-pointer transition-colors duration-300 hover:bg-white/30"
			aria-label="Apri o chiudi il video">
			<span class="mare-toggle-label font-typewriter text-white text-[0.6rem] tracking-[0.25em] uppercase select-none pointer-events-none">CHIUDI</span>
		</button>

	</section>

	<!-- SEZIONE MARE MADRE — si rivela da sotto il video -->
	<?php
	$fish_id = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/plate_fish.jpg');
	$soup_id = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/plate_soup.jpg');
	?>
	<section id="mmadre" class="mare-madre-section relative w-full bg-white text-blue overflow-hidden" style="z-index:1;">

		<div class="relative px-6 py-20 lg:py-32">

			<!-- FOTO SINISTRA — desktop: assoluta top-left, animazione JS (xPercent + rotation) -->
			<div class="mare-madre-from-left hidden lg:block absolute top-24 left-[3%] w-[13%] pointer-events-none will-change-transform">
				<div>
					<?php if ($fish_id) : ?>
						<?php echo get_custom_responsive_image($fish_id, 'large', 'block w-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_fish.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

			<!-- FOTO DESTRA — desktop: assoluta top-right, animazione JS (xPercent + rotation) -->
			<div class="mare-madre-from-right hidden lg:block absolute top-1/2 right-[3%] w-[13%] pointer-events-none will-change-transform">
				<div>
					<?php if ($soup_id) : ?>
						<?php echo get_custom_responsive_image($soup_id, 'large', 'block w-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_soup.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

			<!-- CONTENUTO CENTRALE -->
			<div class="relative max-w-6xl mx-auto text-center">

				<!-- Etichetta typewriter -->
				<p class="font-typewriter text-[clamp(0.55rem,1.1vw,0.75rem)] tracking-[0.25em] uppercase mb-3">
					( &nbsp;Mare Madre&nbsp; )
				</p>

				<!-- Decorazione wavy doodles -->
				<span class="font-doodles block text-8xl leading-none mb-6 scale-x-125 -mt-10" aria-hidden="true">r</span>

				<!-- Titolo principale — New Icon Serif -->
				<h2 class="font-icon-serif text-[clamp(1.8rem,4.5vw,4rem)] leading-[1.2] uppercase mb-10">
					Mare Madre è la mia bussola.<br>
					Ogni giorno il mare mi affida i suoi<br>
					doni e io li trasformo senza tradirne<br>
					la verità.
				</h2>

				<!-- Citazione corsivo — Morning Memories gold -->
				<p class="font-script text-gold text-[clamp(1.2rem,2vw,1.7rem)] leading-[1.8] -rotate-2">
					Mare Madre è la lotta silenziosa tra quello che<br>
					l&rsquo;acqua decide di regalarmi e la mia<br>
					responsabilità di portarlo a terra.
				</p>

			</div>

			<!-- FOTO MOBILE — solo su mobile, in fondo alla sezione -->
			<div class="flex lg:hidden justify-between items-start mt-16 px-4 gap-4">
				<div class="mare-madre-mobile-left w-[46%] will-change-transform">
					<?php if ($fish_id) : ?>
						<?php echo get_custom_responsive_image($fish_id, 'medium', 'block w-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_fish.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
				<div class="mare-madre-mobile-right w-[46%] mt-10 will-change-transform">
					<?php if ($soup_id) : ?>
						<?php echo get_custom_responsive_image($soup_id, 'medium', 'block w-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_soup.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

		</div>

	</section>
	</div><!-- /video-reveal-wrapper 1 -->

	<!-- ═══════════════════════════════════════════════
	     WRAPPER VIDEO+MARE-MADRE — effetto reveal:
	     il video (z:2) scorre via verso l'alto mentre
	     la mare-madre (z:1, margin-top:-100svh) è già
	     posizionata DIETRO il video e si rivela.
	     Il wrapper contiene il margin negativo così le
	     sezioni successive non vengono spostate.
	     ═══════════════════════════════════════════════ -->
	<div class="mare-video-wrapper">
	<section class="mare-video-section relative w-full h-screen overflow-hidden" style="z-index:2; background:#192422;">

		<!-- MARQUEE INFINITO "MARE MADRE" -->
		<div class="absolute inset-0 flex items-center pointer-events-none z-10 overflow-hidden">
			<div class="mare-marquee-track flex whitespace-nowrap will-change-transform">
				<?php for ($i = 0; $i < 10; $i++) : ?>
					<h3 class="font-icon-serif text-white text-[7vw] uppercase tracking-[0.18em] leading-none select-none px-4">L'ORTO</h3>
				<?php endfor; ?>
			</div>
		</div>

		<!-- IMAGE FRAME -->
		<div class="mare-video-frame absolute inset-0 will-change-transform z-20">
			<?php if ($orto_img_id) : ?>
				<?php echo get_custom_responsive_image($orto_img_id, 'full', 'absolute inset-0 w-full h-full object-cover object-center'); ?>
			<?php else : ?>
				<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/gallery-1-1.jpg'); ?>" alt="" class="absolute inset-0 w-full h-full object-cover object-center" loading="lazy">
			<?php endif; ?>
		</div>

		<!-- BOTTONE CIRCOLARE CHIUDI/APRI -->
		<button
			class="mare-toggle-btn absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-30 w-20 h-20 rounded-full border border-white/50 bg-white/20 backdrop-blur-sm flex items-center justify-center cursor-pointer transition-colors duration-300 hover:bg-white/30"
			aria-label="Apri o chiudi il video">
			<span class="mare-toggle-label font-typewriter text-white text-[0.6rem] tracking-[0.25em] uppercase select-none pointer-events-none">CHIUDI</span>
		</button>

	</section>

	<!-- SEZIONE MARE MADRE — si rivela da sotto il video -->
	<?php
	$fish_bacca_id = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/fish_bacca.jpg');
	$ravioli_id    = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/ravioli.jpg');
	?>
	<section id="orto" class="mare-madre-section relative w-full bg-white text-blue overflow-hidden h-full" style="z-index:1;">

		<div class="relative px-6 py-20 lg:py-32">

			<!-- FOTO SINISTRA — desktop: assoluta top-left, animazione JS (xPercent + rotation) -->
			<div class="mare-madre-from-left hidden lg:block absolute top-1/2 left-[3%] w-[13%] pointer-events-none will-change-transform">
				<div class="aspect-3/4! overflow-hidden">
					<?php if ($fish_bacca_id) : ?>
						<?php echo get_custom_responsive_image($fish_bacca_id, 'large', 'block w-full h-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_fish.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

			<!-- FOTO DESTRA — desktop: assoluta top-right, animazione JS (xPercent + rotation) -->
			<div class="mare-madre-from-right hidden lg:block absolute top-24 right-[3%] w-[13%] pointer-events-none will-change-transform">
				<div class="aspect-3/4! overflow-hidden">
					<?php if ($ravioli_id) : ?>
						<?php echo get_custom_responsive_image($ravioli_id, 'large', 'block w-full h-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_soup.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

			<!-- CONTENUTO CENTRALE -->
			<div class="relative max-w-6xl mx-auto text-center">

				<!-- Etichetta typewriter -->
				<p class="font-typewriter text-[clamp(0.55rem,1.1vw,0.75rem)] tracking-[0.25em] uppercase mb-3">
					( &nbsp;l'orto&nbsp; )
				</p>

				<!-- Decorazione wavy doodles -->
				<span class="font-doodles block text-8xl leading-none mb-6 scale-x-125 -mt-10" aria-hidden="true">N</span>

				<!-- Titolo principale — New Icon Serif -->
				<h2 class="font-icon-serif text-[clamp(1.8rem,4.5vw,4rem)] leading-[1.2] uppercase mb-10">
					La terra parla con<br>
					lo stesso ritmo del mare.<br>
					Basta imparare ad ascoltarla.<br>
				</h2>

				<!-- Citazione corsivo — Morning Memories gold -->
				<p class="font-script text-gold text-[clamp(1.2rem,2vw,1.7rem)] leading-[1.8] -rotate-2">
					Ogni stagione cambia il colore degli orti<br>
					e con esso cambia la cucina.<br>
						Verdure, erbe e radici diventano parte della<br>
							stessa storia che comincia al largo e finisce nel piatto.
				</p>

			</div>

			<!-- FOTO MOBILE — solo su mobile, in fondo alla sezione -->
			<div class="flex lg:hidden justify-between items-start mt-16 px-4 gap-4">
				<div class="mare-madre-mobile-left w-[46%] will-change-transform">
					<?php if ($fish_bacca_id) : ?>
						<?php echo get_custom_responsive_image($fish_bacca_id, 'medium', 'block w-full object-cover h-full aspect-[3/4]!'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_fish.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
				<div class="mare-madre-mobile-right w-[46%] mt-10 will-change-transform">
					<?php if ($ravioli_id) : ?>
						<?php echo get_custom_responsive_image($ravioli_id, 'medium', 'block w-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/plate_soup.jpg'); ?>" alt="" class="block w-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

		</div>

	</section>
	</div><!-- /video-reveal-wrapper 2 -->

	<!-- ═══════════════════════════════════════════════
	     SEZIONE I MENÙ — header + due tab con hover GSAP
	     ═══════════════════════════════════════════════ -->
	<style>
		/* Posizionamento "i Menù" — default Chrome/Firefox */
		.imenu-text {
			margin-top: 1.8em;
		}
		/* Tutti i browser su OS Apple (macOS, iOS, iPadOS) — rilevato via JS */
		.is-apple-os .imenu-text {
			margin-top: 0.65em;
		}

		@media (min-width: 1024px) {
			.menu-tab {
				background-color: #ffffff;
				transition: background-color 0.45s ease;
			}
			.menu-tab:hover {
				background-color: #23222D;
			}
			.menu-tab-title {
				transition: color 0.45s ease;
			}
			.menu-tab:hover .menu-tab-title {
				color: #ffffff;
			}
			.menu-tab-subtitle {
				transition: color 0.45s ease;
			}
			.menu-tab:hover .menu-tab-subtitle {
				color: rgba(255, 255, 255, 0.55);
			}
			.menu-tab-img {
				opacity: 0;
				transition: opacity 0.35s ease;
			}
			.menu-tab:hover .menu-tab-img {
				opacity: 1;
			}
		}
	</style>
	<section id="menu" class="menu-section w-full bg-white pt-10 lg:pt-0 relative z-50" style="border-top: 1px solid #23222D; border-bottom: 1px solid #23222D;">

		<!-- "i Menù" — DESKTOP: in-flow, margin negativo per overlap su menu-header -->
		<div class="hidden lg:flex items-center gap-2 pointer-events-none" style="margin-left: 50%; margin-bottom: -130px; transform: rotate(-3deg); transform-origin: left center;">
			<span class="inline-grid font-doodles text-blue text-[250px] leading-none tracking-[0.08em]">
				<span style="grid-area:1/1">yi</span>
				<span style="grid-area:1/1; align-self:start; justify-self:end; margin-right:2.5rem;" class="imenu-text font-script text-blue text-5xl leading-tight px-4 py-1">i&nbsp;Men&#xF9;</span>
			</span>
		</div>

		<!-- HEADER ───────────────────────────────── -->
		<div class="menu-header relative px-6 lg:px-14 pt-8 pb-6 lg:pt-18 lg:pb-10" style="border-bottom: 1px solid #23222D;">

			<!-- "i Menù" — MOBILE: in-flow sopra il titolo -->
			<div class="lg:hidden relative flex items-center justify-center gap-2 pointer-events-none overflow-hidden" style="transform: rotate(-3deg);">
				<span class="inline-grid font-doodles text-blue text-[150px] leading-none tracking-[0.08em]">
					<span style="grid-area:1/1">yi</span>
					<span style="grid-area:1/1; align-self:start; justify-self:end; margin-right:1.25rem;" class="imenu-text font-script text-blue text-3xl leading-tight px-4">i&nbsp;Men&#xF9;</span>
				</span>

			</div>

			<div class="w-fit mx-auto -mt-6 lg:mt-auto">
			<!-- Titolo MARE MADRE — centrato, grande -->
			<h2 class="font-icon-serif text-blue text-center text-9xl lg:text-[clamp(3.5rem,11vw,10rem)] uppercase leading-[0.9] tracking-tight mb-5 lg:mb-7">
				MARE MADRE
			</h2>
			<!-- Riga sottotitolo: sinistra diario + destra coordinate -->
			<div class="flex flex-col items-center lg:flex-row lg:justify-between lg:items-baseline gap-1 lg:gap-0">
				<p class="font-typewriter text-blue text-[clamp(0.5rem,0.82vw,0.72rem)] tracking-[0.15em] uppercase m-0">
					<span style="border-bottom: 1px solid #23222D;">DIARIO</span> DI BORDO DI ALESSANDRO FEO
				</p>
				<p class="font-typewriter text-blue text-[clamp(0.5rem,0.82vw,0.72rem)] tracking-[0.15em] m-0 whitespace-nowrap">
					40&deg;10&prime;31&Prime;N&nbsp;&nbsp;15&deg;07&prime;01&Prime;E
				</p>
			</div>
			</div>


		</div>

		<?php
		$le_tre_rotte_id      = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/le_tre_rotte.jpg');
		$navigazione_libera_id = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/navigazione_libera.jpg');
		?>

		<!-- TAB 1: LE TRE ROTTE ─────────────────── -->
		<a href="https://www.alessandrofeoristorante.it/il-menu/" target="_blank" class="menu-tab block relative cursor-pointer select-none group transition-all duration-500 ease-in-out hover:bg-blue" style="border-bottom: 1px solid #23222D;">

			<div class="relative z-10 px-6 lg:px-14 py-10 lg:py-16">
				<!-- Desktop: titolo e sottotitolo inline -->
				<div class="hidden lg:flex items-baseline gap-6">
					<h3 class="menu-tab-title font-icon-serif text-[clamp(2.5rem,7vw,6.5rem)] uppercase leading-none text-blue group-hover:text-white">
						LE DUE ROTTE
					</h3>
					<span class="menu-tab-subtitle font-typewriter text-[clamp(0.6rem,0.9vw,0.8rem)] tracking-[0.2em] uppercase text-blue group-hover:text-white">
						( MEN&Ugrave; DEGUSTAZIONE )
					</span>
				</div>
				<!-- Mobile: titolo e sottotitolo su righe separate -->
				<div class="lg:hidden">
					<h3 class="font-icon-serif text-blue text-[clamp(2.8rem,10vw,5rem)] uppercase leading-none mb-2">
						LE DUE ROTTE
					</h3>
					<span class="font-typewriter text-blue text-[0.7rem] tracking-[0.2em] uppercase">
						( MEN&Ugrave; DEGUSTAZIONE )
					</span>
				</div>
			</div>

			<!-- Immagine hover — desktop only, wrapper aspect-ratio + overflow-hidden -->
			<div class="menu-tab-img hidden lg:block absolute right-14 top-1/2 -translate-y-1/2 w-[20%] max-w-[260px] pointer-events-none rotate-6 will-change-transform z-20" aria-hidden="true">
				<div class="aspect-[3/4] overflow-hidden">
					<?php if ($le_tre_rotte_id) : ?>
						<?php echo get_custom_responsive_image($le_tre_rotte_id, 'large', 'block w-full h-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/le_tre_rotte.jpg'); ?>" alt="" class="block w-full h-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

		</a>

		<!-- TAB 2: NAVIGAZIONE LIBERA ───────────── -->
		<a href="https://www.alessandrofeoristorante.it/il-menu/" target="_blank" class="menu-tab block group relative cursor-pointer select-none transition-all duration-500 ease-in-out hover:bg-blue">

			<div class="relative z-10 px-6 lg:px-14 py-10 lg:py-16">
				<!-- Desktop -->
				<div class="hidden lg:flex items-baseline gap-6">
					<h3 class="menu-tab-title font-icon-serif text-[clamp(2.5rem,7vw,6.5rem)] text-blue uppercase leading-none group-hover:text-white">
						NAVIGAZIONE LIBERA
					</h3>
					<span class="menu-tab-subtitle font-typewriter text-[clamp(0.6rem,0.9vw,0.8rem)] text-blue tracking-[0.2em] uppercase group-hover:text-white">
						( MEN&Ugrave; ALLA CARTA )
					</span>
				</div>
				<!-- Mobile -->
				<div class="lg:hidden">
					<h3 class="font-icon-serif text-blue text-[clamp(2.8rem,10vw,5rem)] uppercase leading-none mb-2">
						NAVIGAZIONE LIBERA
					</h3>
					<span class="font-typewriter text-blue text-[0.7rem] tracking-[0.2em] uppercase">
						( MEN&Ugrave; ALLA CARTA )
					</span>
				</div>
			</div>

			<!-- Immagine hover — desktop only, wrapper aspect-ratio + overflow-hidden -->
			<div class="menu-tab-img hidden lg:block absolute right-14 top-1/2 rotate-6 -translate-y-1/2 w-[20%] max-w-[260px] pointer-events-none will-change-transform z-20"
				 aria-hidden="true">
				<div class="aspect-[3/4] overflow-hidden">
					<?php if ($navigazione_libera_id) : ?>
						<?php echo get_custom_responsive_image($navigazione_libera_id, 'large', 'block w-full h-full object-cover'); ?>
					<?php else : ?>
						<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/navigazione_libera.jpg'); ?>" alt="" class="block w-full h-full object-cover" loading="lazy">
					<?php endif; ?>
				</div>
			</div>

		</a>

	</section>

	<!-- ═══════════════════════════════════════════════
	     SEZIONE GALLERY POLAROID 2 — 4 immagini, nessun testo
	     ═══════════════════════════════════════════════ -->
	<?php
	$gallery_2_images = [
		[ 'url' => get_site_url() . '/wp-content/uploads/2026/03/gallery-2-1.jpg' ],
		[ 'url' => get_site_url() . '/wp-content/uploads/2026/03/gallery-2-2.png' ],
		[ 'url' => get_site_url() . '/wp-content/uploads/2026/03/gallery-2-3.png' ],
		[ 'url' => get_site_url() . '/wp-content/uploads/2026/03/gallery-2-4.png' ],
	];
	?>
	<section class="gallery-polaroid-section relative w-full bg-white overflow-hidden py-20 lg:py-32 px-4">

		<div class="gallery-polaroid-grid relative w-full mx-auto">

			<?php foreach ($gallery_2_images as $idx => $img) :
				$img_id   = attachment_url_to_postid($img['url']);
				$from_dir = ($idx < 2) ? 'left' : 'right';
				$rotations = ['-rotate-[3deg]', 'rotate-[2deg]', '-rotate-[1.5deg]', 'rotate-[2.5deg]'];
				$rot = $rotations[$idx];
			?>
				<div class="gallery-polaroid-item gallery-polaroid-item--<?php echo $from_dir; ?> relative flex flex-col <?php echo ($idx % 2 === 0) ? 'justify-end' : 'justify-start'; ?>"
					data-index="<?php echo $idx; ?>">

					<!-- Immagine -->
					<div class="gallery-polaroid-frame <?php echo $rot; ?> will-change-transform">
						<div class="w-full overflow-hidden">
							<?php if ($img_id) : ?>
								<?php echo get_custom_responsive_image($img_id, 'large', 'block w-full h-full object-cover object-center'); ?>
							<?php else : ?>
								<img src="<?php echo esc_url($img['url']); ?>" alt="" class="block w-full h-full object-cover object-center" loading="lazy">
							<?php endif; ?>
						</div>
					</div>

				</div>
			<?php endforeach; ?>

		</div>

	</section>

	<!-- ═══════════════════════════════════════════════
	     SEZIONE EVENTI — banner marquee diagonale bg-blue
	     ═══════════════════════════════════════════════ -->
	<div id="eventi" class="overflow-hidden">
		<div class="relative overflow-hidden py-16 -rotate-3">
			<section class="eventi-marquee-section relative w-full bg-blue py-5 scale-110 overflow-hidden pointer-events-none">
				<div class="eventi-marquee-track flex whitespace-nowrap will-change-transform">
					<?php for ($i = 0; $i < 10; $i++) : ?>
						<h3 class="font-icon-serif text-white text-6xl lg:text-8xl pt-3 lg:pt-5 uppercase tracking-[0.25em] leading-none select-none px-8">EVENTI</h3>
					<?php endfor; ?>
				</div>
			</section>
		</div>
	</div>

	<!-- ═══════════════════════════════════════════════
	     SEZIONE FEO & FRIENDS — testo sinistra + swiper cards destra
	     ═══════════════════════════════════════════════ -->
	<section class="feo-friends-section w-full bg-white px-6 py-20 lg:py-32 text-blue">

		<div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center gap-16 lg:gap-24">

			<!-- COLONNA SINISTRA — testo -->
			<div class="w-full lg:w-1/2 flex flex-col gap-6">

				<!-- Etichetta typewriter -->
				<p class="font-typewriter text-[clamp(0.55rem,1.1vw,0.75rem)] tracking-[0.25em] uppercase m-0">
					( &nbsp;Gli eventi di Feo&nbsp; )
				</p>

				<!-- Titolo principale — New Icon Serif -->
				<h2 class="font-icon-serif text-[clamp(3rem,7vw,6rem)] uppercase leading-[1.05] m-0">
					Feo &amp; Friends
				</h2>

				<!-- Testo descrittivo — typewriter -->
				<div class="font-typewriter text-[clamp(0.85rem,1.05vw,1rem)] leading-[1.9] tracking-wide max-w-md">
					<p class="m-0">Certe sere il mio diario di bordo si apre agli appunti e alle storie di altri chef.</p>
					<br>
					<p class="m-0">Feo &amp; Friends è un incontro tra cucine, idee e territori diversi. Amici che arrivano nel mio ristorante per cucinare insieme e raccontare il loro mare, la loro terra, la loro visione. Menu irripetibili, a più mani.</p>
				</div>

				<!-- CTA Button -->
				<div class="mt-4">
					<a href="#form" class="inline-block font-typewriter text-[clamp(0.6rem,0.9vw,0.75rem)] rounded-full tracking-[0.2em] uppercase text-blue py-4 px-8 transition-colors duration-300 hover:bg-blue hover:text-white" style="border: 1px solid #23222D;">
						Riserva il tuo tavolo
					</a>
				</div>

			</div>

			<!-- COLONNA DESTRA — Swiper cards -->
			<div class="feo-friends-cards-wrapper p-5 overflow-hidden w-full lg:w-1/2 flex items-center justify-center">
				<div class="swiper feo-friends-swiper overflow-hidden">
					<div class="swiper-wrapper">

						<!-- Slide 1: card-1.png -->
						<?php
						$card1_id = attachment_url_to_postid(get_site_url() . '/wp-content/uploads/2026/03/card-1.png');
						?>
						<div class="swiper-slide p-10 aspect-square">
							<div class="feo-friends-card overflow-hidden">
								<?php if ($card1_id) : ?>
									<?php echo get_custom_responsive_image($card1_id, 'large', 'block w-full h-auto object-cover aspect-square'); ?>
								<?php else : ?>
									<img src="<?php echo esc_url(get_site_url() . '/wp-content/uploads/2026/03/card-1.png'); ?>" alt="Feo &amp; Friends" class="block w-full h-full object-cover" loading="lazy">
								<?php endif; ?>
							</div>
						</div>

						<!-- Slide 2: quadrato beige -->
						<div class="swiper-slide">
							<div class="feo-friends-card aspect-square" style="background-color: #E8DCC8;"></div>
						</div>

						<!-- Slide 3: quadrato blu -->
						<div class="swiper-slide aspect-square">
							<div class="feo-friends-card" style="background-color: #23222D;"></div>
						</div>

					</div>
				</div>
			</div>

		</div>

	</section>

	<!-- ═══════════════════════════════════════════════
	     SEZIONE RISERVA IL TUO TAVOLO — form prenotazione
	     ═══════════════════════════════════════════════ -->
	<section id="form" class="riserva-section w-full bg-blue px-6 py-20 lg:py-32">

		<div class="riserva-card max-w-6xl mx-auto bg-white px-10 py-12 lg:px-16 lg:py-16">

			<!-- Titolo — New Icon Serif -->
			<h2 class="font-icon-serif text-[clamp(2.2rem,5.5vw,4.5rem)] uppercase leading-[1.05] text-blue mb-4">
				Riserva il tuo tavolo
			</h2>

			<!-- Sottotitolo — typewriter -->
			<p class="font-typewriter text-blue text-[clamp(0.72rem,0.95vw,0.85rem)] tracking-wide leading-[1.8] mb-10">
				Compila i campi qui sotto e sarai ricontattato per confermare il tuo viaggio culinario.
			</p>

			<!-- Contact Form 7 — sostituisci YOUR_FORM_ID con l'ID del form -->
			<?php echo do_shortcode('[contact-form-7 id="e1c3e12" title="Riserva il tuo tavolo"]'); ?>

		</div>

	</section>

</article>
