<?php
/**
 * This is a simple helper class to simplify enqueuing
 * core styles and js for modern WordPress Block Themes
 * 
 * To use simply instantiate the class and feed in the path
 * to the css and js directory within the theme
 * 
 * Examples:
 * 
 * new Extend_Block_Assets('/assets/css/blocks/'); // for only style files
 * new Extend_Block_Assets('', '/assets/js/blocks/'); // for only javascript files
 * 
 */

class Extend_Block_Assets {

    /**
     * string value for the styles directory
     *
     * @var string
     */
    private $css_directory;

    /**
     * string value for the javascript directory
     *
     * @var string
     */
    private $js_directory;

    /**
     * Array to hold the block style names for which to enqueue assets
     *
     * @var array
     */
    private $block_style_assets = array();

    /**
     * Array to hold the block js names for which to register assets
     *
     * @var array
     */
    private $block_js_assets = array();

    /**
     * Initializes the class with two string parameters
     * one for the themes CSS path and one for the themes JS path
     *
     * @param string $style_path
     * @param string $javascript_path
     */
    public function __construct( $style_path = null, $javascript_path = null ) {

        // set the variables
        $this->css_directory = $style_path;
        $this->js_directory = $javascript_path;

        // get the files from the theme's directory
        $this->block_style_assets = $this->get_style_file_names();
        $this->block_js_assets = $this->get_script_file_names();

        // Register block styles with automatically generated handle and path
        $this->register_block_style_assets();

        // Register block script with automatically generated handle and path
        $this->register_block_script_assets();

    }

    /**
     * Get CSS file names for block styles
     *
     * @return array
     */
    public function get_style_file_names() {
        return $this->get_file_names($this->css_directory);
    }

    /**
     * Get JavaScript file names for block scripts
     *
     * @return array
     */
    public function get_script_file_names() {
        return $this->get_file_names($this->js_directory);
    }

    /**
     * Helper to retrieve file names from a directory
     *
     * @param string $directory Directory to scan
     * @return array
     */
    private function get_file_names($directory) {
        if (empty($directory)) {
            return [];
        }

        $files = glob(get_template_directory() . $directory . '/*');
        $file_names = [];

        foreach ($files as $file) {
            if (is_file($file)) {
                $file_names[] = pathinfo($file, PATHINFO_FILENAME);
            }
        }

        return $file_names;
    }

    /**
     * Register styles and scripts for the specified blocks
     */
    public function register_block_style_assets() {
        foreach ( $this->block_style_assets as $block_name)  {
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
                $style_src,
                array(),
                filemtime( get_template_directory() . $this->css_directory  . '/' . $block_name . '.css' )
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
     * Register block scripts by iterating over $block_js_assets
     */
    public function register_block_script_assets() {
        foreach ($this->block_js_assets as $block_name) {
            $this->register_block_script($block_name);
        }
    }

    /**
     * Register script for a block and add to block metadata
     */
    private function register_block_script($block_name) {
        $script_handle = 'extend-' . $block_name . '-script';
        $script_src = $this->get_asset_path($block_name, 'js');

        if ($script_src) {
            wp_register_script(
                $script_handle,
                $script_src,
                array('wp-blocks', 'wp-element', 'wp-editor'), // Dependencies
                filemtime(get_template_directory() . $this->js_directory . '/' . $block_name . '.js'),
                true
            );

            add_action('enqueue_block_editor_assets', function() use ($script_handle) {
                wp_enqueue_script($script_handle);
            });

            // Add the registered script to the block's metadata as 'viewScript'
            wp_set_script_translations($script_handle, 'text-domain', get_template_directory() . '/languages');
            $this->add_view_script_to_block_metadata('core/' . $block_name, $script_handle);
        }
    }

    /**
     * Add 'viewScript' to block type metadata
     *
     * @param string $block_type Block type (e.g., 'core/paragraph')
     * @param string $script_handle Registered script handle
     */
    private function add_view_script_to_block_metadata($block_type, $script_handle) {
        $block_type_object = WP_Block_Type_Registry::get_instance()->get_registered($block_type);

        if ($block_type_object) {
            $block_type_object->view_script = $script_handle;
        }
    }

    /**
     * Helper function to generate asset path based on block name and file extension
     *
     * @param string $block_name Block name without 'core/' prefix
     * @param string $type File extension ('css' or 'js')
     * @return string|false Path to the asset, or false if file does not exist
     */
    private function get_asset_path($block_name, $type) {
        $directory = $type === 'css' ? $this->css_directory : $this->js_directory;
        $filename = $block_name . '.' . $type;
        $file_path = get_template_directory_uri() . $directory . '/' . $filename;

        return file_exists(get_template_directory() . $directory . '/' . $filename) ? $file_path : false;
    }
    
}
