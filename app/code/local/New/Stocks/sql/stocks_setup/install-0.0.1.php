<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
/**
 * Create table 'stocks/stocks'
 */
$table = $installer->getConnection()
    ->newTable($installer->getTable('stocks/stocks'))
    ->addColumn('stocks_id', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'identity'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Stocks ID')
    ->addColumn('title', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable'  => false,
        ), 'Stocks Title')
    ->addColumn('start_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'Start Stock')
    ->addColumn('end_time', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
        ), 'End Stock')    
    ->addColumn('is_active', Varien_Db_Ddl_Table::TYPE_SMALLINT, null, array(
        'nullable'  => false,
        'default'   => '1',
        ), 'Is Stocks Active')
    ->addColumn('summary', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        
        ), 'Summary')
    ->addColumn('content', Varien_Db_Ddl_Table::TYPE_TEXT, '2M', array(
        ), 'Stocks Content')
        
    ->addColumn('image', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
        'nullable'  => false,
        ), 'Stocks Image')
    ->addColumn('product_id', Varien_Db_Ddl_Table::TYPE_INTEGER,10, array(
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Product List')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
    ), 'Position')
     
    ->addIndex($installer->getIdxName('stocks/stocks', array('product_id')),
        array('product_id'))
    ->addForeignKey($installer->getFkName('stocks/stocks', 'product_id', 'catalog/product', 'entity_id'),
        'product_id', $installer->getTable('catalog/product'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    
    ->setComment('Stocks');
$installer->getConnection()->createTable($table);

$installer->endSetup();
