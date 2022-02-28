<?php namespace presentation;
$file=$_SERVER['DOCUMENT_ROOT']."/include/appControl/Bl.php";
include_once($file);
use BL\BL;
class Present extends BL
{
    private $myName="pwaInstruct";
    public function __construct()
    {
        $this->trace[]="({$this->myName}/php)::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b> @".date("H:i:s");
        parent::__construct($this->myName);
        parent::executeAPICalls();
        parent::getHTML(); // gives $this->html - also does replaces


        // parent::__construct();
        // parent::evalCookie();
        // /* set api Vars */
        // $this->pageArray['apiVars']['getPage']=$this->myName;
        // $this->pageArray['apiCalls'][]='getPage';
        // $this->pageArray['apiCalls'][]='getAllEntityTypes';
        // $this->pageArray['apiCalls'][]='getMessages';
        // if(isset($this->pageArray['cookie']['cEmail'])){
        //     $this->pageArray['apiCalls'][]='setUserLogin';
        // }
        // parent::executeAPICalls();
        // parent::evalCookie();
        // if(isset($this->pageArray['page']['apiFindUser']['data'])){
        //     parent::writeCookie($this->pageArray['page']['apiFindUser']['data']['data']);
        // }
        // $emailText="<input name=\"pstMail\" placeholder=\"Email\" type=\"text\" value=\"###emailAddress###\">";
        // $email="eMail";
        // $person="Name";
        // $validUser="Not Set";
        // $logoutText="";
        // if(isset($this->pageArray['cookie']['cEmail'])){$email=$this->pageArray['cookie']['cEmail'];}
        // if(isset($this->pageArray['cookie']['cUserName'])){$person=$this->pageArray['cookie']['cUserName'];}
        // if(isset($this->pageArray['cookie']['cSiteValidation'])){
        //     if($this->pageArray['cookie']['cSiteValidation']==1){
        //         $validUser="Valid App User";
        //         $logoutText="<br><a href=\"logout.php\">Remove Login</a>";
        //     }
        // }
        // parent::buildEntityTypesMenu("all");
        $postsDetailCondition=$this->buildMessages($this->pageArray['messages']);
        // $this->html=file_get_contents("templates/{$this->pageArray['page']['page']['hddr_template']}");
        // $this->html.=file_get_contents("templates/{$this->pageArray['page']['page']['body_template']}");
        // $this->html.=file_get_contents("templates/{$this->pageArray['page']['page']['footer_template']}");
        // parent::replaceSiteStatics();
        // parent::replacePageElements();
        $this->html=str_replace("###title###",$this->pageArray['page']['page']['title'],$this->html);
        //$this->html=str_replace("###softMail###",$emailText,$this->html);
        $this->html=str_replace("###addedStyles###",$this->pageArray['page']['page']['styles_added'],$this->html);
        $this->html=str_replace("###softSubMenus###",$this->addedMenu,$this->html);
        //$this->html=str_replace("###emailAddress###",$email,$this->html);
        //$this->html=str_replace("###personName###",$person,$this->html);
        $this->html=str_replace("###postsDetailCondition###",$postsDetailCondition,$this->html);
        //$this->html=str_replace("###validUser###",$validUser,$this->html);
        //$this->html=str_replace("###logoutText###",$logoutText,$this->html);
        $this->html=str_replace("###myName###",$this->myName,$this->html);
        $dBug=parent::setDebugger($this->pageArray['cookie']);
        $this->html=str_replace("###debugger###",$dBug,$this->html);
        echo($this->html);
        parent::writeLogs();
    }
}
new Present;


