<?php
/**
 * @package msp-dashboard_helper-api
 */
/*
Plugin Name: dashboard_helper
Plugin URI: 
Description: ダッシュボードへノートを追加するプラグイン
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class mspDashBoardHelperInit
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once("dashboard_helper.php");
    }
}

new mspDashBoardHelperInit();