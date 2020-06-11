jQuery("ul.subsubsub").find("li.draft").remove();
jQuery("ul.subsubsub").find("li.all").remove();
jQuery("ul.subsubsub").find("li.publish").remove();
jQuery("ul.subsubsub").find("li.trash").remove();
jQuery(documeent).ready(function() {
    if (jQuery('.wp-menu-name').text() == 'Contact') {
        alert('heeloo');
        jQuery(this).remove();
    }
});