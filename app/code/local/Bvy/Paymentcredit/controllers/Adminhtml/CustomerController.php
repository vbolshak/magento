<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 01.05.16
 * Time: 11:16
 */

require_once(Mage::getModuleDir('controllers','Mage_Adminhtml').DS.'CustomerController.php');


class Bvy_Paymentcredit_Adminhtml_CustomerController extends Mage_Adminhtml_CustomerController {




    public function paymentcredithistoryAction(){
        $this->_initCustomer();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('bvy_paymentcredit/adminhtml_customer_edit_tab_paymentcredithistory','admin.customer.custom')
                ->setUseAjax(true)
                ->toHtml()
        );
    }
}