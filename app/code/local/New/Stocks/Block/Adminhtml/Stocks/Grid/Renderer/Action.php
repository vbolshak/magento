<?php


class New_Stocks_Block_Adminhtml_Stocks_Grid_Renderer_Action
    extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /**
     * 
     * make reference to Preview
     * @return type
     */
    public function render(Varien_Object $row)
    {
       
        $href = Mage::getUrl('stocks/index/view', array(
                '_current' => true,
                'stocks_id' => $row->getId()
            )); 
         
        return '<a href="'.$href.'" target="_blank">'.$this->__('Preview').'</a>';
    }
}