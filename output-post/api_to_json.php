<?php

class apiToJson
{
    public function __construct()
    {
        add_action('transition_post_status', [$this, 'outputJson'], 10, 3);
    }

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
                    //valueはここで設定します
                    $data = json_encode($decoded_data, JSON_PRETTY_PRINT);
                    $json_file_path = dirname(__FILE__) . '/output.json';
                    file_put_contents($json_file_path, $data);
                } else {

                }
            }

        } catch (Exception $e) {
            
        }
        return;
    }

}

new apiToJson();