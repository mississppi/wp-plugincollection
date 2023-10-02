<?php

if(array_key_exists('hook_name',$_POST)){
    global $wp_filter;
    $action = [];
    $search_hook = $_POST['hook_name'];
    try {
        $search = false;
        //wp_filterからフックと関数を取り出す
        foreach($wp_filter as $hook_name => $hook){
            if($search_hook === $hook_name){
                foreach($hook as $p => $obj){
                    foreach($obj as $callback){
                        if(gettype($callback['function']) === 'string'){
                            $rf = new ReflectionFunction($callback['function']);
                            $fn = ($rf->getClosureScopeClass() === null ?  ''
                            : $rf->getClosureScopeClass()->getName() . '-&gt;') . $rf->getName();
                            $file_name = $rf->getFileName();
                            $line = $rf->getStartLine();
                            $action[] = "<td>$p , $fn [$file_name] ($line)</td>";
                        } else if (gettype($callback['function']) === 'array'){
                        }
                    }
                }
            }
        }
    } catch (\Throwable $th) {
        //throw $th;
    }

    if(!empty($action)){
        ?> 
        <h2>検索結果</h2>
        <table class="wp-list-table widefat fixed">
            <thead>
                <tr>
                    <th><?php echo $search_hook ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($action as $item) {
                    echo '<tr>';
                    echo $item;
                    echo '</tr>';
                }

                ?>
            </tbody>
        </table>
        
        <?php
    } else {
        ?> 
            <h3>検索結果見つかりませんでした</h3>
        <?php
    }
}