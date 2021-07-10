<?php
/**
 * @package cart-favicon
 * @version 1.0.0
 */
/*
Plugin Name: cart-favicon
Plugin URI: https://srinathdevinfo.github.io/favicon_wo.html
Description: Add cart item count on your favicon with animated badges.
Author: Srinath Madusanka
Version: 1.0.0
Author URI: https://srinathdevinfo.github.io/
License: GPLv2 or later
Text Domain: cart-favicon
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.


 */

// Exit if accessed directly.
defined('ABSPATH') or die();

if (in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    if (!class_exists('WC_Favicon_Woo')) {

        class WC_Favicon_Woo
        {




   




            public function __construct()
            {
                add_action('wp_footer', array($this, 'enqueueAssets'));
                add_action('wp_footer', array($this, 'cart_favicon_add_to_cart_script'));
               

                                            

                 add_action('wp_ajax_show_favicon', array($this, 'show_favicon'));
                 add_action('wp_ajax_nopriv_show_favicon', array($this, 'show_favicon'));
            }

            public function enqueueAssets()
            {
                wp_register_script('cartfavicon', plugins_url('js/favico.js', __FILE__), array('jquery'), '', true);
                wp_enqueue_script('cartfavicon');



                wp_enqueue_script('cartfavicon_ajax-script', get_template_directory_uri() . '/js/cartcount.js', array('jquery'));

                wp_localize_script(
                    'cartfavicon_ajax-script',
                    'cartfavicon_object',
                    array( 'ajax_url' => admin_url('admin-ajax.php') )
                );
            }



            public function show_favicon()
            {
               
                echo WC()->cart->get_cart_contents_count();
                die(); // this is required to return a proper result
            }

            public function cart_favicon_add_to_cart_script()
            {

                ?>
            <script type="text/javascript">





                // Ready state
                (function($){


$(window).on('load', function() {
var data = {
        action: 'show_favicon',
        gettotal: 1
    };

    jQuery.post(cartfavicon_object.ajax_url, data, function(response) {
        //alert('Got this from the server: ' + response);
           var favicon=new Favico({
    animation:'slide'
});
favicon.badge(response);
    });
});



     $( document.body ).on( 'updated_cart_totals', function(e){

var data = {
        action: 'show_favicon',
        gettotal: 1
    };

    jQuery.post(cartfavicon_object.ajax_url, data, function(response) {
        //alert('Got this from the server: ' + response);
           var favicon=new Favico({
    animation:'slide'
});
favicon.badge(response);
    });

  
        

                  });

      $( document.body ).on( 'added_to_cart', function(){
   
var data = {
        action: 'show_favicon',
        gettotal: 1
    };

    jQuery.post(cartfavicon_object.ajax_url, data, function(response) {
        //alert('Got this from the server: ' + response);
           var favicon=new Favico({
    animation:'slide'
});
favicon.badge(response);
    });

                    });




                })(jQuery);
            </script>
                <?php
            }
        }

    }
}

if (class_exists('WC_Favicon_Woo')) {
    $WC_Favicon_Woo = new WC_Favicon_Woo();
}


