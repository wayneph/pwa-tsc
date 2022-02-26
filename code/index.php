<?php namespace presentation;
$file=$_SERVER['DOCUMENT_ROOT']."/include/appControl/Bl.php";
include_once($file);
$file=$_SERVER['DOCUMENT_ROOT']."/include/pl.php";
include_once($file);
use BL\BL;
use presentationLogic\Pl as PL;
class Present extends BL
{
    private $myName="index";
    public function __construct()
    {
        parent::__construct();
        parent::evalCookie();
        /* set api Vars */
        $this->pageArray['apiVars']['getPage']=$this->myName;
        $this->pageArray['apiCalls'][]='getPage';
        $this->pageArray['apiCalls'][]='getAllEntityTypes';
        if(isset($this->pageArray['cookie']['cEmail'])){
            $this->pageArray['apiCalls'][]='setUserLogin';
        }
        parent::executeAPICalls();
        parent::evalCookie();
        if(isset($this->pageArray['page']['apiFindUser']['data'])){
            parent::writeCookie($this->pageArray['page']['apiFindUser']['data']['data']);
        }
        parent::buildEntityTypesMenu("all");
        $this->html=file_get_contents("templates/{$this->pageArray['page']['page']['hddr_template']}");
        $this->html.=file_get_contents("templates/{$this->pageArray['page']['page']['body_template']}");
        $this->html.=file_get_contents("templates/{$this->pageArray['page']['page']['footer_template']}");
        parent::replaceSiteStatics();
        parent::replacePageElements();
        /* set some defaults */
        $emailText="<input name=\"pstMail\" placeholder=\"Email\" type=\"text\" value=\"###emailAddress###\">";
        $email="eMail";
        $person="Name";
        $validUser="Not Set";
        $logoutText="";
        if(isset($this->pageArray['cookie']['cEmail'])){$email=$this->pageArray['cookie']['cEmail'];}
        if(isset($this->pageArray['cookie']['cUserName'])){$person=$this->pageArray['cookie']['cUserName'];}
        if(isset($this->pageArray['cookie']['cSiteValidation'])){
            if($this->pageArray['cookie']['cSiteValidation']==1){
                $validUser="Valid App User";
                $logoutText="<br><a href=\"logout.php\">Remove Login</a>";
            }
        }
        /* assign values to page */
        $this->html=str_replace("###title###",$this->pageArray['page']['page']['title'],$this->html);
        $this->html=str_replace("###softMail###",$emailText,$this->html);
        $this->html=str_replace("###addedStyles###",$this->pageArray['page']['page']['styles_added'],$this->html);
        $this->html=str_replace("###softSubMenus###",$this->addedMenu,$this->html);
        $this->html=str_replace("###emailAddress###",$email,$this->html);
        $this->html=str_replace("###personName###",$person,$this->html);
        $this->html=str_replace("###validUser###",$validUser,$this->html);
        $this->html=str_replace("###logoutText###",$logoutText,$this->html);
        $this->html=str_replace("###myName###",$this->myName,$this->html);
        $this->html=str_replace("###scriptAdded###","",$this->html);
        $dBug=parent::setDebugger($this->pageArray['cookie']);
        $this->html=str_replace("###debugger###",$dBug,$this->html);
        echo($this->html);
        parent::writeLogs();
    }
}
new Present;


