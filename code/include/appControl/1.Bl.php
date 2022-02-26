<?php namespace BL;
require 'vendor/autoload.php';
use GuzzleHttp\Client as GUZ;
use GuzzleHttp\Exception\ClientException;

use function GuzzleHttp\Psr7\_parse_message;

class BL
{
    /* privates*/
    private $apiArray;
    private $myName="BL";
    /*control vars */
    public $pageArray;
    public $apiUserArray;
    public $infoPathArray=array();
    public $addedMenu=array();
    public $html;
    public $addedAPIcalls=array();
    public $ToDo=array();
    public $trace;
    public function __construct()
    {
        $this->trace[]="started::".date("H:i:s");
        $this->pageArray=array();
        $this->getEnv();
    }

    private function apiEchoError(array $response, string $method)
    {
        echo("<br>API error:<b>$method</b>");
        echo("<br>Array:response(".__LINE__."({$this->myName}))<br><pre>"); print_r($response); echo("</pre><hr>");
        echo("<br>Array:apiArray(".__LINE__."({$this->myName}))<br><pre>"); print_r($this->apiArray); echo("</pre><hr>");
        echo("<br>Array:pageArray(".__LINE__."({$this->myName}))<br><pre>"); print_r($this->pageArray); echo("</pre><hr>");
        exit();
    }
    public function buildEntityTypesAccordion($entityTypesArray)
    {
        $outPutHtml="<!-- plGenerated::".__METHOD__."::line::".__LINE__."  -->";
        $htmlTemplate="\n<button class=\"accordion\">##heading##</button>\n
        <div class=\"panel\">\n
          <p>##description##\n
          <br><br>\n
          &nbsp;&minusb;&nbsp;<a href=\"showEntitiesForType.php/##slug##\">List Entities for <strong>##heading##(s)</strong> here</a></b>.\n
          </p>\n
        </div>\n";
        for($i=0;$i<count($entityTypesArray);$i++){
            $itemHtml = $htmlTemplate;
            $itemHtml = str_replace("##heading##",$entityTypesArray[$i]['selector'],$itemHtml);
            $itemHtml = str_replace("##slug##",$entityTypesArray[$i]['slug'],$itemHtml);
            $itemHtml = str_replace("##description##",$entityTypesArray[$i]['descriptor'],$itemHtml);
            $outPutHtml.=$itemHtml;
        }
        return $outPutHtml;
    }
    public function buildEntityListsAccordion()
    {
        $entitiesList=$this->pageArray['entitiesList'];
        // echo('<br>Array:pageArray('.__LINE__."({$this->myName}))<br><pre>"); print_r($entitiesList); echo("</pre><hr>");
        // exit();
        $outPutHtml="<!-- plGenerated::".__METHOD__."::line::".__LINE__."  -->";
        $htmlTemplate="\n<button class=\"accordion\">##heading## Information</button>\n
        <div class=\"panel\">\n
          <p>\n
            <br>
            <ul>\n
                <li>
                    See <b>All Information &amp; Related Items</b> for &rarr; <a href=\"entityInfoAll.php/##slug##/all\">##heading##</a>\n
                </li>
                <li>\n
                    See Only <b>Information Items</b> on &rarr; <a href=\"entityInfo.php/##slug##/info\">##heading##</a>\n
                </li>
                <li>
                    See Only <b>Related Items</b> for &rarr; <a href=\"entityInfo.php/##slug##/relate\">##heading##</a>\n
                </li>\n
            </ul>
          </p>\n
        </div>\n";
        for($i=0;$i<count($entitiesList);$i++){
            $itemHtml = $htmlTemplate;
            $itemHtml = str_replace("##heading##",$entitiesList[$i]['entity'],$itemHtml);
            $itemHtml = str_replace("##slug##",$entitiesList[$i]['slug'],$itemHtml);
            //$itemHtml = str_replace("##description##",$description,$itemHtml);
            $outPutHtml.=$itemHtml;
        }
        return $outPutHtml;
    }



    public function buildMessages(array $messages)
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        // echo("<br>Array:messages(".__LINE__."({$this->myName}))<br><pre>"); print_r($messages); echo("</pre><hr>");
        // exit();
        $returnString="";
        $template="
        <li>
            <article class=\"box excerpt\">
                <header>
                    <span class=\"date\">##monthYearPosted##</span>
                    <h2><a href=\"#\"><b>##headingPosted##</b></a></h2>
                </header>
                <p>##msgPosted##</p>
            </article>

