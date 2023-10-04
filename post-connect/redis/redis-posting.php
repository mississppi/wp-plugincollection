<?php
include_once('redis-helper.php');
/**
 * redisに投稿するクラスです。
 */
class redisPosting
{
    /** 
     * このクラスのコンストラクタでwp_insert_postにフックし
     * redisへ連携します。
     * 
     **/
    public function __construct()
    {
        add_action('wp_insert_post', [$this,'handle_post_crud'], 10, 3);
        add_action('trashed_post', [$this, 'delete_redis_data']);
    }

    /**
     * redisの削除
     *
     * @param string $post_id
     * @return void
     */
    public function delete_redis_data($post_id)
    {
        $redis = new RedisHelper();
        $redis->delete('post_' . $post_id);
    }

    /**
     * wp_insert_postフックを利用してcreateとupdateを行います
     *
     * @param string $post_id
     * @param string $post
     * @param int $update
     * @return void
     */
    public function handle_post_crud($post_id, $post, $update)
    {
        if($post->post_type !== 'post'){
            return ;
        }

        if($update){
            $this->update_redis_data($post_id, $post);
        } else {
            $this->create_redis_data($post_id, $post);
        }
    }

    /**
     * redishelperを使ってredisへsetします
     *
     * @param [type] $id
     * @param [type] $post
     * @return void
     */
    public function create_redis_data($id, $post)
    {
        $redis = new RedisHelper();
        $redis->set('post_'.$id, $post->post_content);
    }

    /**
     * redishelperを使ってredisへupdateします
     *
     * @param [type] $id
     * @param [type] $post
     * @return void
     */
    public function update_redis_data($id, $post)
    {
        $this->create_redis_data($id, $post);
    }
    
}

new redisPosting();