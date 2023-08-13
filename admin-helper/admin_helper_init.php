<?php
/**
 * @package msp-adminhelper-api
 */
/*
Plugin Name: adminhelper
Plugin URI: 
Description: adminhelper
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class mspAdminHelperInit
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once("admin_helper.php");
    }
}

new mspAdminHelperInit();