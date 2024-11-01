<?php

defined( 'ABSPATH' ) or die( 'Hush! Stay away please!' );

class WCDRM_Main
{

    public function __construct()
    {
        //Display Rider Select Metabox
        add_action( 'add_meta_boxes', array($this, 'rider_add_meta_box') );

        //Save Rider Field Value
        add_action( 'save_post', array($this, 'woo_add_custom_fields_save'), 10, 1 );

    }

    /**
     * Add rider user-role on plugin activation
     **/

    public function create_rider_role()
    {
        add_role( 'rider', 'Rider', array( 'read' => true ) );
    }


    /**
     * Display Rider Select Metabox
     **/

    public function rider_add_meta_box()
    {
        add_meta_box(
                'wcdrm-rider-box',
                __( 'Select Rider' ),
                array($this, 'rider_meta_box_fields'),
                'shop_order',
                'side',
                'default'
        );

    }


    /**
     * Add fields to the metabox
     **/

    public function rider_meta_box_fields( $post )
    {

        $args = array('role' => 'rider');
        $riders = get_users( $args );

        $ridersArray = array();

        $ridersArray[0] = '---';

        foreach($riders as $key=>$rider)
        {
            $ridersArray[$rider->ID] = $rider->display_name;
        }

        woocommerce_wp_select(
            array(
                'id' => '_rider_id',
                'label' => __('Rider: ', 'woocommerce'),
                'options' => $ridersArray
            )
        );
    }


    /**
     * Save Rider Field Value
     **/

    public function woo_add_custom_fields_save( $product_id )
    {

        if( !empty( $_POST['_rider_id'] ) )

            update_post_meta( $product_id, '_rider_id', $_POST['_rider_id'] );

    }


    /**
     * Delete rider user-role on plugin deactivation
     **/

    public function delete_rider_role()
    {
        remove_role( 'rider' );
    }

}