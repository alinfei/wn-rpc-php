<?php

    function println($content){
        echo $content."\n";
    }

    function require_once_more($baseDir,$scriptFiles){
        if(is_string($baseDir) && is_array($scriptFiles)){
            foreach($scriptFiles as $file){
                require_once $baseDir."/".$file;
            }
        }
    }