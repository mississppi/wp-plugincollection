<?php
require_once __DIR__ . '/vendor/autoload.php'; 

class FacebookPosting
{
    public function __construct()
    {
        add_action('wp_insert_post', [$this,'post_to_facebook'], 10, 3);
    }

    public function post_to_facebook($post_id, $post, $update )
    {
        // if($post->post_status === 'publish'){
            $fb = new \Facebook\Facebook([
                'app_id' => '',
                'app_secret' => '',
            ]);

            // Facebookに投稿するためのデータ
            $postData = [
                'message' => 'Hello, Facebook!', // 投稿メッセージ
            ];

            $accessToken = '';

            // Facebook Graph APIリクエスト
            try {
                // フィードに投稿
                $response = $fb->post('/me/feed', $postData, $accessToken);

                // レスポンスを取得
                $graphNode = $response->getGraphNode();
                
                // 投稿IDを取得
                $postId = $graphNode['id'];

                echo '投稿が成功しました。投稿ID: ' . $postId;
            } catch (Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Facebook API エラー: ' . $e->getMessage();
            } catch (Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK エラー: ' . $e->getMessage();
            }
        // }
    }
}

new FacebookPosting();