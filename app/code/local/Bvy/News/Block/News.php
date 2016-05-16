<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 26.03.16
 * Time: 20:44
 */

class Bvy_News_Block_News extends Mage_Core_Block_Template{

    public function __construct(){
    $f=55;
}

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        // добавим пейджер в блок и засетим ему коллекцию
        $pager = $this->getLayout()->createBlock('page/html_pager', 'your.custom.blockname.pager')
            ->setCollection($this-> getNewsCollection()); //call your own collection getter here, name it something better than getCollection, please; *or* your call to getResourceModel()
        $this->setChild('pager', $pager);
        return $this;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }

    public function getNewsCollection()
    {
        $collection = Mage::getModel('bvy_news/news')->getCollection();
        $collection-> addFieldToFilter('status','1');

        return $collection;
    }

    public function getSingleNews(){

        $f=33;
       return $news = Mage::getModel('bvy_news/news')->load($this->getRequest()->getParams('id'));
    }
}