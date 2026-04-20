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
$audio_url = get_site_url() . '/wp-content/uploads/2026/03/Sea.mp3';

// Full Menu — immagini per le card
$full_menu_images = array(
	get_site_url() . '/wp-content/uploads/2026/03/plate_oil.jpg',
	get_site_url() . '/wp-content/uploads/2026/04/005_FC--scaled.webp',
	get_site_url() . '/wp-content/uploads/2026/04/089_FC--scaled.webp',
	get_site_url() . '/wp-content/uploads/2026/04/063_FC-.jpg.webp',
	get_site_url() . '/wp-content/uploads/2026/04/051_FC--scaled.webp',
	get_site_url() . '/wp-content/uploads/2026/04/FC2_7678.webp',
	get_site_url() . '/wp-content/uploads/2026/04/006_FC--scaled.webp',
);

// Full Menu — numerali romani
$roman_numerals = array( 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X' );

// Full Menu — voci di menu (stessa location del footer)
$menu_locations   = get_nav_menu_locations();
$full_menu_obj_id = isset( $menu_locations['menu-2'] ) ? $menu_locations['menu-2'] : 0;
$full_menu_items  = $full_menu_obj_id ? wp_get_nav_menu_items( $full_menu_obj_id ) : array();
?>

<style>
/* ═══════════════════════════════════════════
   FULL MENU OVERLAY
   z-index: 9998 — l'header (z:9999) rimane sopra
   Il bottone toggle diventa X quando il menu è aperto
═══════════════════════════════════════════ */

/* — Icona X nel toggle button (nascosta di default) — */
#fm-icon-close { display: none; }

/* — Quando il full menu è aperto: disabilita mix-blend-difference
     sull'header così il bottone X rimane visibile sul fondo scuro — */
body.fm-is-open #masthead {
	mix-blend-mode: normal;
}

/* — Overlay — */
#full-menu-overlay {
	position: fixed;
	inset: 0;
	z-index: 9998;
	background: #23222D;
	display: flex;
	flex-direction: column;
	opacity: 0;
	pointer-events: none;
	visibility: hidden;
	/* mobile: scroll verticale */
	overflow-y: auto;
	overflow-x: hidden;
	-webkit-overflow-scrolling: touch;
}

#full-menu-overlay.is-open {
	pointer-events: all;
	visibility: visible;
}

/* — Spacer per non finire sotto l'header — */
.fm-header-space {
	flex-shrink: 0;
	height: 135px; /* header py-6 (24px*2) + logo 87px */
}

/* — Cards wrapper — */
#fm-cards {
	display: flex;
	flex-direction: column; /* mobile: verticale */
	gap: 0.75rem;
	padding: 0.5rem 1rem 2rem;
	flex: 1;
}

/* — Singola card — */
.fm-card {
	flex: 0 0 auto;
	width: 100%;
	min-height: 88svh;
	display: flex;
	flex-direction: column;
	align-items: center;
	text-align: center;
	padding: 3rem 2rem 2.5rem;
	background: #ffffff;
	border-radius: 3px;
	text-decoration: none;
	cursor: pointer;
	overflow: hidden;
}

/* — Contenuto card — */
.fm-card-title {
	font-family: 'icon-serif', serif;
	font-size: clamp(2.4rem, 9vw, 4.5rem);
	color: #23222D;
	text-transform: uppercase;
	line-height: 1;
	margin: 0 0 0.9rem;
	letter-spacing: 0.01em;
}

.fm-card-desc {
	font-family: 'script', cursive;
	font-size: clamp(1rem, 3.5vw, 1.35rem);
	color: #23222D;
	line-height: 1.45;
	margin: 0 0 0;
	max-width: 32ch;
}

.fm-card-image {
	flex: 1;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: 1.75rem 0;
	width: 100%;
}

.fm-card-image img {
	max-width: 70%;
	max-height: clamp(200px, 42svh, 420px);
	width: 100%;
	height: 100%;
	aspect-ratio: 2 / 3!important;
	object-fit: cover;
	display: block;
}

.fm-card-capitolo {
	font-family: 'icon-serif', serif;
	font-size: clamp(1.5rem, 5vw, 2.5rem);
	color: #23222D;
	text-transform: uppercase;
	letter-spacing: 0.05em;
	line-height: 1;
	margin: 0 0 0.85rem;
}

