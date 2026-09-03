<?php
/**
 * ACF helpers — lettura campi tema-side.
 *
 * Regola: nei template NON usare mai get_field() diretto. Usa questi helper,
 * che non vanno in errore se ACF è assente e gestiscono il fallback al testo
 * di default. Stessa convenzione del tema elaionsuitespa (vedi il suo
 * GUIDA-CAMPI-ACF.md), adattata con il prefisso di questo tema.
 *
 * @package alessandrofeoristorante
 */

if ( ! function_exists( 'alessandrofeoristorante_field' ) ) :
	/**
	 * Legge un campo ACF del post/pagina corrente, con fallback.
	 *
	 * @param string   $name     Nome del campo ACF.
	 * @param string   $fallback Valore di default se il campo è vuoto o ACF assente.
	 * @param int|null $post_id  Post ID specifico. Default: post corrente.
	 * @return mixed Valore del campo, o il fallback.
	 */
	function alessandrofeoristorante_field( $name, $fallback = '', $post_id = null ) {
		if ( ! function_exists( 'get_field' ) ) {
			return $fallback;
		}

		$value = get_field( $name, $post_id );

		if ( null === $value || '' === $value || false === $value ) {
			return $fallback;
		}

		return $value;
	}
endif;

if ( ! function_exists( 'alessandrofeoristorante_the_field' ) ) :
	/**
	 * Stampa un campo ACF del post/pagina corrente, con fallback.
	 *
	 * HTML inline consentito di default (wp_kses_post): i campi di contenuto
	 * accettano <br>, <strong>, <em>, ecc. Passare $allow_html = false solo per
	 * forzare l'escape totale (mai in un contesto attributo: lì usare
	 * esc_attr( alessandrofeoristorante_field( ... ) )).
	 *
	 * @param string   $name       Nome del campo ACF.
	 * @param string   $fallback   Valore di default se il campo è vuoto o ACF assente.
	 * @param bool     $allow_html True (default) per consentire HTML (wp_kses_post); false per esc_html.
	 * @param int|null $post_id    Post ID specifico. Default: post corrente.
	 */
	function alessandrofeoristorante_the_field( $name, $fallback = '', $allow_html = true, $post_id = null ) {
		$value = alessandrofeoristorante_field( $name, $fallback, $post_id );

		echo $allow_html ? wp_kses_post( $value ) : esc_html( $value );
	}
endif;
