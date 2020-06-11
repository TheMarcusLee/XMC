<?php
/*
Template name:Terms of use
*/
get_header();
?>

 <!-- Bootstrap -->
 
    <link href="<?php echo  get_template_directory_uri().'-child'; ?>/css/faq.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

	
	<section class="faq">
		<div class="container">
			<div class="heading-me"><center><h6>Terms Of Use</h6></center></div>
			<div class="footer-innerpages">
				Xtreme Marketing Code and Real View Promotions INC do not pay out any commissions.  It is a peer to peer pay system.
Xtreme Marketing Code and Real View Promotions INC cannot guarantee any amount of income, earnings, and or commissions 
XMC affiliates have legal rights to use, distribute and sell all XMC products along with the franchise itself.
XMC is not responsible for any taxes an affiliate may acquire using XMC.  See financial advisor for income generated form XMC.
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