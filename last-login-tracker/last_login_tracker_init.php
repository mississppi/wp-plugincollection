<?php

class lastLoginTrackerInit
{
    public function __construct()
    {
        add_action('init', [$this, 'initIncludeFile'], 1000);
        add_action('admin_init', [$this, 'includeFile'], 1000);
    }

    public function initIncludeFile()
    {
        include_once('update_last_login.php');
    }

    public function includeFile()
    {
        include_once('custom_user_columns.php');
    }
}

new lastLoginTrackerInit();