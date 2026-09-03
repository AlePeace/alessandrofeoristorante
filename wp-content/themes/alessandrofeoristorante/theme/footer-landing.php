<?php
/**
 * Footer alternativo per le landing page ads (get_footer( 'landing' )).
 *
 * Richiama il footer visivo snello — contatti essenziali, niente voci menu —
 * al posto di template-parts/layout/footer-content.php.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package alessandrofeoristorante
 */

?>

	</div><!-- #content -->

	<?php get_template_part( 'template-parts/layout/footer', 'landing' ); ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
