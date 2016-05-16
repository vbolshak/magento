<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 22.04.16
 * Time: 15:26
 */

class Bvy_Paymentcredit_Model_Paymentcredit extends Mage_Payment_Model_Method_Abstract
{
    protected $_code = 'paymentcredit';
    //добавим форму для ввода параметров на шаге пеймент
    protected $_formBlockType = 'bvy_paymentcredit/form_paymentcredit';
    protected $_infoBlockType = 'bvy_paymentcredit/info_paymentcredit';

//The function assignData($data) is called, when we click the ‘Continue’ button in the checkout Payment Step. -
    public function assignData($data)
    {
        if (!($data instanceof Varien_Object)) {
            $data = new Varien_Object($data);
        }
        //The $this->getInfoInstance() returns an object of class Mage_Payment_Model_Info, this object is used in many places and is considered to have the information of a payment method. -
        $info = $this->getInfoInstance();
        //магические геттеры и сетеры. берем имя своего параметра из формы
        $info->setComment($data->getComment());

        return $this;
    }


    public function validate()
    {
        parent::validate();

        $info = $this->getInfoInstance();

        $comment = $info->getComment();

        $errorMsg = '';
        if(empty($comment) ){
            $errorCode = 'invalid_data';
            $errorMsg = $this->_getHelper()->__('Comment is required field');
        }

        if($errorMsg){
            Mage::throwException($errorMsg);
        }
        return $this;
    }


    public function getTitle(){

        $quote = Mage::getSingleton('checkout/cart')->getQuote();
        $currencySymbol = Mage::app()->getLocale()->currency($quote->getQuoteCurrencyCode())->getSymbol();

        return parent::getTitle()."( ". $this->getAvailableCredit() . " $currencySymbol)";
    }

    public function getQuateMinusCredit(){

        if(Mage::getSingleton('customer/session')->isLoggedIn()) {

            $quote = Mage::getSingleton('checkout/cart')->getQuote();
            $quoteData= $quote->getData();
            $grandTotal=$quoteData['grand_total'];


            $balanse = $this->getAvailableCredit() - $grandTotal ;


            return $balanse;
        }
    }

    public function getAvailableCredit(){
        $customer = Mage::getSingleton('customer/session')->getCustomer();
        return $customer->getCustomerscredit();
    }




    public function isAvailable($quote = null)
    {
        $checkResult = new StdClass;
        $isActive = (bool)(int)$this->getConfigData('active', $quote ? $quote->getStoreId() : null);
        $checkResult->isAvailable = $isActive;
        $checkResult->isDeniedInConfig = !$isActive; // for future use in observers
        Mage::dispatchEvent('payment_method_is_active', array(
            'result'          => $checkResult,
            'method_instance' => $this,
            'quote'           => $quote,
        ));

        if ($checkResult->isAvailable && $quote ) {
            $checkResult->isAvailable = $this->isApplicableToQuote($quote, self::CHECK_RECURRING_PROFILES);
        }

        if ($this->getQuateMinusCredit()<0) {
            $checkResult->isAvailable = false;
        }
        return $checkResult->isAvailable;
    }

}
?>
