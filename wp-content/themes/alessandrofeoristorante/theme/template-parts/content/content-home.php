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

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> class="m-0 p-0">

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
		<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-20 text-center w-[90%] pointer-events-none">

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
		<div class="absolute bottom-[8%] left-1/2 -translate-x-2/3 z-20 pointer-events-none rotate-90">
			<span
				class="font-doodles text-white text-9xl scale-180 block leading-none animate-[heroArrowBounce_2.4s_ease-in-out_infinite]"
				aria-hidden="true">y</span>
		</div>

	</section>
	<!-- ═══════════════════════════════════════════════
	     SEZIONE ROTTA — marquee + immagine scroll
	     ═══════════════════════════════════════════════ -->
	<section class="rotta-section relative w-full min-h-[90vh] flex items-center bg-white overflow-hidden justify-center px-5 py-20 lg:py-40">

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
	<section class="chef-section relative w-full bg-white px-6 py-20 lg:py-32 text-blue overflow-hidden">

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
	     SEZIONE MARE — scroll normale, z-index:2 (sopra).
	     Nessun wrapper, nessun sticky.
	     La sezione successiva sta già sotto (z-index:1,
	     margin-top:-100vh) e viene rivelata naturalmente
	     mentre questa scorre via verso l'alto.
	     ═══════════════════════════════════════════════ -->
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
				<source src="<?php echo $video_url; ?>" type="video/webm">
			</video>
		</div>

		<!-- BOTTONE CIRCOLARE CHIUDI/APRI -->
		<button
			class="mare-toggle-btn absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-30 w-20 h-20 rounded-full border border-white/50 bg-white/20 backdrop-blur-sm flex items-center justify-center cursor-pointer transition-colors duration-300 hover:bg-white/30"
			aria-label="Apri o chiudi il video">
			<span class="mare-toggle-label font-typewriter text-white text-[0.6rem] tracking-[0.25em] uppercase select-none pointer-events-none">CHIUDI</span>
		</button>

	</section>

	<!-- ═══════════════════════════════════════════════
	     SEZIONE SUCCESSIVA — z-index:1, margin-top:-100vh.
	     Sta già nascosta sotto la sezione mare (z-index:2).
	     Nessuna animazione JS: man mano che la sezione mare
	     sale e lascia il viewport, questa emerge da sotto.
	     Puro CSS — zero dipendenze da ScrollTrigger.
	     ═══════════════════════════════════════════════ -->
	<section class="chef-section relative w-full bg-white px-6 py-20 lg:py-32 text-blue overflow-hidden">

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

</article>