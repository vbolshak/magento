<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 18.03.16
 * Time: 13:22
 */



class Bvy_News_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction()
    {


        $this->loadLayout();
     //  $this->getLayout()->createBlock('news/news');
        $this->renderLayout();

    }


}