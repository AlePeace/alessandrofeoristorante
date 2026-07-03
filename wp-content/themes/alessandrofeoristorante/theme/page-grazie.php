<?php
/**
 * Template Name: Grazie – Thank You Page
 *
 * Thank you page mostrata dopo l'invio del form di prenotazione (Contact Form 7).
 * Si applica automaticamente a una Pagina con slug `grazie`, oppure può essere
 * selezionata da Attributi pagina → Template.
 *
 * @package alessandrofeoristorante
 */

get_header();
?>

<style>
/* ═══════════════════════════════════════════
   THANK YOU PAGE — stile marinaro Alessandro Feo
   CSS autonomo (non dipende dalla build Tailwind)
═══════════════════════════════════════════ */
.grazie-page {
	position: relative;
	width: 100%;
	min-height: 100vh;
	background: #23222D;
	display: flex;
	align-items: center;
	justify-content: center;
	padding: clamp(150px, 18vh, 200px) 1.25rem clamp(4rem, 8vh, 7rem);
	overflow: hidden;
}

/* Coordinate decorative in filigrana sullo sfondo */
.grazie-page::before {
	content: "40\00B0 10\2032 31\2033 N   15\00B0 07\2032 01\2033 E";
	position: absolute;
	top: clamp(120px, 15vh, 160px);
	left: 50%;
	transform: translateX(-50%);
	font-family: 'typewriter', monospace;
	font-size: 0.62rem;
	letter-spacing: 0.32em;
	color: #C9B47C;
	opacity: 0.55;
	white-space: nowrap;
	pointer-events: none;
}

.grazie-card {
	position: relative;
	width: 100%;
	max-width: 780px;
	background: #ffffff;
	border-radius: 2px;
	padding: clamp(2.5rem, 5vw, 4.5rem) clamp(1.75rem, 5vw, 4rem);
	box-shadow: 0 30px 80px rgba(0, 0, 0, 0.35);
}

/* — Icona ancora in alto — */
.grazie-anchor {
	display: flex;
	justify-content: center;
	margin-bottom: 1.75rem;
}
.grazie-anchor svg {
	width: 40px;
	height: 40px;
}

/* — Titolo — */
.grazie-title {
	font-family: 'icon-serif', serif;
	font-size: clamp(2rem, 5.5vw, 3.6rem);
	line-height: 1.05;
	text-transform: uppercase;
	color: #23222D;
	text-align: center;
	margin: 0 0 1.75rem;
	letter-spacing: 0.01em;
}

/* — Intro / lead — */
.grazie-lead {
	font-family: 'typewriter', monospace;
	font-size: clamp(0.78rem, 1vw, 0.9rem);
	line-height: 1.85;
	color: #23222D;
	text-align: center;
	margin: 0 auto 1.25rem;
	max-width: 56ch;
}
.grazie-lead strong {
	font-weight: 400;
	border-bottom: 1px solid #C9B47C;
	padding-bottom: 1px;
}

.grazie-intro-steps {
	font-family: 'typewriter', monospace;
	font-size: clamp(0.78rem, 1vw, 0.9rem);
	line-height: 1.85;
	color: #23222D;
	text-align: center;
	margin: 2.25rem auto 2rem;
	max-width: 52ch;
}

/* — Divisore con rombo — */
.grazie-divider {
	display: flex;
	align-items: center;
	justify-content: center;
	gap: 0.75rem;
	margin: 2rem auto;
	max-width: 220px;
}
.grazie-divider span {
	flex: 1;
	height: 1px;
	background: rgba(35, 34, 45, 0.2);
}
.grazie-divider i {
	width: 6px;
	height: 6px;
	transform: rotate(45deg);
	background: #C9B47C;
	flex-shrink: 0;
}

/* — Lista passaggi — */
.grazie-steps {
	list-style: none;
	margin: 0 auto;
	padding: 0;
	max-width: 560px;
	counter-reset: rotta;
}
.grazie-steps > li {
	position: relative;
	display: flex;
	align-items: flex-start;
	gap: 1.1rem;
	padding: 0 0 1.75rem;
}
.grazie-steps > li:last-child {
	padding-bottom: 0;
}
/* linea verticale che unisce i numeri come una rotta */
.grazie-steps > li:not(:last-child)::before {
	content: "";
	position: absolute;
	left: 17px;
	top: 40px;
	bottom: 4px;
	width: 1px;
	background: repeating-linear-gradient(
		to bottom,
		rgba(35, 34, 45, 0.35) 0 3px,
		transparent 3px 7px
	);
}
.grazie-step-num {
	counter-increment: rotta;
	flex-shrink: 0;
	width: 36px;
	height: 36px;
	border: 1px solid #23222D;
	border-radius: 50%;
	display: flex;
	align-items: center;
	justify-content: center;
	font-family: 'typewriter', monospace;
	font-size: 0.85rem;
	color: #23222D;
	background: #ffffff;
	position: relative;
	z-index: 1;
}
.grazie-step-num::before {
	content: counter(rotta);
}
.grazie-step-body {
	flex: 1;
	padding-top: 0.35rem;
}
.grazie-step-body p {
	font-family: 'typewriter', monospace;
	font-size: clamp(0.75rem, 0.95vw, 0.86rem);
	line-height: 1.8;
	color: #23222D;
	margin: 0;
}
.grazie-step-body .grazie-substep {
	opacity: 0.7;
	font-size: clamp(0.68rem, 0.85vw, 0.78rem);
	margin-top: 0.4rem;
}

