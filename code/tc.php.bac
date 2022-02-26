<?php namespace presentation;
$cookieName="tscskunks-pwa";
if(isset($_COOKIE[$cookieName]))
{
    $cArray=json_decode($_COOKIE[$cookieName], true);
    $was="<br>Array:WasCookie(".__LINE__."()<br><pre>".print_r($cArray,true). "</pre><hr>";
    //setcookie($cookieName, "", time() + (-3* 86400 * 30), "/");
}
// $cookieArray['setAt']=date('Y-m-d H:i:s');
// $cookieArray['email']='wayne.p@cllkie.com';
// $cookieArray['userName']='waynePH';
// $cookieArray['auth']=array();

// setcookie($cookieName, json_encode($cookieArray), time() + (3* 86400 * 30), "/"); //3 days
// $was.="<br>Array:IsCookie(".__LINE__."()<br><pre>".print_r($cookieArray,true). "</pre><hr>";
echo($was);