<?php
/**
 * taskApiControllerクラスはカスタムエンドポイントを操作するためのコントローラーです。
 *
 * このクラスはタスクに関連するデータを取得、作成、更新、削除するためのエンドポイントを提供します。
 * タスクデータの操作には権限チェックが含まれます。
 *
 * 
 * 
 */
class taskApiController extends WP_REST_Posts_Controller{
    private $remove_key = ['date_gmt', 'type', 'guid', 'modified_gmt', 'link', 'template', '_links'];

    public function __construct()
    {
        parent::__construct('task');
        $this->namespace = 'msp/v1';
        $this->rest_base = 'tasks';
    }

    public function register_routes()
    {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                //read
                [
                    'methods' => WP_REST_Server::READABLE,
                    'callback' => [$this, 'get_items'],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    'args'  => $this->get_collection_params(),
                ],
                
                //create
                [
                    'methods'             => 'POST',
                    'callback'            => [$this, 'create_item' ],
                    'permission_callback' => [ $this, 'get_items_permissions_check' ],
                    //--header 'Content-Type: application/x-www-form-urlencoded' \--data-urlencode 'title=タイトル' \--data-urlencode 'slug=hogehoge'
                ],
            ]
        );


        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base . '/(?P<id>[\d]+)',
            [
                //delete
                [
                    'methods'             => WP_REST_Server::DELETABLE,
                    'callback'            => [ $this, 'delete_item' ],
                    'permission_callback' => [ $this, 'delete_permissions_check' ],
                    'args'                => [
                        'force' => array(
                            'type'        => 'boolean',
                            'default'     => false,
                            'description' => __( 'Whether to bypass Trash and force deletion.' ),
                        ),
                    ],
                ],
                //update
                [
                    'methods'             => WP_REST_Server::EDITABLE,
                    'callback'            => [ $this, 'update_item' ],
                    'permission_callback' => [ $this, 'update_item_permissions_check' ],
                    'args'                => $this->get_endpoint_args_for_item_schema( WP_REST_Server::EDITABLE ),
                ],
            ]
        );
    }

    /**
     * タスクの一覧を取得します。
     *
     * この関数は REST API エンドポイントからタスクの一覧を取得します。一部の不要なフィールドを除外します。
     *
     * @param WP_REST_Request $request REST API リクエストオブジェクト。
     * @return WP_REST_Response REST API レスポンスオブジェクト。
     */
    public function get_items($request) {
        $response = parent::get_items($request);
        if(isset($response->data)){
            $result = [];
            foreach($response->data as $post){
                foreach($this->remove_key as $key){
                    if(array_key_exists($key, $post)){
                        unset($post[$key]);
                    }
                }
                $result[] = $post;
            }
            $response->data = $result;
        }
        return $response;
    }

    public function delete_permissions_check($request){
        //ここに認証を追加
        return true;
    }

    public function update_item_permissions_check($request){
        //ここに認証を追加
        return true;
    }

}