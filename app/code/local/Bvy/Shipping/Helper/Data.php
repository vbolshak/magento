<?php
class Bvy_Shipping_Helper_Data extends Mage_Core_Helper_Abstract {

    public function getExpressMaxWeight(){

       return Mage::getStoreConfig('carriers/bvy_shipping/express_max_weight');
    }
}