<?php
/**
*
 */

class New_Stocks_Block_Adminhtml_Stocks_Form_Renderer_Image extends Varien_Data_Form_Element_Image
{       
    /**
    * override method to get a link to an image
    */
    protected function _getUrl()
    {
        
        $url = false;
        if ($this->getValue()) {
            $url = Mage::getBaseUrl('media') .'stocks'. $this->getValue();
        }
       // var_dump($this->getValue());
        return $url;
    }
}
