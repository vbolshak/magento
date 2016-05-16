<?php
class New_Stocks_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function filterHtml($html)
    {
        $helper = Mage::helper('cms');
        /*Retrieve Template processor for Block Content*/
        $processor = $helper->getBlockTemplateProcessor();

        return $processor->filter($html);
        
    }   
   
}
