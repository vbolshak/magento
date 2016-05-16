<?php

class New_Stocks_IndexController extends Mage_Core_Controller_Front_Action
{
    /**
     * Stocks list action
     */
     public function listAction()
    {
        
        $this->loadLayout();
        $this->renderLayout();
        
    }
    
    /**
     *  Stocks views action
     */
    public function viewAction()
    {
        if ($this->_initStocks()) {
            
            $this->loadLayout();
            $this->renderLayout();
        } else {
            $this->_forward('noRoute');
        }
    }
    
     /**
     * Inits stocks object to work with
     * check Referer and check for membership to store
     */
    protected function _initStocks()
    {
        $id = $this->getRequest()->getParam('stocks_id');
                
        $stocks = Mage::getModel('stocks/stocks')->load($id);
        
            // Register model to use later in blocks
            
            Mage::register('stocks', $stocks);
            return $stocks;
    }
    
}
