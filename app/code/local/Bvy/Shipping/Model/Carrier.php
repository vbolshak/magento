<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 21.04.16
 * Time: 14:48
 */

class Bvy_Shipping_Model_Carrier  extends Mage_Shipping_Model_Carrier_Abstract implements Mage_Shipping_Model_Carrier_Interface

{
    protected $_code = 'bvy_shipping';

    public function getAllowedMethods()
    {
        return array(
            'standard'    =>  'Standard delivery',
            'express'     =>  'Express delivery',
        );
    }

    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {

        /** @var Mage_Shipping_Model_Rate_Result $result */
        $result = Mage::getModel('shipping/rate_result');

        /** @var Bvy_Shipping_Helper_Data $expressMaxProducts */
        $expressMaxWeight = Mage::helper('bvy_shipping')->getExpressMaxWeight();

        $expressAvailable = true;
        foreach ($request->getAllItems() as $item) {
            if ($item->getWeight() > $expressMaxWeight) {
                $expressAvailable = false;
            }
        }

        if ($expressAvailable) {
            $result->append($this->_getExpressRate());
        }
        $result->append($this->_getStandardRate());

        return $result;
    }


    protected function _getStandardRate()
    {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('large');
        $rate->setMethodTitle('Standard delivery');
        $rate->setPrice(1.23);
        $rate->setCost(0);

        return $rate;
    }


    protected function _getExpressRate()
    {
        /** @var Mage_Shipping_Model_Rate_Result_Method $rate */
        $rate = Mage::getModel('shipping/rate_result_method');

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));
        $rate->setMethod('large');
        $rate->setMethodTitle('non Standard delivery');
        $rate->setPrice(1.23);
        $rate->setCost(0);

        return $rate;
    }


}