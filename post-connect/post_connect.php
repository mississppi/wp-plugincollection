<?php
/**
 * @package post-connect
 */
/*
Plugin Name: post-connect
Plugin URI: 
Description: snsへの自動投稿機能
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class postConnect
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once("post_connect_init.php");
    }
}

new postConnect();