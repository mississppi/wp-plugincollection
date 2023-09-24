<?php

class postConnectInit
{
    public function __construct()
    {
        add_action('admin_init', [$this, 'includeFile'], 10);
    }

    public function includeFile()
    {
        include_once('facebook-posting.php');
    }
}

new postConnectInit();