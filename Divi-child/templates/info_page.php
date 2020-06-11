<?php
/*
Template Name: Info Page
*/

get_header();
while ( have_posts() ) : the_post();
echo '<div class="info_page">';
the_content();
echo '<div class="take_action_btn"><a href="'.home_url().'/registration/?username=scott" class="btn btn-danger take_action_now_btn"> Take Action Now!!! </a></div>';
echo '</div>';
endwhile;
get_footer();

?>
    