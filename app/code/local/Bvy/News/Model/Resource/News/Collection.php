<?php
class Bvy_News_Model_Resource_News_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    //нужно создать для возможности получения коллекции/ Всегда лежит в папке с именем модеи. в нашем случае news
    public function _construct()
    {
        $this->_init('bvy_news/news');
    }
}