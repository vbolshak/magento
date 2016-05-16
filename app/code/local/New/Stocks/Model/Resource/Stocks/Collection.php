<?php
class New_Stocks_Model_Resource_Stocks_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    /**
     * Define resource model
     *
     */
    protected function _construct()
    {
        $this->_init('stocks/stocks');
    }
    
}
