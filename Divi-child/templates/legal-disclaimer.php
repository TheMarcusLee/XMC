<?php 
/*
Template name:Legal Disclaimer
*/
get_header();
?>
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/faq.css" rel="stylesheet">
	
	<section class="faq">
		<div class="container">
			<div class="heading-me"><center><h6>Legal Disclaimer</h6></center></div>
			<div class="footer-innerpages">
				“Xtreme Marketing Code and Real View Promotions INC make all efforts to ensure that we accurately represent these products and the services that come along with them and the earning potential that is possible.  Any statements i.e.: earning statements, income statements, illustrations made by Xtreme Marketing Code and Real View Promotions INC or any independent representatives are general estimates of what you can earn as income.  Xtreme Marketing Code and Real View Promotions INC ensures no guarantee of income.  Any illustration/income examples are not a guarantee or promise.  Our business is not a “get rich quick” scheme.  Before considering if XMC is, and the products it sells are appropriate to your situation, please be sure to have regard to your objectives and do your own independent research. 
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