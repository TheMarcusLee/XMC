<?php
/*
Template name:How it work 
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
	
	<style>
		.how-work-image {
			position: relative;
		}
		.faq {
			padding-top: 40px;
			background: #efefef;
			margin-top:0px;
		}
		.my-take-action {
			position: absolute;
			bottom: 25px;
			min-width: 260px;
			line-height: 35px;
			background: red;
			color: #fff;
			border: 1px solid red;
			left: 26%;
			font-size: 20px;
			text-align: center;
		}
		.my-take-action:hover{color: #fff;}
		.faq embed, .faq iframe, .faq object, .faq video {
    max-width: 100%;
    background: #fff;
    border-radius: 5px;
    padding: 0px 20px;
}
.how-it-work-video {
    margin-bottom: 25px;
}
	</style>
	<section class="faq">
		<div class="container">
			<div class="heading-me"><center><h6>How It Works</h6></center></div>
			<div class="row">
				<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
					<div class="how-work-image">
					 <img src="<?php echo  get_template_directory_uri().'-child'; ?>/img/old-image.jpg" alt="Old Image" />
					 <a class="my-take-action" href="https://www.xtrememarketingcode.com/sales-1/?keyword=easy">Take Action</a>
					</div>
				</div>
				<div class="col-md-6 col-sm-6 col-lg-6 col-xs-12">
					<div class="how-it-work-video"><iframe src="https://player.vimeo.com/video/263070557" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div>
					<div class="footer-innerpages" style="text-align: justify;width:100%;margin-bottom: 45px;">
						<p>Becoming a member of Xtreme Marketing Code is Xtremely simple.   Pay the $97 yearly admin/hosting/resale rights fees.  Then choose which tier is best for you.  Please note that these fees will be only $50 each year after for all returning members.</p>
						<p>Tier 1 is our in-house auto-responder system and material for you to use to market your business.  The cost is $40.  Your first sale is $40 paid directly to you giving you a full return.  Your second (2nd) sale goes as follows; $20 to you and $20 to your admin.  Your second (2nd) sale is your qualifier.</p>
						<p>Once qualified, each sale hereafter goes as follows; $20 to you and $20 to your inviter.</p>
						<p>If someone signs up under you at a higher tier you will not receive commissions from their Tier 2 sales.</p>
						<p>Keep in mind that you now have resale rights to XMC.  This system is all about <b><i><u>residual income.</u></i></b>  The bigger your team, the more residual <b>income and more commissions.</b></p>
						<p>Tier 2 is our Xtreme Marketing Suite.Products include</p>
						<ul>
							<li>- Xtreme SMS</li>
							<li>- Xtreme Voice Broadcasting</li>
							<li>- Xtreme Capture Page Builder</li>
							<li>- Xtreme Voiceless Voicemail Drop</li>
						</ul>
						<p>The cost of Tier 2 is $200.  This is a great deal for all the products XMC has to offer, with no monthly fees.</p>
						<p>Just like Tier 1, your first sale will be $200 paid directly to you giving you full return.  Your second (2nd) sale which is your qualifier goes as follows; $150 goes to your inviter and $50 goes to admin.  This is your one pass up.</p>
						<p>Once you are qualified each sale you make will go as follows; $100 to YOU, $50 to your inviter, and $50 to admin.</p>
					</div>
					
				</div>
			</div>
		</div>
	</section>
	<?php
	get_footer();
	?>