<?php
class Bvy_Paymentcredit_Block_Info_Paymentcredit extends Mage_Payment_Block_Info
{

    //The _prepareSpecificInformation() is basically called by magento, to get an object which has the information we need to display. -
    //The default phtml file used to display this information is ‘app\design\frontend\base\default\template\payment\info\default.phtml’ -
    protected function _prepareSpecificInformation($transport = null)
    {
        if (null !== $this->_paymentSpecificInformation) {
            return $this->_paymentSpecificInformation;
        }
        $info = $this->getInfo();
        $transport = new Varien_Object();
        $transport = parent::_prepareSpecificInformation($transport);
        $transport->addData(array(
            Mage::helper('bvy_paymentcredit')->__('Comment#') => $info->getComment(),

        ));
        return $transport;
    }
}
