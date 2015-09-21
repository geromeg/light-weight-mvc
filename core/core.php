<?php
/**
 * @author Gerome Guilfoyle
 * @date 26 August 2015
 * @description Core class with core functionality which will be inherited by other core classes
 */
global $aConfig;

class ACore {

    /**
     * @param $eCondition
     * @param $sType
     */
    protected function evalcondition($eCondition,$sType) {
        $bResult = $eCondition;

        if(!$bResult) {
            switch($aConfig['prepost_condition_mode']) {
                case FULL_FAILURE:
                    throw new Exception("{$eCondition} did not evaluate to what was expected on the {$sType}");
                    break;
                case LOG_STATE:
                    $sMessage = "{$eCondition} did not evaluate to what was expected on the {$sType}";
                    $this->logMessage($sMessage,LOG_SIMPLE);
                    file_put_contents($aConfig['logs']['post_pre_condition_log'],FILE_APPEND);
                    break;

            }
        }
    }

    /**
     * @param $eCondition A condition in String format of the condition to be met Eg: "$iCount>0"
     */
    protected function postcondition($eCondition) {
        try {
            $this->evalcondition($eCondition,"Post Condition");
        } catch(Exeption $e) {}
    }

    /**
     * @param $eCondition A condition in String format of the condition to be met Eg: "$iCount>0"
     */
    protected function precondition($eCondition) {
        try {
            $this->evalcondition($eCondition,"Pre Condition");
        } catch(Exception $e) {}
    }

    /**
     * Helps with sanitizing variables and making sure you get what you are expecting from a data source
     * @param $eValue
     * @param $sType
     * @return bool
     */
    protected function expecting($eValue, $sType) { //When you are expecting a certain variable type and you would like to validate it
        $eNewvalue = settype($eValue,$sType);

        if($eNewvalue != $eValue) {
            return false;
        } else {
            return $eNewvalue;
        }
    }

    /**
     * Method for determining paths to core files
     * @param $sPath
     * @return mixed
     */
    private function getCorePaths($sPath)
    {
        $aPaths = explode("/",$sPath);
        $aPath['function'] = array_pop($aPaths);
        $aPath['file'] = array_pop($aPaths);
        $aPath['folder'] = implode("/",$aPaths);
        return $aPath;
    }

    /**
     * Loads a model with the model path
     * @param string $sModelname
     */
    protected function loadModel($sModelname = ""){

        foreach (func_get_args() as $sModel) {
            $aPath = $this->getCorePaths($sModel);
            $sFilename = $aPath['function'];
            $sClassname = ucwords($sFilename)."_Model";
            require_once('models/' . $sFilename . ".php" );
            $this->{$sFilename} = new $sClassname;
        }
    }

    /**
     * @param string $sHelpername
     */
    protected function loadHelper($sHelpername = ""){
        foreach (func_get_args() as $sHelper) {
            $aPath = $this->getCorePaths($sHelper);
            require_once('helpers/' . $aPath['file'] . ".php" );
        }
    }

    /**
     * @param string $sViewname The path to the view that will be loaded
     * @param $aData Data passed to the view as an associative array
     * @return string The view with the populated data returned for printing
     */
    protected function loadView($sViewname = "",$aData) {
               
        ob_start();
        extract($aData);
        require_once('views/' . $sViewname . ".php" );
        $cBody = ob_get_contents();
        ob_end_clean();
        return $cBody;

    }

    /**
     * @param $iMode
     */
    protected function setPrePostConditionMode($iMode){
        $aConfig['prepost_condition_mode'] = (int)$iMode;
    }

    /**
     * @param $iMode
     */
    protected function setLoggingMode($iMode){
        $aConfig['logging_mode'] = (int)$iMode;
    }

    /**
     * @param $sMessage
     * @param int $iLogType
     */
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

?>