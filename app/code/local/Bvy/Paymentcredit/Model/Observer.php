<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 24.04.16
 * Time: 18:18
 */


class Bvy_Paymentcredit_Model_Observer {


    public function addDefaultCredit($observer) {

        $customer = $observer->getCustomer();
        $customer->setCustomerscredit(300)
            ->save();

        Mage::getSingleton('core/session')->addNotice('You have 300 credits dollars');


    }

//observe method order after save
//get customer balance and order cost. If order cost more than balance then payment method wouldn't show
//save payment history to DB
    public function deductCreditBalanse($observer) {

        $order = $observer->getData('order');
        $orderCost = $order->getGrandTotal();
        $customer = $observer->getOrder()->getCustomer();
        $balanse = $customer->getCustomerscredit() - $orderCost ;
        if ($balanse>=0) {
            $customer->setCustomerscredit($balanse )
                ->save();
        }
        else {
            Mage::getSingleton('core/session')->addNotice('You limit is not allow make this payment');
        }

        $modelPaymentHistory = new Bvy_Paymentcredit_Model_Paymenthistory();
        $data = ['order_id' =>  $order->getData('entity_id'),
                 'total'    =>  $order->getData('grand_total'),
                 'type'     =>  $order->getData('status'),
                 'customer_id' => $customer->getData('entity_id')];
        $modelPaymentHistory->setData($data)->save();
        $this->createInvoice($order);

    }


    public function createInvoice($order){

        try {
            if(!$order->canInvoice())
            {
                Mage::throwException(Mage::helper('core')->__('Cannot create an invoice.'));
            }

            $invoice = Mage::getModel('sales/service_order', $order)->prepareInvoice();

            if (!$invoice->getTotalQty()) {
                Mage::throwException(Mage::helper('core')->__('Cannot create an invoice without products.'));
            }

            $invoice->setRequestedCaptureCase(Mage_Sales_Model_Order_Invoice::CAPTURE_ONLINE);
            $invoice->register();
            $transactionSave = Mage::getModel('core/resource_transaction')
                ->addObject($invoice)
                ->addObject($invoice->getOrder());

            $transactionSave->save();
        }
        catch (Mage_Core_Exception $e) {

        }



    }

//inject tab if customer have history
    public function injectTabs($observer){


            $block = $observer->getEvent()->getBlock();
            // add tab in customer edit page
            if ($block instanceof Mage_Adminhtml_Block_Customer_Edit_Tabs)
            {
                if ($this->_getRequest()->getActionName() == 'edit' || $this->_getRequest()->getParam('type'))
                {
                    if ( $this->isShowTabHistory()){
                    $block->addTabAfter('paymentcredithistory', array('label'=> Mage::helper('customer')->__('View payment history'),'url'=> $block->getUrl('*/*/paymentcredithistory', array('_current' => true)),'class'=> 'ajax'),'tags');
                    }
                }
            }

    }

    //i определил method will use when inject tabs
    protected function _getRequest()
    {
        return Mage::app()->getRequest();
    }

    protected function isShowTabHistory(){

        $customer = Mage::app()->getRequest()->getParams()['id'];
        if ($customer){
            if (count(Mage::getModel('bvy_paymentcredit/paymenthistory')->getCollection()->customerFilter($customer))) {
                return true;
            }
        }
    }
}