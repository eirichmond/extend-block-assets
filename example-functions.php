<?php 

function extend_register_enqueue_assets() {

    /***
     * The class simply takes two path parameters as string values,
     * 
     * First one for the Theme's CSS styles directory
     * Second one for the Theme's JS directory
     * There is no need to provide the Theme's absolute directory path,
     * only the individual paths within the Theme's directory are needed
     * for example, '/assets/css/blocks/' or '/assets/css/core-blocks/' or '/assets/css/' etc
     * 
     * As long as there is a file in the theme's directory the CLASS will look after everything else
     * 
     * NOTE: the name of the file should reflect the name of the block and not preceed with the key 'core'
     * for example, for a core heading CSS of JS file, the file name should be 'heading.css' or 'heading.js'
     * do not use 'core-heading.css' or 'core-heading.js'
     * 
     * If you only want to include JS file's simply pass an empty string for the first parameter, and vice versa
     * its a assumed that you'll likely only need to include styles but it's possible to pass empty parameters
     * 
     * example usage
     * new Extend_Block_Assets('/assets/css/blocks/'); // for only style files
     * new Extend_Block_Assets('', '/assets/js/blocks/'); // for only javascript files
     * 
     */

    // Instantiate the class with the block assets array
    new Extend_Block_Assets('/assets/css/blocks', '/assets/js/blocks', );

}
add_action( 'init', 'extend_register_enqueue_assets' );
