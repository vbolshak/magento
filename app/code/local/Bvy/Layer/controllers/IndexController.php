<?php
//в этом модуле я делаю загрузку блока аяксом
class Bvy_Layer_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {




         $confProduct = Mage::getModel('catalog/product')->load(402);

        $childProducts = Mage::getModel('catalog/product_type_configurable')
            ->getUsedProducts(null,$confProduct);
        $b = Mage::getModel('catalog/product_type_configurable')
            ->getChildrenIds(402);
        $this->loadLayout();


        $this->renderLayout();
    }


    public function ajaxAction()
    {

        $d=7;
        $this->getResponse()->setBody($cont = file_get_contents("http://news.finance.ua/ru/news/-/375200/zhiteli-chehii-ohotno-vzhivlyayut-v-telo-nfc-chipy #news-body"));



    }



}