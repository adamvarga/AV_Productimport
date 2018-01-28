<?php

class AV_Productimport_IndexController extends Mage_Core_Controller_Front_Action {

    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
        //echo 'test index';
    }

    public function mamethodeAction() {
        echo 'test mamethode';
    }

}
