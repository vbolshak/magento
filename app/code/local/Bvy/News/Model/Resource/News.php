<?php

//модель ресурс нужна для сохранения данных в бд. При вызове метода сейв модели происходит вход в этот клас, где определяется соответ. таблица в бд

class Bvy_News_Model_Resource_News extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('bvy_news/news', 'news_id');
    }
}
