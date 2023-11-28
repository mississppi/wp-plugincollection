<?php
include_once(dirname(plugin_dir_path(__FILE__)) . '/async-debug-log/async_debug_log.php');
class apiToJson
{
    /**
     * apiToJsonクラスのコンストラクタ
     * transition_post_statusアクションにフックする。投稿ステータスが変更されたときに
     * JSONデータを生成・保存するメソッドを呼び出します。
     */
    public function __construct()
    {
        // $seri = get_option('cron');
        // var_dump($seri); exit;
        // $debug = new AsyncDebugLog();
        // $debug->debug('ho');
        // var_dump($debug); exit;
        // add_action('transition_post_status', [$this, 'outputJson'], 10, 3);
        add_action('transition_post_status', [$this, 'outputJson'], 10, 3);
    }

    /**
     * JSONデータを生成・保存するメソッド
     *
     * WordPressの投稿が公開されたときに呼び出され、指定された投稿の情報をAPIから取得し、
     * JSON形式でファイルに保存します。
     *
     * @param string $new_status 投稿の新しいステータス
     * @param string $old_status 投稿の以前のステータス
     * @param WP_Post $post 投稿オブジェクト
     * @return void
     */
    public function outputJson($new_status, $old_status, $post)
    {
        //自動下書きはreturn
        if($post->post_status === 'auto-draft'){
            return;
        }

        //リクエストを作成します
        $slug = $post->post_name;
        $url = "http://localhost:80/wp-json/wp/v2/posts?slug=$slug";

        try {
            $response = wp_remote_get($url);
            if(is_wp_error($response)){
                // $msg = $response->get_error_message();
            } else {
                $api_data = wp_remote_retrieve_body($response); // APIからのデータ
                $decoded_data = json_decode($api_data);
                if ($decoded_data) {
                    // JSONデータを生成して保存
                    $data = json_encode($decoded_data, JSON_PRETTY_PRINT);
                    $json_file_path = dirname(__FILE__) . '/output.json';
                    file_put_contents($json_file_path, $data);
                } else {
                    // データが正しくデコードできない場合のエラーハンドリング
                }
            }

        } catch (Exception $e) {
            // 例外のエラーハンドリング
        }
        return;
    }

}

new apiToJson();