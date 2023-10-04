<?php

class postConnectInit
{
    public function __construct()
    {
        add_action('init', [$this, 'initIncludeFile'], 15);
        add_action('admin_init', [$this, 'includeFile'], 10);
    }

    public function initIncludeFile()
    {
        include_once(plugin_dir_path(__FILE__) . '/redis/redis-posting.php');
    }

    public function includeFile()
    {
        // include_once('facebook-posting.php');
    }
}

new postConnectInit();