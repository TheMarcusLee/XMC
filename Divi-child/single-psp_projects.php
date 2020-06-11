<?php
		// Start the loop.
		
		while ( have_posts() ) : the_post();
			the_content();
		endwhile;
		