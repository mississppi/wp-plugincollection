<?php
/**
 * @package multisite-restapi
 */
/*
Plugin Name: multisite-restapi
Plugin URI: 
Description: マルチサイト用のrestapiをカスタマイズするプラグインです
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

// include_once dirname(__FILE__) . '/task_api_controller.php';

class MultiSiteRestApi
{
    public function __construct()
    {
        add_action('init', [$this, 'initInclude'], 10);
        add_action('rest_api_init', [$this, 'include'], 15);
    }

    public function initInclude()
    {
        include_once('custom-content.php');
    }

    public function include()
    {
        include_once('custom-content-api.php');
    }
}

new MultiSiteRestApi();
