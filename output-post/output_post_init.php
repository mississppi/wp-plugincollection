<?php

class outputPostInit
{
    public function __construct()
    {
        add_action('init', [$this, 'initIncludeFile'], 20);
        // add_action('admin_init', [$this, 'includeFile'], 10);
    }

    public function initIncludeFile()
    {
        include_once('api_to_json.php');
    }

    public function includeFile()
    {
        include_once('api_to_json.php');
    }
}

new outputPostInit();