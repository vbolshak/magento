<?php
class New_Stocks_Model_Resource_Stocks extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('stocks/stocks', 'stocks_id');
    }

}
