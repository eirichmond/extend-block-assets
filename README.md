# Testing #
**Contributors:** [erichmond](https://profiles.wordpress.org/erichmond/)  
**Donate link:** https://elliottrichmond.co.uk  
**Tags:** extend, core, styles  
**Requires at least:** 4.5  
**Tested up to:** 6.6.2  
**Requires PHP:** 5.6  
**Stable tag:** 0.1.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Extend core styles.

## Description ##

Register and Enqueue styles for core blocks when they are rendered to the page

## Installation ##

1. Drop this folder into your theme folder
2. Require the class in your theme's function.php file with the following - require_once get_template_directory() . '/extend-block-assets/class-extent-block-assets.php';
3. See example-functions.php for usage in your project
4. When you add a core block style to your array be sure to add a style sheet with the correct core style sheet under /assets/css with the naming convention 'extend-core-*blockname*.css'

## Frequently Asked Questions ##

### Do you have any questions? ###

Answers to questions will follow.

## Changelog ##

### 1.0 ###
* Initial setup.
