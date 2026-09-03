<?php
/**
 * Header alternativo per le landing page ads (get_header( 'landing' )).
 *
 * Stessa struttura di header.php (doctype, wp_head, wrapper #page) ma
 * richiama l'header visivo snello — solo logo, senza il full menu del sito —
 * al posto di template-parts/layout/header-content.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package alessandrofeoristorante
 */

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<div id="page">

	<?php get_template_part( 'template-parts/layout/header', 'landing' ); ?>

	<div id="content">
