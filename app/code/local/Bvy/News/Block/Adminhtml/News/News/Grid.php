<?php

class Bvy_News_Block_Adminhtml_News_News_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('bvy_news_news_grid');  //это просто идентификатор для верстки
        $this->setDefaultSort('increment_id');
     //   $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bvy_news/news')->getCollection();
        ;

        $this->setCollection($collection);
        parent::_prepareCollection();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('news');


        $this->addColumn('news_id', array(
            'header'    => Mage::helper('news')->__('ID'),
            'align'     =>'right',
            'width'     => '10px',
            'index'     => 'news_id',
        ));

        $this->addColumn('titul', array(
            'header'    => Mage::helper('news')->__('titul'),
            'align'     =>'left',
            'index'     => 'titul',
            'width'     => '50px',
        ));


        $this->addColumn('data_start', array(
            'header'    => Mage::helper('news')->__('data start'),
            'width'     => '30px',
            'index'     => 'data_start',
        ));

        $this->addColumn('data_end', array(
            'header'    => Mage::helper('news')->__('data_end'),
            'width'     => '30px',
            'index'     => 'data_end',
        ));

        $this->addColumn('url_key', array(
            'header'    => Mage::helper('news')->__('url key'),
            'align'     =>'left',
            'index'     => 'url_key',
            'width'     => '50px',
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('news')->__('status'),
            'align'     =>'left',
            'index'     => 'status',
            'width'     => '50px',
        ));

        $this->addColumn('tezis', array(
            'header'    => Mage::helper('news')->__('tezis'),
            'align'     =>'left',
            'index'     => 'tezis',
            'width'     => '50px',
        ));


        $this->addColumn('text', array(
            'header'    => Mage::helper('news')->__('text'),
            'align'     =>'left',
            'index'     => 'text',
            'width'     => '50px',
        ));

        $this->addColumn('thumb', array(
            'header'    => Mage::helper('news')->__('thumb'),
            'align'     =>'left',
            'renderer' => 'news/adminhtml_news_renderer_image',  //указываем класс блока, который будет рендерить картинку в гриде
            'index'     => 'url_key',
            'width'     => '50px',
        ));

        $this->addColumn('products', array(
            'header'    => Mage::helper('news')->__('products'),
            'align'     =>'left',
            'index'     => 'products',
            'width'     => '50px',
        ));

        $this->addColumn('layout', array(
            'header'    => Mage::helper('news')->__('layout'),
            'align'     =>'left',
            'index'     => 'layout',
            'width'     => '50px',
        ));
        return parent::_prepareColumns();




        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    /*
     * click on the row in grid
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('news_id' => $row->getNewsId()));
    }


    //добавляем блок груп. действий и определяем сами действия
    //getUrl('*/*/massDelete') указывает на имя экшена в контроллере
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('news_id');
        $this->getMassactionBlock()->setFormFieldName('news');  //news по этому имени будем получать параметры

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('news')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('news')->__('Are you sure?')
        ));


        $this->getMassactionBlock()->addItem('disable', array(
            'label'=> Mage::helper('news')->__('Disable'),
            'url'  => $this->getUrl('*/*/massDisable', array('_current'=>true)),
            'confirm'  => Mage::helper('news')->__('Are you sure?')
        ));


        $this->getMassactionBlock()->addItem('enable', array(
            'label'=> Mage::helper('news')->__('Enable'),
            'url'  => $this->getUrl('*/*/massEnable', array('_current'=>true)),
            'confirm'  => Mage::helper('news')->__('Are you sure?')
        ));


        return $this;


    }

}