<?php
/**
 * @package msp-oauth2-api
 */
/*
Plugin Name: oauth2plugin
Plugin URI: 
Description: auth api
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class mspOAuth2Init
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once("oauth2_api.php");
    }
}

new mspOAuth2Init();