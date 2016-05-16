<?php
class Bvy_Paymentcredit_Model_Resource_Paymenthistory_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    //нужно создать для возможности получения коллекции/ Всегда лежит в папке с именем модели. в нашем случае paymenthistory
    public function _construct()
    {
        $this->_init('bvy_paymentcredit/paymenthistory');
    }



    public function customerFilter($customerId){

     //  $this->getSelect()->where('main_table.customer_id = ?', $customerId);
       $this->getSelect()->where('main_table.customer_id = ?', $customerId)
           ->join($this->getTable('sales/order'), 'main_table.order_id =sales_flat_order.entity_id ')
           ->join( $this->getTable('sales/order_payment'),'sales_flat_order_payment.parent_id = main_table.order_id');
        return $this;
    }
}