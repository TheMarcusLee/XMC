<div class="sidebar">
	<div class="close_sidebar">
		<a href="javascript:void(0);" id="close_sidebar"><i class="fa fa-times-circle"></i></a>
	</div>
	<?php if($_SESSION['role'] == 'admin') { ?>
		<ul class="sidebar-ul">
			<li><a href="<?php echo home_url();?>/my-dashboard"><i class="fa fa-tachometer"></i> Dashboard</a></li>
			<li><a href="<?php echo home_url();?>/my-dashboard?option=settings"><i class="fa fa-cog"></i> Settings</a></li>
			<li><a href="<?php echo home_url();?>/my-dashboard?option=earnings"><i class="fa fa-usd"></i>  Earning  </a></li>
			<li><a href="<?php echo home_url();?>/my-dashboard?option=admin-affiliates"><i class="fa fa-file-video-o" aria-hidden="true"></i>  Affiliates</a></li>
			<li><a href="<?php echo home_url();?>/paid-registration/?username=easy"><i class="fa fa-handshake-o" aria-hidden="true"></i>  Paid Registration</a></li>
			<li><a href="<?php echo home_url();?>/my-dashboard?log_action=logout"><i class="fa fa-power-off"></i> Log Out</a></li>
		</ul>
	<?php }else{  ?>
		<ul class="sidebar-ul">
			<li><a href="<?php echo home_url();?>/dashboard"><i class="fa fa-tachometer"></i> Dashboard</a></li>
			<li><a href="<?php echo home_url();?>/dashboard?option=settings"><i class="fa fa-cog"></i> Settings</a></li>
			<li><a href="<?php echo home_url();?>/dashboard?option=media_library"><i class="fa fa-photo"></i> Media Library</a></li>
			<li><a href="<?php echo home_url();?>/dashboard?option=subscription"><i class="fa fa-users"></i> Subscribers</a></li>
			<li><a href="<?php echo home_url();?>/dashboard?option=inviter_business"><i class="fa fa-briefcase"></i>  My Inviter Business </a></li>
			<li><a href="<?php echo home_url();?>/dashboard?option=earnings"><i class="fa fa-usd"></i>  Earning  </a></li>
			<li><a href="<?php echo home_url();?>/dashboard?option=tutorials"><i class="fa fa-file-video-o" aria-hidden="true"></i>  Tutorials  </a></li>
			<li><a href="<?php echo home_url();?>/dashboard/?page=contact"><i class="fa fa-phone" style="    transform: rotate(18deg);"></i> Contact Us- Support</a></li>
			<li><a href="<?php echo home_url();?>/dashboard?log_action=logout"><i class="fa fa-power-off"></i> Log Out</a></li>
		</ul>	
	<?php } ?>	
	</div>