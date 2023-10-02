<?php
/**
 * @package view-hooks
 */
/*
Plugin Name: view-hooks
Plugin URI: 
Description: フックを確認するプラグイン
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class viewHooks
{

    public function __construct()
    {
        add_action('wp_loaded', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once('create_option_page.php');
    }
}

new viewHooks();