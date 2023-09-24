<?php
/**
 * @package async_debug_log
 */
/*
Plugin Name: async_debug_log
Plugin URI: 
Description: デバッグ用ヘルパープラグイン。ファイル出力する
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/

class AsyncDebugLog
{
    public function debug($data)
    {
        $file = date("Ymd") . ".txt";
        $date = date("YmdHisu");
        $current = "[$date]: $data" . "\n";
        file_put_contents(__DIR__ . "/" . $file, $current, FILE_APPEND);
    }
}