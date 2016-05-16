<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 05.04.16
 * Time: 13:42
 */
//это форма, в которую потом добавим табы
class Bvy_News_Block_Adminhtml_Form_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Preparing form
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(
            array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save'),
                'method' => 'post',
                'enctype' => 'multipart/form-data',
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);

//        $helper = Mage::helper('news');
//        $fieldset = $form->addFieldset('display', array(
//            'legend' => $helper->__('Display Settings'),
//            'class' => 'fieldset-wide'
//        ));
//
//        $fieldset->addField('label', 'text', array(
//            'name' => 'label',
//            'label' => $helper->__('Label'),
//        ));
//
//        if (Mage::registry('bvy_news')) {
//            $form->setValues(Mage::registry('bvy_news')->getData());
//        }

        return parent::_prepareForm();
    }
}