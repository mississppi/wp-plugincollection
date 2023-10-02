<?php

class CreateOptionPage
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'add_option_page'));
    }
    
    public function add_option_page()
    {
        $function = [$this, 'view_callback'];
        add_options_page('viewhook', 'viewhook', 'manage_options', 'view-hook', $function);
    }

    public function view_callback()
    {
        include_once(plugin_dir_path(__FILE__) . 'view.php');
    }
}

new CreateOptionPage();