/* — Box nota carta di credito — */
.grazie-note {
	margin: 1rem 0 0;
	padding: 1rem 1.15rem;
	background: rgba(201, 180, 124, 0.1);
	border-left: 2px solid #C9B47C;
	border-radius: 2px;
}
.grazie-note p {
	font-family: 'typewriter', monospace;
	font-size: clamp(0.68rem, 0.85vw, 0.78rem);
	line-height: 1.75;
	color: #23222D;
	margin: 0;
}
.grazie-note strong {
	font-weight: 400;
	color: #23222D;
	border-bottom: 1px solid #C9B47C;
}

/* — Chiusura confermata — */
.grazie-confirm {
	font-family: 'typewriter', monospace;
	font-size: clamp(0.75rem, 0.95vw, 0.86rem);
	line-height: 1.8;
	color: #23222D;
	text-align: center;
	margin: 2rem auto 0;
	max-width: 52ch;
}

/* — Riga finale in script — */
.grazie-signoff {
	font-family: 'script', cursive;
	font-size: clamp(1.35rem, 3.5vw, 2rem);
	line-height: 1.35;
	color: #23222D;
	text-align: center;
	margin: 1.75rem auto 0;
	max-width: 24ch;
}

/* — Bottone torna alla home — */
.grazie-actions {
	display: flex;
	justify-content: center;
	margin-top: 2.5rem;
}
.grazie-btn {
	display: inline-block;
	font-family: 'typewriter', monospace;
	font-size: clamp(0.6rem, 0.9vw, 0.72rem);
	letter-spacing: 0.2em;
	text-transform: uppercase;
	color: #23222D;
	text-decoration: none;
	background: transparent;
	border: 1px solid #23222D;
	border-radius: 9999px;
	padding: 0.9rem 2.5rem;
	transition: background-color 0.3s ease, color 0.3s ease;
}
.grazie-btn:hover {
	background-color: #23222D;
	color: #ffffff;
}
</style>

<main id="main" class="grazie-page">

	<div class="grazie-card">

		<!-- Ancora -->
		<div class="grazie-anchor" aria-hidden="true">
			<svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
				<circle cx="12" cy="4" r="2.1" stroke="#C9B47C" stroke-width="1.4"/>
				<path d="M12 6.1V21" stroke="#C9B47C" stroke-width="1.4" stroke-linecap="round"/>
				<path d="M8.5 9.5H15.5" stroke="#C9B47C" stroke-width="1.4" stroke-linecap="round"/>
				<path d="M4 13.5C4 17.9 7.6 21 12 21C16.4 21 20 17.9 20 13.5" stroke="#C9B47C" stroke-width="1.4" stroke-linecap="round"/>
				<path d="M4 13.5L2.3 14.6M4 13.5L5.9 14.3" stroke="#C9B47C" stroke-width="1.4" stroke-linecap="round"/>
				<path d="M20 13.5L21.7 14.6M20 13.5L18.1 14.3" stroke="#C9B47C" stroke-width="1.4" stroke-linecap="round"/>
			</svg>
		</div>

		<!-- Titolo -->
		<h1 class="grazie-title">Grazie per aver scelto Alessandro Feo</h1>

		<!-- Intro -->
		<p class="grazie-lead">
			La tua rotta è tracciata: abbiamo ricevuto la tua richiesta di prenotazione,
			<strong>ma non è stata ancora confermata.</strong>
		</p>

		<p class="grazie-intro-steps">
			Per salpare insieme verso questa esperienza, è necessario seguire questi semplici passaggi:
		</p>

		<div class="grazie-divider" aria-hidden="true">
			<span></span><i></i><span></span>
		</div>

		<!-- Passaggi -->
		<ol class="grazie-steps">
			<li>
				<span class="grazie-step-num" aria-hidden="true"></span>
				<div class="grazie-step-body">
					<p>Attendi la nostra e-mail sull'indirizzo indicato nel form.</p>
					<p class="grazie-substep">
						Se entro pochi minuti non l'hai ricevuta, ti invitiamo a verificare
						anche la cartella Spam o Posta indesiderata.
					</p>
				</div>
			</li>

			<li>
				<span class="grazie-step-num" aria-hidden="true"></span>
				<div class="grazie-step-body">
					<p>Clicca sul link sicuro ricevuto nella mail per completare la procedura di conferma.</p>
				</div>
			</li>

			<li>
				<span class="grazie-step-num" aria-hidden="true"></span>
				<div class="grazie-step-body">
					<p>Inserisci i dati della tua carta di credito a garanzia della prenotazione.</p>
					<div class="grazie-note">
						<p>
							La carta di credito è richiesta esclusivamente a tutela della prenotazione
							e <strong>non comporta alcun addebito anticipato.</strong>
							In caso di mancata presentazione sarà applicata una penale di 30&nbsp;€ per persona.
						</p>
					</div>
				</div>
			</li>

			<li>
				<span class="grazie-step-num" aria-hidden="true"></span>
				<div class="grazie-step-body">
					<p>Prenotazione confermata.</p>
				</div>
			</li>
		</ol>

		<!-- Conferma finale -->
		<p class="grazie-confirm">
			Solo al termine di questa procedura la tua prenotazione sarà considerata
			confermata e accettata.
		</p>

		<!-- Firma emozionale -->
		<p class="grazie-signoff">
			Ti aspettiamo a bordo, per condividere il mare secondo Alessandro Feo.
		</p>

		<!-- Torna alla home -->
		<div class="grazie-actions">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="grazie-btn">Torna alla home</a>
		</div>

	</div>

</main><!-- .grazie-page -->

<?php
get_footer();