.fm-card-coords {
	font-family: 'typewriter', monospace;
	font-size: 0.65rem;
	letter-spacing: 0.1em;
	color: #23222D;
	opacity: 0.65;
	margin: 0;
}

/* ─── SCROLL HINT — solo desktop ──────── */
#fm-scroll-hint {
	display: none;
}

@media (min-width: 1024px) {
	#fm-scroll-hint {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 0.8rem;
		padding: 0 2rem 0.75rem;
		flex-shrink: 0;
		opacity: 1;
		transition: opacity 0.5s ease;
		pointer-events: none;
		user-select: none;
	}

	#fm-scroll-hint.is-hidden {
		opacity: 0;
	}

	.fm-scroll-hint-dot {
		width: 14px;
		height: 14px;
		border-radius: 50%;
		background: #ffffff;
		flex-shrink: 0;
	}

	.fm-scroll-hint-text {
		font-family: 'typewriter', monospace;
		font-size: 1rem;
		letter-spacing: 0.32em;
		text-transform: uppercase;
		color: #ffffff;
		opacity: 0.75;
	}
}

/* ─── DESKTOP ──────────────────────────── */
@media (min-width: 1024px) {
	.fm-header-space {
		height: 135px;
	}

	#full-menu-overlay {
		overflow: hidden; /* JS gestisce lo scroll orizzontale */
	}

	#fm-cards {
		flex-direction: row; /* orizzontale */
		gap: 1.25rem;
		padding: 1.75rem 2rem 2rem;
		flex: 1;
		min-height: 0;
		will-change: transform;
		align-items: stretch;
		/* overflow visible: la rotazione CSS delle card non viene clippata
		   dall'#fm-cards, ma dall'overlay che ha overflow:hidden */
		overflow: visible;
	}

	.fm-card {
		flex: 0 0 30vw;
		width: 30vw;
		min-height: 0;
		height: 100%;
		padding: 3rem 2.5rem 2.5rem;
		border-radius: 4px;
		/* Transizione per hover (rotazione + colore immagine) */
		transition: transform 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94);
	}

	/* Rotazioni alternate in stato normale */
	.fm-card:nth-child(odd) {
		transform: rotate(-1.5deg);
	}
	.fm-card:nth-child(even) {
		transform: rotate(1deg);
	}

	/* Hover: card si raddrizza + immagine a colori */
	.fm-card:hover {
		transform: rotate(0deg);
	}

	/* Immagini in B&W di default, a colori su hover */
	.fm-card .fm-card-image img {
		filter: grayscale(100%);
		transition: filter 0.5s ease;
	}
	.fm-card:hover .fm-card-image img {
		filter: grayscale(0%);
	}

	.fm-card-title {
		font-size: clamp(2rem, 3.2vw, 4rem);
		margin-bottom: 0.75rem;
	}

	.fm-card-desc {
		font-size: clamp(0.9rem, 1.2vw, 1.1rem);
	}

	.fm-card-image img {
		max-width: 60%;
		//max-height: clamp(200px, 36vh, 400px);
		//padding: 0 45px;
	}

	.fm-card-capitolo {
		font-size: clamp(1.3rem, 2vw, 2rem);
	}
}
</style>

<header id="masthead" class="fixed w-full top-0 left-0 right-0 z-9999 mix-blend-difference">

	<div class="relative w-full flex items-center justify-between px-5 lg:px-20 py-6">

		<!-- SINISTRA: bottone full menu — diventa X quando il menu è aperto -->
		<button
			id="full-menu-toggle"
			class="flex items-center justify-center opacity-90 hover:opacity-100 transition-opacity cursor-pointer"
			aria-label="<?php esc_attr_e( 'Apri menu', 'alessandrofeoristorante' ); ?>"
			aria-expanded="false"
		>
			<!-- Icona: segnalibro (menu chiuso) -->
			<span id="fm-icon-open" aria-hidden="true">
				<svg width="22" height="27" viewBox="0 0 24 30" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M0 30V3.33333C0 2.41667 0.326666 1.63222 0.98 0.98C1.63333 0.327778 2.41778 0.00111111 3.33333 0H20C20.9167 0 21.7017 0.326667 22.355 0.98C23.0083 1.63333 23.3344 2.41778 23.3333 3.33333V30L11.6667 25L0 30ZM3.33333 24.9167L11.6667 21.3333L20 24.9167V3.33333H3.33333V24.9167Z" fill="white"/>
				</svg>
			</span>
			<!-- Icona: X (menu aperto) -->
			<span id="fm-icon-close" aria-hidden="true">
				<svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M20 2L2 20M2 2L20 20" stroke="white" stroke-width="2.5" stroke-linecap="round"/>
				</svg>
			</span>
		</button>

		<!-- CENTRO: logo FEO — assoluto al 50% esatto della pagina -->
		<div class="absolute left-1/2 -translate-x-1/2 pointer-events-none">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="pointer-events-auto relative block w-full overflow-hidden" aria-label="<?php bloginfo( 'name' ); ?> – Home">
				<svg width="87" height="87" viewBox="0 0 87 87" fill="none" xmlns="http://www.w3.org/2000/svg">
