<?php
/*
Template name:Return policy
*/
get_header();
?>


  <!-- Bootstrap -->
 
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/faq.css" rel="stylesheet">
	
	<section class="faq">
		<div class="container">
			<div class="heading-me"><center><h6>Return Policy</h6></center></div>
			<div class="footer-innerpages">
				All sales are Final. 
				Questions and concerns can be sent to <a href="mainto:support@xtrememarketingcode.com">support@xtrememarketingcode.com</a>
			</div>
		</div>
	</section>
	
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
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
	<?php
	get_footer();
	?>