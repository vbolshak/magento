<?php

class Magentotutorial_Weblog_Model_Test_Resource_Test_Blogpost_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
        $this->_init('weblog/test_blogpost'); //первая часть название модели, вторая часть название ресурс модели
    }
}