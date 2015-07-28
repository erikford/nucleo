<?php
/**
 * Nucleo Comments
 *
 * This template is loaded by single.php and contains comments and the comment
 * form. The display of comments is handled by nucleo_user_comments_cb()
 * and nucleo_trackback_comments_cb() functions located in /includes/theme-template-tags.php.
 *
 * @package Nucleo
 * @version 1.0.0
 * @since 1.0.0
 * @author Erik Ford <@okayerik>
 *
 */ ?>
<div id="comments"><!-- begin #comments -->	
    <?php if ( post_password_required() ) : // if this is a password protected post ?>
    <p class="form-messages"><?php _e( 'This post is password protected. Enter the password to view comments.', 'nucleo' ); ?></p>
</div><!-- End #comments -->
<?php
    /* Stop the rest of comments.php from being processed, but don't kill the
     * script entirely -- we still have to fully load the template.
     */
    return;

    endif; // end password protection conditional check ?>

<?php if ( have_comments() ) : // if this post has comments ?>
    <h3 class="comments-head"><?php printf( _n( '1 Comment', '%1$s Comments', get_comments_number(), 'nucleo' ), number_format_i18n( get_comments_number() ) ); ?></h3>

    <?php if ( !comments_open() ) : ?>
        <p class="form-messages"><?php _e( 'Comments for this post are now closed.', 'nucleo' ); ?></p>
    <?php endif; ?>

    <?php if ( !empty( $comments_by_type['comment'] ) ) : // if there are user generated comments ?>
        <ol class="commentlist">
            <?php
                /* Loop through and list the comments. Tell wp_list_comments() to use the
                 * nucleo_user_comments_cb() to markup the comments.
                 */
                wp_list_comments( array(
                    'style'       => 'ol',
                    'callback'    => 'nucleo_user_comments_cb',
                    'type'        => 'comment',
                    'reply_text'  => '&mdash; Respond',
                    'avatar_size' => 50,
                    )
                );
            ?>
        </ol>
    <?php endif; // end user generated comments conditional check ?>

<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // if comments pagination is enabled and there are more than one page of comments ?>
    <div class="comments-navigation clear">
        <p class="alignleft"><?php previous_comments_link( __( '&laquo; Older Comments', 'nucleo' ) ); ?></p>
        <p class="alignright"><?php next_comments_link( __( 'Newer Comments &raquo;', 'nucleo' ) ); ?></p>
    </div>
<?php endif; // end comments pagination conditional check ?>

<?php elseif ( !comments_open() && !is_page() && post_type_supports( get_post_type(), 'comments' ) ) : // if there are no comments and comments are closed and the post type supports comments ?>
    <h3 class="comments-head"><?php _e( 'Comments Closed', 'compendio' ); ?></h3>
    <p class="form-messages"><?php _e( 'Comments for this post are closed.', 'compendio' ); ?></p>
<?php endif; // end conditional check for post comments ?>

<?php
    comment_form(
        array(
            'label_submit'         => __( 'Post Comment', 'nucleo' ),
            'title_reply'          => __( 'Leave a Comment', 'nucleo' ),
            'cancel_reply_link'    => __( 'Cancel Response', 'nucleo' ),
            'fields'               => array(
            	'author' => '<p><label for="author">' . __( 'Your Name', 'nucleo' )  . ( $req ? '<span class="rq">*</span>' : '' ) . '</label><input placeholder="' . esc_attr__( 'Name', 'nucleo' ) . '" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" tabindex="1" aria-required="true" required></p>',
            	'email'  => '<p><label for="email">' . __( 'Your Email', 'nucleo' ) . ( $req ? '<span class="rq">*</span>' : '' ) . '</label><input placeholder="' . esc_attr__( 'Email', 'nucleo' ) . '" id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" tabindex="2" aria-required="true" required></p>',
            	'url'    => '<p><label for="url">' . __( 'Your URL', 'nucleo' ) . '</label><input placeholder="' . esc_attr__( 'Your Website', 'nucleo' ) . '" id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" tabindex="3" /></p>' . '<!-- #<span class="hiddenSpellError" pre="">form-section-url</span> .form-section -->',
            ),			
            'comment_field'        => '<p><label for="comment">' . __( 'Comment<span class="rq">&#42;</span>', 'nucleo' ) . '</label><textarea placeholder="' . esc_attr__( 'Your comment', 'nucleo' ) . '" id="comment" name="comment" aria-required="true" tabindex="4"></textarea></p>',
            'comment_notes_before' => __( '<p class="form-rules">Your email address will never be published or shared. Required fields are marked with an asterisk (<span class="rq">*</span>).</p>', 'nucleo' ),
            'comment_notes_after'  => '',
        )
    );	
?>
</div><!-- End #comments -->