<?php

class New_Stocks_Block_List extends Mage_Core_Block_Template
{
    protected $_collection;
    
    public function getStocksCollection()
    {
        if (!$this->_collection) {
            $currentStore = Mage::app()->getStore()->getStoreId();

            $stocksCollection = Mage::getModel('stocks/stocks')->getCollection();
            $stocksCollection->addFieldToFilter('is_active',true)
                ->setOrder('stocks_id', 'DESC');
          

            $this->_collection = $stocksCollection;
        }

        return $this->_collection;
    }
  
    protected function _prepareLayout()
    {
        $breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')
                ->addCrumb('home', array('label'=>Mage::helper('cms')->__('Home'), 'title'=>Mage::helper('cms')->__('Go to Home Page'), 'link'=>Mage::getBaseUrl()))
                ->addCrumb('stocks list', array('label'=>'Stocks List', 'title'=>'Stocks List'));
       

        return parent::_prepareLayout();
    }

    
    protected function _beforeToHtml()
    {
       //create block pager
        $pager = $this->getLayout()->createBlock('page/html_pager', 'stocks.pager');
        
        $collection = $this->getStocksCollection();
        //get config value 
        $config = Mage::getStoreConfig('stocks/pagination/pagination');
        
        $config = explode(',', $config);
        //set limit on collection
       
        $pager->setAvailableLimit(array(
            
            $config[0] => $config[0],
            $config[1] => $config[1],
            $config[2] => $config[2]
            ));
                

        // set collection to toolbar
        $pager->setCollection($collection);
        // set child block      
        $this->setChild('stocks.pager', $pager);

        return $this;
    }

    /**
     * 
     * Retrieve child block HTML
     */
    public function getPagerHtml()
    {
        return $this->getChildHtml('stocks.pager');
    }
   
}
