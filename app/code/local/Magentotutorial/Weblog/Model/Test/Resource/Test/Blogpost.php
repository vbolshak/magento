<?php

class Magentotutorial_Weblog_Model_Test_Resource_Test_Blogpost extends Mage_Core_Model_Resource_Db_Abstract{
    protected function _construct()
    {
        $this->_init('weblog/blogpost', 'blogpost_id'); //первая часть название модели, вторая часть название сущности (таблицы в БД
    }
}