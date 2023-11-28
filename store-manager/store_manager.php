<?php
/**
 * @package store-manager
 */
/*
Plugin Name: store-manager
Plugin URI: 
Description: 店舗マスタをAPIで管理できるプラグイン
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class storeManager
{
    function __construct()
    {
        add_action('init', [$this, 'includeFile'], 1);
        add_action('rest_api_init', [$this, 'apiInit'], 5);
    }

    public function includeFile()
    {
        include_once("register_store.php");
    }

    public function apiInit()
    {
        include_once("custom_store_wpapi.php");
    }
}

new storeManager();