<g clip-path="url(#clip0_475_1206)">
<path d="M73.9483 30.1681C68.1404 29.7093 62.6683 32.7837 60.1272 37.9811C59.0047 40.2769 58.5418 42.5636 58.6689 45.1518C58.9627 51.129 63.0737 56.4268 68.9201 58.0842C71.4072 58.7892 74.0995 58.8063 76.6291 58.1104C80.6463 57.0047 83.8602 54.1965 85.6221 50.5123C86.5249 48.6246 86.9666 46.6103 86.9988 44.518C87.1132 37.0658 81.4456 30.7609 73.9483 30.1681ZM80.8487 48.2473C79.6394 51.3461 76.9068 53.5667 73.4652 53.7679C72.0155 53.8522 70.6671 53.6801 69.3847 53.117C65.6987 51.4994 63.9161 47.6716 64.0518 43.805C64.2255 38.8526 67.5573 34.774 72.7729 34.7466C76.9862 34.725 80.2311 37.4294 81.249 41.4226C81.828 43.695 81.7015 46.062 80.8487 48.2473Z" fill="white"/>
<path d="M48.552 30.8548L48.5508 57.8704L30.0202 57.8738L29.9609 57.5198L29.9638 53.313L43.4088 53.3135L43.4105 46.2637L34.2243 46.2626V41.7228L43.4123 41.7222V35.3683L30.9167 35.3689L30.9178 30.8457L48.552 30.8548Z" fill="white"/>
<path d="M14.4496 42.3743L14.453 46.9163L5.14028 46.918V57.8738L0 57.8732L0.00115008 30.8565L17.5933 30.8457L17.5979 35.3695L5.14143 35.3678L5.14258 42.3749L14.4496 42.3743Z" fill="white"/>
<path d="M56.8203 70.8773L56.0509 70.8881L54.0825 68.036L54.0583 70.8835L53.293 70.8824V66.8385L54.079 66.834L56.0296 69.6541L56.0555 66.8368L56.8197 66.8374L56.8203 70.8773Z" fill="white"/>
<path d="M51.7983 20.1618L51.0145 20.1806L49.0577 17.3456L49.0249 20.1732L48.2676 20.1675L48.2682 16.1259L49.0445 16.123L51.0013 18.9529L51.0312 16.1259L51.792 16.1248L51.7983 20.1618Z" fill="white"/>
<path d="M57.5673 18.1728C57.5489 17.6365 57.4667 17.1736 57.1303 16.7878C56.7675 16.3711 56.2281 16.142 55.6588 16.1386L53.8652 16.1289L53.8675 20.1773C54.58 20.1671 55.2229 20.2104 55.8681 20.1448C56.917 20.0377 57.603 19.2107 57.5673 18.1728ZM56.5771 18.9251C56.2206 19.584 55.2511 19.531 54.6502 19.4922L54.6513 16.8168L55.5616 16.8277C55.9009 16.8317 56.2839 16.9838 56.4845 17.2665C56.8227 17.7419 56.8664 18.3905 56.5771 18.9251Z" fill="white"/>
<path d="M66.5023 16.0237C65.2936 15.8966 64.2217 16.7988 64.1556 18.0316C64.0941 19.1721 64.9141 20.1439 66.0118 20.2784C67.132 20.4158 68.1763 19.6834 68.3793 18.5264C68.5995 17.2707 67.7157 16.1513 66.5023 16.0237ZM67.1602 19.22C66.8163 19.5648 66.3223 19.6423 65.8755 19.5061C65.4799 19.3853 65.1441 19.0376 65.0302 18.5822C64.8991 18.0578 64.9756 17.4936 65.3684 17.0895C65.9106 16.5304 66.8721 16.5959 67.3258 17.2428C67.7479 17.8441 67.6904 18.6882 67.1602 19.22Z" fill="white"/>
<path d="M39.1996 66.7131C37.9041 66.7284 36.9144 67.8775 37.1237 69.1935C37.2876 70.2251 38.1669 70.99 39.1945 70.9986C40.2249 71.0071 41.1369 70.2947 41.3232 69.2277C41.5602 67.8729 40.5188 66.6971 39.1996 66.7131ZM40.4883 69.2545C40.3589 69.7475 40.0196 70.0941 39.6062 70.2115C39.1369 70.3448 38.6361 70.2457 38.3072 69.8803C37.7626 69.2762 37.7609 68.3141 38.3618 67.7384C38.8431 67.2773 39.6821 67.3144 40.1364 67.7823C40.5176 68.1744 40.6263 68.729 40.4883 69.2545Z" fill="white"/>
<path d="M61.643 18.4894C62.2249 18.1822 62.4147 17.5969 62.2778 17.0355C62.1439 16.4894 61.6257 16.127 61.0168 16.127H59.5527L59.5539 20.1691L60.2951 20.1731L60.2991 18.5818L60.8828 18.5977L61.6988 20.1794L62.5619 20.1657L61.643 18.4894ZM61.137 17.9041C60.8673 17.9634 60.5717 17.944 60.2986 17.9303L60.2957 16.7864L60.9081 16.7756C61.1996 16.7699 61.4515 16.958 61.505 17.1928C61.5682 17.4709 61.4837 17.8271 61.137 17.9041Z" fill="white"/>
<path d="M22.333 69.1911C22.8477 68.9306 23.0697 68.4342 22.9984 67.8677C22.9247 67.2863 22.4268 66.8959 21.8327 66.832L20.2422 66.8337V70.8816L20.9874 70.8862L20.9938 69.2931L21.5901 69.3062L22.3957 70.8936L23.268 70.8759L22.333 69.1911ZM21.7039 68.6377C21.4411 68.6462 21.2215 68.6434 20.9897 68.6371L20.9943 67.4858C21.2836 67.4829 21.5194 67.4789 21.7741 67.5046C22.0639 67.5337 22.2295 67.8266 22.2255 68.0683C22.2209 68.331 22.0444 68.6274 21.7039 68.6377Z" fill="white"/>
<path d="M45.3666 69.1894C45.9359 68.9055 46.1509 68.3014 46.0089 67.748C45.8663 67.1911 45.3464 66.8309 44.7386 66.832L43.2832 66.8343V70.8822L44.0221 70.8873L44.0256 69.2965L44.619 69.3045L45.4333 70.8924L46.2976 70.8713L45.3666 69.1894ZM44.8876 68.604C44.6121 68.6679 44.3131 68.6485 44.0256 68.6422V67.4938C44.3286 67.4812 44.6104 67.4653 44.8853 67.5223C45.1251 67.5713 45.2424 67.8374 45.2487 68.0147C45.2562 68.2455 45.1912 68.5334 44.8876 68.604Z" fill="white"/>
<path d="M31.5982 20.1749L28.7961 20.176L28.7949 19.5035L30.7972 19.5006L30.8133 18.4548L29.4401 18.4428L29.4315 17.7628L30.8053 17.748L30.8076 16.8104L28.9387 16.8036L28.9329 16.123L31.5965 16.1236L31.5982 20.1749Z" fill="white"/>
<path d="M45.0349 16.135L44.2281 16.123L42.6836 20.1646L43.495 20.1755L43.8429 19.1666L45.3748 19.1769L45.7198 20.1863L46.5691 20.1521L45.0349 16.135ZM44.062 18.522L44.6106 17.0088L45.1448 18.5123L44.062 18.522Z" fill="white"/>
<path d="M66.7515 70.8873L63.9551 70.8884L63.9568 70.1914L65.9758 70.1845V69.1404L64.6003 69.1375L64.6009 68.457L65.9781 68.441L65.97 67.5029L64.1046 67.4955L64.1063 66.832L66.7509 66.8332L66.7515 70.8873Z" fill="white"/>
<path d="M20.9381 16.1287L20.1301 16.127L18.5879 20.1663L19.3987 20.1754L19.7437 19.17L21.2796 19.1757L21.6155 20.1805L22.474 20.1628L20.9381 16.1287ZM19.9697 18.5174L20.5074 16.9956L21.041 18.4957L19.9697 18.5174Z" fill="white"/>
<path d="M50.0661 66.842L49.2512 66.834L47.709 70.8767L48.5198 70.8858L48.8792 69.8491L50.3967 69.8593L50.7504 70.8904L51.6072 70.8773L50.0661 66.842ZM49.0937 69.2187L49.6354 67.6975L50.1667 69.205L49.0937 69.2187Z" fill="white"/>
<path d="M35.5344 20.16C34.719 20.4752 33.8093 20.2261 33.2773 19.5405C33.4326 19.3706 33.6103 19.2065 33.815 19.0457C34.2049 19.4931 34.7155 19.7234 35.2538 19.504C35.4533 19.423 35.5522 19.1785 35.5482 18.9899C35.5436 18.7727 35.3722 18.5966 35.1313 18.5265L34.2446 18.2683C33.8317 18.148 33.5631 17.7747 33.4987 17.4345C33.4142 16.9842 33.5505 16.5453 33.9248 16.2905C34.5683 15.854 35.6902 15.9001 36.21 16.5898L35.6954 17.0634C35.3561 16.7454 34.9484 16.5903 34.5286 16.7699C34.3935 16.828 34.2653 17.0064 34.2532 17.1318C34.2078 17.6054 34.9754 17.6995 35.3596 17.8083C35.9156 17.9657 36.2836 18.3812 36.3274 18.9112C36.3699 19.435 36.0956 19.9428 35.5344 20.16Z" fill="white"/>
<path d="M40.4505 20.1077C39.6282 20.5061 38.6196 20.2507 38.0859 19.5349C38.2682 19.34 38.4252 19.198 38.6201 19.0464C39.0054 19.4881 39.5069 19.7207 40.0474 19.5064C40.2297 19.4346 40.3539 19.214 40.3608 19.0345C40.3913 18.1869 38.6777 18.6896 38.3355 17.5537C38.2055 17.1222 38.2803 16.6412 38.642 16.3596C39.3372 15.8187 40.3872 15.8894 41.0181 16.562L40.4982 17.0635C40.171 16.7472 39.7789 16.6041 39.3683 16.7552C39.1877 16.8213 39.056 17.006 39.0578 17.1849C39.0595 17.336 39.2101 17.536 39.3901 17.589L40.2412 17.837C40.7472 17.9846 41.0652 18.3875 41.1244 18.8572C41.1866 19.3548 40.9657 19.8575 40.4505 20.1077Z" fill="white"/>
<path d="M29.9783 70.8593C29.179 71.1824 28.2377 70.9368 27.7012 70.2414L28.2141 69.7444C28.5712 70.1058 28.9783 70.3668 29.4844 70.2694C29.7696 70.2141 29.9553 70.0254 29.9668 69.7661C29.9778 69.5079 29.8254 69.289 29.5384 69.2138L28.7983 69.02C28.4108 68.9186 28.1204 68.6461 27.9916 68.3349C27.826 67.9342 27.8789 67.5073 28.1445 67.1813C28.7023 66.4985 30.1744 66.5772 30.6264 67.2999L30.1273 67.7524C29.788 67.476 29.4504 67.3181 29.056 67.4258C28.8651 67.4783 28.7069 67.6367 28.6839 67.8009C28.6569 67.9912 28.7834 68.2209 28.9979 68.2825L29.7828 68.5082C30.351 68.6718 30.7138 69.0913 30.7506 69.6293C30.7851 70.136 30.4999 70.6484 29.9783 70.8593Z" fill="white"/>
<path d="M35.7984 67.4955L34.4172 67.5017L34.4155 70.8833L33.642 70.881L33.6392 67.5063L32.2637 67.4943L32.2677 66.832L35.7915 66.8326L35.7984 67.4955Z" fill="white"/>
<path d="M62.1699 67.4935L60.7708 67.5004L60.7662 70.8779L60.0026 70.8848L59.9986 67.5049L58.6058 67.4935L58.6035 66.8318L62.1561 66.8301L62.1699 67.4935Z" fill="white"/>
<path d="M26.9643 19.5071L26.9637 20.1762L24.165 20.179L24.1621 16.138L24.9332 16.1289L24.9424 19.5053L26.9643 19.5071Z" fill="white"/>
<path d="M25.843 70.8798L25.084 70.8838V66.8365L25.8413 66.8359L25.843 70.8798Z" fill="white"/>
</g>
<defs>
<clipPath id="clip0_475_1206">
<rect width="87" height="55" fill="white" transform="translate(0 16)"/>
</clipPath>
</defs>
</svg>
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

