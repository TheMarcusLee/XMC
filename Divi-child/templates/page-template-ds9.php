<?php
/*
Template Name: DS9
*/

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() ); ?>

<div id="main-content">
    
   
    
   
   

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
					<?php
						the_content();

						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'Divi' ), 'after' => '</div>' ) );
					?>
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->
  <?php if(isset($_GET['username'])) {  
            $refrer_table = $wpdb->prefix.'register_user';            				
            $refrer_detail = $wpdb->get_row("SELECT * FROM $refrer_table WHERE username='".strtolower($_GET['username'])."'");            
            if($refrer_detail){ 
            ?>
		 <script>
    
    $("#rname").text('<?php echo ucwords($refrer_detail->fname.' '.$refrer_detail->lname); ?>');
        
         $("#remail").text('<?php echo $refrer_detail->email;?>');
         $("#rmobile").text('<?php echo $refrer_detail->mobile;?>');
         $(".rusername").text(' <?php echo $refrer_detail->username;?>');
             $(".key").attr("href", "https://xtrememarketingcode.com/sales-1/?keyword=<?php echo $refrer_detail->username;?>")
             
             $(".kreg").attr("href", "  https://www.xtrememarketingcode.com/registration/?username=<?php echo $refrer_detail->username;?>")
             
             
             $(".kemail").attr("href", "mailto:<?php echo $refrer_detail->email;?>")
           
    </script>
    
						  
			
						  
			
                        
			
                       
			
                      
	
    <?php } 
        } else{ ?>
<script>
 $("#rname").text('Xtreme Marketing Code ');
 $("#remail").text(' xmc@xtrememarketingcode.com');
$("#rmobile").text(' 800-486-9962');
    $(".rusername").text('easy');
    $(".key").attr("href", "https://xtrememarketingcode.com/sales-1/?keyword=easy")
     $(".kreg").attr("href", "  https://www.xtrememarketingcode.com/registration/?username=easy")
     $(".kemail").attr("href", "mailto:xmc@xtrememarketingcode.com")
           
</script>
       
                         
					
                         
				
					
    <?php } ?>
<?php

get_footer();
