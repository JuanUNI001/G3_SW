<?php

function resuelve($path = ''){ 
    $url = '';  
    $app = \es\ucm\fdi\aw\src\BD::getInstance();
    $url = $app->resuelve($path);
    return $url;
}
