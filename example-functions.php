<?php 

function extend_register_enqueue_assets() {

    // To add more assets simply add the 'core/*block-reference*' to the array below
    $block_assets = [
        'core/site-logo',
        'core/heading',
        'core/image',
        'core/cover',
        'core/buttons',
        'core/button',
        'core/separator',
        'core/quote',
    ];

    // Instantiate the class with the block assets array
    $extend_block_assets = new ExtendBlockAssets($block_assets);

}
add_action('after_setup_theme', 'extend_register_enqueue_assets');
