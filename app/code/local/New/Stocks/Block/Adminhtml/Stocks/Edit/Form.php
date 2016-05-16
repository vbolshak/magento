<?php

class New_Stocks_Block_Adminhtml_Stocks_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Create a form content block
     * The form item will be added by Tabs block
     */
    protected function _prepareForm()
    {
        $stocks = Mage::registry('stocks');
        //создаем объект типа Varien_Data_Form
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('block_id' => $stocks->getId())),
            'method' => 'post',
            'enctype' => 'multipart/form-data',
            ));
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
