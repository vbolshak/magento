<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 18.03.16
 * Time: 13:22
 */

class Alanstormdotcom_Configviewer_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
        echo 'Hello !';
        $this->paramsAction();
    }

    public function goodbyeAction() {
        echo 'Goodbye World!';
    }

    public function paramsAction() {
        echo '<dl>';
        foreach($this->getRequest()->getParams() as $key=>$value) {
            echo '<dt><strong>Param: </strong>'.$key.'</dt>';
            echo '<dl><strong>Value: </strong>'.$value.'</dl>';
        }
        echo '</dl>';
    }
}