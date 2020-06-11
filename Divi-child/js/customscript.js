$(document).ready(function() {

    // Sidebar Menu
    $(".dashboard-box .no-padding-left").first().addClass("sidebar_left");

    $(".sidebar_menus").click(function() {

        $(".sidebar_left").animate({ 'margin-left': '0%' });
    });
    $("#close_sidebar").click(function() {
        $(".sidebar_left").animate({ 'margin-left': '-100%' });
    });

    // End 

    $(".up_pop").click(function() {
        $(".update_modalbox").fadeIn();
        var con_val = $(this).attr('id');
        $("#upconval").val(con_val);

    });

    $("#clo_it").click(function() {
        $(this).parent().parent().fadeOut();
    });

    $(".setting_tab_api").click(function() {

        $(".setting_tab_api").removeClass("active");
        $(this).addclass("active");
    });

    $("#apb").change(function() {

        if ($(this).prop("checked")) {

            $(".apbf").fadeIn(100);
        } else {
            $(".apbf").fadeOut(100);
        }
    });

    $("#a3pa").change(function() {

        if ($(this).prop("checked")) {

            $(".a3pr").fadeIn(100);
        } else {
            $(".a3pr").fadeOut(100);
        }
    });


    $("#services-select").change(function() {
        var show_val = $(this).val();
        $(".auto_respo").fadeOut();
        $("#" + show_val).fadeIn();

    });
    $("#credit-card").change(function() {
        if ($(this).prop("checked")) {

            $(".creditcard").fadeIn(100);
        } else {
            $(".creditcard").fadeOut(100);
        }
    });
    $("#paypal_check").change(function() {
        if ($(this).prop("checked")) {

            $(".paypalform").fadeIn(100);
        } else {
            $(".paypalform").fadeOut(100);
        }
    });
    // Javascript to enable link to tab
    // var url = document.location.toString();
    // if (url.match('#')) {
    // 	$('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
    // } 

    // Change hash for page-reload
    // $('.nav-tabs a').on('shown.bs.tab', function (e) {
    // 	window.location.hash = e.target.hash;
    // });
    $('[data-toggle="tooltip"]').tooltip();

    $("#conf_pass").blur(function() {

        if ($(this).val() != $("#new_pass").val()) {
            $("#conf_password").fadeIn(100);
            $(this).css("border", "1px solid red");
        } else {
            $("#conf_password").fadeOut(100);
            $(this).css("border", "1px solid #ccc");
        }

    });
    $("#sms_campaign_sms").keyup(function() {
        var textvalue = $(this).val();
        val_array = textvalue.split("");

        var total_charcter = 135;
        var remain_charcter = total_charcter - val_array.length;
        $("#sms_length_count").html(remain_charcter);
    });

    $("#sms_lead_text").keyup(function() {
        var textvalue = $(this).val();
        val_array = textvalue.split("");

        var total_charcter = 135;
        var remain_charcter = total_charcter - val_array.length;
        $("#sms_count").html(remain_charcter);
    });

    $("#sms_below_text").keyup(function() {
        var textvalue = $(this).val();
        val_array = textvalue.split("");

        var total_charcter = 135;
        var remain_charcter = total_charcter - val_array.length;
        $("#sms_character_text").html(remain_charcter);
    });

    $(".time_sms").timepicker({
        timeFormat: 'h:mm p',
        interval: 15,
        minTime: '12:00am',
        maxTime: '11:45pm',
        defaultTime: '12',
        startTime: '12:00am',
        dynamic: false,
        dropdown: true,
        scrollbar: true
    });

    $("#state_radio").change(function() {
        if ($(this).prop("checked")) {
            $(".mobilehidden-div").hide();
            $("#mobilehidden-div").fadeIn();

        } else {
            alert("fkdjkfl");
            $("#mobilehidden-div").fadeOut();

        }
    });
    $("#area_code_radio").change(function() {
        if ($(this).prop("checked")) {
            $(".mobilehidden-div").hide();
            $("#mhidden-div").fadeIn();
        } else {
            $("#mhidden-div").fadeOut();
        }
    });
    if ($("#area_code_radio").prop("checked")) {
        $(".mobilehidden-div").hide();
        $("#mhidden-div").fadeIn();
    } else {
        $("#mhidden-div").fadeOut();
    }

    if ($("#state_radio").prop("checked")) {
        $(".mobilehidden-div").hide();
        $("#mobilehidden-div").fadeIn();

    } else {

        $("#mobilehidden-div").fadeOut();

    }

    $("#phone_list_create").validate({
        rules: {
            list_name: {
                required: true,
            }
        },
        messages: {
            list_name: "Please Enter the List Name",
        }
    });

    $("#ann_in_list").validate({
        rules: {
            contact_number: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,

            }
        },
        messages: {
            contact_number: "Please Enter A Validate Number",
        }
    });

    $("#add_camp").validate({
        rules: {
            title: {
                required: true,
            },
            caller_id: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            }
        },
        messages: {
            title: "Please Enter Campaign Title",
            caller_id: "Please Enter Valid Caller Id example : 6173999980",
        }

    });

    $('.dropdown-button').click(function() {
        $('.dropdown-options').toggle();
    });
    $('.btnAdd').click(function() {
        $('#services-select').toggleClass('hidden-select');
        $('#btnAdd').toggleClass('removeBtnAdd');
    });
    $("#chkall").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 2000);

    $(".audio_file").click(function() {

        var audio_file = $(this).attr("audio_file");

        var audio = '<audio controls controlsList="nodownload" autoplay>';
        audio += '<source src="' + audio_file + '" type="audio/wav">';
        audio += '</audio>';

        $(this).parent().parent().html(audio);



    });

});

function ischeckbox() {
    var unique = $("#unique").val();

    if (jQuery('input[type=checkbox]:checked').length) {
        return true;
    } else {
        alert("select at least one checkbox");
        return false;
    }
}