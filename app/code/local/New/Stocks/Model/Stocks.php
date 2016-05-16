<?php

class New_Stocks_Model_Stocks extends Mage_Core_Model_Abstract
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    const THUMB = 'image';
    
    /**
     * initialization of the model
     */
     protected function _construct()
    {
        $this->_init('stocks/stocks');
    }
    
    
     public function getAvailableStatuses()
    {
        $statuses = new Varien_Object(array(
            self::STATUS_ENABLED => Mage::helper('stocks')->__('Enabled'),
            self::STATUS_DISABLED => Mage::helper('stocks')->__('Disabled'),
        ));
        return $statuses->getData();
    }
    
   
    
    /**
     * Handles file upload on admin pages
     */
    public function uploadFiles()
    {
        $path = Mage::getBaseDir('media') . DS . 'stocks' . DS ;
        //handling thumb image upload
    
        $image = $this->getImage();
        if (!empty($_FILES[self::THUMB]['name'])) {
            try {
                $uploader = new Varien_File_Uploader(self::THUMB);
                $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png')); // or pdf or anything
               
                $uploader->setAllowRenameFiles(true);
                //If this variable is set to TRUE, files despersion will be supported
                $uploader->setFilesDispersion(true);
                $results = $uploader->save($path, $_FILES[self::THUMB]['name']);
             
                //deleting previous file
                if (is_array($image)) {
                    unlink($path . $image['value']);
                } elseif (!empty($image)) {
                    unlink($path . $image);
                }
               
                //setting path to new uploade image 
                $this->setData(self::THUMB, $results['file']);
            } catch (Exception $e) {
                
            }
        }elseif (!empty($image['delete']) && (!empty($image['value']))) {
            unlink($path . $image['value']);
            $this->setData(self::THUMB, '');
        } elseif (!empty($image['value'])) {
            $this->setData(self::THUMB, $image['value']);
        }
    }
}
