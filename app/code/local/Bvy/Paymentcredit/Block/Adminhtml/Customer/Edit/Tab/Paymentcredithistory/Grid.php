<?php

class Bvy_Paymentcredit_Block_Adminhtml_Customer_Edit_Tab_Paymentcredithistory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bvy_paymmentcredithistory_grid');  //это просто идентификатор для верстки
        // $this->setDefaultSort('increment_id');
        //   $this->setDefaultDir('DESC');

        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $customerId = Mage::registry('current_customer')->getEntityId();
        if ($customerId) {
            $collection=  Mage::getModel('bvy_paymentcredit/paymenthistory')->getCollection()->customerFilter($customerId);
        }
//


        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('bvy_paymentcredit');


//        $this->addColumn('order_id', array(
//            'header'    => Mage::helper('bvy_paymentcredit')->__('order id'),
//            'align'     =>'right',
//            'width'     => '10px',
//            'index'     => 'order_id',
//        ));

        $this->addColumn('increment_id', array(
            'header'    => Mage::helper('bvy_paymentcredit')->__('order number'),
            'align'     =>'left',
            'index'     => 'increment_id',
            'width'     => '50px',
        ));

        $this->addColumn('total', array(
            'header'    => Mage::helper('bvy_paymentcredit')->__('Grand total'),
            'align'     =>'left',
            'index'     => 'total',
            'width'     => '50px',
        ));

        $this->addColumn('base_currency_code', array(
            'header'    => Mage::helper('bvy_paymentcredit')->__('currency'),
            'align'     =>'left',
            'index'     => 'base_currency_code',
            'width'     => '50px',
        ));

//
//
        $this->addColumn('type', array(
            'header'    => Mage::helper('bvy_paymentcredit')->__('type'),
            'align'     =>'left',
            'index'     => 'type',
            'width'     => '50px',
        ));
//

        $this->addColumn('created_at', array(
            'header'    => Mage::helper('bvy_paymentcredit')->__('created_at'),
            'align'     =>'left',
            'index'     => 'created_at',
            'width'     => '50px',
        ));

        $this->addColumn('comment', array(
            'header'    => Mage::helper('bvy_paymentcredit')->__('comment'),
            'align'     =>'left',
            'index'     => 'comment',
            'width'     => '50px',
        ));
//
//
//        $this->addColumn('text', array(
//            'header'    => Mage::helper('news')->__('text'),
//            'align'     =>'left',
//            'index'     => 'text',
//            'width'     => '50px',
//        ));
//
//        $this->addColumn('thumb', array(
//            'header'    => Mage::helper('news')->__('thumb'),
//            'align'     =>'left',
//            'renderer' => 'news/adminhtml_news_renderer_image',  //указываем класс блока, который будет рендерить картинку в гриде
//            'index'     => 'url_key',
//            'width'     => '50px',
//        ));
//
//        $this->addColumn('products', array(
//            'header'    => Mage::helper('news')->__('products'),
//            'align'     =>'left',
//            'index'     => 'products',
//            'width'     => '50px',
//        ));
//
//        $this->addColumn('layout', array(
//            'header'    => Mage::helper('news')->__('layout'),
//            'align'     =>'left',
//            'index'     => 'layout',
//            'width'     => '50px',
//        ));
//        return parent::_prepareColumns();
//


        return parent::_prepareColumns();
    }

//    public function getGridUrl()
//    {
//        return $this->getUrl('*/*/grid', array('_current'=>true));
//    }
//
//    /*
//     * click on the row in grid
//     */
//    public function getRowUrl($row)
//    {
//        return $this->getUrl('*/*/edit', array('news_id' => $row->getNewsId()));
//    }


    //добавляем блок груп. действий и определяем сами действия
    //getUrl('*/*/massDelete') указывает на имя экшена в контроллере
}