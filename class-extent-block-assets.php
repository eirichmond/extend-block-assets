<?php
/**
 * This is a simple helper class to simplify enqueuing
 * core styles for modern WordPress Block Themes
 * 
 * To use simply instantiate the class and feed in an array
 * of core block name references like:
 * 
 * $block_assets = array(
 *     'paragraph',
 *     'heading',
 *     'quote'
 * )
 * 
 * new Extend_Block_Assets($block_assets);
 * 
 * @var array $block_assets
 * 
 */

class Extend_Block_Assets {

    // Array to hold the block names for which to enqueue assets
    private $block_assets = array();

    /**
     * Constructor function
     * Initializes the block assets (styles) to be enqueued.
     */
    public function __construct( $block_assets = array() ) {
        $this->block_assets = $block_assets;

        $this->register_block_assets();
    }

    /**
     * Register styles and scripts for the specified blocks
     */
    public function register_block_assets() {
        foreach ( $this->block_assets as $block_name)  {
            // Register block style with automatically generated handle and path
            $this->register_and_enqueue_block_style( $block_name );
        }
    }

    /**
     * Register and associate styles with a block using a dynamic handle
     */
    private function register_and_enqueue_block_style($block_name) {

        $style_handle = 'extend-' . str_replace('/', '-', $block_name) . '-style';

        $style_src = $this->get_asset_path($block_name, 'css');

        if ($style_src) {
            wp_register_style(
                $style_handle,
                $style_src
            );

            wp_enqueue_block_style(
                'core/' . $block_name,
                array(
                    'handle' => $style_handle
                )
            );
        }
    }

    /**
     * Helper function to generate asset path based on block name and file extension
     */
    private function get_asset_path($block_name, $type) {
        $filename = 'extend-' . $block_name . '.' . $type;
        $file_path = get_template_directory_uri() . '/extend-block-assets/assets/' . $type . '/' . $filename;

        // Check if file exists in the theme directory
        return file_exists(get_template_directory() . '/extend-block-assets/assets/' . $type . '/' . $filename) ? $file_path : false;
    }

}
