<?php

class New_Stocks_Block_Adminhtml_Stocks_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Load Wysiwyg on demand and Prepare layout
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }
    
    protected function _prepareForm()
    {

        $model = Mage::registry('stocks');

        /*
         * Checking if user have permissions to save information
         */
       
       
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }


        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('stocks_');

        $fieldset = $form->addFieldset('content_fieldset', array('legend'=>Mage::helper('stocks')->__('Information'),'class'=>'fieldset-wide'));
        $this->_addElementTypes($fieldset);
        
        $wysiwygConfig = Mage::getSingleton('cms/wysiwyg_config')->getConfig(
            array('tab_id' => $this->getTabId())
        );
        if ($model->getStocksId()) {
            $fieldset->addField('stocks_id', 'hidden', array(
                'name' => 'stocks_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('stocks')->__('Title'),
            'title'     => Mage::helper('stocks')->__('Title'),
            'required'  => true,
            'disabled'  => $isElementDisabled
        ));

         $fieldset->addField('summary', 'editor', array(
            'name'      => 'summary',
            'label'     => Mage::helper('stocks')->__('Summary'),
            'title'     => Mage::helper('stocks')->__('Summary'),
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));

        $fieldset->addField('content', 'editor', array(
            'name'      => 'content',
            'label'     => $this->__('Content'),
            'style'     => 'height:36em;',
            'required'  => true,
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));
        
        $fieldset->addField('image', 'image', array(
            'name'      => 'image',
            'label'     => Mage::helper('stocks')->__('Image'),
            'disabled'  => $isElementDisabled,
            'config'    => $wysiwygConfig
        ));


        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('stocks')->__('Status'),
            'title'     => Mage::helper('stocks')->__('Stocks Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => $model->getAvailableStatuses(),
            'disabled'  => $isElementDisabled,
        ));
        if (!$model->getId()) {
            $model->setData('is_active', $isElementDisabled ? '0' : '1');
        }
        
        $dateFormatIso = Mage::app()->getLocale()->getDateFormat(
            Mage_Core_Model_Locale::FORMAT_TYPE_SHORT
        );
        $fieldset->addField('start_time', 'date', array(
            'name'      => 'start_time',
            'label'     => Mage::helper('stocks')->__('Start Stocks'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => $dateFormatIso,
            'disabled'  => $isElementDisabled,
            'class'     => 'validate-date validate-date-range date-range-custom_theme-from'
        ));

        $fieldset->addField('end_time', 'date', array(
            'name'      => 'end_time',
            'label'     => Mage::helper('stocks')->__('End Stocks'),
            'image'     => $this->getSkinUrl('images/grid-cal.gif'),
            'format'    => $dateFormatIso,
            'disabled'  => $isElementDisabled,
            'class'     => 'validate-date validate-date-range date-range-custom_theme-to'
        ));

        Mage::dispatchEvent('adminhtml_news_edit_tab_content_prepare_form', array('form' => $form));

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Retrieve predefined additional element types
     * @return array
     */
    protected function _getAdditionalElementTypes()
    {
        return array(
            'image' => Mage::getConfig()->getBlockClassName('stocks/adminhtml_stocks_form_renderer_image')
        );
    }
    
    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('stocks')->__('Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('stocks')->__('Information');
    }

    /**
     * Returns status flag about this tab can be shown or not
     *
     * @return true
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns status flag about this tab hidden or not
     *
     * @return true
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('stocks/' . $action);
    }
}
