<?php
/*
Plugin Name: Woo Delivery Rider Management
Plugin URI:  http://thenabeel.com
Description: This plugin manages riders for orders deliveries
Version:     1.0.0
Author:      Nabeel Ahmed
Author URI:  http://thenabeel.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) or die( 'Hush! Stay away please!' );

require_once plugin_dir_path( __FILE__ ) . 'includes/class-main.php';

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
{
    //Add rider user-role on plugin activation
    register_activation_hook( __FILE__, array('WCDRM_Main', 'create_rider_role') );

    //Delete rider user-role on plugin deactivation
    register_deactivation_hook( __FILE__, array('WCDRM_Main', 'delete_rider_role' ) );

    $obj = new WCDRM_Main();

    //WooCommerce plugin activation prompt tracker
    update_option('wcdrm_woocommerce_prompt', 'false');
}
else
{
    //WooCommerce plugin activation prompt tracker
    update_option('wcdrm_woocommerce_prompt', 'true');

    if( get_option('wcdrm_woocommerce_prompt') == 'true' )
    {
        //Show prompt to user
        add_action('admin_notices', 'wcdrm_woocommerce_activate_prompt');
        function wcdrm_woocommerce_activate_prompt()
        {
            echo "<div class='updated'><p>Please activate WooCommerce to use WooCommerce-Delivery-Rider-Management.</p></div>";
        }
    }

}
