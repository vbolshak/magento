<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 18.03.16
 * Time: 13:22
 */



class Bvy_News_ViewController extends Mage_Core_Controller_Front_Action {


    public function viewAction()
    {

       $s=5;

        $this->loadLayout();
        //  $this->getLayout()->createBlock('news/news');
        $this->renderLayout();

    }

    public function indexAction(){
        $ar = [];
        $arCross = [];
        $object = Mage::getModel('catalog/product')->getCollection();
        foreach ($object as $product ) {
        $col = $product->getCrossSellProductIds();
        if ($col) {
            foreach ($col as $crossel) {
                $prodCross = Mage::getModel('catalog/product')->load($crossel);

                $arCross[] = array($crossel =>   $prodCross->getName());
            }
        }
        $ar[ $product->getEntityId()] =  $arCross;

        }

       file_put_contents( Mage::getBaseDir('media').'/ar.txt' , print_r($ar, true) );

    }
}