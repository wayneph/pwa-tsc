<?php namespace presentation;
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$file=$_SERVER['DOCUMENT_ROOT']."/include/appControl/Bl.php";
include_once($file);
$file=$_SERVER['DOCUMENT_ROOT']."/include/pl.php";
include_once($file);
use presentationLogic\Pl as PL;
USE BL\BL as BL;
class Present extends BL
{
    private $myName="_handler_.php";
    private $alertMsg="";
    public function __construct()
    {
        // error handling -- action
        if(isset($_SESSION['errors'][0])){
            unset($_POST);
            $errs=$_SESSION['errors'];
            unset($_SESSION['errors']);
            $file=date("ymd_His")."-error.log";
            file_put_contents($file,"\n".date("Ymd H:i:s")."Errors::\n".print_r($errs,true));
            $notice="General Notice";
            if(null!==$errs[0]){
                $notice="Our apologies &rarr; We have an error &rarr; &nbsp;".$errs[0];
            }
            $detail="Overall Detail of this error has been saved.\n";
            if(null!==$errs[0]){
                $detail.="More Information &rarr; &nbsp;".$errs[1]."";
            }
            $html=file_get_contents("templates/notices.html");
            $html=str_replace("[[notice]]",$notice,$html);
            $html=str_replace("[[detail]]",$detail,$html);
            echo($html);
            exit();
        }
        if(isset($_POST)){
            // non error actions
            PL::getEnv($this->myName);
            $this->pageArray=parent::handleSession($this->myName);
            $elements=$this->pageArray['elements'];
            // forms handling - each form must redirect - no output
            $typeElement=4;
            $posts=$_POST;
            unset($_POST);
            $thisElement=PL::setTheseElements($elements,$posts,$typeElement);
            $function=$thisElement['position_name'];
            BL::$function($posts, $thisElement['validate']);
            exit();
        }
        exit();
    }
}
new Present;