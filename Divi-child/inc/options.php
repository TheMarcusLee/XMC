<?php
/*
Description: Theme Options
Theme: Neuro Themes
*/

// Check if Redux exixts
if ( !class_exists( 'Redux' ) ) {
	return;
}


//******************//
// OPTIONS ARUMENTS //
//******************//

$un_opt_args = array(

	// Options Name
	'opt_name' => NT,
	
	// Display
	'display_name' => 'Options',
	'admin_bar' => true,
	'admin_bar_icon' => 'dashicons-screenoptions', 
	'allow_sub_menu' => true,
	'display_version' => false,
	'hide_reset' => false,
	'menu_type' => 'menu',
	'menu_title' => 'Options',
	'menu_icon' => 'dashicons-screenoptions',
	'page_icon' => 'dashicons-screenoptions',
	'page_slug' => 'neuro_options',
	'page_title' => 'Marketing Options',
	
	// Features
	'customizer' => true,
	'default_show' => true,
	'default_mark' => '*',
	'show_import_export' => true,
	'class' => 'nt-redux',
	'update_notice' => false,
	'disable_tracking' => true,
	'dev_mode' => false,
	
);

// Set Arguments
Redux::setArgs( NT, $un_opt_args );



//******************//
// OPTIONS SECTIONS //
//******************//


// Payments

// Parent Panel
$payment_section = array(
    'title'  => esc_html__('Payments', 'neuro'),
    'id'     => 'payment',
    'icon'   => 'dashicons dashicons-admin-generic',
);

Redux::setSection(NT, $payment_section);

// PayPal
$payment_section = array(
    'title'  => esc_html__('PayPal', 'neuro'),
    'id'     => 'payment_paypal',
    'subsection' => true,
    'icon'   => 'dashicons dashicons-format-image',
    'fields' => array(

        // API Key
        array(
            'id'       => 'opt_paypal_api_key',
            'type'     => 'text',
            'title'    => esc_html__('API Key', 'neuro'),
            
        ),

        // Email
        array(
            'id'       => 'opt_paypal_email',
            'type'     => 'text',
            'title'    => esc_html__('Email', 'neuro'),
            'validate' => 'email',
        ),

        

    ),
);

Redux::setSection(NT, $payment_section);

// Stripe
$payment_section = array(
    'title'  => esc_html__('Stripe', 'neuro'),
    'id'     => 'payment_stripe',
    'subsection' => true,
    'icon'   => 'dashicons dashicons-format-image',
    'fields' => array(

        // Publishable Key
        array(
            'id'       => 'opt_stripe_pk_key',
            'type'     => 'text',
            'title'    => esc_html__('Publishable Key', 'neuro'),
            
        ),

        // Secret Key
        array(
            'id'       => 'opt_stripe_sk_key',
            'type'     => 'text',
            'title'    => esc_html__('Secret Key', 'neuro'),
        ),

        

    ),
);

Redux::setSection(NT, $payment_section);

// Authorize
$payment_section = array(
    'title'  => esc_html__('Authorize.Net', 'neuro'),
    'id'     => 'payment_authorize',
    'subsection' => true,
    'icon'   => 'dashicons dashicons-format-image',
    'fields' => array(

        // API Login ID
        array(
            'id'       => 'opt_authorize_login_id',
            'type'     => 'text',
            'title'    => esc_html__('API Login ID', 'neuro'),
            
        ),

        // Transaction Key
        array(
            'id'       => 'opt_authorize_transaction_key',
            'type'     => 'text',
            'title'    => esc_html__('Transaction Key', 'neuro'),
        ),

        

    ),
);

Redux::setSection(NT, $payment_section);




// SMS/Voice

// Parent Panel
$sms_section = array(
    'title'  => esc_html__('SMS/Voice', 'neuro'),
    'id'     => 'sms',
    'icon'   => 'dashicons dashicons-admin-generic',
);

Redux::setSection(NT, $sms_section);


// Twilio SMS/Voice
$sms_section = array(
    'title'  => esc_html__('Twilio', 'neuro'),
    'id'     => 'sms_twilio',
    'subsection' => true,
    'icon'   => 'dashicons dashicons-format-image',
    'fields' => array(

        // Account SID
        array(
            'id'       => 'opt_twilio_account_sid',
            'type'     => 'text',
            'title'    => esc_html__('Account SID', 'neuro'),
            
        ),

        // Token Key
        array(
            'id'       => 'opt_twilio_token_key',
            'type'     => 'text',
            'title'    => esc_html__('Authorize Token', 'neuro'),
        ),

        

    ),
);

Redux::setSection(NT, $sms_section);