<?php get_header();?>
<div class="container">
   <header class="entry-header alignwide">
		<h1 class="entry-title"><?php the_title();?></h1>		
	    <figure class="post-thumbnail">
		<?php if (has_post_thumbnail( $post->ID ) ): ?>
        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
         <img src="<?php echo $image[0];?>">
         <?php endif;?>

<?php $admin = get_field('admin_name'); ?>
<h5><?php if ($admin) {  echo $admin; } ?>  </h5>
 <?php $date = the_field('publish_date'); ?>
        <h4><?php if ($date){echo $date; } ?> </h4>
		 </figure><!-- .post-thumbnail -->

     </header>
      <p><?php the_content();?></p>
</div>
<?php		
$twenty_twenty_one_comment_count = get_comments_number();
?>

<div id="comments" class="comments-area default-max-width <?php echo get_option( 'show_avatars' ) ? 'show-avatars' : ''; ?>">

  <?php
  if ( have_comments() ) :
    ;
    ?>
    <h2 class="comments-title">
      <?php if ( '1' === $twenty_twenty_one_comment_count ) : ?>
        <?php esc_html_e( '1 comment', 'twentytwentyone' ); ?>
      <?php else : ?>
        <?php
        printf(
          /* translators: %s: Comment count number. */
          esc_html( _nx( '%s comment', '%s comments', $twenty_twenty_one_comment_count, 'Comments title', 'twentytwentyone' ) ),
          esc_html( number_format_i18n( $twenty_twenty_one_comment_count ) )
        );
        ?>
      <?php endif; ?>
    </h2><!-- .comments-title -->

    <ol class="comment-list">
      <?php
      wp_list_comments(
        array(
          'avatar_size' => 60,
          'style'       => 'ol',
          'short_ping'  => true,
        )
      );
      ?>
    </ol><!-- .comment-list -->

    <?php
    the_comments_pagination(
      array(
        'before_page_number' => esc_html__( 'Page', 'twentytwentyone' ) . ' ',
        'mid_size'           => 0,
        'prev_text'          => sprintf(
          '%s <span class="nav-prev-text">%s</span>',
          is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ),
          esc_html__( 'Older comments', 'twentytwentyone' )
        ),
        'next_text'          => sprintf(
          '<span class="nav-next-text">%s</span> %s',
          esc_html__( 'Newer comments', 'twentytwentyone' ),
          is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' )
        ),
      )
    );
    ?>

    <?php if ( ! comments_open() ) : ?>
      <p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'twentytwentyone' ); ?></p>
    <?php endif; ?>
  <?php endif; ?>

  <?php
  comment_form(
    array(
      'logged_in_as'       => null,
      'title_reply'        => esc_html__( 'Leave a comment', 'twentytwentyone' ),
      'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
      'title_reply_after'  => '</h2>',
    )
  );
  ?>

</div><!-- #comments -->

<script type="text/javascript">
  
  jQuery('document').ready(function($){
    var commentform=$('#commentform'); // find the comment form
    commentform.prepend('<div id="comment-status" ></div>'); // add info panel before the form to provide feedback or errors
    var statusdiv=$('#comment-status'); // define the infopanel

    commentform.submit(function(){
        //serialize and store form data in a variable
        var formdata=commentform.serialize();
        //Add a status message
        statusdiv.html('<p>Processing...</p>');
        //Extract action URL from commentform
        var formurl=commentform.attr('action');
        //Post Form with data
        $.ajax({
            type: 'post',
            url: formurl,
            data: formdata,
            error: function(XMLHttpRequest, textStatus, errorThrown)
                {
                    statusdiv.html('<p class="ajax-error" >You might have left one of the fields blank, or be posting too quickly</p>');
                },
            success: function(data, textStatus){
                if(data == "success" || textStatus == "success"){
                    statusdiv.html('<p class="ajax-success" >Thanks for your comment. We appreciate your response.</p>');
                }else{
                    statusdiv.html('<p class="ajax-error" >Please wait a while before posting your next comment</p>');
                    commentform.find('textarea[name=comment]').val('');
                }
            }
        });
        return false;
    });
});
</script>
<?php get_footer();?>
