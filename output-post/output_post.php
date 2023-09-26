<?php
/**
 * @package output_post
 */
/*
Plugin Name: output_post
Plugin URI: 
Description: 記事のapiをjson出力します
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class outputPost
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once("output_post_init.php");
    }
}

new outputPost();