        </li>";
        for($d=0;$d<count($messages);$d++){
            $tmp=$template;
            $site=getenv("siteSlug");
            $dt=strtotime($messages[$d]['created']);
            $dateSetting = date("M y",$dt);
            $commsBy=str_replace("@",rand(1,9),$messages[$d]['comms_by_slug']);
            $commsBy=str_replace(".",rand(1,9),$commsBy);
            $commsBy=str_replace("mail",rand(1,99),$commsBy);
            $commsBy=str_replace("com",rand(1,99),$commsBy);
            $msg=$messages[$d]['comms_text'];
            $msg.="<br><br><i> Posted by <b>$commsBy</b> on {$messages[$d]['created']}";
            $msg.="<br>Vetted by <b>$site</b> on {$messages[$d]['updated']}.</i>";
            $tmp=str_replace("##monthYearPosted##",$dateSetting,$tmp);
            $tmp=str_replace("##headingPosted##",$messages[$d]['comms_topic'],$tmp);
            $tmp=str_replace("##msgPosted##",$msg,$tmp);
            $returnString.="\n$tmp\n";
        }
        return $returnString;
    }

    public function executeAPICalls()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $this->apiArray=array();
        $this->apiArray['apiExecuteStart']=time();
        $this->apiArray['caller']=getenv("api-host");
        $this->apiArray['siteSlug']=getenv("siteSlug");
        $this->apiArray['host']=getenv("api-host");
        $this->apiArray['headersIn']['api-key']=getenv("api-key");
        $this->apiArray['userUri']=$this->apiArray['host'].getenv("user-api-area");
        $this->apiArray['sitesUri']=$this->apiArray['host'].getenv("sites-api-area");
        $this->apiArray['entitiesUri']=$this->apiArray['host'].getenv("entities-api-area");
        $this->apiArray['entitiesInvocation']=$this->apiArray['host'].getenv("entities-api-area");
        $this->apiArray['mailUri']=$this->apiArray['host'].getenv("mail-api-area");
        $this->apiArray['userName']=getenv("api-user-name");
        $this->apiArray['userPin']=getenv("api-user-pin");
        $response=$this->apiLogInOwner();
        $response=$this->apiGetOwnerUser();
        $cnt=count($this->pageArray['apiCalls']);
        for($a=0;$a<$cnt;$a++){
            switch ($this->pageArray['apiCalls'][$a]){
                case 'getPage':
                    $response=$this->apiGetPage();
                    $data=json_decode($response['body'],true);
                    $this->pageArray['page']=$data['data'];
                    $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
                    break;
                case 'getAllEntityTypes':
                    $this->apiLogInOwner();
                    $response=$this->apiGetAllEntityTypes();
                    $data=json_decode($response['body'],true);
                    $this->pageArray['entityTypes']=$data['data'];
                    $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
                    break;
                case 'setUserLogin':
                    if(isset($this->pageArray['cookie']['cEmail'])){
                        $this->apiLogInOwner();
                        $response=$this->apiFindUser($this->pageArray['cookie']['cHash']);
                        $data=json_decode($response['body'],true);
                        $this->pageArray['appUser']=$data['data'];
                        $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
                        $this->setUserLoginVars();
                    }
                    break;
                case 'getMessages':
                    $this->apiLogInOwner();
                    $response=$this->apiGetMessages();
                    $data=json_decode($response['body'],true);
                    $this->pageArray['messages']=$data['data'];
                    $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
                    break;
                case 'getEntitiesForType':
                    $this->apiLogInOwner();
                    $response=$this->apiGetEntitiesForType();
                    $data=json_decode($response['body'],true);
                    $this->pageArray['entitiesList']=$data['data'];
                    $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
                    break;
                case 'setTouchMail':
                    break;
                    $checkArray=json_decode($jsonReg, true);
                    $linkBits=rand(1000,9999)."rg";
                    if(isset($checkArray['data']['comms_ref'])){
                        $linkBits=substr($checkArray['data']['comms_ref'],0,6);
                        $linkBits.="rg"; //used for register url key
                    }
                    $from=getenv('api-user-name');
                    $site=getenv('siteName');
                    $linkBack=getenv('domain');
                    $inArray['to']=$touchArray['pstMail'];
                    $inArray['to_person']=$touchArray['pstFrom'];
                    $inArray['subject']=$touchArray['pstType']."-".$touchArray['pstType'];
                    $inArray['body']="
                        Welcome to {$site} {$touchArray['pstFrom']},
                        <br><br>
                        Thank you for the touch!. This is your reference: <b>{$linkBits}</b>.
                        <br><br>
                        Your Touch Message:
                        <br><br>
                        <b>{$touchArray['pstMessage']}</b>
                        <br><br>
                        Regards,
                        <br><br>
                        $from
                        <br>";
                    $this->apiArray['postMailStart']=time();
                    $client = new GUZ([
                        'headers' => $this->apiArray["headersIn"]
                    ]);
                    $bodyInJson=json_encode($inArray);
                    try{
                        $r = $client->request("POST", $this->apiArray['mailUri']."/send",['body' => $bodyInJson, 'http_errors' => true]);
                        $response['body']=$r->getBody()->getContents();
                        $response['status']=$r->getStatusCode();
                        $response['headersOut']=$r->getHeaders();
                        $response['20xMethodCode']=__LINE__;
                    } catch (ClientException $e) {
                        $exception = $e->getResponse();
                        $response['body']['error'][] = "error:\n";
                        $response['body']['error'][] = $bodyInJson;
                        $response['status'] = $exception->getStatusCode();
                        $response['headersOut'] = $exception->getHeaders();
                        $response['40xMethodCode']=__LINE__;
                    }
                    $this->apiArray['postMailEnd']=time();
                    return;







                    if(!isset($this->pageArray['inputs']['posts'])){
                        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
                    }
                    $this->apiSetComms($this->pageArray['inputs']['posts']); 
                    break;
                case 'setTouchData':
                    if(!isset($this->pageArray['inputs']['posts'])){
                        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
                    }
                    $response=$this->apiSetTouchData();
                    $data=json_decode($response['body'],true);
                    $this->pageArray['comms']=$data['data'];
                    $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
                    break;

                default:
                $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
            }
        }
        return;


        // foreach($this->addedAPIcalls as $key => $value) {
        //     switch ($key) {

        //         case 'getEntitiesForType':
        //             $this->pageArray[$key]=$this->getEntitiesForType($this->infoPathArray);
        //             $this->buildEntityTypesMenu($this->pageArray[$key]);
        //             break;
        //         case 'postSwitchGets':
        //             if($value['function']=='rg'){ //i.e. register user from email link  // registerUser
        //                 $this->pageArray['xpostSwitchElements']['date']=date("D d M Y");
        //                 $outArray[$key]=$this->apiRegisterSiteUser($value);
        //                 if($outArray[$key]['status']==202){// i.e. success
        //                     $this->pageArray[$key]['mailAdmin']=$this->sendMailAdmin("Registration Request- skunks.Messages",$outArray);
        //                     $this->pageArray[$key]['mailAdmin']['outArray']=$outArray[$key];
        //                 }
        //                 else{
        //                     $this->pageArray[$key]['mailAdmin']=$this->sendMailAdmin("Registration Request Failure - skunks.Messages",$outArray);
        //                 }
        //                 $this->pageArray['xpostSwitchElements']['specificHeader']="<b>Touch</b> response!";
        //                 $this->pageArray['xpostSwitchElements']['topic']='Registration Request';
        //                 $this->pageArray['xpostSwitchElements']['message']='email Link Clicked - Thank you &nbsp;&nbsp;&#128524;';
        //                 $this->pageArray['xpostSwitchElements']['response']='Your <b>Request</b> has been logged..<br>We will respond to your <b>eMail address</b>';
        //                 $this->pageArray['xpostSwitchElements']['heading']='Response To Message';
        //             }
        //             if($value['function']=='lo'){ //i.e. LogOut // i.e. destroy cookie
        //                 $cValue['unset']="Y";
        //                 $cValue['calledLine']=__LINE__;
        //                 $this->writeCookie($cValue);
        //                 $this->pageArray['xpostSwitchElements']['date']=date("D d M Y");
        //                 $this->pageArray['xpostSwitchElements']['specificHeader']="<b>Logout</b> -or <b>Reset</b> success";
        //                 $this->pageArray['xpostSwitchElements']['topic']='Authentication';
        //                 $this->pageArray['xpostSwitchElements']['message']='Authenticated email un-Linked - Thank you &nbsp;&nbsp;&#128524;';
        //                 $this->pageArray['xpostSwitchElements']['response']='Navigate Home <a href ="index.php">here</a>.';
        //                 $this->pageArray['xpostSwitchElements']['heading']='Response To un-Link eMail address';
        //             }
        //             break;
                //case 'postTouch': 
                    // $this->pageArray['xpostSwitchElements']['date']=date("D d M Y");
                    // $cookieArray=$this->evalCookie();
                    // if(!isset($cookieArray['cAuth'])){
                    //     $cookieArray['cAuth']=0;
                    // }
                    // if($cookieArray['cAuth']==1){ // authenticated
                    //     ///
                    // }
                    // if($cookieArray['cAuth']<1){ // authenticated
                    //     ///
                    // }
                    // if((strlen($_SESSION['us'])>50) AND ($cookieArray[''])){ /*hash is set*/
                    //     ##### if $valus['pstCategory']=='Login'
                    //     $this->pageArray['todo'][]="Attempt Login::".__LINE__;
                    //     $this->pageArray['xxpostSwitchElements']['specificHeader']="<b>Logout</b> -or <b>Reset</b> success";
                    //     $this->pageArray['xpostSwitchElements']['topic']='xxAuthentication';
                    //     $this->pageArray['xpostSwitchElements']['message']='xxAuthenticated email un-Linked - Thank you &nbsp;&nbsp;&#128524;';
                    //     $this->pageArray['xxpostSwitchElements']['response']='xxNavigate Home <a href =\"index.php\">here</a>.';
                    //     $this->pageArray['xpostSwitchElements']['heading']='xxResponse To un-Link eMail address';
                    // }
                    // if (filter_var($value['pstMail'], FILTER_VALIDATE_EMAIL)) {
                    //     $this->pageArray['xpostSwitchElements']['specificHeader']="<b>eMail</b> address required";
                    //     $this->pageArray['xpostSwitchElements']['topic']='Authentication';
                    //     $this->pageArray['xpostSwitchElements']['message']='Authenticated email Not set - Thank you &nbsp;&nbsp;&#128524;';
                    //     $this->pageArray['xpostSwitchElements']['response']='Navigate Home &amp retry please <a href =\"index.php\">here</a>.';
                    //     $this->pageArray['xpostSwitchElements']['heading']='Response request without eMail address';
                    // }
                    // $cookieArray['email']=$value['pstMail'];
                    // $cookieArray['userName']=$value['pstFrom'];
                    // $cookieArray['setOnLine']=__LINE__;
                    // $this->writeCookie($cookieArray);
                    // $this->pageArray[$key]=$this->postTouch($value);   // sends the mail
                    // if($this->pageArray[$key]['status']==201){
                    //     $this->pageArray['xpostSwitchElements']['specificHeader']="<b>eMail</b> address seems valid - checking registration";
                    //     $this->pageArray['xpostSwitchElements']['topic']='Authentication';
                    //     $this->pageArray['xpostSwitchElements']['message']='Authenticated email Not set - Thank you &nbsp;&nbsp;&#128524;';
                    //     $this->pageArray['xpostSwitchElements']['response']='Navigate Home &amp retry please <a href =\"index.php\">here</a>.';
                    //     $this->pageArray['xpostSwitchElements']['heading']='Response request without eMail address';
                    //     $this->pageArray[$key]['mailLog']=$this->postTouchMail($value,$this->pageArray[$key]['body']);
                    // }
                    // $this->pageArray['xpostSwitchElements']['specificHeader']="FUBAR";
                    // $this->pageArray['xpostSwitchElements']['topic']='FUBAR';
                    // $this->pageArray['xpostSwitchElements']['message']='FUBAR';
                    // $this->pageArray['xpostSwitchElements']['response']='Navigate Home &amp retry please <a href =\"index.php\">here</a>.';
                    // $this->pageArray['xpostSwitchElements']['heading']='FUBAR';
                    //
                    //break;

        //     }
        // }
    }

    private function apiFindUser()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $started=microtime(true);
        if(!isset($this->pageArray['cookie']['cHash'])){
            $this->pushToErrorPage(__METHOD__,array('cookie not set','this is an anomaly','Line::'.__LINE__));
        }
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."::".
            $this->apiArray['userUri']."/find/{$this->pageArray['cookie']['cHash']}</b>";
        $this->apiArray['apiFindUser']['url']=$this->apiArray['userUri']."/find/{$this->pageArray['cookie']['cHash']}";
        try{
            $r = $client->request("GET", $this->apiArray['apiFindUser']['url'],['http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$endArray);
        }
    }

    private function apiGetAllEntityTypes()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $started=microtime(true);
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        try{
            $r = $client->request("GET", $this->apiArray['entitiesUri']."/entityTypes",['http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
            $this->apiArray['apiCalls']['apiGetAllEntityTypes']['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$endArray);
        }
    }

    private function apiGetEntitiesForType()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        // this array is called & from end checked
        $slug=$this->infoPathArray['slug'];
        $page=$this->infoPathArray['page'];
        $size=$this->infoPathArray['size'];
        $started=microtime(true);
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        try{
            $r = $client->request("GET", $this->apiArray['entitiesUri']."/type/$slug/?page=$page&size=$size",['http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
            $this->apiArray['apiCalls']['apiGetEntitiesForType']['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xBlMethodCode']=__LINE__;
            $endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$endArray);
        }
    }
    private function apiGetMessages(string $pagination="1/10")
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $arrayPagination=explode("/",$pagination);
        $page=$arrayPagination[0];
        $size=$arrayPagination[1];
        $slug=getenv('siteSlug');
        $started=microtime(true);
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        try{
            $r = $client->request("GET", $this->apiArray['userUri']."/comms/$slug/?page=$page&size=$size",['http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['apiCalls']['apiGetMessages']['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$endArray);
        }
        // $this->apiArray['apiGetMessages']=time();
        // $slug=getenv('siteSlug');
        // $arrayPagination=explode("/",$pagination);
        // $page=$arrayPagination[0];
        // $size=$arrayPagination[1];
        // $client = new GUZ([
        //     'headers' => $this->apiArray["headersIn"]
        // ]);
        // try{
        //     $r = $client->request("GET", $this->apiArray['userUri']."/comms/$slug/?page=$page&size=$size",['http_errors' => true]);
        //     $response['body']=$r->getBody()->getContents();
        //     $response['status']=$r->getStatusCode();
        //     $response['headersOut']=$r->getHeaders();
        //     $response['20xMethodCode']=__LINE__;
        // } catch (ClientException $e) {
        //     $exception = $e->getResponse();
        //     $response['body'] = $exception->getBody()->getContents();
        //     $response['dBugAdded']['inBody'] = $this->apiArray['entitiesUri']."/entityTypes}";
        //     $response['dBugAdded']['inHeader'] = $this->apiArray["headersIn"];
        //     $response['status'] = $exception->getStatusCode();
        //     $response['headersOut'] = $exception->getHeaders();
        //     $response['40xMethodCode']=__LINE__;
        //     $this->apiEchoError($response,__METHOD__);
        // }
        // $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
        // $this->apiArray['apiGetMessages']=time();
        // return;
    }

    private function apiGetOwnerUser()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $started=time();
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        $response['callWas']=__METHOD__;
        try{
            $r = $client->request("GET", $this->apiArray['userUri']."/show", ['http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
            $this->apiArray['apiCalls']['apiGetOwnerUser']['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$endArray);
        }
    }

    private function apiGetPage()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $started=microtime(true);
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        try{
            $r = $client->request("GET", $this->apiArray['sitesUri']."/site/{$this->apiArray['siteSlug']}/{$this->pageArray['apiVars']['getPage']}", ['http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['apiCalls']['apiGetPage']['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$endArray);
        }
    }
    private function apiLogInOwner()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $started=microtime(true);
        $loginJsonArray['user_id']=$this->apiArray['userName'];
        $loginJsonArray['pin']=$this->apiArray['userPin'];
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        $bodyInJson=json_encode($loginJsonArray);
        try{
            $r = $client->request("POST", $this->apiArray['userUri']."/login", [
                'body' => $bodyInJson,'http_errors' => true
            ]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
            $this->apiArray['apiCalls']['apiLogInOwner']['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$endArray);
        }
    }


    private function xxxapiRegisterSiteUser(array $response)
    {
        $this->apiArray['registerAPIuserStart']=time();
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        $commitArray['status']=1; //1=takeAction
        $commitArray['action_slug']="registerUser";
        $bodyInJson=json_encode($commitArray);
        try{
            $r = $client->request("PATCH", $this->apiArray['userUri']."/comms/{$response['codeThis']}",['body' => $bodyInJson, 'http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['dBugAdded']['inBody'] = $bodyInJson;
            $response['dBugAdded']['inHeader'] = $this->apiArray["headersIn"];
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $this->apiEchoError($response,__METHOD__);
        }
        $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
        $this->apiArray['registerAPIuserEnd']=time();
        return;
    }

    private function xxxapiRegisterAPIuser(array $response)
    {
        $this->apiArray['registerAPIuserStart']=time();
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        /*  {
                [url] => /switch.php/fed33392d3a48aa149a87a38b875ba4af061e144187058db2387337ba1e0b0249ba90f55b2ba2521rg
                [function] => rg
                [codeAll] => fed33392d3a48aa149a87a38b875ba4af061e144187058db2387337ba1e0b0249ba90f55b2ba2521rg
                [codeThis] => f061e144187058db
                /////
            {
                "status":1,
                "action_slug":"registerUser"
            }
            }
        */
        $commitArray['status']=1; //1=takeAction
        $commitArray['action_slug']="registerUser";
        $bodyInJson=json_encode($commitArray);
        try{
            $r = $client->request("PATCH", $this->apiArray['userUri']."/comms/{$response['codeThis']}",['body' => $bodyInJson, 'http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['dBugAdded']['inBody'] = $bodyInJson;
            $response['dBugAdded']['inHeader'] = $this->apiArray["headersIn"];
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            $this->apiEchoError($response,__METHOD__);
        }
        $this->apiArray['headersIn']['usageToken']=$response['headersOut']['token'][0];
        $this->apiArray['registerAPIuserEnd']=time();
        return;
    }

    private function apiSetTouchData()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $started=microtime(true);
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        $topic=getenv('siteSlug')."-".$this->pageArray['inputs']['posts']['pstCategory'];
        $this->apiArray['postTouchStart']=time();
        $commitArray['site_slug']=getenv('siteSlug');
        $commitArray['comms_by_slug']=$this->pageArray['inputs']['posts']['pstMail'];
        $commitArray['source_slug']=$this->pageArray['inputs']['posts']['pstSource'];
        $commitArray['for_slug']=getenv('api-user-name');
        $commitArray['comms_log']="\nTouch Created @ ".date("Y-n-d H:i:s");;
        $commitArray['comms_topic']=$topic;
        $commitArray['comms_text']=$this->pageArray['inputs']['posts']['pstMessage'];
        $bodyInJson=json_encode($commitArray);
        try{
            $r = $client->request("POST", $this->apiArray['userUri']."/comms",['body' => $bodyInJson, 'http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
            $this->apiArray['apiCalls']['apiSetTouchData']['executionTime']=microtime(true)-$started;
            return $response;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
            //$endArray=json_decode($response['body'],true);
            $this->pushToErrorPage(__METHOD__,$response);
        }
    }
    public function buildEntityTypesMenu()
    {
        $array=$this->pageArray['entityTypes'];
        $menuLeader=getenv('siteMenuLeader');
        $itemsPerPage=getenv('defaultPageSize');
        $this->addedMenu="\n<li><a href=\"listEntityTypes.php\"><span>$menuLeader<strong>&nbsp;&isin;</strong></span></a>\n<ul>\n";
        for($a=0;$a<count($array);$a++){
            $this->pageArray['getEntityTypes'][$a]['linkCode']=$array[$a]['slug']."/{$array[$a]['slug']}/1/$itemsPerPage";
            $this->addedMenu.="\n<li><a href=\"showEntitiesForType.php/{$array[$a]['slug']}/1/$itemsPerPage\">&#8714;&nbsp;{$array[$a]['selector']}</a></li>\n";
        }
        $this->addedMenu.="\n</ul>\n</li>\n";
    }

    public function deEncrypt(string $data)
    {
        for ($i = 1000; $i < 1010; $i++) {
            $extract=md5($i);
            $data=str_replace($extract,"",$data);
        }
        return $data;
    }

    function enCryp(string $data, $leaveData=0)
    {
        $randPos1=rand(1000,1007);
        $randPos2=$randPos1+1;
        $randPos3=$randPos1+2;
        if($leaveData==0){
            $data=md5($data);
        }
        $x=rand(3,5);
        if(($x % 2) ==0)
        {
            return md5($randPos2).$data.md5($randPos3);
        }
        if(($x % 3) ==0)
        {
            return md5($randPos3).md5($randPos1).$data;
        }
        if(($x % 5) ==0)
        {
            return md5($randPos2).md5($randPos3).$data.md5($randPos1);
        }
        return md5($randPos3).md5($randPos1).$data.md5($randPos2);
    }
    public function evalCookie()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $this->pageArray['cookie']=array();
        $cookieName=getenv("siteSlug")."-pwa";
        if(isset($_COOKIE[$cookieName]))
        {
            $this->pageArray['cookie']=json_decode($_COOKIE[$cookieName], true);
        }
        return;
    }

    public function evalInputs()
    {
        $this->pageArray['inputs']['type']='UnKnown';
        if(isset($_SERVER['PATH_INFO'])){
            $this->pageArray['inputs']['type']='get';
            $this->pageArray['inputs']['urlAdded']=trim($_SERVER['PATH_INFO']);
            $this->pageArray['inputs']['function']=substr($this->pageArray['inputs']['urlAdded'],-2);
            //$this->evalGets();
            //$this->addedAPIcalls['postSwitchGets']=$this->pageArray['inputs'];
            return "get";
        }
        if(isset($_POST)){
            $this->pageArray['inputs']['type']='post';
            $posts=$_POST;
            unset($_POST);
            if(!isset($posts['pstSource'])){
                $posts['pstSource']="No posting Source (pstSource)|";
            }
            if(!isset($posts['pstType'])){
                $posts['pstType']="No posting Origen";
            }
            $posts['pstMailValid']=1;
            if(!isset($posts['pstMail'])){
                $posts['pstMail']="Not set";
                $posts['pstMailValid']=0;
            }
            if (!filter_var($posts['pstMail'], FILTER_VALIDATE_EMAIL)) {
                if(substr($posts['pstMail'],0,5)!='eMAil'){
                    $posts['pstMail']="Invalid email captured";
                    $posts['pstMailValid']=0;
                }
            }
            $posts['eMailDisplay']=$this->setEmailDisplay($posts['pstMail']);
            $posts['date']=date("D d M y");
            $category="<u>Regarding:</u>&rarr;<b>".$posts['pstCategory']."</b>";
            if(strlen($posts['pstMessage'])<2){
                $posts['pstMessage']="No Message";
            }
            $posts['message']=$posts['pstMessage']."\n\nFrom\n".$posts['message']=$posts['pstFrom'];
            $posts['topic']="UnKnown (pstType)";
            if(isset($posts['pstType'])){
                $posts['topic']=$category." on ".$posts['pstType'];
            }
            $posts['response']="";
            $posts['response'].="<br><br>Thank you <b>{$posts['pstFrom']}</b> for the <b>touch !</b><br>";
            if(isset($posts['pstSource'])){
                $posts['response'].="<hr><br>Use the menu or return to <a href=\"{$posts['pstSource']}.php\"> {$posts['pstSource']}</a>.";
            }
            $posts['response'].="<br>An email was attempted to an address like::<b>{$posts['eMailDisplay']}</b>::<br>";
            if(strlen($posts['pstSource'])<2){
                $posts['response']="Please Use the menu to navigate to the desired section.";
            }
            $this->pageArray['inputs']['posts']=$posts;
            $this->pageArray['inputs']['posts']['cBlLine']=__LINE__;
            $this->writeCookie($this->pageArray['inputs']['posts']);
            $this->evalCookie();
            $this->pageArray['postSwitchElements']['date']=date("D d M Y");
            if(isset($this->pageArray['cookie']['cSiteValidation'])){
                if($this->pageArray['cookie']['cSiteValidation']==1){
                    $this->pageArray['postSwitchElements']['specificHeader']="<b>Registered eMail</b>";
                    $this->pageArray['postSwitchElements']['topic']='Authentication';
                    $this->pageArray['postSwitchElements']['message']='Authenticated - Thank you &nbsp;&nbsp;&#128524;';
                    $this->pageArray['postSwitchElements']['response']='Navigate Home &amp retry please <a href ="index.php">here</a>.';
                    $this->pageArray['postSwitchElements']['heading']='Touch Acknowledged';
                    return;
                }
            }
            $this->pageArray['postSwitchElements']['specificHeader']="<b>eMail Not Validated</b>";
            $this->pageArray['postSwitchElements']['topic']='Authentication Pending';
            $this->pageArray['postSwitchElements']['message']='Thank you &nbsp;&nbsp;&#128524;';
            $this->pageArray['postSwitchElements']['response']='Navigate Home &amp retry please <a href ="index.php">here</a>.';
            $this->pageArray['postSwitchElements']['heading']='Touch Acknowledged';
            return;
        }
    }

    private function getEntitiesForType(array $pathInfo)
    {
        $apiArray=$this->apiGetEntitiesForType($pathInfo);
        if($apiArray['status']!==200){
            return null;
        }
        else
        {
            $apiDataArray=json_decode($apiArray['body'],true);
            return $apiDataArray;
        }
    }

    private function getEntityTypes(string $value)
    {
        // if($value=='all'){  //get all types
        //     $apiArray=$this->xapiGetxAllEntityTypes();
        //     if($apiArray['status']!==200){
        //         $this->pageArray['getEntityTypes']=array();
        //         return;
        //     }
        //     $apiDataArray=json_decode($apiArray['body'],true);
        //     $this->pageArray['getEntityTypes']=$apiDataArray['data'];
        //     return;
        // }
    }
    public function getEnv(){
        $file=$_SERVER['DOCUMENT_ROOT']."/.env";
        $contents=file_get_contents($file);
        $arrayContents=explode("\n",$contents);
        foreach ($arrayContents as $key => $value) {
            $value=trim($value);
            $findEq=strpos($value,"=");
            if($findEq>0){
                $lineItemArray=explode("=",$value);
                $putEnvStr=trim($lineItemArray[0])."=".trim($lineItemArray[1]);
                putenv($putEnvStr);
            }
        }
        date_default_timezone_set(getenv('tz'));
        return;
    }
    public function getInfoPathArray(string $path)
    {
        $pathExploded=explode("/",$path);
        $defaultPageSize=getenv("defaultPageSize");
        $this->infoPathArray['slug']=$pathExploded[1];
        $this->infoPathArray['page']=1;
        $this->infoPathArray['size']=$defaultPageSize;
        if(isset($pathExploded[2])){
            $this->infoPathArray['page']=$pathExploded[2];
        }
        if(isset($pathExploded[3])){
            $this->infoPathArray['size']=$pathExploded[3];
        }
    }

    private function setUserLoginVars() // only of isset cHash
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        //$this->pageArray['page']['appUser']
        // if(!isset($this->pageArray['cookie']['cHash'])){
        //     $this->pageArray['loginUser']['apiStatus']=0;
        //     return;
        // }
        if(!isset($this->pageArray['appUser'])){
           $this->trace[]="ToDo::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
           return;
        }        //exit();
        if(($this->pageArray['appUser']['status']<4) AND ($this->pageArray['appUser']['status']>0)){
            //1=skunks access
            //2=PWA only accesss
            $this->pageArray['appUser']['action']=json_decode($this->pageArray['appUser']['action_json'],true);
            $findFor=getenv('siteSlug');
            //echo("<br>Array:['appUser']".__LINE__."({$this->myName}))<br><pre>"); print_r($this->pageArray['appUser']); echo("</pre><hr>");
            //exit();
            $accessArray=array();
            for($i=0;$i<count($this->pageArray['appUser']['action']);$i++){
                if($this->pageArray['appUser']['action'][$i]['slug']==$findFor){
                    $accessArray=$this->pageArray['appUser']['action'][$i];
                    //echo("<br>Array:pageArray(".__LINE__."({$this->myName}))<br><pre>"); print_r($this->trace); echo("</pre><hr>");
                }
            }
            $value['cUserName']=$this->pageArray['appUser']['fullname'];
            $value['cUserStatus']=$this->pageArray['appUser']['status'];
            if(count($accessArray)>0){
                $value['cSiteAccess']=$accessArray['access'];
                $value['cSiteValidation']=$accessArray['validate'];
            }
            $value['calledLine']=__LINE__;
            $this->writeCookie($value);
        }
        return;
    }
    private function pushToErrorPage(string $method, array $endArray)
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        echo("<br>Array:trace(".__LINE__."({$this->myName}))<br><pre>"); print_r($this->trace); echo("</pre><hr>");
        echo("<b>{$this->myName}</b>->Method::<b>".$method."</b>");
        echo("<br>Array:endArray(".__LINE__."({$this->myName}))<br><pre>"); print_r($endArray); echo("</pre><hr>");
        // $output="?method=".$method;
        // $fl="page.log";
        // $contents=print_r($this->pageArray['apiCalls'],true);
        // file_put_contents($fl,$contents);
        // header("Location: apiErr.php$output",301);
        exit();
    }
    private function xxxpostTouchMail(array $touchArray,string $jsonReg)
    {
        // $checkArray=json_decode($jsonReg, true);
        // // echo("<br>Array:checkArray(".__LINE__."({$this->myName}))<br><pre>"); print_r($checkArray); echo("</pre><hr>");
        // // exit();
        // $linkBits=rand(1000,9999)."rg";
        // if(isset($checkArray['data']['comms_ref'])){
        //     $linkBits=substr($checkArray['data']['comms_ref'],0,6);
        //     $linkBits.="rg"; //used for register url key
        // }
        // $from=getenv('api-user-name');
        // $site=getenv('siteName');
        // $linkBack=getenv('domain');
        // $inArray['to']=$touchArray['pstMail'];
        // $inArray['to_person']=$touchArray['pstFrom'];
        // $inArray['subject']=$touchArray['pstType']."-".$touchArray['pstType'];
        // $inArray['body']="
        //     Welcome to {$site} {$touchArray['pstFrom']},
        //     <br><br>
        //     Thank you for the touch!. This is your reference: <b>{$linkBits}</b>.
        //     <br><br>
        //     Your Touch Message:
        //     <br><br>
        //     <b>{$touchArray['pstMessage']}</b>
        //     <br><br>
        //     Regards,
        //     <br><br>
        //     $from
        //     <br>";
        // $this->apiArray['postMailStart']=time();
        // $client = new GUZ([
        //     'headers' => $this->apiArray["headersIn"]
        // ]);
        // $bodyInJson=json_encode($inArray);
        // try{
        //     $r = $client->request("POST", $this->apiArray['mailUri']."/send",['body' => $bodyInJson, 'http_errors' => true]);
        //     $response['body']=$r->getBody()->getContents();
        //     $response['status']=$r->getStatusCode();
        //     $response['headersOut']=$r->getHeaders();
        //     $response['20xMethodCode']=__LINE__;
        // } catch (ClientException $e) {
        //     $exception = $e->getResponse();
        //     $response['body']['error'][] = "error:\n";
        //     $response['body']['error'][] = $bodyInJson;
        //     $response['status'] = $exception->getStatusCode();
        //     $response['headersOut'] = $exception->getHeaders();
        //     $response['40xMethodCode']=__LINE__;
        // }
        // $this->apiArray['postMailEnd']=time();
        // return;
    }
    private function sendMailAdmin(string $msg, array $addMessageArray)
    {
        if(count($addMessageArray)){
            $msg.="<pre>";
            $msg.=print_r($addMessageArray,true);
            $msg.="</pre>";
        }
        $from=getenv('api-user-name');
        $site=getenv('siteSlug');
        $inArray['to']=getenv('adminMail');
        $inArray['to_person']=$from;
        $inArray['subject']="AdminMail - $site";
        $inArray['body']="
            {$site} message for {$from},
            <br><br>
            {$msg}";
        $this->apiArray['postMailAdmin']=time();
        $client = new GUZ([
            'headers' => $this->apiArray["headersIn"]
        ]);
        $bodyInJson=json_encode($inArray);
        try{
            $r = $client->request("POST", $this->apiArray['mailUri']."/send",['body' => $bodyInJson, 'http_errors' => true]);
            $response['body']=$r->getBody()->getContents();
            $response['status']=$r->getStatusCode();
            $response['headersOut']=$r->getHeaders();
            $response['20xMethodCode']=__LINE__;
        } catch (ClientException $e) {
            $exception = $e->getResponse();
            $response['body'] = $exception->getBody()->getContents();
            $response['status'] = $exception->getStatusCode();
            $response['headersOut'] = $exception->getHeaders();
            $response['40xMethodCode']=__LINE__;
        }
        $this->apiArray['postMailAdmin']=time();
        return;
    }
    private function xxpostTouch(array $touchArray)
    {
        // $this->apiArray['postTouchStart']=time();
        // $client = new GUZ([
        //     'headers' => $this->apiArray["headersIn"]
        // ]);
        // $topic=getenv('siteSlug')."-".$touchArray['pstCategory'];
        // $this->apiArray['postTouchStart']=time();
        // $commitArray['site_slug']=getenv('siteSlug');
        // $commitArray['comms_by_slug']=$touchArray['pstMail'];
        // $commitArray['source_slug']=$touchArray['pstSource'];
        // $commitArray['for_slug']=getenv('api-user-name');
        // $commitArray['comms_log']="\nTouch Created @ ".date("Y-n-d H:i:s");;
        // $commitArray['comms_topic']=$topic;
        // $commitArray['comms_text']=$touchArray['pstMessage'];
        // $bodyInJson=json_encode($commitArray);
        // try{
        //     $r = $client->request("POST", $this->apiArray['userUri']."/comms",['body' => $bodyInJson, 'http_errors' => true]);
        //     $response['body']=$r->getBody()->getContents();
        //     $response['status']=$r->getStatusCode();
        //     $response['headersOut']=$r->getHeaders();
        //     $response['20xMethodCode']=__LINE__;
        // } catch (ClientException $e) {
        //     $exception = $e->getResponse();
        //     $response['body'] = $exception->getBody()->getContents();
        //     $response['status'] = $exception->getStatusCode();
        //     $response['headersOut'] = $exception->getHeaders();
        //     $response['40xMethodCode']=__LINE__;
        // }
        // $this->apiArray['postTouchEnd']=time();
    }
    public function replacePageElements()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $elementsArray=$this->pageArray['page']['elements'];
        usort($elementsArray, function($a, $b) {
            return $a['seq'] <=> $b['seq'];
        });
        for($e=0;$e<count($elementsArray);$e++){
            $replaceMe=$elementsArray[$e]['position_name'];
            if($elementsArray[$e]['conditional']==0){
                $replaceWith=$elementsArray[$e]['element_text'];
            }
            if($elementsArray[$e]['conditional']==1){
                $caseArray=explode("|",$elementsArray[$e]['element_text']);
                switch ($caseArray[0]) {
                    case "rand":
                        $rangeSplit=explode("~",$caseArray[1]);
                        $replaceWith=rand((int)$rangeSplit[0],(int)$rangeSplit[1]);
                        break;
                    case "arrayLimitedOutput":
                        $template=$caseArray[3];
                        $replaceWith="";
                        for($r=0;$r<$caseArray[2];$r++){
                            $replaceArray=$this->pageArray['getMessages']['data'][$r];  //buggggggg
                            $replaceWith.=$template;
                            foreach($replaceArray as $key => $value) {
                                $replaceWith=str_replace("###$key###",$value,$replaceWith);
                            }
                        }
                        break;
                    default:
                        $replaceWith="FUBAR";
                        break;
                }
            }
            $this->html=str_replace("###$replaceMe###",$replaceWith,$this->html);
        }
    }
    public function replaceSiteStatics()
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $staticsArray=$this->pageArray['page']['static'];
        for($e=0;$e<count($staticsArray);$e++){
            $replaceMe=$staticsArray[$e]['position_name'];
            $replaceWith=$staticsArray[$e]['ht'];
            $this->html=str_replace("###$replaceMe###",$replaceWith,$this->html);
        }
    }
    public function writeCookie(array $values)
    {
        $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        $wantCookieArray=array('cEmail','cHash','cUserName','cUserStatus','cSiteAccess','cSiteValidation');
        $cookieName=getenv("siteSlug")."-pwa";
        $cookieValues=array();
        if(isset($_COOKIE[$cookieName]))
        {
            $cookieValues=json_decode($_COOKIE[$cookieName], true);
        }
        for($n=0;$n<count($wantCookieArray);$n++){
            if(isset($values[$wantCookieArray[$n]])){
                $cookieValues[$wantCookieArray[$n]]=$values[$wantCookieArray[$n]];
            }
        }
        $cookieValues['cCreatedAt']=date("Y-m-d H:i:s");
        if(isset($values['pstFrom'])){  //we have inputs
            if(isset($values['pstMail'])){
                if($values['pstMailValid']==1){
                    $cookieValues['cEmail']=$values['pstMail'];
                    $cookieValues['cHash']=$this->enCryp($values['pstMail']);
                }
            }
            if(isset($valuesArray['pstFrom'])){
                $cookieValues['cUserName']=$values['pstFrom'];
            }
        }
        setcookie($cookieName, json_encode($cookieValues), time() + (3* 86400 * 30), "/");
        return;
    }
    public function setDebugger(array $array)
    {
        $debug=getenv('debug');
        $returnContents="";
        if($debug){
            $returnContents=print_r($array,true);
        }
        return $returnContents;
    }
    public function setEmailDisplay(string $email)
    {
        if(strpos("@",$email)>1){
            $splits=explode("@",$email);
            return "**@".$splits[1];
        }
        return "$email-notValid";
    }
    public function writeLogs()
    {
        $debug=getenv('debug');
        if($debug){
            $dte=date("H:i:s");
            $fl="page.log";
            $contents="\n\nTrace\n=====($dte)=======\n";
            $contents.=print_r($this->trace,true);
            $contents.="\n\nToDos===================\n";
            $contents.=implode("\n",$this->ToDo);
            $contents.="\n\nPageArray================\n";
            $contents.=print_r($this->pageArray,true);
            $contents.="\n\nEOF()";
            file_put_contents($fl,$contents);
        }
        return;
    }
}
