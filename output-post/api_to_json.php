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

        //valueはここで設定します
        $data = ['message' => 'test'];
        $json_file_path = dirname(__FILE__) . '/output.json';
        file_put_contents($json_file_path, json_encode($data));
        return;
    }

}

new apiToJson();