<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 18.03.16
 * Time: 13:22
 */

class Alanstormdotcom_Helloworld_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
        $this->loadLayout();
        $this->renderLayout();
    }

    public function goodbuyAction(){
        $this->loadLayout();
        $this->renderLayout();
    }
}