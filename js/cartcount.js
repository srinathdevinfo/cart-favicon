var data = {
    'action': wp_ajax_data.action,
    '_ajax_nonce': wp_ajax_data.nonce
};



 $( document.body ).on( 'updated_cart_totals', function(e){
jQuery.post(ajaxurl, data);

}


