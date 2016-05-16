<?php

class New_Stocks_Block_Adminhtml_Stocks_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('stocks_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('stocks')->__('Information'));
    }

     protected function _beforeToHtml() {
       
        $this->addTab('Attached products', array(
        'label' => Mage::helper('stocks')->__('Attached products'),
        'url'   => Mage::getUrl('*/*/products', array('_current' => true)),
        'class' => 'ajax'
    ),'stocks_edit_tab_main');
        parent::_beforeToHtml();

     }
}
