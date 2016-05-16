<?php


class New_Stocks_Block_Adminhtml_Stocks extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * block grid container
     */
    public function __construct()
    {        
        $this->_blockGroup = 'stocks';
        //where is the controller
        $this->_controller = 'adminhtml_stocks';
        $this->_headerText = $this->__('Stocks');
        $this->_addButtonLabel = $this->__('Add Stocks');
        parent::__construct();
    }

}