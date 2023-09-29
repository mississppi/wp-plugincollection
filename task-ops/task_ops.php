<?php
/**
 * @package TaskOps
 */
/*
Plugin Name: TaskOps
Plugin URI: 
Description: カスタム投稿タイプをapiからCRUD操作できるプラグイン
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

include_once dirname(__FILE__) . '/task_api_controller.php';

class taskOps
{
    public function __construct()
    {
        add_action('init', [$this, 'includeFile'], 10);
        add_action('rest_api_init', [$this, 'api_init'], 10);
    }

    public function includeFile()
    {
        // include_once("task_ops_init.php");
        include_once("register_type.php");
    }

    public function api_init()
    {
        //コントローラの初期化
        $controller = new taskApiController();
        $controller->register_routes();
    }
}

new taskOps();
