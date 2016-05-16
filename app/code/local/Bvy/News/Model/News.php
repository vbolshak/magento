<?php

class Bvy_News_Model_News  extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('bvy_news/news');   //групповое имя это то, что указано в конфиге <models> , news это имя файла
    }


    public function uploadImage(){

        $currentUrlImage = (string) $this->getUrlKey();
        $patchForNews = 'news'.DS;
        $path = Mage::getBaseDir('media') . DS .$patchForNews;

        if (isset($_FILES['file_path']['name']) && $_FILES['file_path']['name'] != '') {

            $uploader = new Varien_File_Uploader('file_path');
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
            $uploader-> setAllowRenameFiles(true); //-> move your file in a folder the magento way
            // setAllowRenameFiles(true) -> move your file directly in the $path folder
            $uploader->setFilesDispersion(false);


            if (file_exists( Mage::getBaseDir('media') . DS . str_replace(' ','_' ,$currentUrlImage )) && !empty($currentUrlImage)) {
                unlink(Mage::getBaseDir('media') . DS .$currentUrlImage );
            }

            $uploader->save($path, $_FILES['file_path']['name']);
            $this->setUrlKey( $patchForNews .  $uploader->getUploadedFileName());
        }

    }
}