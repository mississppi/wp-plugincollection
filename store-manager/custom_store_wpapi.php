<?php

class customStoreWpApi extends WP_REST_Controller{
    public function __construct()
    {
        // var_dump("dattara"); exit;
        add_action('rest_api_init', [$this, 'register_route']);
        
    }

    public function register_route()
    {
        // create
        register_rest_route('wp/v2', 'stores', [
            'methods' => 'POST',
            'callback' => [$this, 'upsert_store'],
            'permission_callback' => [$this, 'check_permission']
        ]);

        // update
        register_rest_route('wp/v2', 'stores' . '/(?P<id>[\d]+)', 
        [
            [
                'methods' => 'PUT',
                // 'callback' => [$this, 'upsert_store'],
                'callback' => [$this, 'upsert_store'],
                'permission_callback' => [$this, 'check_permission'],
            ],
            [
                'methods' => 'DELETE',
                'callback' => [$this, 'delete_store'],
                'permission_callback' => [$this, 'check_permission'],
            ]
        ]);
    }

    //仮で
    function check_permission($request)
    {
        try {
            //code...
            return true;
        } catch (\Throwable $th) {
            //throw $th;
            var_dump($th); exit;
        }
    }

    function upsert_store($request, $id = null)
    {
        $id = $request->get_param( 'id' );
        $title = $request->get_param( 'title' );
        $content = $request->get_param( 'content' );
        
        $post_data = array(
            'post_title'   => $title,
            'post_content' => $content,
            'post_status'  => 'publish',
            'post_type'    => 'stores', // カスタム投稿タイプの名前
        );

        if ($id !== null) {
            // 更新の場合、既存の投稿を取得
            $post = get_post($id);
            if ($post) {
                $post_data['ID'] = $post->ID;
            } else {
                return new WP_Error('update_error', 'Store not found for update.', ['status' => 404]);
            }
        }

        $store_id = wp_insert_post(wp_slash($post_data), true, false);

        if($store_id) {
            $message = ($id !== null) ? 'update success' : 'create success';
            $response = [
                'message' => $message,
                'store_id' => $store_id,
            ];
            return rest_ensure_response($response);
        } else {
            $error = ($id !== null) ? 'failed to update' : 'failed to create';
            return new WP_Error('error', $error);
        }
    }

    function delete_store($request)
    {
        $id = $request->get_param( 'id' );
		$post = get_post( $id );

        if(!$post){
            $message = 'The specified store does not exist';
            $response = ['message' => $message];
            return rest_ensure_response($response);
        }

        try {
            $result   = wp_trash_post( $id );
            $message = 'delete success';
            $response = ['message' => $message];
            return rest_ensure_response($response);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    
}

new customStoreWpApi();