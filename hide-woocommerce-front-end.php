<?php

/**
 *
 * @link              https://github.com/ivo-ivanov/
 * @since             1.0.0
 * @package           Hide_Woocommerce_Front_End
 *
 * @wordpress-plugin
 * Plugin Name:       Hide WooCommerce Front End
 * Plugin URI:        https://github.com/ivo-ivanov/hide-woocommerce-front-end
 * Description:       The easy way to completely hide all WooCommerce Pages from being show on front end. WooCommerce will be visible to all logged in admins.
 * Version:           1.0.0
 * Author:            Ivo Ivanov
 * Author URI:        https://github.com/ivo-ivanov/
 * License:           GPLv3
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       hide-woocommerce-front-end
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


/**
* is_realy_woocommerce_page - Returns true if on a page which uses WooCommerce templates (cart and checkout are standard pages with shortcodes and which are also included)
*
* @access public
* @return bool
*/
function is_realy_woocommerce_page () {
    if( function_exists ( "is_woocommerce" ) && is_woocommerce()){
        return true;
    }
    $woocommerce_keys = array ( "woocommerce_shop_page_id" ,
        "woocommerce_terms_page_id" ,
        "woocommerce_cart_page_id" ,
        "woocommerce_checkout_page_id" ,
        "woocommerce_pay_page_id" ,
        "woocommerce_thanks_page_id" ,
        "woocommerce_myaccount_page_id" ,
        "woocommerce_edit_address_page_id" ,
        "woocommerce_view_order_page_id" ,
        "woocommerce_change_password_page_id" ,
        "woocommerce_logout_page_id" ,
        "woocommerce_lost_password_page_id" ) ;

    foreach ( $woocommerce_keys as $wc_page_id ) {
        if ( get_the_ID () == get_option ( $wc_page_id , 0 ) ) {
            return true ;
        }
    }
    return false;
}

// Redirect to home page
function hide_woocommerce() {
	$is_admin = current_user_can('manage_options');
	if ( is_realy_woocommerce_page() && !$is_admin ) {
		wp_redirect( home_url() );
		exit();
	}
}
add_action( 'template_redirect', 'hide_woocommerce' );
