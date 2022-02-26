<?php namespace presentation;
$file=$_SERVER['DOCUMENT_ROOT']."/include/appControl/Bl.php";
include_once($file);
use BL\BL;
class Present extends BL
{
    private $myName="switch";
    public function __construct()
    {
        $this->html=file_get_contents("templates/hddr.html");
        $this->html.=file_get_contents("templates/apiErr.html");
        $this->html.=file_get_contents("templates/footer.html");
        //parent::executeAddedCalls();
        /*  SET by action
        $this->pageArray['PostSwitchElements']['specificHeader']="<b>Logout</b> -or <b>Reset</b> success";
        $this->pageArray['PostSwitchElements']['topic']='Authentication';
        $this->pageArray['PostSwitchElements']['message']='Authenticated email un-Linked - Thank you &nbsp;&nbsp;&#128524;';
        $this->pageArray['PostSwitchElements']['response']='Navigate Home <a href =\"index.php\">here</a>.';
        $this->pageArray['PostSwitchElements']['heading']='Response To un-Link eMail address';
        */
        // $this->html=file_get_contents("templates/{$this->pageArray['data']['page']['hddr_template']}");
        // $this->html.=file_get_contents("templates/{$this->pageArray['data']['page']['body_template']}");
        // $this->html.=file_get_contents("templates/{$this->pageArray['data']['page']['footer_template']}");
        // parent::replaceSiteStatics();
        // parent::replacePageElements();
        // parent::executeAddedCalls();
        // parent::writeLogs($this->pageArray, "pageArray");
        // replace page specific bits
        $this->html=str_replace("###title###","Theewaters Sport Club",$this->html);
        $this->html=str_replace("###specificHeader###","API Access Error ",$this->html);
        $this->html=str_replace("###copyRight###","
            <li>
                &copy; : Theewaters Sport Club Members(2021).
            </li>
            <li>
                Powered by : <a href=\"http://skunks.co\" target=\"_blank\">SkunkWorx</a>
            </li>
            <li>
                Design : Wayne Philip.
            </li>",
            $this->html);
        $errVars=file_get_contents("page.log");
        // $this->html=str_replace("###header###",$this->pageArray['postSwitchElements']['heading'],$this->html);
        // $this->html=str_replace("###messageDate###",$this->pageArray['postSwitchElements']['date'],$this->html);
        // $this->html=str_replace("###messageTopic###",$this->pageArray['postSwitchElements']['topic'],$this->html);
        // $this->html=str_replace("###message###",$this->pageArray['postSwitchElements']['message'],$this->html);
        // $this->html=str_replace("###messageResponse###",$this->pageArray['postSwitchElements']['response'],$this->html);
        // this page bits
        // $this->html=str_replace("###addedStyles###",$this->pageArray['data']['page']['styles_added'],$this->html);
        // $this->html=str_replace("###softSubMenus###",$this->addedMenu,$this->html);
        // $this->html=str_replace("###myName###",$this->myName,$this->html);
        // default for script added
        $this->html=str_replace("###scriptAdded###","<!-- No Script This Page-->",$this->html);
        $this->html=str_replace("###errPageData###",$errVars,$this->html);
        //$dBug=parent::setDebugger($this->pageArray['apiVars']);
        $dBug="";
        $this->html=str_replace("###debugger###",$dBug,$this->html);
        echo($this->html);
        parent::writeLogs();
    }
}
new Present;



