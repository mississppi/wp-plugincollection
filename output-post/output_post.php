<?php
/**
 * @package output_post
 */
/*
Plugin Name: output_post
Plugin URI: 
Description: 記事のapiをjson出力します
Version: 1.0
Author: msp
Author URI: 
License: GPLv2 or later
*/


// add_action('save_post', 'output', 10, 3);

// if (!function_exists('output')){
    
//     // function output($new_status, $old_status, $post ){
//     //     if ( $old_status != 'publish'  &&  $new_status == 'publish' ) {
//     //         // 投稿ステータスが公開以外から公開へ変化するとき実行する処理を記載
//     //         // $postからいろいろ取得できるので、記事IDが欲しい場合などは以下のようにする
//     //         // $ID = $post->ID;

//     //         $d = new AsyncDebugLog();
//     //         $d->debug($post);
        
//     //         // 宛先・タイトル・本文
//     //         $mail_to = '4rnowr2@gmail.com';
//     //         $subject = 'これだよおおお';
//     //         $message = '<p>いいいいいねえええええええ</p>'."\r\n";
//     //         $message .= '<a href="'.home_url('/').'">リンクテスト(ホームURL)</a>'."\r\n";
//     //         $res = wp_mail( $mail_to, $subject, $message, $headers );
        
//     //         // remove_action('transition_post_status', 'output');
//     //         // return;
//     //     }

//     // }

//     function output($post_id, $post, $update){
//         $d = new AsyncDebugLog();
//         $d->debug($update);
//         if ($update){
//             $d = new AsyncDebugLog();
//             $d->debug($post);
    
//             // 宛先・タイトル・本文
//             $mail_to = '4rnowr2@gmail.com';
//             $subject = 'やでえええええ';
//             $message = '<p>いいいいいねえええええええ</p>'."\r\n";
//             $message .= '<a href="'.home_url('/').'">リンクテスト(ホームURL)</a>'."\r\n";
//             $res = wp_mail( $mail_to, $subject, $message, $headers );
//         }

//     }
    
// }


// class outputPost
// {
//     public function __construct()
//     {
//         add_action('init', [$this, 'includeFile'], 10);
//     }

//     public function includeFile()
//     {
//         include_once("output_post_init.php");
//     }
// }

// new outputPost();