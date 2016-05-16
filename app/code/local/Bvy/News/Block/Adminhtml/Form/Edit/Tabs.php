<?php

//в этом файле мы перечисляем какие табы мы добавляем. Непосредственно самы табы будут в папке Tab
class Bvy_News_Block_Adminhtml_Form_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

/**
* Constructor
*/
public function __construct()
{
parent::__construct();
$this->setId('edit_home_tabs'); //даем айди нашей табе
$this->setDestElementId('edit_form'); //указываем айди родителькой формы в которую мы сетим нашу табу
$this->setTitle(Mage::helper('news')->__('Form Tabs'));
}

/**
* add tabs before output
*
* @return
*/
protected function _beforeToHtml()
{//первый параметр это идентификатор табы.
$this->addTab('information', array(
'label' => Mage::helper('news')->__('Information'),
'title' => Mage::helper('news')->__('Information'),
'content' => $this->getLayout()->createBlock('news/adminhtml_form_edit_tab_information')->toHtml(),
));

//$this->addTab('products', array(
//        'label' => Mage::helper('news')->__(' Attached products'),
//        'title' => Mage::helper('news')->__(' Attached products'),
//        'content' => $this->getLayout()->createBlock('news/adminhtml_form_edit_tab_products')->toHtml(),
//    ));
//
//
$this->addTab('products', array(
            'label'     => Mage::helper('news')->__('Products'),
            'title'     => Mage::helper('news')->__('Products'),
            'url'       => $this->getUrl('*/*/products', array('_current' => true)),
            'class'     => 'ajax',
));

return parent::_beforeToHtml();
}


}

?>