var $ = jQuery.noConflict();
var frame = wp.media({
    title: 'Select or Upload Media Of Your Chosen Persuasion',
    button: {
        text: 'Use this media'
    },
    multiple: false // Set to true to allow multiple files to be selected
});
jQuery(document).ready(function() {

    $(".upload_video").click(function() {
        frame.open();


    });

    frame.on('select', function() {
        var attachment = frame.state().get('selection').first().toJSON();
        $("#video_url").val(attachment.url);
    });

});
var myElement = jQuery('select[name="page_template"]');

myElement.find('option:eq(1)').prop('selected', true);