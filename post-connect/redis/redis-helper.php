<?php
/* 
 * redis操作クラス
 */
class RedisHelper{
    private $redis;

    /**
     * RedisHelper コンストラクタ
     * 
     * @param string $host redisのホスト
     * @param int $port redisのポート
     **/
    public function __construct($host = 'redis', $post = 6379)
    {
        $this->redis = new Redis();
        $this->redis->connect($host, $post);
    }

    /**
     * データを格納します
     *
     * @param srting $key キー
     * @param mixed $value データ
     * @return bool 成功時にtrue、失敗でfalse
     **/
    public function set($key, $value){
        $value = json_encode($value);
        return $this->redis->set($key, $value);
    }

    /**
     * redisからデータを取得します
     *
     * @param int $key
     * @return string 
     */
    public function get($key)
    {
        $value = $this->redis->get($key);
        return $value ? json_decode($value, true) : '';
    }

    /**
     * データを更新します
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function update($key, $value)
    {
        if($this->redis->exists($key)){
            $this->redis->set($key, $value);
        }
    }

    /**
     * データを削除します
     *
     * @param string $key
     * @return void
     */
    public function delete($key)
    {
        $this->redis->del($key);
    }
}