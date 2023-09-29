<?php

class taskOpsInit
{
    public function __construct()
    {
        add_action('init', [$this, 'initIncludeFile'], 10);
        // add_action('rest_api_init', [$this, 'initApi'], 10);
    }

    public function initIncludeFile()
    {
        include_once('register_type.php');
    }

    public function initApi()
    {
        // include_once('kanban.php');
    }
}

new taskOpsInit();