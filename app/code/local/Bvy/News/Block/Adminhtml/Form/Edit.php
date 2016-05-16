<?php

//файл является контейнером для всей формы

class Bvy_News_Block_Adminhtml_Form_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Constructor
     */
    public function __construct()
{
    parent::__construct();
    $this->_blockGroup = 'news'; //указываем как групповое имя блока в конфиге
    $this->_controller = 'adminhtml_form';   //берем часть имени Adminhtml_Form из названия класса. Этим указываем что файлы формы, табы будут лежать в папке Form
    $this->_headerText = Mage::helper('news')->__('Edit Form');
}
}


?>