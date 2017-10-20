<?php
/*----------------------------------------------------------------------------*/
/* User Comments Callback
/*----------------------------------------------------------------------------*/

/**
 * User Comments Callback
 *
 * This is our custom comments callback that will be used to markup the user
 * comments list when comments are enabled and the post has comments.
 *
 * @param $comment
 * @param $args
 * @param $depth
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_user_comments_cb( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    extract( $args, EXTR_SKIP );

    if ( 'div' == $args['style'] ) {
        $tag = 'div';
        $add_below = 'comment';
    } else {
        $tag = 'li';
        $add_below = 'div-comment';
    } ?>

<<?php echo $tag; ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
    <?php if ( 'div' != $args['style'] ) : ?>
    <div id="div-comment-<?php comment_ID() ?>" class="comment-body">
    <?php endif; ?>
        <div class="comment-author vcard">
            <?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
            <?php printf( '<address>%s</address>', get_comment_author_link() ); // the comment author name and link if URL was provided ?>
            <time class="comment-date" datetime="<?php comment_date( 'c' ); ?>"><?php printf( '%1$s &#64; %2$s', get_comment_date(), get_comment_time() ) ?> <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>" title="<?php esc_attr_e( 'Permanent link to this comment', 'nucleo' ); ?>">&#35;</a></time>
        </div>

        <?php if ( $comment->comment_approved == '0' ) : ?>
            <p class="form-messages"><?php _e( 'Your comment is awaiting moderation.', 'nucleo' ) ?></p>
        <?php endif; ?>

        <?php comment_text(); ?>
        
        <?php edit_comment_link( __( 'Edit', 'nucleo' ), '<span>', '</span>' ); ?>

        <div class="reply">
            <?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
        </div>
    <?php if ( 'div' != $args['style'] ) : ?>
    </div>
    <?php endif; ?>
<?php }

/*----------------------------------------------------------------------------*/
/* Trackback Comments Callback
/*----------------------------------------------------------------------------*/

/**
 * Trackback Comments Callback
 *
 * This is our custom comments callback that will be used to markup the trackback
 * comments list.
 *
 * @param $comment
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_trackback_comments_cb( $comment ) {
$GLOBALS['comment'] = $comment; ?>
<li><?php printf( '%s', get_comment_author_link() ) ?> <?php edit_comment_link( __( 'Edit', 'nucleo' ), '<span>', '</span>' ); ?>
<?php
}

/*----------------------------------------------------------------------------*/
/* Get Theme Menu Name
/*----------------------------------------------------------------------------*/

/**
 * Get Theme Menu Name
 *
 * Get the saved name value of a theme menu.
 *
 * @param $theme_location Theme location object from register_nav_menus()
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_get_theme_menu_name( $theme_location ) {
    if ( !has_nav_menu( $theme_location ) ) return false;

    $menus      = get_nav_menu_locations();
    $menu_title = wp_get_nav_menu_object( $menus[$theme_location] )->name;
    return $menu_title;
}

/*----------------------------------------------------------------------------*/
/* Archive Title
/*----------------------------------------------------------------------------*/

/**
 * Archive Title
 *
 * Print the archive title.
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.1 added conditions for author archive
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_archive_title() {
    if ( is_category() ) {
        printf( '<h1>%s</h1>', single_cat_title( '', false ) );
    } else if ( is_tag() ) {
        printf( __( '<h1>Articles tagged &lsquo;%s&rsquo;</h1>', 'nucleo' ), single_tag_title( '', false ) );
    } else if ( is_post_type_archive() ) {
        printf( '<h1>%s</h1>', post_type_archive_title( '', false ) );
    } else if ( is_day() ) {
        printf( '<h1>%s</h1>', get_the_time( get_option( 'date_format' ) ) );
    } else if ( is_month() ) {
        printf( '<h1>%s</h1>', get_the_time( 'F Y' ) );
    } else if ( is_year() ) {
        printf( '<h1>%s</h1>', get_the_time( 'Y' ) );
    } else if ( is_search() ) {
        printf( __( '<h1>Search Results for &ldquo;%s&rdquo;</h1>', 'nucleo' ), get_search_query() );
    } else if ( is_404() ) {
        echo __( '<h1>404 Error: Page not found</h1>', 'nucleo' );
    } else if ( is_author() ) {
        global $wp_query;
        $currauth = $wp_query->get_queried_object();
        echo __( '<h1>Posts by ' . esc_html( $currauth->display_name ) . '</h1>', 'nucleo' );
    } else if ( get_option( 'page_for_posts' ) ) {
        printf( '<h1>%s</h1>', get_the_title( get_option( 'page_for_posts' ) ) );
    }
}

/*----------------------------------------------------------------------------*/
/* Index Loop
/*----------------------------------------------------------------------------*/

/**
 * Index Loop
 *
 * Perform the index loop for index templates.
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_index_loop() {
    while ( have_posts() ) : the_post(); // execute the loop   
        if ( !get_post_format() ) { // if this is a standard blog entry
            get_template_part( 'loop' );
        } else {
            get_template_part( 'loop', get_post_format() );
        } 
    endwhile;
}

/*----------------------------------------------------------------------------*/
/* Content Loop
/*----------------------------------------------------------------------------*/

/**
 * Content Loop
 *
 * Perform the content loop for singular templates.
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_content_loop() {
    while ( have_posts() ) : the_post(); // execute the loop
        get_template_part( 'content' );
    endwhile;
}

/*----------------------------------------------------------------------------*/
/* Archive Pagination
/*----------------------------------------------------------------------------*/

/**
 * Archive Pagination
 *
 * Print archive pagination when necessary.
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_archive_pagination() {
    global $wp_query;

    // do not print an empty div if there is only one page
    if ( $wp_query->max_num_pages < 2 )
        return;

    $args = array(
        'mid_size'  => 3,
        'prev_text' => __( 'Previous', 'nucleo' ),
        'next_text' => __( 'Next', 'nucleo' ),
    );
    $args = apply_filters( 'nucleo_archive_paging_args', $args );

    the_posts_pagination( $args );
}

/*----------------------------------------------------------------------------*/
/* Post Pagination
/*----------------------------------------------------------------------------*/

/**
 * Post Pagination
 *
 * Print post pagination when <!--nextpage--> tag is present.
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_post_pagination() {
    $args = array(
        'before'         => '<p class="post-pagination">' . __( 'Pages ', 'nucleo' ),
        'after'          => '</p>',
        'link_before'    => '',
        'link_after'     => '',
        'separator'      => ' &#047; ',
        'next_or_number' => 'number',
    );
    $args = apply_filters( 'nucleo_post_paging_args', $args );

    wp_link_pages( $args );
}

/*----------------------------------------------------------------------------*/
/* Get Theme Menu Name
/*----------------------------------------------------------------------------*/

/**
 * Get Theme Menu Name
 *
 * Get the saved name value of a theme menu.
 *
 * @param $theme_location Theme location object from register_nav_menus()
 *
 * @package nucleo
 * @version 1.0.0
 * @since 1.0.1
 * @author Erik Ford <@okayerik>
 *
 */

function nucleo_get_theme_menu_name( $theme_location ) {
    if ( !has_nav_menu( $theme_location ) ) return false;

    $menus      = get_nav_menu_locations();
    $menu_title = wp_get_nav_menu_object( $menus[$theme_location] )->name;
    return $menu_title;
}