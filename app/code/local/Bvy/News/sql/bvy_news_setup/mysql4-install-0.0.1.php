<?php
echo 'Running This Upgrade: '.get_class($this)."\n <br /> \n";

$installer = $this;

$installer->startSetup();

$table = $installer->getConnection()
	->newTable($installer->getTable('bvy_news/news'))
	->addColumn('news_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'identity'  => true,
		'unsigned'  => true,
		'nullable'  => false,
		'primary'   => true,
	), 'Id')
	->addColumn('titul', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
		'nullable'  => true,
			), 'Titul')
	->addColumn('data_start', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
		'nullable'  => false,
	), 'Data start')
	->addColumn('data_end', Varien_Db_Ddl_Table::TYPE_DATE, null, array(
		'nullable'  => false,
	), 'Data end')
	->addColumn('url_key', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
		'nullable'  => false,
	), 'Url key')
	->addColumn('status', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
		'nullable'  => false,
	), 'Status')
	->addColumn('tezis', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
		'nullable'  => false,
	), 'Tezis')
	->addColumn('text', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
		'nullable'  => false,
	), 'Text')
	->addColumn('thumb', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
		'nullable'  => false,
	), 'Thumb')
	->addColumn('products', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
		'nullable'  => false,
	), 'Products')
	->addColumn('layout', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
		'nullable'  => false,
	), 'Layout')


;

$installer->getConnection()->createTable($table);

$installer->endSetup();