<!-- ═══════════════════════════════════════════
     FULL MENU OVERLAY  (z:9998 — header z:9999 rimane sopra)
     Toggle apre/chiude — bottone diventa X
═══════════════════════════════════════════ -->
<div
	id="full-menu-overlay"
	aria-hidden="true"
	role="dialog"
	aria-modal="true"
	aria-label="<?php esc_attr_e( 'Menu di navigazione', 'alessandrofeoristorante' ); ?>"
>

	<!-- Spazio per non finire nascosto sotto l'header fisso -->
	<div class="fm-header-space" aria-hidden="true"></div>

	<!-- Scroll hint — desktop only, scompare al primo scroll -->
	<div id="fm-scroll-hint" aria-hidden="true">
		<span class="fm-scroll-hint-dot"></span>
		<span class="fm-scroll-hint-text">Scroll</span>
	</div>

	<!-- Cards — una per ogni voce di menu -->
	<div id="fm-cards">
		<?php
		$fm_coords = '40&#176;10&#8242;31&#8243;N 15&#176;07&#8242;01&#8243;E';

		if ( ! empty( $full_menu_items ) ) :
			foreach ( $full_menu_items as $idx => $item ) :
				$img_url    = $full_menu_images[ $idx % 7 ];
				$numeral    = isset( $roman_numerals[ $idx ] ) ? $roman_numerals[ $idx ] : ( $idx + 1 );
				$capitolo   = 'CAPITOLO ' . $numeral;
				$desc       = ! empty( $item->description ) ? $item->description : '';
				?>
				<a
					href="<?php echo esc_url( $item->url ); ?>"
					class="fm-card"
					aria-label="<?php echo esc_attr( $item->title ); ?>"
				>
					<h2 class="fm-card-title"><?php echo esc_html( $item->title ); ?></h2>
					<?php if ( $desc ) : ?>
					<p class="fm-card-desc"><?php echo esc_html( $desc ); ?></p>
					<?php endif; ?>
					<div class="fm-card-image">
						<img
							src="<?php echo esc_url( $img_url ); ?>"
							alt="<?php echo esc_attr( $item->title ); ?>"
							loading="lazy"
						>
					</div>
					<p class="fm-card-capitolo"><?php echo esc_html( $capitolo ); ?></p>
					<p class="fm-card-coords"><?php echo $fm_coords; ?></p>
				</a>
				<?php
			endforeach;
		else :
			// Fallback se il menu non è ancora configurato in WP
			$fallback = array(
				array( 'title' => 'La Mia Rotta', 'url' => home_url( '/' ),         'desc' => 'Seguo il mare e lascio parlare la materia prima' ),
				array( 'title' => 'Lo Chef',       'url' => home_url( '/chef/' ),    'desc' => "Nella mia cucina s\u2019incontrano terra, mare e rispetto dei prodotti" ),
				array( 'title' => 'Madre Mare',    'url' => home_url( '/menu/' ),    'desc' => 'I doni del mare e la mia responsabilit&agrave; di portarli a terra' ),
			);
			foreach ( $fallback as $idx => $item ) :
				$img_url  = $full_menu_images[ $idx % 3 ];
				$numeral  = $roman_numerals[ $idx ];
				$capitolo = 'CAPITOLO ' . $numeral;
				?>
				<a
					href="<?php echo esc_url( $item['url'] ); ?>"
					class="fm-card"
					aria-label="<?php echo esc_attr( $item['title'] ); ?>"
				>
					<h2 class="fm-card-title"><?php echo esc_html( $item['title'] ); ?></h2>
					<p class="fm-card-desc"><?php echo $item['desc']; ?></p>
					<div class="fm-card-image">
						<img
							src="<?php echo esc_url( $img_url ); ?>"
							alt="<?php echo esc_attr( $item['title'] ); ?>"
							loading="lazy"
						>
					</div>
					<p class="fm-card-capitolo"><?php echo esc_html( $capitolo ); ?></p>
					<p class="fm-card-coords"><?php echo $fm_coords; ?></p>
				</a>
				<?php
			endforeach;
		endif;
		?>
	</div>

</div><!-- #full-menu-overlay -->
