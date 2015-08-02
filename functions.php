<?php
/*----------------------------------------------------------------------------*/
/* Content Width
/*----------------------------------------------------------------------------*/

/**
 * Content Width
 *
 * Set the maximum content width.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

global $content_width;
if ( !isset( $content_width ) ) $content_width = 792;

/*----------------------------------------------------------------------------*/
/* Theme Setup
/*----------------------------------------------------------------------------*/

add_action( 'after_setup_theme', 'nucleo_theme_setup', 10 );

/**
 * Theme Setup
 *
 * Perform basic theme setup, registrations and init actions during theme
 * initialization.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_theme_setup() {
    // define version
    define( 'NUCLEO_VERSION', '1.0.0' );

    // add theme support for automatic-feed-links
    add_theme_support( 'automatic-feed-links' );

    // add theme support for HTML5 galleries & captions
    add_theme_support( 'html5', array( 'gallery' ) );

    // add theme support for post formats
    add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'status', 'quote', 'video'  ) );

    // add theme support for document title tag
    add_theme_support( 'title-tag' );

    // add theme support for post thumnail and setting the size
    add_theme_support( 'post-thumbnails' );

    // make theme available for translation
    // translations can be filed in the /languages/ directory
    load_theme_textdomain( 'nucleo', get_template_directory() . '/languages' );

    $locale = get_locale();
    $locale_file = get_template_directory() . '/languages/$locale.php';
    if ( is_readable( $locale_file ) )
        require_once( $locale_file );
}

/*----------------------------------------------------------------------------*/
/* Theme Setup
/*----------------------------------------------------------------------------*/

add_action( 'init', 'nucleo_theme_includes', 10 );

/**
 * Theme Includes
 *
 * Load custom theme helpers, actions and filters.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_theme_includes() {
    // load theme template tags
    require_once( get_template_directory() . '/includes/theme-template-tags.php' );

    // load theme filters
    require_once( get_template_directory() . '/includes/theme-filters.php' );
}

/*----------------------------------------------------------------------------*/
/* Viewport Width
/*----------------------------------------------------------------------------*/

add_action( 'wp_head', 'nucleo_viewport_width', 10 );

/**
 * Viewport Width
 *
 * Setting the viewport width for device agnostic mobile first layouts.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

if ( !function_exists( 'nucleo_viewport_width' ) ) {
    function nucleo_viewport_width() { ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php }
}

/*----------------------------------------------------------------------------*/
/* MS Viewport Patch
/*----------------------------------------------------------------------------*/

add_action( 'wp_head', 'nucleo_ms_viewport_patch', 10 );

/**
 * MS Viewport Patch
 *
 * Applying the Microsoft recommended solution for the viewport bug in Windows 8.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

if ( !function_exists( 'nucleo_ms_viewport_patch' ) ) {
    function nucleo_ms_viewport_patch() { ?>
<!-- Windows Mobile viewport patch -->
<script>
(function() {
    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
        var msViewportStyle = document.createElement("style");
        msViewportStyle.appendChild(
            document.createTextNode("@-ms-viewport{width:auto!important}")
        );
        document.getElementsByTagName("head")[0].appendChild(msViewportStyle);
    }
})();
</script>
<?php }
}

/*----------------------------------------------------------------------------*/
/* Theme Stylesheets
/*----------------------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'nucleo_theme_stylesheets', 10 );

/**
 * Theme Stylesheets
 *
 * Register and enqueue all theme related stylesheets using wp_register_style()
 * and wp_enqueue_style() respectively.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_theme_stylesheets() {
    if ( !is_admin() ) { // we do not want to register or enqueue these styles on admin screens
        // enqueue core stylesheet
        wp_register_style( 'nucleo', get_stylesheet_uri(), '', NUCLEO_VERSION, 'screen' );
    }
}

/*----------------------------------------------------------------------------*/
/* Remove Recent Comments Inline CSS
/*----------------------------------------------------------------------------*/

add_action( 'widgets_init', 'nucleo_remove_recent_comments_inline_css' );

/**
 * Remove Recent Comments Inline CSS
 *
 * Remove inline styles injected by Recent Comments widget.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_remove_recent_comments_inline_css() {
    global $wp_widget_factory;
    remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}

/*----------------------------------------------------------------------------*/
/* Theme Scripts
/*----------------------------------------------------------------------------*/

add_action( 'wp_enqueue_scripts', 'nucleo_theme_scripts', 10 );

/**
 * Theme Scripts
 *
 * Register and enqueue all theme related javascript files using 
 * wp_register_script() and wp_enqueue_script() respectively.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_theme_scripts() {
    if ( !is_admin() ) { // we do not want to register or enqueue these scripts on admin screens
        // enqueue jQuery
        wp_enqueue_script( 'jquery' );

        // enqueue comment reply JS
        if ( is_single() && comments_open() && get_option( 'thread_comments' ) )
            wp_enqueue_script( 'comment-reply' );
    }
}

/*----------------------------------------------------------------------------*/
/* Remove Widgets
/*----------------------------------------------------------------------------*/

add_action( 'widgets_init', 'nucleo_remove_widgets', 10 );

/**
 * Remove Widgets
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

if ( !function_exists( 'nucleo_remove_widgets' ) ) {
    function nucleo_remove_widgets() {
        unregister_widget( 'WP_Widget_Pages' );
        unregister_widget( 'WP_Widget_Calendar' );
        unregister_widget( 'WP_Widget_Links' );
        unregister_widget( 'WP_Widget_Meta' );
        unregister_widget( 'WP_Widget_Recent_Comments' );
        unregister_widget( 'WP_Widget_RSS' );
        unregister_widget( 'WP_Widget_Tag_Cloud' );
    }
}