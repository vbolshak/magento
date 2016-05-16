<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 24.04.16
 * Time: 15:09
 */


class Bvy_Paymentcredit_Block_Form_Paymentcredit extends Mage_Payment_Block_Form
{
    protected function _construct()
    {
        parent::_construct();
        $this->setTemplate('bvy_paymentcredit/form/paymentcredit.phtml');
    }
}
