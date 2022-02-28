<?php namespace presentation;
$file=$_SERVER['DOCUMENT_ROOT']."/include/appControl/Bl.php";
include_once($file);
use BL\BL;

class Present extends BL
{
    private $myName="switch";
    public function __construct()
    {
        parent::__construct();
        parent::evalCookie();
        /* set api Vars */
        $this->pageArray['apiVars']['getPage']=$this->myName;
        $this->pageArray['apiCalls'][]='getPage';
        $this->pageArray['apiCalls'][]='getAllEntityTypes';
        parent::evalInputs();
        if(count($this->pageArray['cookie'])>1){
            if(isset($this->pageArray['cookie']['cSiteValidation'])){
                if($this->pageArray['cookie']['cSiteValidation']==1){
                    $this->pageArray['apiCalls'][]='setUserLogin';
                    $this->trace[]="method::CookieIsSet<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
                }
                $this->trace[]="WTF::method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
            }
        }
        if(count($this->pageArray['inputs']['posts'])>1){
            $this->pageArray['apiCalls'][]="setTouchData";
            $this->trace[]="method::<b>".__METHOD__."</b>->Line::<b>".__LINE__."</b>";
        }
        parent::executeAPICalls();
        if(isset($this->pageArray['page']['apiFindUser']['data'])){
            parent::writeCookie($this->pageArray['page']['apiFindUser']['data']['data']);
        }
        parent::buildEntityTypesMenu();;
        $this->html =file_get_contents("templates/{$this->pageArray['page']['page']['hddr_template']}");
        $this->html.=file_get_contents("templates/{$this->pageArray['page']['page']['body_template']}");
        $this->html.=file_get_contents("templates/{$this->pageArray['page']['page']['footer_template']}");
        parent::replaceSiteStatics();
        parent::replacePageElements();
        $this->html=str_replace("###title###",$this->pageArray['page']['page']['title'],$this->html);
        $this->html=str_replace("###specificHeader###",$this->pageArray['postSwitchElements']['specificHeader'],$this->html);
        $this->html=str_replace("###header###",$this->pageArray['postSwitchElements']['heading'],$this->html);
        $this->html=str_replace("###messageDate###",$this->pageArray['postSwitchElements']['date'],$this->html);
        $this->html=str_replace("###messageTopic###",$this->pageArray['postSwitchElements']['topic'],$this->html);
        $this->html=str_replace("###message###",$this->pageArray['postSwitchElements']['message'],$this->html);
        $this->html=str_replace("###messageResponse###",$this->pageArray['postSwitchElements']['response'],$this->html);
        // this page bits
        $this->html=str_replace("###addedStyles###",$this->pageArray['page']['page']['styles_added'],$this->html);
        $this->html=str_replace("###myName###",$this->myName,$this->html);
        // default for script added
        $this->html=str_replace("###scriptAdded###","<!-- No Script This Page-->",$this->html);
        $dBug=parent::setDebugger($this->pageArray['cookie']);
        $this->html=str_replace("###debugger###",$dBug,$this->html);
        echo($this->html);
        parent::writeLogs();
    }
}
new Present;


