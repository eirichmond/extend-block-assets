<?php 

function extend_register_enqueue_assets() {

    /***
     * To add more assets simply add to the array
     * below the {core-block-name-reference}
     * eg 'site-logo','heading','quote' etc
     * 
     * and then physically add the css file to
     * 'extend-block-assets/assets/css/'
     * with the naming convention of
     * 'extend-{core-block-name-reference}.css
     */

    $block_assets = array(
        'site-logo',
        'heading',
        'quote'
    );

    // Instantiate the class with the block assets array
   new Extend_Block_Assets( $block_assets );

}
add_action( 'init', 'extend_register_enqueue_assets' );
