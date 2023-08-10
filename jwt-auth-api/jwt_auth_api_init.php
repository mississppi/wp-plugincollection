<?php
/**
 * @package msp-jwt-auth-api
 */
/*
Plugin Name: jwtauthplugin
Plugin URI: 
Description: auth api
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class mspJwtAuthInit
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once("jwt_auth_api.php");
    }
}

new mspJwtAuthInit();