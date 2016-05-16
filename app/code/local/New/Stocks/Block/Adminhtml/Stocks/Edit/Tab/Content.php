<?php


class New_Stocks_Block_Adminhtml_Stocks_Edit_Tab_Content
    extends Mage_Adminhtml_Block_Widget_Grid       
    
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(false);
        $this->setUseAjax(true);
        
        //add default filter
        if ((int) $this->getRequest()->getParam('stocks_id', 0)) {
            $this->setDefaultFilter(array('in_products' => 1));
        }
        

    }

    /**
     * Add filter
     *
     * @param object $column
     * 
     */
    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in product flag
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                
                $this->getCollection()->addFieldToFilter('entity_id', array('in' => $productIds));
            } else {
                if($productIds) {
                    
                    $this->getCollection()->addFieldToFilter('entity_id', array('nin' => $productIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare collection
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
       
        $collection = Mage::getModel('catalog/product_link')->useRelatedLinks()
       
            ->getProductCollection()
            ->addAttributeToSelect('*');

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }


    /**
     * Add columns to grid
     *
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareColumns()
    {
     
        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'in_products',
            'values'            => $this->_getSelectedProducts(),
            'align'             => 'center',
            'index'             => 'entity_id'
        ));
        

        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('stocks')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header'    => Mage::helper('stocks')->__('Name'),
            'index'     => 'name'
        ));
        
          $this->addColumn('type', array(
            'header'    => Mage::helper('catalog')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name', array(
            'header'    => Mage::helper('catalog')->__('Attrib. Set Name'),
            'width'     => 130,
            'index'     => 'attribute_set_id',
            'type'      => 'options',
            'options'   => $sets,
        ));
        
        $this->addColumn('status', array(
            'header'    => Mage::helper('stocks')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('visibility', array(
            'header'    => Mage::helper('stocks')->__('Visibility'),
            'width'     => 90,
            'index'     => 'visibility',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));


        return parent::_prepareColumns();
    }
    
    /**
     * Retrieve selected products
     *
     * @return array
     */
    protected function _getSelectedProducts()
    {
      
        $products = $this->getProductsList();
        
        if (!is_array($products)) {
            $products = $this->getSelectedProducts();
        }

        return $products;
    }

    /**
     * 
     * Retrieve products
     */
    public function getSelectedProducts()
    {
       $id = $this->getRequest()->getParam('stocks_id');
                
       $stocks = Mage::getModel('stocks/stocks')->getCollection();
       $stocks->addFieldToFilter('stocks_id',$id);
       
       foreach($stocks as $value){
           $productIds = $value->getProductId();
       }
       //$productIds = Mage::registry('current_stocks')->getProductId();
       //$productIds = explode(',', $productIds);
       
       //$stocks->getProductId();
        if (isset($productIds)) {
       $productIds = explode(',', $productIds);
            return $productIds;
        }


    }
    
    /**
     * 
     * Rerieve grid URL
     */
    public function getGridUrl()
    {
        return $this->getData('grid_url')
            ? $this->getData('grid_url')
            : $this->getUrl('*/*/productGrid', array('_current' => true));
    }
    

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('stocks/' . $action);
    }
}
