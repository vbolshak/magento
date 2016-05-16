<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 05.04.16
 * Time: 14:25
 */
class Bvy_News_Block_Adminhtml_Form_Edit_Tab_Information extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * prepare form in tab
     */
    protected function _prepareForm()
    {

        $model = Mage::registry('current_news');
        $form = new Varien_Data_Form();
//        $form->setHtmlIdPrefix('information_');
//        $form->setFieldNameSuffix('information');

        $this->setForm($form);
        $fieldset = $form->addFieldset('form_information',               array('legend'=>Mage::helper('news')->__('Item information')));

        //добавим скрытое поле чтобы можно было получить айди строки
        if ($model->getNewsId()) {
            $fieldset->addField('news_id', 'hidden', array(

                'name'      => 'news_id',

            ));
        }




        $fieldset->addField('titul', 'text', array(
            'label'     => Mage::helper('news')->__('Title'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'titul',
        ));
        $fieldset->addField('tezis', 'text', array(
            'label'     => Mage::helper('news')->__('Tezis'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'tezis',
        ));
        $fieldset->addField('status', 'select', array(
            'name'      => 'status',
            'label'     => Mage::helper('news')->__('News is'),
            'id'        => 'status',
            'title'     => Mage::helper('news')->__('News status'),
            'class'     => 'input-select',
            'style'        => 'width: 80px',
            'options'    => array( '0' => Mage::helper('news')->__('Disable'), '1' => Mage::helper('news')->__('Active'),),
        ));

        $widgetFilters = array('is_email_compatible' => 1);
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(array('widget_filters' => $widgetFilters));

        $fieldset->addField('text', 'editor', array(
            'name'      => 'text',
            'label'     => Mage::helper('news')->__('News Content'),
            'title'     => Mage::helper('news')->__('News Content'),
            'required'  => true,
            'state'     => 'html',
            'style'     => 'height:36em;',
            'value'     =>"",
            'config'    => $wysiwygConfig
        ));
        $fieldset->addField('data_start', 'date', array(
            'name'      => 'data_start',
            'label'     => Mage::helper('news')->__('Date from'),
            'after_element_html' => '<small></small>',
            'tabindex' => 1,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));

        $fieldset->addField('data_end', 'date', array(
            'name'      => 'data_end',
            'label'     => Mage::helper('news')->__('Date to'),
            'after_element_html' => '<small></small>',
            'tabindex' => 1,
            'image' => $this->getSkinUrl('images/grid-cal.gif'),
            'format' => Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT)
        ));
//        $fieldset->addField('image', 'image', array(
//            'value'     => 'http://www.excellencemagentoblog.com/wp-content/themes/excelltheme/images/logo.png',
//        ));
        $fieldset->addField('file_path', 'file', array(
            'label' => Mage::helper('news')->__('File'),
            'value'  => '',
            'class' => 'required-entry',
            'disabled' => false,
            'readonly' => true,
            'name' => 'file_path',

        ));


        if ( Mage::registry('current_news') )
        {
            $form->setValues(Mage::registry('current_news')->getData());
        }
        return parent::_prepareForm();
    }
 }
