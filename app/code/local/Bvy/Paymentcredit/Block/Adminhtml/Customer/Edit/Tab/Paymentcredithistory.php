<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 01.05.16
 * Time: 11:26
 */


class Bvy_Paymentcredit_Block_Adminhtml_Customer_Edit_Tab_Paymentcredithistory extends Mage_Adminhtml_Block_Widget_Grid_Container

{
    public function __construct()
    {
        $this->_blockGroup = 'bvy_paymentcredit';   //группое имя блока, как задано в конфиге <blocks>
        $this->_controller = 'adminhtml_customer_edit_tab_paymentcredithistory';  //указываем путь этого-же класса
        $this->_headerText = Mage::helper('bvy_paymentcredit')->__('Payment history');

        parent::__construct();

    }
}