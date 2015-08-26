<?php
/**
 * @author Gerome Guilfoyle
 * @date 26 August 2015
 * @description Core class with core functionality which will be inherited by other core classes
 */
global $aConfig;

class ACore {

    protected function evalcondition($eCondition,$sType) {
        $bResult = eval($eCondition);
        if(!$bResult) {
            switch($aConfig['prepost_condition_mode']) {
                case FULL_FAILURE:
                    throws new Exception("{$eCondition} did not evaluate to what was expected on the {$sType}")
                    break;
                case LOG_STATE:
                    $sMessage = "{$eCondition} did not evaluate to what was expected on the {$sType}";
                    $this->logMessage($sMessage,LOG_SIMPLE);
                    file_put_contents($aConfig['logs']['post_pre_condition_log'],FILE_APPEND);
                    break;

            }
        }
    }
    protected function postcondition($eCondition,$sCustommessage = "") {
       $this->evalcondition($eCondition,"Post Condition");
    }
    protected function precondition($eCondition,$sCustommessage = "") {
        $this->evalcondition($eCondition,"Pre Condition");
    }
    protected function expecting($eValue, $sType) { //When you are expecting a certain variable type and you would like to validate it
        $eNewvalue = ({$sType})$eValue;

        if($eNewvalue != $eValue) {
            return false;
        } else {
            return $eNewvalue;
        }
    }
    protected function getCorePaths($sPath)
    {
        $aPaths = explode("/",$sPath);
        $aPath['function'] = array_pop($aPaths);
        $aPath['file'] = array_pop($aPaths);
        $aPath['folder'] = implode("/",$aPaths);
        return $aPath;
    }
    protected function loadModel($sModelname = ""){

        foreach (func_get_args() as $sModel) {
            $aPath = $this->getCorePaths($sModel);
            require_once('models/' . $aPath['file'] . ".php" );
            $this->{$aPath['file']} = new {$aPath['file']."_Model();"};
        }
    }
    protected function loadHelper($sHelpername = ""){
        foreach (func_get_args() as $sHelper) {
            $aPath = $this->getCorePaths($sHelper);
            require_once('helpers/' . $aPath['file'] . ".php" );
        }
    }
    protected function loadView($sViewname = "",$aData) {
        $aPath = $this->getCorePaths($sViewname);
        ob_start();
        extract($aData);
        require_once('views/' . $aPath['file'] . ".php" );
        $cBody = ob_get_contents();
        ob_end_clean();
        return $cBody;

    }
    protected function setPrePostConditionMode($iMode){
        $aConfig['prepost_condition_mode'] = (int)$iMode;
    }
    protected function setLoggingMode($iMode){
        $aConfig['logging_mode'] = (int)$iMode;
    }
    protected function logMessage($sMessage,$iLogType = 0) {

        $iLogType = (int)$iLogType;

        switch($aConfig['logging_mode']) {
            case LOG_VERBOSE:
                $sMessage = date("Y-m-d H:i:s"). " " . implode("#",$_SERVER). "#".implode("#",$_POST)."#".implode("#",$_GET)." ".$sMessage;
                break;
            case LOG_SIMPLE:
                $sMessage = date("Y-m-d H:i:s"). " " .$sMessage;
                break;
        }

        if($iLogType == 0) { //No mode is set so log only to consolidated log
            file_put_contents($aConfig['logs']['main_log'],$sMessage,FILE_APPEND);
        } else {
            file_put_contents($aConfig['logs']['main_log'],$sMessage,FILE_APPEND);
            file_put_contents($aConfig['logs'][$iLogType],$sMessage,FILE_APPEND);
        }
    }
}

}
?>