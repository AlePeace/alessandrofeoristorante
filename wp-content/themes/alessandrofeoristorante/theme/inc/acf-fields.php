<?php
/**
 * ACF field groups — registrati via codice (versionabili, non dipendono dal DB).
 *
 * Stessa convenzione del tema elaionsuitespa: un field group per page
 * template, organizzato con tab per sezione. I default_value replicano la
 * copy attuale: aprendo la pagina in admin il cliente trova i campi già
 * compilati col testo esistente, pronto da modificare/tradurre.
 *
 * Traduzione: WPML + ACFML. Ogni campo dichiara 'wpml_cf_preferences'
 * (Traduci / Copia / Copia una volta) — vedi alessandrofeoristorante_acf().
 *
 * Convenzione naming: {area}_{sezione}_{elemento} — snake_case.
 * Letti nei template via alessandrofeoristorante_field() /
 * alessandrofeoristorante_the_field() (inc/acf-helpers.php).
 *
 * @package alessandrofeoristorante
 */

/**
 * Builder campo ACF — riduce il boilerplate degli array.
 *
 * @param string $name    Nome campo (anche key, prefisso 'field_').
 * @param string $label   Label in admin.
 * @param string $type    Tipo ACF: text|textarea|url|wysiwyg|... Default 'text'.
 * @param string $default Valore di default (pre-compila il campo in admin).
 * @param array  $extra   Override/aggiunte (es. rows, instructions, wpml_cf_preferences).
 * @return array
 */
function alessandrofeoristorante_acf( $name, $label, $type = 'text', $default = '', $extra = array() ) {
	return array_merge(
		array(
			'key'                 => 'field_' . $name,
			'name'                => $name,
			'label'               => $label,
			'type'                => $type,
			'default_value'       => $default,
			// WPML/ACFML: preferenza di traduzione per campo. Costante nominale
			// (corretta a prescindere dalla numerica interna WPML); fallback intero
			// solo se WPML assente al momento di acf/init. Override via $extra
			// (es. WPML_COPY_CUSTOM_FIELD per valori tecnici condivisi tra lingue,
			// come URL o numeri di telefono per l'href).
			'wpml_cf_preferences' => defined( 'WPML_TRANSLATE_CUSTOM_FIELD' ) ? WPML_TRANSLATE_CUSTOM_FIELD : 2,
		),
		$extra
	);
}

/**
 * Builder tab ACF — separatore di sezione dentro un field group.
 *
 * @param string $slug  Slug univoco (entra nella key).
 * @param string $label Label tab.
 * @return array
 */
function alessandrofeoristorante_acf_tab( $slug, $label ) {
	return array(
		'key'   => 'field_tab_' . $slug,
		'label' => $label,
		'type'  => 'tab',
	);
}

/**
 * Location rule: field group legato a un Template pagina specifico
 * (l'header "Template Name:" del file, es. page-prenota-ads.php),
 * indipendentemente dallo slug/URL scelto per la pagina in WordPress.
 *
 * A differenza di una regola per slug, questa funziona anche per template
 * pensati per essere assegnati a slug diversi di volta in volta (es. le
 * landing page ads, dove lo slug cambia per ogni campagna).
 *
 * @param string $template_file Nome del file template (es. 'page-prenota-ads.php').
 * @return array
 */
function alessandrofeoristorante_acf_location_template( $template_file ) {
	return array(
		array(
			array(
				'param'    => 'page_template',
				'operator' => '==',
				'value'    => $template_file,
			),
		),
	);
}

add_action( 'acf/init', 'alessandrofeoristorante_register_acf_fields' );
/**
 * Registra tutti i field group del tema.
 */
function alessandrofeoristorante_register_acf_fields() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	alessandrofeoristorante_register_prenota_ads_fields();
}

/**
 * Field group — Prenota Tavolo, Landing Ads (page-prenota-ads.php).
 */
function alessandrofeoristorante_register_prenota_ads_fields() {
	// Valori tecnici (numero per il link tel:, email): stessi in tutte le
	// lingue, non vanno tradotti.
	$copy_once = array(
		'wpml_cf_preferences' => defined( 'WPML_COPY_CUSTOM_FIELD' ) ? WPML_COPY_CUSTOM_FIELD : 1,
	);

	acf_add_local_field_group(
		array(
			'key'      => 'group_prenota_ads',
			'title'    => 'Contenuti — Prenota Tavolo (Landing Ads)',
			'location' => alessandrofeoristorante_acf_location_template( 'page-prenota-ads.php' ),
			'style'    => 'default',
			'position' => 'normal',
			'fields'   => array(

				alessandrofeoristorante_acf_tab( 'lp_hero', 'Hero' ),
				alessandrofeoristorante_acf( 'lp_hero_coordinate', 'Coordinate (decorative)', 'text', '40°10′31″N   15°07′01″E', $copy_once ),
				alessandrofeoristorante_acf( 'lp_hero_kicker', 'Sopratitolo', 'text', 'Casal Velino · Cilento' ),
				alessandrofeoristorante_acf( 'lp_hero_titolo_riga_1', 'Titolo — riga 1', 'text', 'Alessandro Feo' ),
				alessandrofeoristorante_acf( 'lp_hero_titolo_riga_2', 'Titolo — riga 2', 'text', 'Ristorante' ),
				alessandrofeoristorante_acf(
					'lp_hero_lead',
					'Descrizione breve',
					'textarea',
					"Un ristorante affacciato sul mare del Cilento, dove il pescato del giorno incontra le erbe dell'orto e la cucina dello chef Alessandro Feo racconta ogni sera una rotta diversa. Prenota il tuo tavolo e vivi una cena a due passi dall'acqua.",
					array( 'type' => 'textarea', 'rows' => 4 )
				),
				alessandrofeoristorante_acf( 'lp_hero_cta_label', 'Bottone CTA — etichetta', 'text', 'Prenota il tuo tavolo' ),

				alessandrofeoristorante_acf_tab( 'lp_form', 'Form' ),
				alessandrofeoristorante_acf( 'lp_form_titolo', 'Titolo', 'text', 'Prenota il tuo tavolo' ),
				alessandrofeoristorante_acf(
					'lp_form_sottotitolo',
					'Sottotitolo',
					'textarea',
					'Compila i campi qui sotto: ti ricontatteremo per confermare la tua serata.',
					array( 'type' => 'textarea', 'rows' => 2 )
				),

				alessandrofeoristorante_acf_tab( 'lp_footer', 'Footer' ),
				alessandrofeoristorante_acf( 'lp_footer_indirizzo', 'Indirizzo', 'text', 'Via Angelo Lista, 24 — 84040 Casal Velino (SA)' ),
				alessandrofeoristorante_acf( 'lp_footer_telefono_testo', 'Telefono — testo visibile', 'text', '+39 328 8937 083' ),
				alessandrofeoristorante_acf( 'lp_footer_telefono_href', 'Telefono — numero per il link tel: (senza spazi)', 'text', '+393288937083', $copy_once ),
				alessandrofeoristorante_acf( 'lp_footer_email', 'Email', 'text', 'info@feoristorante.it', $copy_once ),
				alessandrofeoristorante_acf( 'lp_footer_orari', 'Orari', 'text', 'Aperti tutte le sere a cena' ),
				alessandrofeoristorante_acf( 'lp_footer_privacy_label', 'Link — etichetta Privacy Policy', 'text', 'Privacy Policy' ),
				alessandrofeoristorante_acf( 'lp_footer_cookie_label', 'Link — etichetta Cookie policy', 'text', 'Cookie policy' ),
			),
		)
	);
}
