<?php

/**
 * Storefront automatically loads the core CSS even if using a child theme as it is more efficient
 * than @importing it in the child theme style.css file.
 *
 * Uncomment the line below if you'd like to disable the Storefront Core CSS.
 *
 * If you don't plan to dequeue the Storefront Core CSS you can remove the subsequent line and as well
 * as the sf_child_theme_dequeue_style() function declaration.
 */
//add_action( 'wp_enqueue_scripts', 'sf_child_theme_dequeue_style', 999 );

/**
 * Dequeue the Storefront Parent theme core CSS
 */
function sf_child_theme_dequeue_style() {
    wp_dequeue_style( 'storefront-style' );
    wp_dequeue_style( 'storefront-woocommerce-style' );
}

/**
 * Note: DO NOT! alter or remove the code above this text and only add your custom PHP functions below this text.
 */

 add_action( 'wp_head', 'remove_my_action' );
 function remove_my_action(){
 	remove_action( 'wp_footer', 'function_being_removed' );
 }

 add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);

 function special_nav_class ($classes, $item) {
     if (in_array('current-menu-item', $classes) ){
         $classes[] = 'active ';
     }
     return $classes;
 }

 // remove default sorting dropdown in StoreFront Theme

 add_action('init','delay_remove');

 function delay_remove() {
 remove_action( 'woocommerce_after_shop_loop', 'woocommerce_catalog_ordering', 10 );
 remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 10 );
 }


 // remove default sorting dropdown

add_filter( 'woocommerce_show_page_title' , 'woo_hide_page_title' );

function woo_hide_page_title() {

	return false;

}

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

//Remove WooCommerce Tabs - this code removes all 3 tabs - to be more specific just remove actual unset lines
add_filter( 'woocommerce_product_tabs', 'woo_remove_product_tabs', 98 );
function woo_remove_product_tabs( $tabs ) {
 unset( $tabs['description'] );      	// Remove the description tab
 unset( $tabs['reviews'] ); 			// Remove the reviews tab
 unset( $tabs['additional_information'] );  	// Remove the additional information tab
 return $tabs;
}
