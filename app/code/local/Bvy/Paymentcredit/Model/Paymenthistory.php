<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 29.04.16
 * Time: 16:14
 */

class Bvy_Paymentcredit_Model_Paymenthistory extends  Mage_Core_Model_Abstract{

    protected function _construct()
    {
        $this->_init('bvy_paymentcredit/paymenthistory');   //групповое имя это то, что указано в конфиге <models> , news это имя файла
    }



}
