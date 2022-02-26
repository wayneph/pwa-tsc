<?php namespace protectem;
$dir="inputs";
$filesArray=scandir($dir);
echo("<br>Array:pageArray(".__LINE__."({}))<br><pre>"); print_r($filesArray); echo("</pre><hr>");
for($f=0;$f<count($filesArray);$f++){
    echo("<br>{$filesArray[$f]}");
    $fl=$dir.DIRECTORY_SEPARATOR.$filesArray[$f];
    if(is_file($fl)){ // is actual file
        
        echo("<br>IsFile::{$fl}");
        $contents=file_get_contents($fl);
        echo("<hr><pre>$contents</pre>");
     }
}
