<?php
/*Template Name: FAQ
 
*/
get_header();



	

$args = array(
	'post_type'=> 'faq_list',	
	'order'    => 'ASC',	
	'posts_per_page' => -1,
	);              

$the_query = new WP_Query( $args );
 ?>
 
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 <link href="<?php  echo  get_template_directory_uri().'-child'; ?>/css/faq.css" rel="stylesheet">
	<section class="faq">
		<div class="container">
			<div class="heading-me"><center><h6>FAQ</h6></center></div>
			<div class="panel-group" id="faqAccordian" role="tablist" aria-multiselectable="true">
			 
			 <?php $i=1; if($the_query->have_posts() ) { while ( $the_query->have_posts() ) { $the_query->the_post(); ?>
				<div class="panel panel-default">
					<div class="panel-heading <?php if($i == 1){ echo "active"; } ?>" role="tab" id="headingTen">
					  <h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#faqAccordian" href="#collapseTen<?= $i; ?>" aria-expanded="false" aria-controls="headingTen">
						   <i class="more-less glyphicon glyphicon-plus"></i><?php echo the_title();?>
					
						</a>
					  </h4>
					</div>
					<div id="collapseTen<?= $i; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTen">
					  <div class="panel-body">
						<?php echo the_content();?>
					  </div>
					</div>
				</div>
			 <?php $i++;
			 }
			} ?>
			</div>
		</div>
	</section>

	<?php get_footer(); ?>
	<script src="<?php echo  get_template_directory_uri().'-child'; ?>/js/bootstrap.min.js"></script>
	<script>
		function toggleIcon(e) {
			$(e.target)
				.prev('.panel-heading')
				.find(".more-less")
				.toggleClass('glyphicon-plus glyphicon-minus');
		}
		$('.panel-group').on('hidden.bs.collapse', toggleIcon);
		$('.panel-group').on('shown.bs.collapse', toggleIcon);
	</script>
	<script>
		$('.panel-heading a').click(function() {
			$('.panel-heading').removeClass('active');
			
			//If the panel was open and would be closed by this click, do not active it
			if(!$(this).closest('.panel').find('.panel-collapse').hasClass('in'))
				$(this).parents('.panel-heading').addClass('active');
		 });
	</script>
  