<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 31.03.16
 * Time: 11:42
 */
class Bvy_News_Block_Adminhtml_News_News extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'news';   //группое имя блока, как задано в конфиге <blocks>
        $this->_controller = 'adminhtml_news_news';  //указываем путь этого-же класса
        $this->_headerText = Mage::helper('news')->__('news - bvy');

        parent::__construct();

    }
}