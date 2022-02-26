<?php namespace presentation;
session_start();
$envVars=getenv();
$sessionVars='<hr><pre>Env '.print_r($envVars, true).'</pre>';
$sessionVars.='<hr><pre>_SESSION '.print_r($_SESSION, true).'</pre>';
$sessionVars.='<hr><pre>_SERVER '.print_r($_SERVER, true).'</pre>';
$ht="<!doctype html>
        <html lang=\"en\">
        <head>
            <meta charset=\"utf-8\">
            <title>WHP_debugger</title>
            <meta name=\"description\" content=\"Session Stuff\">
            <meta name=\"author\" content=\"waynep\">
        </head>
        <body>
        $sessionVars.
        </body>
        </html>";
echo $ht;