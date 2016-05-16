<?php

class Bvy_News_Block_Adminhtml_Form_Edit_Tab_Productgrid extends Mage_Adminhtml_Block_Widget_Grid
{


    public function __construct()
    {
        parent::__construct();
        $this->setId('tab_products');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
        $this->setSaveParametersInSession(false);

        //add default filter
        if ((int) $this->getRequest()->getParam('news_id', 0)) {
            $this->setDefaultFilter(array('in_products' => 1));
        }
    }


    public function getCategory()
    {
        return Mage::registry('tab_info');
    }


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

    protected function _prepareCollection()
    {

        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addStoreFilter($this->getRequest()->getParam('store'));

        $this->setCollection($collection);



        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('in_products', array(
            'header_css_class'  => 'a-center',
            'type'              => 'checkbox',
            'name'              => 'customer',
            'values'            => $this->_getSelectedProducts(),
            'align'             => 'center',
            'index'             => 'entity_id'
        ));


        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('news')->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ));
        $this->addColumn('position', array(
            'header'            => Mage::helper('news')->__('ID'),
            'name'              => 'position',
            'width'             => 60,
            'type'              => 'number',
            'validate_class'    => 'validate-number',
            'index'             => 'position',
            'editable'          => true,
            'edit_only'         => true
        ));


        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ));
        $this->addColumn('price', array(
            'header'    => Mage::helper('catalog')->__('Price'),
            'type'  => 'currency',
            'width'     => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'     => 'price'
        ));


        return parent::_prepareColumns();
    }



//используется при аякс запросах внутри грида. указывается имя экшена из контроллера.
    public function getGridUrl()
    {
        return $this->getUrl('*/*/productgrid', array('_current'=>true));
    }




    protected function getSelectedProducts()
    {

        $id = $this->getRequest()->getParam('news_id');

        $stocks = Mage::getModel('bvy_news/news')->getCollection();
        $stocks->addFieldToFilter('news_id',$id);

        foreach($stocks as $value){
            $productIds = $value->getProducts();
        }


        if (isset($productIds)) {
            $productIds = explode(',', $productIds);
            return $productIds;
        }


    }

    protected function _getSelectedProducts(){

        //получаем данные из атрибута products_list который определили в лаяуте и присвоили значение в контроллере
        $products = $this->getProductsList();

        if (!is_array($products)) {
            $products = $this->getSelectedProducts();
        }

        return $products;

    }


}