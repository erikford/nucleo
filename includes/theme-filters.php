<?php
/*----------------------------------------------------------------------------*/
/* HTML5 Image Caption
/*----------------------------------------------------------------------------*/

add_filter( 'img_caption_shortcode', 'nucleo_html5_image_caption', 10, 3 );

/**
 * HTML5 Image Caption
 *
 * Return valid HTML5 markup for images with captions by filtering the WordPress
 * Caption shortcode.
 *
 * @param $val
 * @param $attr
 * @param $content
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_html5_image_caption( $val, $attr, $content = null ) {
    extract( shortcode_atts( array(
        'id'      => '',
        'align'   => '',
        'width'   => '',
        'caption' => '',
    ), $attr ) );

    if ( 1 > ( int ) $width || empty( $caption ) ) {
    	return $val;
    }

    if ( $id )
        $id = 'id="' . esc_attr( $id ) . '" ';

    return '<figure ' . $id . 'class="wp-caption ' . esc_attr( $align ) . '">' . do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $caption . '</figcaption></figure>';
}

/*----------------------------------------------------------------------------*/
/* Style MCE Button
/*----------------------------------------------------------------------------*/

add_filter( 'mce_buttons_2', 'nucleo_style_mce_button', 10, 1 );

/**
 * Style MCE Button
 *
 * Enable the Style drop down button on the WordPress Visual Editor screen.
 *
 * @param $buttons
 * @return $buttons
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_style_mce_button( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}

/*----------------------------------------------------------------------------*/
/* Custom Theme Classes
/*----------------------------------------------------------------------------*/

add_filter( 'tiny_mce_before_init', 'nucleo_custom_theme_classes', 10, 1 );

/**
 * Custom Theme Classes
 *
 * Adding CSS classes for additional type styling and setting.
 *
 * @param $settings
 * @return $settings
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_custom_theme_classes( $settings ) {
    $style_formats = array(
        array(
            'title'    => __( 'Primary Button', 'compendio' ),
            'selector' => 'a',
            'classes'  => 'button primary-button',
        ),
    );
    $style_formats = apply_filters( 'nucleo_style_formats', $style_formats );

	$settings['style_formats'] = json_encode( $style_formats );

    return $settings;
}

/*----------------------------------------------------------------------------*/
/* Trim Excerpt
/*----------------------------------------------------------------------------*/

add_filter( 'excerpt_length', 'nucleo_trim_excerpt', 10, 1 );

/**
 * Trim Excerpt
 *
 * A filter to trim post excerpts to 35 words.
 *
 * @param $length Default length
 * @return integer Filtered length
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_trim_excerpt( $length ) {
    return 35;
}

/*----------------------------------------------------------------------------*/
/* Excerpt Ellipsis
/*----------------------------------------------------------------------------*/

add_filter( 'excerpt_more', 'nucleo_excerpt_ellipsis', 10, 1 );

/**
 * Excerpt Ellipsis
 *
 * A filter to add a horizontal ellipsis to the end of excerpts.
 *
 * @param $more Default more string
 * @return string Filtered more string
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_excerpt_ellipsis( $more ) {
    return '&hellip;';
}

/*----------------------------------------------------------------------------*/
/* Post Teaser
/*----------------------------------------------------------------------------*/

add_filter( 'the_content_more_link', 'nucleo_post_teaser', 10, 1 );

/**
 * Post Teaser
 *
 * Add a class of post-teaser to the p tag wrapping the <!--more--> link and
 * preventing the default more link scroll.
 *
 * @param $link Default link string
 * @return $link Filtered link string
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_post_teaser( $link ) {
    $link = '<p class="post-teaser">' . preg_replace( '|#more-[0-9]+|', '', $link ) . '</p>';
    return $link;
}

/*----------------------------------------------------------------------------*/
/* Main Search Form
/*----------------------------------------------------------------------------*/

add_filter( 'get_search_form', 'nucleo_main_search_form', 10, 1 );

/**
 * Main Search Form
 *
 * Filter the HTML output of the default search form.
 *
 * @param $form Default search form
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_main_search_form( $form ) {
    $form = "<form class='search-form' id='search-form' action='" . get_home_url() . "/' method='get' role='search'>";
    $form .= "<label for='s'>" . __( 'Search', 'compendio' ) . "</label>";
    $form .= "<input id='s' name='s' type='search'>";
    $form .= "<input type='submit' value='" . esc_attr__( 'Submit', 'nucleo' ) . "'>";
    $form .= "</form>";
    return $form;
}

/*----------------------------------------------------------------------------*/
/* Alternate Search Form
/*----------------------------------------------------------------------------*/

/**
 * Alternate Search Form
 *
 * The HTML output for our alternate search form.
 *
 * @param $form Default search form
 *
 * @package Compendio
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function compendio_alt_search_form( $form ) {
    $form = "<form class='alt-search-form' id='alt-search-form' action='" . get_home_url() . "/' method='get' role='search'>";
    $form .= "<label for='s2'>" . __( 'Search', 'nucleo' ) . "</label>";
    $form .= "<input id='s2' name='s' type='search' placeholder='" . esc_attr__( 'Enter search keywords', 'nucleo' ) . "'>";
    $form .= "<input type='submit' name='submit' value='" . esc_attr__( 'Submit', 'nucleo' ) . "'>";
    $form .= "</form>";
    return $form;
}

/*----------------------------------------------------------------------------*/
/* Custom Password Form
/*----------------------------------------------------------------------------*/

add_filter( 'the_password_form', 'nucleo_custom_pw_form', 10 );

/**
 * Custom Password Form
 *
 * The HTML output for our custom password form.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford for Heavy Heavy <@okayerik>
 *
 */

function nucleo_custom_pw_form() {
    global $post;

    $label = "pwbox-" . ( empty( $post->ID ) ? rand() : $post->ID );

    $pwf = "<form class='nucleo-post-form' action='" . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . "' method='post'>";
    $pwf .= "<p class='form-messages'>" . __( 'Enter the password to view this post.', 'nucleo' ) . "</p>";
    $pwf .= "<p><label for='" . $label . "'>" . __( 'Enter Password', 'nucleo' ) . "</label><input name='post_password' id='" . $label . "' type='password' size='20' maxlength='20' /><br>";
    $pwf .= "<input type='submit' name='submit' value='" . esc_attr__( 'Submit Password', 'nucleo' ) . "' /></p>";
    $pwf .= "</form>";
    return $pwf;
}

/*----------------------------------------------------------------------------*/
/* Password Protected Excerpt
/*----------------------------------------------------------------------------*/

add_filter( 'the_excerpt', 'nucleo_pw_protected_excerpt', 10, 1 );

/**
 * Password Protected Excerpt
 *
 * Return a message on posts that are password protected instead of the
 * default excerpt.
 *
 * @param $excerpt
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function compendio_pw_protected_excerpt( $excerpt ) {
    if ( post_password_required() )
        $excerpt = "<p class='form-messages'>" . __( 'This post is password protected.', 'nucleo' ) . "</p>";
    return $excerpt;
}