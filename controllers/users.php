<?php
class Controller extends AController {
    public function view() {
        $this->loadModel("users");
        $aData = $this->users->foo();

        $this->precondition($aData['Username'] == 'Gerome');
        echo $this->loadView("users/displaytable",$aData);

        $this->postcondition($aData['Username'] == 'Gerome');
    }
}
?>