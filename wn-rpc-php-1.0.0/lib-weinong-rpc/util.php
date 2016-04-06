<?php
/**
 * 打印并换行
 * @param $content 打印的内容
 */
function println($content){
    echo $content."\n";
}


/**
 * 引入一个目录下多个文件
 * @param $baseDir 扫描的目录
 * @param $scriptFiles(array(string)) 文件数组
 *        |$allFiles(bool) 是否引入全部文件,不会递归引入全部文件
 */
function require_once_more($baseDir,$scriptFiles){
    if(is_string($baseDir)){
        if(is_array($scriptFiles)){
            foreach($scriptFiles as $file){
                require_once $baseDir."/".$file;
            }
        }else if(is_bool($scriptFiles) && $scriptFiles){
            $files = scandir($baseDir);
            foreach($files as $file){
                $filePath = $baseDir."/".$file;
                if(is_file($filePath)){
                    require_once $filePath;
                }
            }
        }
    }
}