<?php namespace presentation;
$file=$_SERVER['DOCUMENT_ROOT']."/include/appControl/Bl.php";
include_once($file);
$file=$_SERVER['DOCUMENT_ROOT']."/include/pl.php";
include_once($file);
use BL\BL;
use presentationLogic\Pl as PL;
class Present extends BL
{
    private $myName="pwaInstruct";
    private $alertMsg="";
    public function __construct()
    {
        $emailAddress="";
        $userName="";
        if(isset($_COOKIE['TSCloginData'])) {
            $splitMeArray=explode("~",$_COOKIE['PWAloginData']);
            $emailAddress=$splitMeArray[0];
            $userName=$splitMeArray[1];
            $this->addedAPIcalls['setPIN']=$splitMeArray;
        }
        PL::getEnv($this->myName);
        $this->addedAPIcalls['getEntityTypes']="all";
        $this->addedAPIcalls['getMessages']="1/10";
        parent::getPage($this->myName);
        $postsDetailCondition=PL::buildMessages($this->pageArray['getMessages']['data']);
        $this->html=file_get_contents("templates/{$this->pageArray['data']['page']['hddr_template']}");
        $this->html.=file_get_contents("templates/{$this->pageArray['data']['page']['body_template']}");
        $this->html.=file_get_contents("templates/{$this->pageArray['data']['page']['footer_template']}");
        parent::replaceSiteStatics();
        parent::replacePageElements();
        $this->html=str_replace("###title###",$this->pageArray['data']['page']['title'],$this->html);
        $this->html=str_replace("###addedStyles###",$this->pageArray['data']['page']['styles_added'],$this->html);
        $this->html=str_replace("###softSubMenus###",$this->addedMenu,$this->html);
        $this->html=str_replace("###postsDetailCondition###",$postsDetailCondition,$this->html);
        $this->html=str_replace("###emailAddress###",$emailAddress,$this->html);
        $this->html=str_replace("###personName###",$userName,$this->html);
        $this->html=str_replace("###myName###",$this->myName,$this->html);
        echo($this->html);
    }
}
new Present;


