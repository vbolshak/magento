<?php

class New_Stocks_Helper_Image extends Mage_Core_Helper_Abstract
{
    
    protected $_imageObject;
    
    protected $_filename;
    //will contain the full path to the file
    protected $_origFile;
    protected $_baseDirInMedia = 'stocks';
    protected $_forceRecreate;

    
     public function getBaseDirInMedia()
    { 
        return $this->_baseDirInMedia;
    }
    
    public function getBaseDir()
    { 
        return Mage::getBaseDir('media') . DS .  $this->_baseDirInMedia;
    }
    
    /**
     * 
     *
     * @return path to the image for example /var/www/media/stocks/cache/width_height/s/c
     */
    protected function _getDestinationDir($profile)
    {
        return $this->getBaseDir() . DS . $this-> _getCachedSubDir($profile);
    }
    
    /**
     * 
     * 
     * @return $dir for example cache/width_height/s/c
     */
    protected function _getCachedSubDir($profile)
    {
        $pathinfo = pathinfo($this->_filename);
        $dir = 'cache' . DS . $profile;
        if ($pathinfo['dirname'] != '.') {
            $dir .= $pathinfo['dirname'];
        }
        
        return $dir;
    }
    
    public function getCachedFilePath($profile) 
    {
      
        return $this->_getCachedFileUrl($profile);
    }  
    
    /**
     * 
     * 
     * @return Get the URL resized image
     */
    protected function _getCachedFileUrl($profile) {
        $fileSubPath = 
                $this->_baseDirInMedia .
                DS . $this->_getCachedSubDir($profile) .
                DS . $this->_getFilename();

        $fileSubPath = str_replace(DS, '/', $fileSubPath);
          
        return Mage::getBaseUrl('media') . $fileSubPath;
    }
    /**
     * 
     * @return image name
     */
    protected function _getFilename()
    {
       
        $pathinfo = pathinfo($this->_filename);
        
        return $pathinfo['basename'];
    }

    public function init(Varien_Object $object, $field, $forceRecreate = false)
    {
        $filename = $object->getData($field);
       
        $this->_forceRecreate = $forceRecreate;

        $this->_filename = '';
        if (($filename) && (0 !== strpos($filename, '/', 0))) {
            $filename = '/' . $filename;
        }
       
        $origFile = $this->getBaseDir() . $filename;

        try {
            $this->_imageObject = new Varien_Image($origFile);
         
            $this->_origFile = $origFile;
            $this->_filename = $filename;
        } catch (Exception $e) {
            $this->_imageObject = NULL;
        }

        return $this;
    }

    public function resize($width, $height = null)
    {
        
        if (!($image = $this->_imageObject)) {
            return '/';
        }

        if (!$height) $height = $width;
        $profile = $width . '_' .$height;

        $destination = $this->_getDestinationDir($profile);
        
        $filename = $this->_getFilename();
        if (!file_exists($destination . DS . $filename) || ($this->_forceRecreate)) {
            $image->resize($width, $height);
            $image->save($destination, $this->_getFilename());
        }
        /**
         * Get the URL resized image
         */
        
        return $this->_getCachedFileUrl($profile);
    }
    
    /**
     * 
     * preserves the original image size
     *
     */
    public function keepAspectRatio($value)
    {
        if ($this->_imageObject) {
            $this->_imageObject->keepAspectRatio($value);
        }

        return $this;
    }
}
