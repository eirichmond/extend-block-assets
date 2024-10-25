<?php
class ExtendBlockAssets {

    // Array to hold the block names for which to enqueue assets
    private $block_assets = [];

    /**
     * Constructor function
     * Initializes the block assets (styles and scripts) to be enqueued.
     */
    public function __construct($block_assets = []) {
        $this->block_assets = $block_assets;

        // Hook into WordPress to register block styles and scripts
        add_action('init', [$this, 'register_block_assets']);
    }

    /**
     * Register styles and scripts for the specified blocks
     */
    public function register_block_assets() {
        foreach ($this->block_assets as $block_name) {
            // Register block style with automatically generated handle and path
            $this->register_and_enqueue_block_style($block_name);

            // Register block script with automatically generated handle and path
            $this->register_script($block_name);
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
                $style_src,
                [],
                null,
                'all'
            );

            wp_enqueue_block_style(
                $block_name,
                [
                    'handle' => $style_handle,
                ]
            );
        }
    }

    /**
     * Register scripts for a block with a dynamically generated handle
     */
    private function register_script($block_name) {
        $script_handle = 'extend-' . str_replace('/', '-', $block_name) . '-script';
        $script_src = $this->get_asset_path($block_name, 'js');

        if ($script_src) {
            wp_register_script(
                $script_handle,
                $script_src,
                ['jquery'],
                null,
                true
            );
        }
    }

    /**
     * Helper function to generate asset path based on block name and file extension
     */
    private function get_asset_path($block_name, $type) {
        $filename = 'extend-' . str_replace('/', '-', $block_name) . '.' . $type;
        $file_path = get_template_directory_uri() . '/extend-block-assets/assets/' . $type . '/' . $filename;

        // Check if file exists in the theme directory
        return file_exists(get_template_directory() . '/extend-block-assets/assets/' . $type . '/' . $filename) ? $file_path : false;
    }

    /**
     * Add block assets dynamically after instantiation
     */
    public function add_block_assets($block_name) {
        $this->block_assets[] = $block_name;
    }
}
