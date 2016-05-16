<?php



class New_Stocks_Adminhtml_StocksController extends Mage_Adminhtml_Controller_Action
{
    
    protected function _initStocks()
    {
        $id = $this->getRequest()->getParam('stocks_id');
                
        $stocks = Mage::getModel('stocks/stocks')->load($id);
        
        // Register model to use later in blocks

        Mage::register('current_stocks', $stocks);

        return $stocks;
    }
    /**
     * 
     *  this method will set some basic params for each action

     */
     protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('stocks')
            ->_addBreadcrumb(Mage::helper('stocks')->__('Stocks'), Mage::helper('stocks')->__('Stocks'))
            
        ;
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {
       $this->_title($this->__('Stocks'));


        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Create new Stocks page
     */
    public function newAction()
    {
         $this->_forward('edit');
    }

    /**
     * Edit Stocks
     */
    public function editAction()
    {
        
        $this->_title($this->__('Stocks'));

        //get ID and create model
        $id = $this->getRequest()->getParam('stocks_id');
       
        $model = Mage::getModel('stocks/stocks');

        //initial checking
        if ($id) {
          
           $model->load($id);
            if (! $model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(
                    Mage::helper('stocks')->__('This stock no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        
        $this->_title($model->getId() ? $model->getTitle() : $this->__('New Stocks'));

        //set entered data if was error when we do save
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (! empty($data)) {
            $model->setData($data);
        }

        //register model to use later in blocks
        Mage::register('stocks', $model);

        //build edit form
        $this->_initAction()
            ->_addBreadcrumb(
                $id ? Mage::helper('stocks')->__('Edit Stocks')
                    : Mage::helper('stocks')->__('New Stocks'),
                $id ? Mage::helper('stocks')->__('Edit Stocks')
                    : Mage::helper('stocks')->__('New Stocks'));

        $this->renderLayout();
    }

   
    
    /**
     * Save action
     */
    public function saveAction()
    {   
        
        // check if data sent
        if ($data = $this->getRequest()->getPost()) {
            $data = $this->_filterPostData($data);
            //init model and set data
            $model = Mage::getModel('stocks/stocks');

            if ($id = $this->getRequest()->getParam('stocks_id')) {
                $model->load($id);
            }

           
            //for the resize image
            $helper = Mage::helper('stocks/image');
            $helper ->init($model,'image')
                    ->keepAspectRatio(true)
                    ->resize(200);
            
            $model->setData($data);
            //Handles file upload on admin pages
            $model->uploadFiles();
            Mage::dispatchEvent('stocks_prepare_save', array('stocks' => $model, 'request' => $this->getRequest()));
            //validating
            if (!$this->_validatePostData($data)) {
                $this->_redirect('*/*/edit', array('stocks_id' => $model->getId(), '_current' => true));
                return;
            }
            
            $products = $this->getRequest()->getPost('product_id');
            
            $decodeProducts = Mage::helper('adminhtml/js')->decodeGridSerializedInput($products);
           
            $productsIds = implode(',', $decodeProducts);
                        
                    
            $model->setData('product_id',$productsIds);
          
            
            // try to save it
            try {
                
                // save the data
                $model->save();

                // display success message
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('stocks')->__('The stocks has been saved.'));
                // clear previously saved data from session
                Mage::getSingleton('adminhtml/session')->setFormData(false);
                // check if 'Save and Continue'
                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('stocks_id' => $model->getId(), '_current'=>true));
                    return;
                }
                // go to grid
                $this->_redirect('*/*/');
                return;

            } catch (Mage_Core_Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
            catch (Exception $e) {
                $this->_getSession()->addException($e,
                    Mage::helper('stocks')->__('An error occurred while saving the stocks.'));
            }

            $this->_getSession()->setFormData($data);
            $this->_redirect('*/*/edit', array('stocks_id' => $this->getRequest()->getParam('stocks_id')));
            return;
        }
        $this->_redirect('*/*/');
    }
    

    /**
     * Delete action
     */
    public function deleteAction()
    {
        // check if we know what should be deleted
        if ($id = $this->getRequest()->getParam('stocks_id')) {
            $title = "";
            try {
                // init model and delete
                $model = Mage::getModel('stocks/stocks');
                $model->load($id);
                $title = $model->getTitle();
                $model->delete();
                // display success message
                Mage::getSingleton('adminhtml/session')->addSucces(Mage::helper('stocks')->__('The stocks has been deleted.'));
                // go to grid
                
                $this->_redirect('*/*/');
                return;

            } catch (Exception $e) {
                
                // display error message
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                // go back to edit form
                $this->_redirect('*/*/edit', array('stocks_id' => $id));
                return;
            }
        }
        // display error message
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stocks')->__('Unable to find a stock to delete.'));
        // go to grid
        $this->_redirect('*/*/');
    }

    public function massDeleteAction()
    {
        $stocksIds = $this->getRequest()->getParam('stocks');
     
        if (!is_array($stocksIds)) {
            $this->_getSession()->addError($this->__('Please select stocks'));
        } else {
            if (!empty($stocksIds)) {
                try {
                    foreach ($stocksIds as $stocksId) {
                        $stocks = Mage::getModel('stocks/stocks')->load($stocksId);
                       // Mage::dispatchEvent('catalog_controller_product_delete', array('product' => $product));
                        $stocks->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($stocksIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }
    
     /**
     * Update product(s) status action
     *
     */
    public function massStatusAction()
    {
        $stocksIds = $this->getRequest()->getParam('stocks');
        $status     = (int)$this->getRequest()->getParam('status');
       
        if (!is_array($stocksIds)) {
            $this->_getSession()->addError($this->__('Please select stocks'));
        } else {
            if (!empty($stocksIds)) {
                try {
                    foreach ($stocksIds as $stocksId) {
                        $stocks = Mage::getModel('stocks/stocks')->load($stocksId);
                      
                         
                        $stocks->setData('is_active',$status);
                        $stocks->save();
                        
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been update.', count($stocksIds))
                    );
                } catch (Mage_Core_Model_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                } catch (Mage_Core_Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                } catch (Exception $e) {
                    $this->_getSession()
                        ->addException($e, $this->__('An error occurred while updating the product(s) status.'));
                }
            }
        }
        $this->_redirect('*/*/index');
    }

//    /**
//     * Validate batch of products before theirs status will be set
//     *
//     * @throws Mage_Core_Exception
//     * @param  array $productIds
//     * @param  int $status
//     * @return void
//     */
//    public function _validateMassStatus(array $stocksIds, $status)
//    {
//        if ($status == Mage_Catalog_Model_Product_Status::STATUS_ENABLED) {
//            if (!Mage::getModel('catalog/product')->isProductsHasSku($productIds)) {
//                throw new Mage_Core_Exception(
//                    $this->__('Some of the processed products have no SKU value defined. Please fill it prior to performing operations on these products.')
//                );
//            }
//        }
//    }
//    
    /**
     * Check the permission to run it
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        switch ($this->getRequest()->getActionName()) {
            case 'new':
            case 'save':
                return Mage::getSingleton('admin/session')->isAllowed('stocks/save');
                break;
            case 'delete':
                return Mage::getSingleton('admin/session')->isAllowed('stocks/delete');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('stocks/page');
                break;
        }
    }
        
    //create product grid
    public function productsAction()
   {
        $this->_initStocks();
        $this->loadLayout();
        $this->getLayout()->getBlock('stocks.edit.tab.content')
     
         ->setProductsList($this->getRequest()->getPost('products_list', null));
        $this->renderLayout();
    
     
    }
    
    public function productGridAction()
    {
        
        $this->loadLayout();
        $this->getLayout()->getBlock('stocks.edit.tab.content')
            ->setProductsList($this->getRequest()->getPost('products_list', null));
        $this->renderLayout();
    }
    /**
     * Filtering posted data. Converting localized data if needed
     *
     */
    protected function _filterPostData($data)
    {
        $data = $this->_filterDates($data, array('custom_theme_from', 'custom_theme_to'));
        return $data;
    }

    /**
     * Validate post data
     *
     * @param array $data
     * @return bool     Return FALSE if someone item is invalid
     */
    protected function _validatePostData($data)
    {
        $errorNo = true;
        if (!empty($data['layout_update_xml']) || !empty($data['custom_layout_update_xml'])) {
            /** @var $validatorCustomLayout Mage_Adminhtml_Model_LayoutUpdate_Validator */
            $validatorCustomLayout = Mage::getModel('adminhtml/layoutUpdate_validator');
            if (!empty($data['layout_update_xml']) && !$validatorCustomLayout->isValid($data['layout_update_xml'])) {
                $errorNo = false;
            }
            if (!empty($data['custom_layout_update_xml'])
            && !$validatorCustomLayout->isValid($data['custom_layout_update_xml'])) {
                $errorNo = false;
            }
            foreach ($validatorCustomLayout->getMessages() as $message) {
                $this->_getSession()->addError($message);
            }
        }
        return $errorNo;
    }

    
}