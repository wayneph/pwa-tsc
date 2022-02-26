<?php namespace presentation;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$file=$_SERVER['DOCUMENT_ROOT']."/include/appControl/appControlBl.php";
include_once($file);
$file=$_SERVER['DOCUMENT_ROOT']."/include/pl.php";
include_once($file);
use prestationLogic\Pl as PL;
use bizLogic\AppControlBL as BL;
class Present extends BL
{
    private $myName="logIn.php";
    private $alertMsg="";
    public function __construct()
    {
        $specialLogAction="NoAction";
        PL::getEnv($this->myName);
        $this->alertMsg=PL::handleAlerts($this->myName);
        parent::__construct();
        $specifcReplacesArray=parent::buildPage($this->myName);
        $alert="";
        if(strlen($this->alertMsg)>5){
            $alert.=$specifcReplacesArray['alertScript'];
            $alert=str_replace("[[alertMsg]]",$this->alertMsg,$alert);  
        }
        $this->ht=str_replace("//scrAlert",$alert,$this->ht);
        $this->ht=str_replace("[[menuAdded]]",$this->addedMenu,$this->ht);
        $this->ht=str_replace("[[currentPageUrl]]",$this->myName.".php",$this->ht);
        parent::writeLogs("{$this->myName}::$specialLogAction");   
        $Objvars=PL::registerPLVars(get_object_vars($this),2);
        parent::traceObj(__METHOD__,"$Objvars","Construct:{$this->myName}");
        echo($this->ht);
    }
}
new Present;
