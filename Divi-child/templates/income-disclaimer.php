<?php 
/*
Template name:Income Disclaimer
*/
get_header();
?>
     <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/faq.css" rel="stylesheet">
	
	<section class="faq">
		<div class="container">
			<div class="heading-me"><center><h6>Income Disclaimer</h6></center></div>
			<div class="footer-innerpages">
				Examples of earnings shared does not represent each affiliate of XMC.  Any earnings reported herein should not be taken as a guarantee of an affiliate’s earnings, commissions, and profits.  All SALES ARE FINAL, NO REFUNDS are offered.  XMC reserves the rights to amend any aspects of XMC at any given point in time.
				Monies from any new membership received without an inviter will revert to the admin of XMC.
				XMC is not responsible for any monetary loss, or any misplacements of XMC software ie: lead packages.  All affiliates are private contractors.  XMC does not pay out any commissions whatsoever.  This is a peer-to-peer payment system.  Contact a tax professional with your income concerns and questions

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