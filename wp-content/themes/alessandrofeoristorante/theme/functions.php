<?php

/**
 * alessandrofeoristorante functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package alessandrofeoristorante
 */

if (! defined('ALESSANDROFEORISTORANTE_VERSION')) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define('ALESSANDROFEORISTORANTE_VERSION', '0.1.29');
}

if (! defined('ALESSANDROFEORISTORANTE_TYPOGRAPHY_CLASSES')) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `alessandrofeoristorante_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'ALESSANDROFEORISTORANTE_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if (! function_exists('alessandrofeoristorante_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function alessandrofeoristorante_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on alessandrofeoristorante, use a find and replace
		 * to change 'alessandrofeoristorante' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('alessandrofeoristorante', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __('Primary', 'alessandrofeoristorante'),
				'menu-2' => __('Footer Menu', 'alessandrofeoristorante'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Enqueue editor styles.
		add_editor_style('style-editor.css');

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		// Remove support for block templates.
		remove_theme_support('block-templates');
	}
endif;
add_action('after_setup_theme', 'alessandrofeoristorante_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alessandrofeoristorante_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Footer', 'alessandrofeoristorante'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your footer.', 'alessandrofeoristorante'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'alessandrofeoristorante_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function alessandrofeoristorante_scripts()
{
	wp_enqueue_style('alessandrofeoristorante-style', get_stylesheet_uri(), array(), ALESSANDROFEORISTORANTE_VERSION);
	wp_enqueue_script('alessandrofeoristorante-script', get_template_directory_uri() . '/js/script.min.js', array(), ALESSANDROFEORISTORANTE_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'alessandrofeoristorante_scripts');

/**
 * Enqueue the block editor script.
 */
function alessandrofeoristorante_enqueue_block_editor_script()
{
	$current_screen = function_exists('get_current_screen') ? get_current_screen() : null;

	if (
		$current_screen &&
		$current_screen->is_block_editor() &&
		'widgets' !== $current_screen->id
	) {
		wp_enqueue_script(
			'alessandrofeoristorante-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			ALESSANDROFEORISTORANTE_VERSION,
			true
		);
		wp_add_inline_script('alessandrofeoristorante-editor', "tailwindTypographyClasses = '" . esc_attr(ALESSANDROFEORISTORANTE_TYPOGRAPHY_CLASSES) . "'.split(' ');", 'before');
	}
}
add_action('enqueue_block_assets', 'alessandrofeoristorante_enqueue_block_editor_script');

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function alessandrofeoristorante_tinymce_add_class($settings)
{
	$settings['body_class'] = ALESSANDROFEORISTORANTE_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter('tiny_mce_before_init', 'alessandrofeoristorante_tinymce_add_class');

/**
 * Limit the block editor to heading levels supported by Tailwind Typography.
 *
 * @param array  $args Array of arguments for registering a block type.
 * @param string $block_type Block type name including namespace.
 * @return array
 */
function alessandrofeoristorante_modify_heading_levels($args, $block_type)
{
	if ('core/heading' !== $block_type) {
		return $args;
	}

	// Remove <h1>, <h5> and <h6>.
	$args['attributes']['levelOptions']['default'] = array(2, 3, 4);

	return $args;
}
add_filter('register_block_type_args', 'alessandrofeoristorante_modify_heading_levels', 10, 2);

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Function responsive image.
 */
function custom_theme_setup()
{
	add_theme_support('post-thumbnails'); // Abilita immagini in evidenza
	add_image_size('custom-small', 400, 300, true);
	add_image_size('custom-medium', 800, 600, false);
	add_image_size('custom-large', 1200, 900, false);
}

function get_browser_info($user_agent)
{
	$browser_info = array(
		'is_mobile' => false,
		'is_firefox' => false,
		'is_chrome' => false,
		'is_safari' => false,
		'is_ios' => false,
		'is_ipad' => false,
		'is_macos' => false,
		'is_android' => false,
		'is_desktop' => false,
		'browser_name' => '',
		'debug_info' => ''
	);

	// Apple devices detection (must come first)
	if (preg_match('/iPhone|iPod/i', $user_agent)) {
		$browser_info['is_ios'] = true;
		$browser_info['browser_name'] = 'iOS';
	} elseif (
		preg_match('/iPad/i', $user_agent) ||
		(preg_match('/Macintosh/i', $user_agent) && preg_match('/Safari/i', $user_agent))
	) {
		$browser_info['is_ipad'] = true;
		$browser_info['browser_name'] = 'iPadOS';
	} elseif (preg_match('/Macintosh/i', $user_agent)) {
		$browser_info['is_macos'] = true;
		$browser_info['browser_name'] = 'macOS';
	}
	// Mobile Android detection
	elseif (preg_match('/Android/i', $user_agent) && preg_match('/Mobile/i', $user_agent)) {
		$browser_info['is_android'] = true;
		$browser_info['is_mobile'] = true;
		$browser_info['browser_name'] = 'Android Mobile';
	}
	// Firefox detection
	elseif (preg_match('/Firefox/i', $user_agent)) {
		$browser_info['is_firefox'] = true;
		$browser_info['browser_name'] = 'Firefox';
		$browser_info['is_desktop'] = !preg_match('/Mobile|Android/i', $user_agent);
	}
	// Desktop detection
	elseif (preg_match('/Windows|Linux/i', $user_agent)) {
		$browser_info['is_desktop'] = true;
		$browser_info['browser_name'] = 'Desktop';
	}
	// Default fallback
	else {
		$browser_info['browser_name'] = 'Other';
	}

	return $browser_info;
}

function get_custom_responsive_image($image_id, $size = 'large', $classes = '')
{
	if (!$image_id) return '';

	// Get image metadata
	$image_meta = wp_get_attachment_metadata($image_id);

	// Get browser info
	$browser_info = get_browser_info($_SERVER['HTTP_USER_AGENT'] ?? '');

	$attr = array(
		'class' => $classes . ' will-change-transform backface-hidden',
		'sizes' => '(max-width: 768px) 100vw, (max-width: 1024px) 75vw, 100vw',
		'fetchpriority' => 'high',
		'data-browser' => $browser_info['browser_name']
	);

	// Remove existing filters
	remove_all_filters('wp_img_tag_add_loading_attr');
	remove_all_filters('wp_get_attachment_image_attributes');
	add_filter('wp_img_tag_add_loading_attr', '__return_false', 999);

	// Set loading strategy
	if (
		$browser_info['is_android'] && $browser_info['is_mobile'] ||
		$browser_info['is_firefox']
	) {
		// Lazy loading for Android mobile and Firefox
		$attr['loading'] = 'lazy';
		$attr['decoding'] = 'async';
	} else {
		// Eager loading for everything else (Apple devices, desktop, etc)
		$attr['loading'] = 'eager';
		$attr['decoding'] = 'sync';
	}

	// Force dimensions for CLS
	if ($image_meta) {
		$attr['width'] = $image_meta['width'];
		$attr['height'] = $image_meta['height'];
		$attr['style'] = "aspect-ratio: {$image_meta['width']} / {$image_meta['height']};";
	}

	// Build HTML structure with debug comment
	$output = "<!-- Image Loading Debug: {$browser_info['debug_info']} -->\n";
	$output .= '<picture class="will-change-transform w-full h-full pointer-events-none overflow-hidden">';
	$output .= '<figure class="will-change-transform w-full h-full pointer-events-none overflow-hidden">';
	$output .= '<div class="relative w-full h-full will-change-transform pointer-events-none overflow-hidden">';

	// Force our attributes
	add_filter('wp_get_attachment_image_attributes', function ($attrs) use ($attr) {
		return array_merge($attrs, $attr);
	}, 999);

	$output .= wp_get_attachment_image($image_id, $size, false, $attr);
	$output .= '</div>';
	$output .= '</figure>';
	$output .= '</picture>';

	// Restore default behavior
	remove_filter('wp_img_tag_add_loading_attr', '__return_false', 999);
	remove_all_filters('wp_get_attachment_image_attributes', 999);

	return $output;
}


/**
 * Function responsive video.
 */
function get_custom_responsive_video($video_id, $classes = '', $poster_url = '')
{
	if (!$video_id) return '';

	// Get video metadata
	$video_meta = wp_get_attachment_metadata($video_id);

	// Get browser info (reusing your existing function)
	$browser_info = get_browser_info($_SERVER['HTTP_USER_AGENT'] ?? '');

	$attr = array(
		'class' => $classes . ' object-cover',
		'playsinline' => 'true',
		'preload' => 'metadata',
		'muted' => 'true',
		'data-browser' => $browser_info['browser_name'],
		'autoplay' => 'true',
		'loop' => 'true',
	);

	// Add poster if provided
	if (!empty($poster_url)) {
		$attr['poster'] = esc_url($poster_url);
	}

	// Set loading strategy based on browser
	// if (
	// 	$browser_info['is_android'] && $browser_info['is_mobile'] ||
	// 	$browser_info['is_firefox']
	// ) {
	// 	$attr['preload'] = 'none';
	// } else {
	// 	$attr['preload'] = 'auto';
	// }

	// Get video URL
	$video_url = wp_get_attachment_url($video_id);
	$video_mime = get_post_mime_type($video_id);

	// Build HTML structure
	$output = "<!-- Video Loading Debug: Browser: {$browser_info['browser_name']} -->\n";
	$output .= '<div class="video-wrapper relative w-full h-full overflow-hidden">';

	$output .= '<video';
	foreach ($attr as $key => $value) {
		$output .= ' ' . esc_attr($key) . '="' . esc_attr($value) . '"';
	}
	$output .= '>';

	$output .= '<source src="' . esc_url($video_url) . '" type="' . esc_attr($video_mime) . '">';
	$output .= 'Your browser does not support the video tag.';
	$output .= '</video>';

	$output .= '</div>';
	$output .= '<script>
    document.addEventListener("DOMContentLoaded", function() {
        const video = document.getElementById("hero-video-' . $video_id . '");
        if (video) {
            video.addEventListener("loadedmetadata", function() {
                console.log("Video duration:", video.duration);
            });

            video.addEventListener("ended", function() {
                console.log("Video ended, restarting...");
                video.currentTime = 0;
                video.play();
            });

            // Assicurati che il video parta
            video.addEventListener("canplay", function() {
                if (video.paused) {
                    video.play().catch(e => console.log("Autoplay failed:", e));
                }
            });
        }
    });
    </script>';

	return $output;
}
/**
 * Get video ID from URL
 *
 * @param string $video_url The URL of the video in the media library
 * @return int|false The attachment ID if found, false otherwise
 */
function get_video_id_from_url($video_url)
{
	global $wpdb;

	// Clean the URL
	$video_url = esc_url($video_url);

	// Try to get the attachment ID directly from the URL
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $video_url));

	if (!empty($attachment[0])) {
		return (int) $attachment[0];
	}

	// If not found, try using attachment_url_to_postid (WordPress built-in function)
	$attachment_id = attachment_url_to_postid($video_url);
	if ($attachment_id) {
		return $attachment_id;
	}

	// If still not found, try to get it from the modified URL (handles resize variations)
	$video_url = preg_replace('/-\d+x\d+(?=\.(mp4|webm|ogg)$)/i', '', $video_url);
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $video_url));

	return !empty($attachment[0]) ? (int) $attachment[0] : false;
}


add_action( 'wpcf7_init', function() {
    wpcf7_add_form_tag( [ 'time', 'time*' ], function( $tag ) {
        $tag = new WPCF7_FormTag( $tag );
        $atts = array(
            'type'  => 'time',
            'name'  => $tag->name,
            'class' => $tag->get_class_option( 'wpcf7-time' ),
        );
        if ( $tag->is_required() ) {
            $atts['required'] = '';
            $atts['aria-required'] = 'true';
        }
        $html = sprintf(
            '<span class="wpcf7-form-control-wrap" data-name="%1$s"><input %2$s /></span>',
            esc_attr( $tag->name ),
            wpcf7_format_atts( $atts )
        );
        return $html;
    }, [ 'name-attr' => true ] );
} );
