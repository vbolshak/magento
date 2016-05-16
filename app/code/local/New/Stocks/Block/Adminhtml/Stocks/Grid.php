<?php

class New_Stocks_Block_Adminhtml_Stocks_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        
        parent::__construct();
        $this->setId('stocksGrid');
        $this->_controller = 'adminhtml_stocks';
        $this->setDefaultDir('ASC');
    }
    
    protected function _prepareCollection()
    {
        
        $collection = Mage::getModel('stocks/stocks')->getCollection();
        $this->setCollection($collection);
        
        return parent::_prepareCollection();
    }
   
    protected function _prepareColumns()
    {
        $dateFormatIso = Mage::app()->getLocale() ->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        // Add the columns that should appear in the grid
        $baseUrl = $this->getUrl();
        $this->addColumn('stocks_id', array(
            'header'        => Mage::helper('stocks')->__('ID'),
            'align'         => 'right',
            'width'         => '20px',
            'index'         => 'stocks_id'
        ));
        $this->addColumn('title', array(
            'header'    => Mage::helper('stocks')->__('Title'),
            'align'     => 'left',
            'index'     => 'title',
        ));

        
        $this->addColumn('start_time', array(
            'header'    => Mage::helper('stocks')->__('Start Stock'),
            'index'     => 'start_time',
            'type'      => 'date',
            'format' => $dateFormatIso,
        ));
        
        $this->addColumn('end_time', array(
            'header'    => Mage::helper('stocks')->__('End Stock'),
            'index'     => 'end_time',
            'type'      => 'date',
            'format' => $dateFormatIso,
        ));
        
        $this->addColumn('is_active', array(
            'header'    => Mage::helper('stocks')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('stocks')->__('Disabled'),
                1 => Mage::helper('stocks')->__('Enabled')
            ),
        ));
        
        $this->addColumn('summary', array(
            'header'    => Mage::helper('stocks')->__('Summary'),
            'align'     => 'left',
            'index'     => 'summary',
        ));
              
        $this->addColumn('image', array(
            'header'    => Mage::helper('stocks')->__('Thumb image'),
            'align'     => 'center',
            'index'     => 'image',
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => 'stocks/adminhtml_stocks_grid_renderer_thumb',
        ));
        
       
        $this->addColumn('page_actions', array(
            'header'    => Mage::helper('stocks')->__('Action'),
            'width'     => 10,
            'sortable'  => false,
            'filter'    => false,
            'renderer'  => 'stocks/adminhtml_stocks_grid_renderer_action',
        ));

        return parent::_prepareColumns();
    }
    
    /**
     * 
     * 
     */
    protected function _prepareMassaction()
    {
        //set massaction row identifier field
        $this->setMassactionIdField('stocks_id');
        //retrive massaction block and set global form field name for all massaction items
        $this->getMassactionBlock()->setFormFieldName('stocks');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('stocks')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('stocks')->__('Are you sure?')
        ));
           
        $statuses = Mage::getModel('stocks/stocks')->getAvailableStatuses();
       
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('stocks')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('stocks')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        
        return $this;
    }
    
     /**
     * Row click url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
         // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('stocks_id' => $row->getId()));
    }

}