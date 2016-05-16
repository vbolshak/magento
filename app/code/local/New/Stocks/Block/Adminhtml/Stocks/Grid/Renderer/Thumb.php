<?php

class New_Stocks_Block_Adminhtml_Stocks_Grid_Renderer_Thumb
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * 
     */
    public function render(Varien_Object $row)
    {
       
        $helper = Mage::helper('stocks/image');
        $helper->init($row, 'image')
            ->keepAspectRatio(true);
        
        return sprintf('<img src="%s" />', $helper->resize(200,200));
    }
}
