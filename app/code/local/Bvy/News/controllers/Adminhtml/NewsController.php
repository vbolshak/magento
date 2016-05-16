<?php
/**
 * Created by PhpStorm.
 * User: bvy
 * Date: 28.03.16
 * Time: 11:41
 */

class Bvy_News_Adminhtml_NewsController extends Mage_Adminhtml_Controller_Action  // Имя класса Регистр нужно соблюдать.
{
    public function indexAction()
    {
        //загрузим свой лаяут, который определили в конфиге
        $this->_title($this->__('News'))->_title($this->__('News'));
        $this->loadLayout();
        $this->renderLayout();
        // также можно блок добавить и без своего лаяута
//        $this->_setActiveMenu('bvy_news/example');  //указывается как в админхтмл menu-bvy_news-children>
//        $this->_addContent($this->getLayout()->createBlock('news/adminhtml_news_news'));  //указывается имя блока грид контейнера
//        $this->renderLayout();

    }

    /**
     * Create new news action
     */
    public function newAction()
    {
        $this->_forward('edit');



    }


    public function saveAction()
    {
        try  {

            $postData = $this->getRequest()->getPost();

            $model = Mage::getModel('bvy_news/news');

            if ($this->getRequest()->getParam('news_id')){
                $model->load($this->getRequest()->getParam('news_id'));
            }
            $model->addData($postData);

            $model->uploadImage();

            $products = $this->getRequest()->getPost('product');

            //делаем проверку . если продукты не менялись, то в посте не будет о них сведений
            if (!empty($products) ) {

                $decodeProducts = Mage::helper('adminhtml/js')->decodeGridSerializedInput($products);
                $productsIds = implode(',', $decodeProducts);
                $model->setData('products',$productsIds);

            }



            $model->save();

            Mage::getSingleton('adminhtml/session')
                ->addSuccess('successfully saved');

            $this->_redirect('*/*/index');
            return;


        }
        catch (Exception $e) {


            Mage::getSingleton('adminhtml/session')
                ->addError($e->getMessage());

            $this->_redirect('*/*/edit',
                array('id' => $this->getRequest()
                    ->getParam('id')));
            return;

        }

//        if ($data = $this->getRequest()->getPost()) {
//            $model = Mage::getModel('bvy_news/news');
//            $model->setTitul($data['titul']);
//            $model->setTezis($data['tezis']);
//            $model->setStatus($data['is_active']);
//            $model->setDataStart( Mage::getModel('core/date')->date('Y-m-d', strtotime($data['data_start'])));
//            $model->setDataEnd(Mage::getModel('core/date')->date('Y-d-m', strtotime($data['data_end'])));
//          ;
//
//         if (isset($_FILES['file_path']['name']) && $_FILES['file_path']['name'] != '') {
//
//                $uploader = new Varien_File_Uploader('file_path');
//                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
//
//
//                $uploader->setAllowRenameFiles(false);
//
//                $uploader-> setAllowRenameFiles(true); //-> move your file in a folder the magento way
//                // setAllowRenameFiles(true) -> move your file directly in the $path folder
//                $uploader->setFilesDispersion(false);
//
//                $path = Mage::getBaseDir('media') . DS .'news'.DS;
//
//                $uploader->save($path, $_FILES['file_path']['name']);
//
//
//                $data['file_path'] = $_FILES['file_path']['name'];
//                $model->setUrlKey( 'news' . DS .$data['file_path']);
//
//
//          }
//            $model->save();
//        }
//        $this->_redirect('*/*/index');
    }


    /**
     * Edit news action
     */
    public function editAction()
    {
        $id = $this->getRequest()->getParam('news_id');
        $model= Mage::getModel('bvy_news/news')->load($id);
        if ($model || $id ==0) {
            Mage::register('current_news', $model);

            $this->loadLayout();
            $this->renderLayout();
        }
        else
        {

                Mage::getSingleton('adminhtml/session')
                    ->addError('Id does not exist');
                $this->_redirect('*/*/');

        }
    }
//метод вызывается аяксом при клике на табу продуктс. Урл на эту табу формируется в файле Tabs.php
//setProductsList   это сеттер который задавался в лаяуте в ноде  <reload_param_name>
    public function productsAction() {

        $this->loadLayout();
        $this->getLayout()->getBlock('news.tab.products.grid')
            ->setProductsList($this->getRequest()->getPost('products_list', null));
        $this->renderLayout();

    }

 //используется при аякс запросах внутри грида. Это имя было определено в файле Productgrid   в методе public function getGridUrl()
 // сеттер setProductsList  был определен в лаяуете  <reload_param_name>  в нем хранятся данные между переходами по страницам
    public function productgridAction(){
        $this->loadLayout();
        $this->getLayout()->getBlock('news.tab.products.grid')
        ->setProductsList($this->getRequest()->getPost('products_list', null));
        $this->renderLayout();
    }



    //определяем фукцию которая будет вызываться из грида при групповом удалении
    //getParam('news') указываем имя формы, которое задали в гриде в методе getMassactionBlock()->setFormFieldName('news')
    public function massDeleteAction()
    {
        $a=2;
        $newsIds = $this->getRequest()->getParam('news');
        if(!is_array($newsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select news(s).'));
        } else {
            try {
                $news = Mage::getModel('bvy_news/news');
                foreach ($newsIds as $newsId) {
                    $model = $news->load($newsId);
                    $imgPatch = Mage::getBaseDir('media') .DS.  $model->getUrlKey();
                    if (file_exists($imgPatch)) {
                        unlink($imgPatch);}
                    $model  ->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were deleted.', count($newsIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');

    }

    public function massEnableAction()
    {

        $newsIds = $this->getRequest()->getParam('news');
        if(!is_array($newsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select news(s).'));
        } else {
            try {
                $news = Mage::getModel('bvy_news/news');
                foreach ($newsIds as $newsId) {
                    $news->load($newsId)
                        ->setStatus(1)
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were changed status to ACTIVE.', count($newsIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');

    }

    public function massDisableAction()
    {

        $newsIds = $this->getRequest()->getParam('news');
        if(!is_array($newsIds)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select news(s).'));
        } else {
            try {
                $news = Mage::getModel('bvy_news/news');
                foreach ($newsIds as $newsId) {
                    $news->load($newsId)
                        ->setStatus(0)
                        ->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__('Total of %d record(s) were changed status to DISABLE.', count($newsIds))
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }

        $this->_redirect('*/*/index');

    }
}