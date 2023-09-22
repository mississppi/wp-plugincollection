<?php
/**
 * @package last_login_tracker
 */
/*
Plugin Name: last_login_tracker
Plugin URI: 
Description: 最後にログインした時刻をユーザ一覧に表示します
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class lastLoginTracker
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once("last_login_tracker_init.php");
    }
}

new lastLoginTracker();