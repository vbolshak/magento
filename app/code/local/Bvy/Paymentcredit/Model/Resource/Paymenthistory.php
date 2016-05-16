<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 29.04.16
 * Time: 15:09
 */

class Bvy_Paymentcredit_Model_Resource_Paymenthistory extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('bvy_paymentcredit/paymenthistory', 'paymenthistory_id');
    }
}